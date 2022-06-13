import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import draggable from "vuedraggable";

const app = createApp(App);
app.use(createPinia());
app.component("draggable", draggable);

const bundledComponents = import.meta.globEager("./components/**/*.vue");
Object.entries(bundledComponents).forEach(([path, m]) => {
  const name =
    path
      ?.split("/")
      ?.pop()
      ?.replace(/\.\w+$/, "") || "";
  app.component(name, m.default);
});

const Buildy = class {
  app: any;
  bootingCallbacks: { (data: string): void }[];
  bootedCallbacks: { (data: string): void }[];

  constructor(app: any) {
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

  register(name: string, component: object) {
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

declare global {
  interface Window {
    Buildy?: any;
  }
}

window.Buildy = new Buildy(app);

window.Buildy.start();
