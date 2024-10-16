export const getDeep = (obj: any, path: string | string[]) => {
  path = Array.isArray(path) ? path : path.split(".").filter((path) => path)
  const data = path.reduce((a, b) => a && a[b], obj)
  if (!data) {
    return
  }
  return data
}

export const getDeepArray = (obj: any, path: string | string[]) => {
  path = Array.isArray(path) ? path : path.split(".").filter((path) => path)
  const data: any = path.reduce((a, b) => {
    console.log(b, isNaN(Number(b)))
    if (Array.isArray(a) && isNaN(Number(b))) {
      return a.map((item) => getDeep(item, b))
    }
    return a && a[b]
  }, obj)

  if (!data) {
    return Boolean(data)
  }
  return data
}

const isObject = (value: any) => {
  return !!(value && typeof value === "object" && !Array.isArray(value))
}

export const findNestedObject = (
  object: { [key: string]: any } = {},
  keyToMatch = ""
): any => {
  if (isObject(object)) {
    const entries = Object.entries(object)

    for (let i = 0; i < entries.length; i++) {
      const [objectKey, objectValue]: [objectKey: string, objectValue: any] =
        entries[i]

      if (objectKey === keyToMatch) {
        return object[objectKey]
      }

      if (isObject(objectValue)) {
        // return console.log("†est", { objectValue, keyToMatch })
        const child = findNestedObject(objectValue, keyToMatch)

        if (child !== null) {
          return child
        }
      }
    }
  }

  return null
}
