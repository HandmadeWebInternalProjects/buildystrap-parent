const lsExpire = class {
  constructor(name, hours) {
    this.name = name
    this.storage = window.localStorage
    this.timeToExpire = 1000 * 60 * 60 * parseFloat(hours)
  }

  // Check if storage with this name exists at all
  checkStorage() {
    return this.storage.getItem(this.name) ? true : false
  }

  // Test if the timestamp associated with this storage item is after right now
  isExpired() {
    // Check if the item has ever been saved to storage
    if (this.checkStorage()) {

      // Unwrap it
      let storageItem = this.getStorage();
      let timeStamp = storageItem.timestamp;

      // Get current time optionally pass a custom date in to compare against that instead
      const pointInTime = new Date().getTime()
      // Compare the current time from when it was first timestamped, see if it's been longer than expiry                
      const expired = (pointInTime - timeStamp) > this.timeToExpire;

      return expired
    } else {
      // If it doesn't exist, then it is als
      return true
    }
  }

  getStorage() {
    if (this.checkStorage()) {
      return JSON.parse(this.storage.getItem(this.name));
    } else {
      //   console.log(new Error('there is no local storage item with that name'));
    }
  }

  setStorage() {
    let currentTime = new Date().getTime()

    // Save timestamp and optional data to storage
    const dump = {
      timestamp: currentTime,
    }

    this.storage.setItem(this.name, JSON.stringify(dump))
  }

  clearStorage() {
    if (this.storage.getItem(this.name)) {
      this.storage.removeItem(this.name)
    }
  }
}

const cookieHelper = class {
  constructor(name, hours) {
    this.name = name
    this.storage = window.localStorage
    this.timeToExpire = 1000 * 60 * 60 * parseFloat(hours)
  }

  // Set Cookie
  setCookie() {
    let date = new Date();
    date.setTime(date.getTime() + this.timeToExpire);
    if (!this.checkCookie()) {
      document.cookie = `${this.name}= true; expires= ${date.toGMTString()};`
    }
  }

  // Get Cookie 
  getCookie() {
    if (this.checkCookie()) {
      let cookie = document.cookie.match('(^|;) ?' + this.name + '=([^;]*)(;|$)');
      return cookie ? cookie[2] : null;
    }
  }

  // Check if storage with this name exists at all
  checkCookie() {
    if (document.cookie.split(';').filter((item) => item.trim().startsWith(`${this.name}=`)).length) {
      return true
    }
    return false
  }

  // Delete this cookie
  clearCookie() {
    if (this.checkCookie()) {
      document.cookie = `${this.name}= ; expires=Thu, 01 Jan 1970 00:00:00 GMT`
    }
  }
}

export { lsExpire, cookieHelper }
