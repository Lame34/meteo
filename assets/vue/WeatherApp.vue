<template>
    <div class="weather-container" :class="weatherClass">
        <!-- Weather Effects Layer -->
        <div class="weather-effects">
            <!-- Snow Effect -->
            <div v-if="weatherType === 'snow'" class="snow-container">
                <div v-for="i in 50" :key="'snow-'+i" class="snowflake" :style="snowflakeStyle(i)"></div>
            </div>

            <!-- Rain Effect -->
            <div v-if="weatherType === 'rain' || weatherType === 'drizzle'" class="rain-container">
                <div v-for="i in 100" :key="'rain-'+i" class="raindrop" :style="raindropStyle(i)"></div>
            </div>

            <!-- Thunderstorm Effect -->
            <div v-if="weatherType === 'thunderstorm'" class="storm-container">
                <div v-for="i in 100" :key="'storm-rain-'+i" class="raindrop heavy" :style="raindropStyle(i)"></div>
                <div class="lightning" :class="{ flash: lightningFlash }"></div>
            </div>

            <!-- Sun Effect -->
            <div v-if="weatherType === 'clear'" class="sun-container">
                <div class="sun">
                    <div class="sun-core"></div>
                    <div v-for="i in 12" :key="'ray-'+i" class="sun-ray" :style="sunRayStyle(i)"></div>
                </div>
                <div v-for="i in 20" :key="'particle-'+i" class="sun-particle" :style="particleStyle(i)"></div>
            </div>

            <!-- Clouds Effect -->
            <div v-if="weatherType === 'clouds' || weatherType === 'mist'" class="clouds-container">
                <svg v-for="i in 8" :key="'cloud-'+i" class="cloud" :style="cloudStyle(i)" viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
                    <path d="M170 70
                        Q170 50 150 50
                        Q150 30 120 30
                        Q110 10 80 20
                        Q50 10 40 30
                        Q10 30 10 50
                        Q0 50 0 70
                        Q0 90 30 90
                        L170 90
                        Q200 90 200 70
                        Q200 50 170 70Z"
                        fill="currentColor"/>
                </svg>
            </div>

            <!-- Mist/Fog Effect -->
            <div v-if="weatherType === 'mist'" class="mist-container">
                <div v-for="i in 3" :key="'mist-'+i" class="mist-layer" :style="mistStyle(i)"></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Top Bar with Auth -->
            <div class="top-bar">
                <div class="top-bar-left"></div>
                <div class="top-bar-right">
                    <template v-if="isAuthenticated">
                        <span class="user-email">{{ userEmail }}</span>
                        <a :href="logoutUrl" class="auth-btn logout-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                            <span>Déconnexion</span>
                        </a>
                    </template>
                    <template v-else>
                        <a :href="loginUrl" class="auth-btn login-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                            <span>Connexion</span>
                        </a>
                        <a :href="registerUrl" class="auth-btn register-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                            <span>Inscription</span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Header -->
            <header class="header">
                <h1 class="app-title">
                    <span class="title-icon">&#9730;</span>
                    Météo
                </h1>
            </header>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-box">
                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        v-model="citySearch"
                        @keyup.enter="fetchWeather"
                        type="text"
                        placeholder="Rechercher une ville..."
                        class="search-input"
                    >
                    <button @click="fetchWeather" class="search-button" :disabled="loading">
                        <span v-if="!loading">Rechercher</span>
                        <span v-else class="loading-spinner"></span>
                    </button>
                </div>
            </div>

            <!-- Error Message -->
            <transition name="fade">
                <div v-if="error" class="error-card">
                    <div class="error-icon">!</div>
                    <p>{{ error }}</p>
                </div>
            </transition>

            <!-- Weather Card -->
            <transition name="slide-up">
                <div v-if="weather && !loading" class="weather-card">
                    <!-- Location Header -->
                    <div class="location-header">
                        <div class="location-info">
                            <h2 class="city-name">{{ weather.name }}</h2>
                            <p class="country">{{ weather.sys.country }}</p>
                        </div>
                        <div class="current-time">
                            {{ currentTime }}
                        </div>
                    </div>

                    <!-- Main Weather Display -->
                    <div class="main-weather">
                        <div class="weather-icon-wrapper">
                            <img
                                :src="`https://openweathermap.org/img/wn/${weather.weather[0].icon}@4x.png`"
                                :alt="weather.weather[0].description"
                                class="weather-icon"
                            >
                        </div>
                        <div class="temperature-display">
                            <span class="temp-value">{{ Math.round(weather.main.temp) }}</span>
                            <span class="temp-unit">°C</span>
                        </div>
                        <p class="weather-description">{{ weather.weather[0].description }}</p>
                        <p class="feels-like">Ressenti {{ Math.round(weather.main.feels_like) }}°C</p>
                    </div>

                    <!-- Weather Stats Grid -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon humidity-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8zm0 18c-3.35 0-6-2.57-6-6.2 0-2.34 1.95-5.44 6-9.14 4.05 3.7 6 6.79 6 9.14 0 3.63-2.65 6.2-6 6.2z"/>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ weather.main.humidity }}%</span>
                                <span class="stat-label">Humidité</span>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon wind-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.5 2C9.64 2 8 3.57 8 6c0 1.8.91 3.18 2.5 3.82V22h3V9.82C15.09 9.18 16 7.8 16 6c0-2.43-1.64-4-3.5-4zm0 6c-.83 0-1.5-.67-1.5-1.5S11.67 5 12.5 5s1.5.67 1.5 1.5S13.33 8 12.5 8zM6 13c-1.86 0-3 1.14-3 3 0 1.33.64 2.29 1.75 2.73V22h2.5v-3.27c1.11-.44 1.75-1.4 1.75-2.73 0-1.86-1.14-3-3-3z"/>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ Math.round(weather.wind.speed * 3.6) }} km/h</span>
                                <span class="stat-label">Vent</span>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon pressure-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c3.94.49 7 3.85 7 7.93s-3.05 7.44-7 7.93V4.07z"/>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ weather.main.pressure }} hPa</span>
                                <span class="stat-label">Pression</span>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon visibility-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ Math.round(weather.visibility / 1000) }} km</span>
                                <span class="stat-label">Visibilité</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sun Times -->
                    <div class="sun-times">
                        <div class="sun-time sunrise">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 12h4a5 5 0 0 1 10 0h4M5.6 7.6l1.4 1.4M18.4 7.6l-1.4 1.4M12 2v3M12 17v5M7 17h10"/>
                            </svg>
                            <span class="time">{{ formatTime(weather.sys.sunrise) }}</span>
                            <span class="label">Lever</span>
                        </div>
                        <div class="sun-time sunset">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 12h4a5 5 0 0 1 10 0h4M5.6 7.6l1.4 1.4M18.4 7.6l-1.4 1.4M12 2v3M12 17v5M7 17h10"/>
                            </svg>
                            <span class="time">{{ formatTime(weather.sys.sunset) }}</span>
                            <span class="label">Coucher</span>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Initial State - Modern Landing -->
            <div v-if="!weather && !loading && !error" class="initial-state">
                <!-- Hero Section -->
                <div class="hero-section">
                    <div class="hero-icon">
                        <div class="hero-icon-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
                            </svg>
                        </div>
                        <div class="hero-icon-ring"></div>
                        <div class="hero-icon-ring hero-icon-ring-2"></div>
                    </div>
                    <h2 class="hero-title">Découvrez la météo en temps réel</h2>
                    <p class="hero-subtitle">Recherchez n'importe quelle ville dans le monde et obtenez des prévisions détaillées avec des animations immersives</p>
                </div>

                <!-- Features Grid -->
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-sun">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Temps réel</h3>
                        <p class="feature-desc">Données météo actualisées via OpenWeatherMap</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon feature-icon-snow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1v4m0 14v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M1 12h4m14 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                        </div>
                        <h3 class="feature-title">Animations</h3>
                        <p class="feature-desc">Neige, pluie, soleil... selon la météo</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon feature-icon-global">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.562-.766 4.5 4.5 0 01-1.318 1.357L14.25 7.5l.165.33a.809.809 0 01-1.086 1.085l-.604-.302a1.125 1.125 0 00-1.298.21l-.132.131c-.439.44-.439 1.152 0 1.591l.296.296c.256.257.622.374.98.314l1.17-.195c.323-.054.654.036.905.245l1.33 1.108c.32.267.46.694.358 1.1a8.7 8.7 0 01-2.288 4.04l-.723.724a1.125 1.125 0 01-1.298.21l-.153-.076a1.125 1.125 0 01-.622-1.006v-1.089c0-.298-.119-.585-.33-.796l-1.347-1.347a1.125 1.125 0 01-.21-1.298L9.75 12l-1.64-1.64a6 6 0 01-1.676-3.257l-.172-1.03z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Mondial</h3>
                        <p class="feature-desc">Toutes les villes du monde</p>
                    </div>
                </div>

                <!-- Popular Cities -->
                <div class="popular-section">
                    <p class="popular-label">Villes populaires</p>
                    <div class="popular-cities">
                        <button @click="searchCity('Paris')" class="city-chip">Paris</button>
                        <button @click="searchCity('London')" class="city-chip">London</button>
                        <button @click="searchCity('New York')" class="city-chip">New York</button>
                        <button @click="searchCity('Tokyo')" class="city-chip">Tokyo</button>
                        <button @click="searchCity('Dubai')" class="city-chip">Dubai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const citySearch = ref('');
