<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import {trans} from "laravel-vue-i18n";
import {usePoll} from "@inertiajs/vue3";
import axios from "axios";
import Zigbee2MQTT from "@/Enums/Zigbee2MQTT.js";

const props = defineProps({
    heatings: {
        type: Array,
    },
    permissions: {
        type: Object,
        default: null,
    }
})

usePoll(5000, {
    only: ['heatings'],
})

const decreaseOccupiedHeatingSetpoint = (friendlyName, value) => {
    const heat = {
        deviceModelClassName: 'Heating',
        friendlyName: friendlyName,
        occupiedHeatingSetpoint: value - 0.5,
        set: Zigbee2MQTT.SET
    }

    try {
        axios.post(route('heating.set'), heat);
    } catch (error) {
        console.error('Failed to decrease temperature setpoint:', error);
    }
}

const increaseOccupiedHeatingSetpoint = (friendlyName, value) => {
    const heat = {
        deviceModelClassName: 'Heating',
        friendlyName: friendlyName,
        occupiedHeatingSetpoint: value + 0.5,
        set: Zigbee2MQTT.SET
    }

    try {
        axios.post(route('heating.set'), heat);
    } catch (error) {
        console.error('Failed to increase temperature setpoint:', error);
    }
}
</script>

<template>
    <AppLayout :title="trans('heating.heating')">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-3 gap-6 p-6">
                        <div
                            v-for="heating in heatings"
                            :key="heating.friendly_name"
                            class="bg-green-400 shadow-lg rounded-lg overflow-hidden m-6 p-6 col-3"
                        >
                            <div class="text-center pt-1 pb-2 text-lg font-bold text-gray-800 leading-tight">
                                {{ trans(`heating.topic_title.${heating.friendly_name}`).toUpperCase() }}
                            </div>
                            <div v-for="(value, key) in heating" :key="key" class="p-1 font-bold text-gray-600">
                                <template v-if="key !== 'friendly_name' && key !== 'occupied_heating_setpoint'">
                                    {{ trans(`heating.message_label.${key}`).toUpperCase() + value }}
                                </template>
                            </div>
                            <div class="flex justify-between w-full mt-4">
                                <Button
                                    type="button"
                                    icon="pi pi-minus"
                                    @click="decreaseOccupiedHeatingSetpoint(heating.friendly_name, heating.occupied_heating_setpoint)"
                                />
                                <div class="text-3xl font-bold text-gray-800 flex items-center">
                                    {{ heating.occupied_heating_setpoint }}
                                </div>
                                <Button
                                    type="button"
                                    icon="pi pi-plus"
                                    @click="increaseOccupiedHeatingSetpoint(heating.friendly_name, heating.occupied_heating_setpoint)"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
