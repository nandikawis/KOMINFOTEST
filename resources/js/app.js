import './bootstrap';
import { createApp } from 'vue';

// Import your root component
import App from './components/App.vue';

const app = createApp(App);
app.mount("#app");