const weather = ref(null);
const loading = ref(false);
const error = ref(null);
const lightningFlash = ref(false);
const currentTime = ref('');

// Auth state
const isAuthenticated = ref(false);
const userEmail = ref('');
const loginUrl = ref('/login');
const logoutUrl = ref('/logout');
const registerUrl = ref('/register');

let lightningInterval = null;
let timeInterval = null;

const weatherType = computed(() => {
    if (!weather.value) return 'default';

    const code = weather.value.weather[0].id;

    if (code >= 200 && code < 300) return 'thunderstorm';
    if (code >= 300 && code < 400) return 'drizzle';
    if (code >= 500 && code < 600) return 'rain';
    if (code >= 600 && code < 700) return 'snow';
    if (code >= 700 && code < 800) return 'mist';
    if (code === 800) return 'clear';
    if (code > 800) return 'clouds';

    return 'default';
});

const weatherClass = computed(() => {
    return `weather-${weatherType.value}`;
});

const searchCity = (city) => {
    citySearch.value = city;
    fetchWeather();
};

const fetchWeather = async () => {
    if (!citySearch.value.trim()) return;

    loading.value = true;
    error.value = null;

    try {
        const response = await fetch(`/api/weather/${encodeURIComponent(citySearch.value)}`);

        if (!response.ok) {
            throw new Error('Ville introuvable');
        }

        weather.value = await response.json();

        if (weatherType.value === 'thunderstorm') {
            startLightning();
        } else {
            stopLightning();
        }
    } catch (e) {
        error.value = "Impossible de trouver cette ville. Vérifiez l'orthographe.";
        weather.value = null;
    } finally {
        loading.value = false;
    }
};

