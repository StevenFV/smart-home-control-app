<?php

namespace App\Enums;

enum Zigbee2MqttUtility: string
{
    case BaseTopic = 'zigbee2mqtt/';
    case GET = '/get';
    case StateDevicePayload = '{"state": ""}';
    case Zigbee2MQTTBridgeDevices = 'zigbee2mqtt/bridge/devices';
}
