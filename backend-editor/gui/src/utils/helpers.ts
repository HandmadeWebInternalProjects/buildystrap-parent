const debounce = (fn: any, delay: number) => {
  let timeoutID: ReturnType<typeof setTimeout>
  return function (this: any) {
    clearTimeout(timeoutID)
    timeoutID = setTimeout(() => {
      // eslint-disable-next-line prefer-rest-params
      fn.apply(this, arguments)
    }, delay)
  }
}

const tryParseJSON = (jsonString: string) => {
  if (jsonString) {
    try {
      const o = JSON.parse(jsonString)

      // Handle non-exception-throwing cases:
      // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
      // but... JSON.parse(null) returns null, and typeof null === "object",
      // so we must check for that, too. Thankfully, null is falsey, so this suffices:
      if (o && typeof o === "object") {
        return o
      }
    } catch (e) {
      console.log(
        "You didn't paste valid JSON, please re-try copying the section and paste again."
      )
    }

    return false
  }
}

const UCFirst = (text: string): string => {
  return text.charAt(0).toUpperCase() + text.slice(1)
}

const spaceToDash = (str: string): string => {
  str = str.replace(/\s+/g, "-").toLowerCase()
  return str
}

const stripTrailingSlash = (str: string) => {
  return str.endsWith("/") ? str.slice(0, -1) : str
}

const slugToStr = (str) => {
  var i,
    frags = str.split("-")
  for (i = 0; i < frags.length; i++) {
    frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1)
  }
  str = frags.join(" ")
  return str.substring(0, str.lastIndexOf(" "))
}

export {
  debounce,
  UCFirst,
  spaceToDash,
  tryParseJSON,
  stripTrailingSlash,
  slugToStr,
}
