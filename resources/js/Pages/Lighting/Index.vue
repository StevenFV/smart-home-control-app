<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import ToggleSwitch from 'primevue/toggleswitch';
import {trans} from "laravel-vue-i18n";
import {usePoll} from "@inertiajs/vue3";
import Zigbee2MQTT from "@/Enums/Zigbee2MQTT";

const props = defineProps({
    lightings: {
        type: Array,
    },
    permissions: {
        type: Object,
        default: null,
    }
})

usePoll(5000, {
    only: ['lightings'],
})

const toggleLight = (friendlyName) => {
    const light = {
        deviceModelClassName: 'Lighting',
        friendlyName: friendlyName,
        state: Zigbee2MQTT.TOGGLE,
        set: Zigbee2MQTT.SET
    }

    try {
      axios.post(route('lighting.set'), light);
    } catch (error) {
        console.error('Failed to toggle light:', error);
    }
}
</script>

<template>
    <AppLayout :title="trans('lighting.lighting')">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-3 gap-6 p-6">
                        <div
                            v-for="lighting in lightings"
                            :key="lighting.friendly_name"
                            class="bg-green-400 shadow-lg rounded-lg overflow-hidden m-6 p-6 col-3"
                        >
                            <div class="text-center pt-1 pb-2 text-lg font-bold text-gray-800 leading-tight">
                                {{ trans(`lighting.topic_title.${lighting.friendly_name}`).toUpperCase() }}
                            </div>
                            <div v-for="(value, key) in lighting" :key="key" class="p-1 font-bold text-gray-600">
                                <template v-if="key !== 'friendly_name'">
                                    {{ trans(`lighting.message_label.${key}`).toUpperCase() + value }}
                                </template>
                            </div>
                            <ToggleSwitch
                                :disabled="!permissions.lighting.controlDevices || !lighting.state"
                                @click="toggleLight(lighting.friendly_name)"
                                :modelValue="lighting.state === 'ON'"
                                class="ml-1"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
