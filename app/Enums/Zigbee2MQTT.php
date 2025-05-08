<?php

namespace App\Enums;

enum Zigbee2MQTT: string
{
    case BaseTopic = 'zigbee2mqtt/';
    case Get = '/get';
    case StateDevicePayload = '{"state": ""}';
    case BridgeDevices = 'zigbee2mqtt/bridge/devices';
    case LocalTemperatureDevicePayload = '{"local_temperature": ""}';
}
