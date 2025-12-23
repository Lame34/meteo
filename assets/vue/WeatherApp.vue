<template>
    <div class="w-full max-w-md mx-auto mt-10">

        <div class="mb-8 flex gap-2">
            <input
                v-model="citySearch"
                @keyup.enter="fetchWeather"
                type="text"
                placeholder="Entrez une ville..."
                class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-blue-500 text-white placeholder-gray-500 transition-colors"
            >
            <button
                @click="fetchWeather"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition-colors"
            >
                GO
            </button>
        </div>

        <div v-if="loading" class="text-center py-10">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
        </div>

        <div v-if="error" class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg text-center">
            {{ error }}
        </div>

        <div v-if="weather && !loading" class="bg-gray-800 rounded-2xl p-8 shadow-2xl border border-gray-700">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold capitalize mb-2">{{ weather.name }}</h2>
                <p class="text-blue-400 text-lg capitalize">{{ weather.weather[0].description }}</p>
            </div>

            <div class="flex justify-center items-center mb-8">
                <img
                    :src="`https://openweathermap.org/img/wn/${weather.weather[0].icon}@4x.png`"
                    alt="Météo"
                    class="w-32 h-32 drop-shadow-lg"
                >
                <div class="text-6xl font-bold ml-4">
                    {{ Math.round(weather.main.temp) }}°
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-700/30 p-4 rounded-xl text-center backdrop-blur-sm">
                    <span class="block text-gray-400 text-sm mb-1">Humidité</span>
                    <span class="text-xl font-bold">{{ weather.main.humidity }}%</span>
                </div>
                <div class="bg-gray-700/30 p-4 rounded-xl text-center backdrop-blur-sm">
                    <span class="block text-gray-400 text-sm mb-1">Vent</span>
                    <span class="text-xl font-bold">{{ Math.round(weather.wind.speed) }} km/h</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref } from 'vue';

const citySearch = ref('');
const weather = ref(null);
const loading = ref(false);
const error = ref(null);

const fetchWeather = async () => {
    if (!citySearch.value) return;

    loading.value = true;
    error.value = null;
    weather.value = null;

    try {
        const response = await fetch(`/api/weather/${citySearch.value}`);

        if (!response.ok) {
            throw new Error('Ville introuvable');
        }

        weather.value = await response.json();
    } catch (e) {
        error.value = "Impossible de trouver cette ville.";
    } finally {
        loading.value = false;
    }
};
</script>
