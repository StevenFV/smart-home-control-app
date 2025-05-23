<?php

namespace App\Console\Commands\Devices;

use App\Enums\Zigbee2MQTT;
use App\Interfaces\Devices\DeviceStoreInterface;
use App\Traits\Devices\DeviceModelNamespaceResolverTrait;
use Artisan;
use Database\Seeders\StoreDevicesFakeDataSeeder;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Uri;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class StoreData extends Command implements DeviceStoreInterface
{
    use DeviceModelNamespaceResolverTrait;

    protected $signature = 'device:store-data {deviceModelClassName}';

    protected $description = 'Get device data from mqtt broker and put to home-control-app database';

    private ?array $messageDetails = null;

    public function handle(): void
    {
        if (config('mqtt-client.faker')) {
            $this->storeFakeData();

            return;
        }

        $deviceModelClassName = $this->argument('deviceModelClassName');

        $deviceModelClassNameWithNameSpace = $this->getDeviceModelClassNameWithNameSpace($deviceModelClassName);

        $deviceStoreData = app(self::class);

        $deviceStoreData->store($deviceModelClassNameWithNameSpace);
    }

    private function storeFakeData(): void
    {
        $cacheKey = 'store_devices_fake_data_seeder_last_run';
        $lastRun = Cache::get($cacheKey);

        if ($lastRun && now()->diffInMinutes($lastRun) < 15) {
            return;
        }

        Cache::put($cacheKey, now(), 420);

        Artisan::call('db:seed', ['--class' => StoreDevicesFakeDataSeeder::class]);
    }

    public function store(Model $model): void
    {
        $informations = $this->data($model);

        array_map(function ($information) use ($model) {
            $this->updateOrCreateDeviceData($model, $information);
        }, $informations);
    }

    public function data(Model $model): array
    {
        $friendlyNames = $model::distinct('friendly_name')->pluck('friendly_name')->toArray();
        $topicFilters = array_map(function ($friendlyName) {
            return Zigbee2MQTT::BaseTopic->value . $friendlyName;
        }, $friendlyNames);

        return array_map([$this, 'fetchAndProcessMqttMessages'], $topicFilters);
    }

    public function fetchAndProcessMqttMessages($topicFilter): array
    {
        $uri = Uri::of($topicFilter);
        $deviceType = $uri->pathSegments()->get(1);
        $payload = match ($deviceType) {
            'light' => Zigbee2MQTT::StateDevicePayload->value,
            'heat' => Zigbee2MQTT::LocalTemperatureDevicePayload->value,
        };

        try {
            $mqtt = MQTT::connection();

            $mqtt->subscribe(
                $topicFilter,
                function () use ($mqtt) {
                    $mqtt->interrupt();
                },
                MqttClient::QOS_AT_MOST_ONCE,
            );

            $mqtt->publish(
                $topicFilter . Zigbee2MQTT::Get->value,
                $payload,
            );

            // Interrupt the loop after 1 second to avoid the loop to be stuck.
            $loopCallback = function (MqttClient $mqtt, float $elapsedTime) {
                if ($elapsedTime > 1) {
                    $mqtt->interrupt();
                }
            };

            $topicMessageCallback = function (MqttClient $mqtt, string $topic, string $message) {
                $this->messageDetails = $this->extractMessageDetails($topic, $message);
            };

            $mqtt->registerMessageReceivedEventHandler($topicMessageCallback);
            $mqtt->registerLoopEventHandler($loopCallback);
            $mqtt->loop(true, true);

        } catch (MqttClientException $e) {
            Log::info(
                'Fetch and process mqtt failed with the error message: {message}.',
                ['message' => $e->getMessage()],
            );
        }

        return $this->messageDetails ?? $this->extractMessageDetails($topicFilter, '');
    }

    private function extractMessageDetails(string $topic, string $message): array
    {
        return [
            'topic' => $topic,
            'message' => $message,
        ];
    }

    private function updateOrCreateDeviceData(Model $model, array $information): void
    {
        $friendlyName = str_replace('zigbee2mqtt/', '', $information['topic']);
        $message = json_decode($information['message']);
        $deviceData = array_slice($model->getFillable(), 2);

        foreach ($deviceData as $data) {
            $model->updateOrCreate(
                ['friendly_name' => $friendlyName],
                [
                    $data => $message->$data ?? null,
                ],
            );
        }
    }
}
