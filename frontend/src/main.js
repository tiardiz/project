import { createApp } from "vue";
import App from "./App.vue";
import "./assets/main.css";
import router from "./router";

// const app = createApp(App);
// app.mount("#app");
createApp(App).use(router).mount("#app");
