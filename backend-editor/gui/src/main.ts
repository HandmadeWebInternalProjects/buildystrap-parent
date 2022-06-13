import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import draggable from "vuedraggable";

const app = createApp(App);
app.use(createPinia());
app.component("draggable", draggable);

const bundledComponents = import.meta.globEager("./components/**/*.vue");
Object.entries(bundledComponents).forEach(([path, m]) => {
  const name = path
    .split("/")
    .pop()
    .replace(/\.\w+$/, "");
  app.component(name, m.default);
});

const Buildy = class {
  app: any;
  bootingCallbacks: Array;
  bootedCallbacks: Array;

  constructor(app) {
    this.app = app;
    this.bootingCallbacks = [];
    this.bootedCallbacks = [];
  }

  booting(callback: (arg: any) => void) {
    this.bootingCallbacks.push(callback);
  }

  booted(callback: (arg: any) => void) {
    this.bootedCallbacks.push(callback);
  }

  register(name: string, component) {
    this.app.component(name, component);
  }

  start() {
    this.bootingCallbacks.forEach((callback: (arg: any) => void) =>
      callback(this.app)
    );
    this.bootingCallbacks = [];

    app.mount("#app");

    this.bootedCallbacks.forEach((callback: (arg: any) => void) =>
      callback(this.app)
    );
    this.bootedCallbacks = [];
  }
};

window.Buildy = new Buildy(app);

window.Buildy.start();
