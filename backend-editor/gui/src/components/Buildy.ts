export const Buildy = class {
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

    this.app.mount("#app");

    this.bootedCallbacks.forEach((callback: (arg: any) => void) =>
      callback(this.app)
    );
    this.bootedCallbacks = [];
  }
};