const startLightning = () => {
    stopLightning();
    lightningInterval = setInterval(() => {
        if (Math.random() > 0.7) {
            lightningFlash.value = true;
            setTimeout(() => {
                lightningFlash.value = false;
            }, 200);
        }
    }, 2000);
};

const stopLightning = () => {
    if (lightningInterval) {
        clearInterval(lightningInterval);
        lightningInterval = null;
    }
};

const formatTime = (timestamp) => {
    const date = new Date(timestamp * 1000);
    return date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
};

const updateCurrentTime = () => {
    const now = new Date();
    currentTime.value = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
};

// Style generators for dynamic elements
const snowflakeStyle = (i) => ({
    left: `${Math.random() * 100}%`,
    animationDuration: `${3 + Math.random() * 5}s`,
    animationDelay: `${Math.random() * 5}s`,
    opacity: 0.4 + Math.random() * 0.6,
    fontSize: `${8 + Math.random() * 16}px`
});

const raindropStyle = (i) => ({
    left: `${Math.random() * 100}%`,
    animationDuration: `${0.5 + Math.random() * 0.3}s`,
    animationDelay: `${Math.random() * 2}s`,
    opacity: 0.3 + Math.random() * 0.4
});

const sunRayStyle = (i) => ({
    transform: `rotate(${i * 30}deg)`
});

const particleStyle = (i) => ({
    left: `${10 + Math.random() * 80}%`,
    top: `${10 + Math.random() * 80}%`,
    animationDuration: `${3 + Math.random() * 4}s`,
    animationDelay: `${Math.random() * 3}s`,
    width: `${4 + Math.random() * 8}px`,
    height: `${4 + Math.random() * 8}px`
});

