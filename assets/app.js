import './styles/app.css';
import { createApp } from 'vue';
import WeatherApp from './vue/WeatherApp.vue';

const app = createApp(WeatherApp);
app.mount('#app');
