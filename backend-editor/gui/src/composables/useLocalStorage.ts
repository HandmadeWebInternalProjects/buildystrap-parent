export const useLocalStorage = (page_id: number) => {
  const getPageCache = () => {
    const builderCache = getStorageWithExpiry(`buildy_builder_cache`)
    return builderCache?.[`id-${page_id}`] || false
  }

  const updatePageCache = (path: string, payload: any) => {
    let builderCache = getStorageWithExpiry(`buildy_builder_cache`)
    if (!builderCache) {
      builderCache = {}
    }
    if (!builderCache[`id-${page_id}`]) {
      builderCache[`id-${page_id}`] = {}
    }
    builderCache[`id-${page_id}`][path] = payload
    setStorageWithExpiry(`buildy_builder_cache`, builderCache)
  }

  const getStorageWithExpiry = (key: string) => {
    const storage = localStorage.getItem(key)
    if (storage) {
      const storageObj = JSON.parse(storage)
      if (storageObj.expiry && storageObj.expiry < Date.now()) {
        localStorage.removeItem(key)
        return null
      }
      return storageObj.value
    }
    return null
  }

  const setStorageWithExpiry = (key: string, value: any, hours = 1) => {
    localStorage.setItem(
      key,
      JSON.stringify({
        value,
        expiry: Date.now() + 1000 * 60 * 60 * hours,
      })
    )
  }

  return {
    getPageCache,
    updatePageCache,
    getStorageWithExpiry,
    setStorageWithExpiry,
  }
}