const cloudStyle = (i) => {
    const sizes = [0.6, 0.8, 1, 1.2, 0.7, 0.9, 1.1, 0.75];
    const tops = [5, 15, 25, 8, 35, 20, 12, 30];
    const durations = [35, 45, 55, 40, 50, 42, 48, 38];
    const opacities = [0.9, 0.7, 0.85, 0.75, 0.8, 0.65, 0.7, 0.6];

    // Stagger clouds: 3 groups with increasing delays
    const group = Math.floor((i - 1) / 3);
    const baseDelay = group * 12; // 0s, 12s, 24s for each group of 3
    const inGroupDelay = ((i - 1) % 3) * 2; // 0s, 2s, 4s within group

    return {
        top: `${tops[(i - 1) % 8]}%`,
        animationDuration: `${durations[(i - 1) % 8]}s`,
        animationDelay: `${baseDelay + inGroupDelay}s`,
        '--cloud-scale': sizes[(i - 1) % 8],
        '--cloud-opacity': opacities[(i - 1) % 8]
    };
};

const mistStyle = (i) => ({
    animationDuration: `${8 + i * 4}s`,
    animationDelay: `${i * 2}s`,
    opacity: 0.2 + i * 0.1
});

onMounted(() => {
    updateCurrentTime();
    timeInterval = setInterval(updateCurrentTime, 1000);

    // Read auth data from DOM
    const appEl = document.getElementById('weather-app');
    if (appEl) {
        isAuthenticated.value = appEl.dataset.isAuthenticated === 'true';
        userEmail.value = appEl.dataset.userEmail || '';
        loginUrl.value = appEl.dataset.loginUrl || '/login';
        logoutUrl.value = appEl.dataset.logoutUrl || '/logout';
        registerUrl.value = appEl.dataset.registerUrl || '/register';
    }
});

onUnmounted(() => {
    stopLightning();
    if (timeInterval) {
        clearInterval(timeInterval);
    }
});
</script>

<style scoped>
/* Base Container */
.weather-container {
    min-height: 100vh;
    width: 100%;
    position: relative;
    overflow: hidden;
    transition: background 1s ease-in-out;
}

/* Weather Background Gradients */
.weather-default {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
}

.weather-clear {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 30%, #ff9a56 70%, #ffd93d 100%);
}

