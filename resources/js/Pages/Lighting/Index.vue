<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import {computed, onMounted, onUnmounted, reactive, ref, watch} from 'vue';
import ToggleSwitch from 'primevue/toggleswitch';
import {trans} from "laravel-vue-i18n";
import Zigbee2MqttUtility from "@/Enums/Devices/Zigbee2MqttUtility";


const TOPIC_TITLE = 'lighting.topic_title';
const MESSAGE_LABEL = 'lighting.message_label';

const props = defineProps({
    lightingData: {
        type: Object,
        default: null,
    },
    permissions: {
        type: Object,
        default: null,
    }
})

const lightingData = ref(props.lightingData);

async function fetchUpdatedLightingData() {
    try {
        const response = await axios.get(route('lighting.get'));
        lightingData.value = response.data;
    } catch (error) {
        console.error('Failed to fetch updated lighting data:', error);
    }
}

let intervalId;

onMounted(() => {
    fetchUpdatedLightingData();
    intervalId = setInterval(fetchUpdatedLightingData, 50000);
});

onUnmounted(() => {
    clearInterval(intervalId);
});

const sortedLightingData = computed(() => {
  return lightingData.value.map(item => ({
    ...item,
    translatedTitle: displayText(TOPIC_TITLE, item.friendlyName)
  })).sort((a, b) => a.translatedTitle.localeCompare(b.translatedTitle));
});

const translateText = (strKey, varKey = null) => {
  return varKey ? trans(`${strKey}.${varKey}`).toUpperCase() : trans(`${strKey}`).toUpperCase();
}

const displayText = (strKey, varKey = null, value = null) => {
  return value ? `${translateText(strKey, varKey)}${value}` : translateText(strKey, varKey);
}

const state = reactive({});
const data = reactive(props.lightingData);

const updateLightingState = () => {
  for (const index of data) {
    const friendlyName = index?.friendlyName;
    state[friendlyName] = index?.data?.state === 'ON';
  }
}

updateLightingState();

const lightingStates = computed(() => {
    return Object.keys(state).map(friendlyName => ({
        friendlyName,
        state: state[friendlyName] ? 'ON' : 'OFF'
    }));
});

watch(lightingStates, (newStates, oldStates) => {
    const changedKey = Object.keys(newStates).find(key => newStates[key]?.state !== oldStates[key]?.state);

    if (changedKey) {
      toggleLight(newStates, changedKey)
    }
  }, {deep: true}
);

const toggleLight = async (newStates, changedKey) => {
  const changedItem = newStates[changedKey];

  changedItem[Zigbee2MqttUtility.KEY_SET] = Zigbee2MqttUtility.TOPIC_SET;
  changedItem[Zigbee2MqttUtility.KEY_COMMAND_STATE] = Zigbee2MqttUtility.COMMAND_TOGGLE;
  changedItem[Zigbee2MqttUtility.KEY_DEVICE_MODEL_CLASS_NAME] = Zigbee2MqttUtility.LIGHTING;

    try {
      await axios.post(route('lighting.set'), changedItem).then(() => {
        fetchUpdatedLightingData();
      });
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
                            v-for="item in sortedLightingData"
                            :key="item.friendlyName"
                            class="bg-green-400 shadow-lg rounded-lg overflow-hidden m-6 p-6 col-3"
                        >
                            <div class="text-center pt-1 pb-2 text-lg font-bold text-gray-800 leading-tight">
                                {{ displayText(TOPIC_TITLE, item.friendlyName) }}
                            </div>
                            <div
                                v-for="(value, label, indexValue) in item.data"
                                :key="indexValue"
                                class="p-1 font-bold text-gray-600"
                            >
                                <template v-if="label && value">
                                    {{ displayText(MESSAGE_LABEL, label, value) }}
                                </template>
                            </div>
                            <ToggleSwitch
                                :disabled="!permissions.lighting.controlDevices"
                                v-model="state[item.friendlyName]"
                                class="ml-1"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
