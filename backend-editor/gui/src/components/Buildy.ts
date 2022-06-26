import Bus from "./Events"
import Hooks from "./Hooks"
import type { Component } from "vue"

interface BuildyConstructor {
  new (app: any): BuildyInterface
}

interface BuildyInterface {
  app: any
  bootingCallbacks: { (arg: any): void }[]
  bootedCallbacks: { (arg: any): void }[]
  $bus: typeof Bus
  $hooks: typeof Hooks
  $composables: { [key: string]: void }
  $propTypes: { [key: string]: any }
  booting(callback: (arg: any) => void): void
  booted(callback: (arg: any) => void): void
  registerComponent(name: string, component: Component): void
  start(): void
}

export const Buildy: BuildyConstructor = class Buildy {
  app: any
  bootingCallbacks: any[]
  bootedCallbacks: any[]
  $bus: typeof Bus
  $hooks: typeof Hooks
  $composables: { [key: string]: void }
  $propTypes: { [key: string]: any }

  constructor(app: any) {
    this.app = app
    this.bootingCallbacks = []
    this.bootedCallbacks = []
    this.$bus = Bus
    this.$hooks = Hooks
    this.$composables = {}
    this.$propTypes = {}
  }

  booting(callback: any) {
    this.bootingCallbacks.push(callback)
  }

  booted(callback: any) {
    this.bootedCallbacks.push(callback)
  }

  registerComponent(name: string, component: any) {
    this.app.component(name, component)
  }

  start() {
    this.bootingCallbacks.forEach((callback: (arg: any) => void) =>
      callback(this.app)
    )
    this.bootingCallbacks = []

    this.app.mount("#app")

    this.bootedCallbacks.forEach((callback: (arg: any) => void) =>
      callback(this.app)
    )
    this.bootedCallbacks = []
  }
}
