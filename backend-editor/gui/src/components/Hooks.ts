interface HookConstructor {
  new (): HookInterface;
}

export interface HookInterface {
  queue: { [key: string]: any };
  add(
    name: string,
    callback: (resolve: any, reject: any, ...args: any[]) => void,
    priority?: number
  ): void;
  run(name: string, args: any): Promise<any>;
  remove(name: string, callback: (arg: any) => void): void;
  clear(name: string): void;
  getCallbacks(name: string): any[];
  count(name: string): number;
  hasCallbacks(name: string): boolean;
  hasCallback(name: string, callback: (arg: any) => void): boolean;
}

const Hooks: HookConstructor = class Hooks implements HookInterface {
  queue: { [key: string]: any };
  constructor() {
    this.queue = {};
  }

  /**
   * add(name, callback)
   * Example:
   * hooks.add('myHook', () => {
   *    console.log('myHook ran!')
   * })
   */
  add(
    name: string,
    callback: (resolve: any, reject: any, ...args: any[]) => void,
    priority = 10
  ) {
    if (this.queue[name] === undefined) {
      this.queue[name] = [];
    }
    this.queue[name].push({ callback, priority });
  }

  /**
   * run(name, ...args)
   * Example:
   * hooks.run('myHook', 'foo', 'bar')
   */

  run(name: string, ...args: unknown[]) {
    return new Promise((resolve, reject) => {
      const callbacks = this.getCallbacks(name);
      // If the below causes issue (spreading results) then args will need to be wrapped in an array here
      if (!callbacks.length) resolve([...args]);
      this.getCallbacks(name)
        .sort(
          (a: { priority: number }, b: { priority: number }) =>
            b.priority - a.priority
        )
        .map((hook: any) =>
          this.#convertToPromiseCallback(hook.callback, ...args)
        )
        .reduce((promise: any, callback: any) => {
          return promise.then((result: any) =>
            callback().then(Array.prototype.concat.bind(result))
          );
        }, Promise.resolve([]))
        // Return result, we mau need this to be non-spreaded for some reason if so.
        .then((results: PromiseSettledResult<any[]>) => resolve(results))
        .catch((error: ErrorCallback) => reject(error));
    });
  }

  /**
   * convertToPromiseCallback(callback, payload)
   * Convert a callback to a promise callback. So that hooks always return a promise.
   */
  #convertToPromiseCallback(callback: any, ...args: any) {
    return () => {
      return new Promise((resolve, reject) => {
        callback(resolve, reject, ...args);
      });
    };
  }

  /**
   * remove(name, callback)
   * Example:
   * hooks.remove('myHook', callback)
   */
  remove(name: string, callback: any) {
    if (this.queue[name]) {
      this.queue[name] = this.queue[name].filter((el: any) => !el === callback);
    }
  }

  /**
   * clear(name)
   * Example:
   * hooks.clear('myHook')
   */
  clear(name: string) {
    if (this.queue[name]) {
      this.queue[name] = [];
    }
  }

  /**
   * clearAll()
   * Example:
   * hooks.clearAll()
   */
  clearAll() {
    this.queue = {};
  }

  /**
   * getCallbacks(name)
   * Get the callbacks in the queue for a particular hook.
   * Example:
   * hooks.get('myHook')
   */
  getCallbacks(name: string) {
    return this.queue[name] || [];
  }

  /**
   * count(name)
   * Get the number of callbacks in the queue for a particular hook.
   * Example:
   * hooks.count('myHook')
   */
  count(name: string) {
    if (this.queue[name]) {
      return this.queue[name].length;
    }
    return 0;
  }

  /**
   * hasCallbacks(name)
   * Check if the queue has any callbacks for a particular hook.
   * Example:
   * hooks.hasCallbacks('myHook')
   */
  hasCallbacks(name: string) {
    return !!this.queue[name] && this.queue[name].length > 0;
  }

  /**
   * hasCallback(name, callback)
   * Check if a callback exists in the queue.
   * Example:
   * hooks.hasCallback('myHook', () => {
   *    console.log('myHook ran!')
   * })
   */
  hasCallback(name: string, callback: any) {
    return (
      !!this.queue[name] &&
      this.queue[name].filter((el: any) => el.includes(callback))
    );
  }
};

export default new Hooks();
