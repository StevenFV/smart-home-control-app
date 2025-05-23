<?php

namespace App\Console\Commands\Devices;

use App\Enums\DeviceModelClassName;
use App\Enums\Zigbee2MQTT;
use App\Http\Requests\Devices\DeviceRequest;
use App\Services\Devices\HeatingFakeDataService;
use App\Services\Devices\LightingFakeDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use PhpMqtt\Client\Facades\MQTT;

class PublishMessage extends Command
{
    protected $signature = 'device:publish-message';

    protected $description = 'Publish message to device';

    private string $topic;

    private string $message;

    private string $deviceModelClassName;

    public function handle(DeviceRequest $request): void
    {
        if (config('mqtt-client.faker')) {
            $this->storeFakeMessage($request);

            return;
        }

        $this->topic = $this->createTopic($request);
        $this->message = $this->createMessage($request);
        $this->deviceModelClassName = $this->getDeviceModelClassName($request);

        $this->publishMessage();
        $this->updateDeviceDataInDatabase();
    }

    private function storeFakeMessage(DeviceRequest $request): void
    {
        match ($request['deviceModelClassName']) {
            DeviceModelClassName::Lighting->value => LightingFakeDataService::toggleLightingState($request),
            DeviceModelClassName::Heating->value => HeatingFakeDataService::setOccupiedHeatingSetpoint($request),
        };
    }

    private function createTopic(DeviceRequest $request): string
    {
        return Zigbee2MQTT::BaseTopic->value . $request['friendlyName'] . $request['set'];
    }

    private function createMessage(DeviceRequest $request): string
    {
        return match ($request['deviceModelClassName']) {
            DeviceModelClassName::Heating->value => json_encode(['occupied_heating_setpoint' => $request['occupiedHeatingSetpoint']]),
            default => json_encode(['state' => $request['state']]),
        };
    }

    private function getDeviceModelClassName(DeviceRequest $request): string
    {
        return $request['deviceModelClassName'];
    }

    private function publishMessage(): void
    {
        $mqtt = MQTT::connection();

        try {
            $mqtt->publish($this->topic, $this->message);
            $mqtt->disconnect();
        } catch (RepositoryException|DataTransferException $exception) {
            Log::info($exception->getMessage());
        }
    }

    private function updateDeviceDataInDatabase(): void
    {
        Artisan::call('device:store-data', ['deviceModelClassName' => $this->deviceModelClassName]);
    }
}
