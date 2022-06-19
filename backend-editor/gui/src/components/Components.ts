import type { Component } from "vue";

interface ComponentConstructor {
  new (): ComponentInterface;
}

export interface ComponentInterface {
  components: { [key: string]: Component };
  add(paylod: { name: string; component: Component }): void;
  remove(name: string): void;
  extend(name: string, cb: any): void;
}

const Components: ComponentConstructor = class Components
  implements ComponentInterface
{
  components: { [key: string]: any };
  constructor() {
    this.components = {};
  }

  add({ name, component }: { name: string; component: Component }): void {
    this.components[name] = component;
  }

  remove(name: string) {
    if (this.components[name]) {
      delete this.components[name];
    }
  }

  extend(name: string, cb: any) {
    this.components[name] = cb(this.components[name].props);
  }
};

export default new Components();
