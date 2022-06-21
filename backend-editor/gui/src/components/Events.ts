interface EventConstructor {
  new (): EventInterface;
}

export interface EventInterface {
  events: { [key: string]: any };
  on(eventName: string, callback: (arg: any) => void): void;
  off(eventName: string): void;
  emit(eventName: string, data?: any): void;
}

const Event: EventConstructor = class Event implements EventInterface {
  events: { [key: string]: any };
  constructor() {
    this.events = {};
  }

  on(eventName: string, fn: any) {
    this.events[eventName] = this.events[eventName] || [];
    this.events[eventName].push(fn);
  }

  off(eventName: string) {
    if (this.events[eventName]) {
      this.events[eventName] = [];
    }
  }

  emit(eventName: string, data?: any) {
    // console.log({ eventName, data });
    if (this.events[eventName]) {
      this.events[eventName].forEach(function (fn: any): void {
        fn(data);
      });
    }
  }
};

export default new Event();