.weather-clouds {
    background: linear-gradient(135deg, #4a5568 0%, #718096 50%, #a0aec0 100%);
}

.weather-rain, .weather-drizzle {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 50%, #3d5a80 100%);
}

.weather-thunderstorm {
    background: linear-gradient(135deg, #0d1321 0%, #1d2d44 50%, #3e5c76 100%);
}

.weather-snow {
    background: linear-gradient(135deg, #e8f4f8 0%, #b8d4e3 50%, #89b4c8 100%);
}

.weather-mist {
    background: linear-gradient(135deg, #606c88 0%, #3f4c6b 100%);
}

/* Weather Effects Container */
.weather-effects {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
    overflow: hidden;
}

/* Snow Effect */
.snow-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.snowflake {
    position: absolute;
    top: -20px;
    color: white;
    text-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
    animation: snowfall linear infinite;
}

.snowflake::before {
    content: '❄';
}

@keyframes snowfall {
    0% {
        transform: translateY(-20px) rotate(0deg);
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
    }
}

/* Rain Effect */
.rain-container, .storm-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.raindrop {
    position: absolute;
    top: -50px;
    width: 2px;
    height: 20px;
    background: linear-gradient(transparent, rgba(174, 194, 224, 0.8));
    border-radius: 0 0 5px 5px;
    animation: rainfall linear infinite;
}

.raindrop.heavy {
    height: 30px;
    background: linear-gradient(transparent, rgba(174, 194, 224, 0.9));
}

@keyframes rainfall {
    0% {
        transform: translateY(-50px);
    }
    100% {
        transform: translateY(100vh);
    }
}

/* Lightning Effect */
.lightning {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    transition: background 0.1s;
}

.lightning.flash {
    background: rgba(255, 255, 255, 0.3);
}

/* Sun Effect */
.sun-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.sun {
    position: absolute;
    top: 10%;
    right: 10%;
    width: 120px;
    height: 120px;
}

.sun-core {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: radial-gradient(circle, #fff9c4 0%, #ffee58 50%, #ffd600 100%);
    border-radius: 50%;
    box-shadow: 0 0 60px 20px rgba(255, 214, 0, 0.5);
    animation: sunPulse 3s ease-in-out infinite;
}

.sun-ray {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100px;
    height: 3px;
    background: linear-gradient(90deg, rgba(255, 214, 0, 0.8), transparent);
    transform-origin: left center;
    animation: rayPulse 2s ease-in-out infinite;
}

@keyframes sunPulse {
    0%, 100% { transform: translate(-50%, -50%) scale(1); }
    50% { transform: translate(-50%, -50%) scale(1.1); }
}

@keyframes rayPulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

.sun-particle {
    position: absolute;
    background: radial-gradient(circle, rgba(255, 214, 0, 0.8), transparent);
    border-radius: 50%;
    animation: floatParticle ease-in-out infinite;
}

@keyframes floatParticle {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
    50% { transform: translateY(-20px) scale(1.2); opacity: 1; }
}

/* Clouds Effect */
.clouds-container {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.cloud {
    position: absolute;
    width: 250px;
    height: 125px;
    color: rgba(255, 255, 255, 0.85);
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
    opacity: 0;
    transform: scale(var(--cloud-scale, 1)) translateX(-300px);
    animation: cloudMove linear infinite;
    animation-fill-mode: backwards;
}

.weather-mist .cloud {
    color: rgba(255, 255, 255, 0.5);
}

@keyframes cloudMove {
    0% {
        opacity: 0;
        transform: scale(var(--cloud-scale, 1)) translateX(-300px);
    }
    5% {
        opacity: var(--cloud-opacity, 0.8);
    }
    95% {
        opacity: var(--cloud-opacity, 0.8);
    }
    100% {
        opacity: 0;
        transform: scale(var(--cloud-scale, 1)) translateX(calc(100vw + 100px));
    }
}

/* Mist Effect */
.mist-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.mist-layer {
    position: absolute;
    width: 200%;
    height: 100%;
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.1) 25%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.1) 75%,
        transparent 100%);
    animation: mistMove ease-in-out infinite alternate;
}

@keyframes mistMove {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(0%); }
}

/* Content Wrapper */
.content-wrapper {
    position: relative;
    z-index: 10;
    min-height: 100vh;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Header */
.header {
    text-align: center;
    margin-bottom: 2rem;
}

.app-title {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.title-icon {
    font-size: 2.5rem;
}

/* Search Section */
.search-section {
    width: 100%;
    max-width: 600px;
    margin-bottom: 2rem;
}

.search-box {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.search-box:focus-within {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
}

.search-icon {
    width: 24px;
    height: 24px;
    margin-left: 1rem;
    color: rgba(255, 255, 255, 0.7);
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 1rem;
    font-size: 1.1rem;
    color: white;
    outline: none;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.search-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 130px;
}

.search-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.5);
}

.search-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Error Card */
.error-card {
    background: rgba(220, 38, 38, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(220, 38, 38, 0.4);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    max-width: 500px;
}

.error-icon {
    width: 30px;
    height: 30px;
    background: rgba(220, 38, 38, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    flex-shrink: 0;
}

.error-card p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

/* Weather Card */
.weather-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 30px;
    padding: 2.5rem;
    width: 100%;
    max-width: 500px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.location-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.city-name {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0;
    text-transform: capitalize;
}

.country {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.current-time {
    font-size: 1.5rem;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.8);
}

/* Main Weather Display */
.main-weather {
    text-align: center;
    margin-bottom: 2rem;
}

.weather-icon-wrapper {
    margin: -1rem 0;
}

.weather-icon {
    width: 150px;
    height: 150px;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
}

.temperature-display {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    margin-bottom: 0.5rem;
}

.temp-value {
    font-size: 5rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.temp-unit {
    font-size: 2rem;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.5rem;
}

.weather-description {
    font-size: 1.3rem;
    color: white;
    text-transform: capitalize;
    margin: 0 0 0.5rem 0;
}

.feels-like {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg {
    width: 22px;
    height: 22px;
    color: white;
}

.humidity-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.wind-icon {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.wind-icon svg {
    color: #2d3748;
}

.pressure-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.visibility-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
}

.stat-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

/* Sun Times */
.sun-times {
    display: flex;
    justify-content: space-around;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.sun-time {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.sun-time svg {
    width: 28px;
    height: 28px;
}

.sunrise svg {
    color: #fbbf24;
}

.sunset svg {
    color: #f97316;
}

.sun-time .time {
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
}

.sun-time .label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
}

/* Top Bar */
.top-bar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1rem;
    margin-bottom: 1rem;
}

.top-bar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-email {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    padding-right: 0.5rem;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
}

.auth-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.auth-btn svg {
    width: 18px;
    height: 18px;
}

.login-btn {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.login-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.register-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: 1px solid transparent;
}

.register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.logout-btn {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
}

/* Initial State */
.initial-state {
    text-align: center;
    padding: 2rem;
    color: rgba(255, 255, 255, 0.6);
    max-width: 800px;
    width: 100%;
}

/* Hero Section */
.hero-section {
    margin-bottom: 3rem;
}

.hero-icon {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
}

.hero-icon-inner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 2;
}

.hero-icon-inner svg {
    width: 40px;
    height: 40px;
    color: white;
}

.hero-icon-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    animation: ringPulse 3s ease-in-out infinite;
}

.hero-icon-ring-2 {
    width: 120px;
    height: 120px;
    animation-delay: 1s;
}

@keyframes ringPulse {
    0%, 100% {
        opacity: 0.3;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(1.1);
    }
}

.hero-title {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 0 1rem 0;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.feature-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    transition: all 0.3s ease;
}

.feature-card:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.feature-icon svg {
    width: 26px;
    height: 26px;
    color: white;
}

.feature-icon-sun {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.feature-icon-snow {
    background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
}

.feature-icon-global {
    background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
}

.feature-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    margin: 0 0 0.5rem 0;
}

.feature-desc {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
    line-height: 1.5;
}

/* Popular Cities */
.popular-section {
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.popular-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.popular-cities {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.75rem;
}

.city-chip {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 25px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.city-chip:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Transitions */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.slide-up-enter-active {
    transition: all 0.5s ease-out;
}

.slide-up-leave-active {
    transition: all 0.3s ease-in;
}

.slide-up-enter-from {
    opacity: 0;
    transform: translateY(30px);
}

.slide-up-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Snow weather text color adjustment */
.weather-snow .city-name,
.weather-snow .temp-value,
.weather-snow .weather-description,
.weather-snow .stat-value,
.weather-snow .sun-time .time,
.weather-snow .app-title {
    color: #1e3a5f;
}

.weather-snow .country,
.weather-snow .current-time,
.weather-snow .feels-like,
.weather-snow .stat-label,
.weather-snow .sun-time .label,
.weather-snow .initial-text {
    color: rgba(30, 58, 95, 0.7);
}

.weather-snow .search-input {
    color: #1e3a5f;
}

.weather-snow .search-input::placeholder {
    color: rgba(30, 58, 95, 0.5);
}

.weather-snow .search-icon {
    color: rgba(30, 58, 95, 0.7);
}

.weather-snow .initial-icon svg {
    color: rgba(30, 58, 95, 0.5);
}

/* Responsive */
@media (max-width: 640px) {
    .content-wrapper {
        padding: 1rem;
    }

    .top-bar {
        padding: 0.25rem 0.5rem;
    }

    .top-bar-right {
        gap: 0.5rem;
    }

    .auth-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }

    .auth-btn span {
        display: none;
    }

    .auth-btn svg {
        width: 20px;
        height: 20px;
    }

    .user-email {
        font-size: 0.8rem;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .app-title {
        font-size: 2rem;
    }

    .search-box {
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.75rem;
    }

    .search-icon {
        display: none;
    }

    .search-input {
        width: 100%;
        order: 1;
    }

    .search-button {
        width: 100%;
        order: 2;
    }

    .weather-card {
        padding: 1.5rem;
        border-radius: 20px;
    }

    .city-name {
        font-size: 1.5rem;
    }

    .temp-value {
        font-size: 4rem;
    }

    .weather-icon {
        width: 120px;
        height: 120px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    /* Initial State Mobile */
    .initial-state {
        padding: 1rem;
    }

    .hero-title {
        font-size: 1.5rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .feature-card {
        padding: 1.5rem 1rem;
    }

    .popular-cities {
        gap: 0.5rem;
    }

    .city-chip {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}
</style>
