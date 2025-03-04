<?php

namespace App\Abstracts\Devices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractDataConstructor
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function dataForFrontend(): Collection
    {
        $fillableAttributes = $this->model->getFillable();

        return $this->model->all()->map(function ($model) use ($fillableAttributes) {
            $data = [
                'friendlyName' => $model->friendly_name,
                'data' => [],
            ];

            $attributes = method_exists($model, 'toArrayWithoutIeeeAddress') ? $model->toArrayWithoutIeeeAddress() : $model->toArray();

            foreach ($fillableAttributes as $attribute) {
                if ($attribute !== 'friendly_name' && isset($attributes[$attribute])) {
                    $data['data'][$attribute] = $attributes[$attribute];
                }
            }

            return $data;
        });
    }
}
