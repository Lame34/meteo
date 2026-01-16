import './styles/app.css';
import { createApp } from 'vue';
import WeatherApp from './vue/WeatherApp.vue';

const weatherElement = document.getElementById('weather-app');

if (weatherElement) {
    const app = createApp(WeatherApp);
    app.mount('#weather-app');
}
