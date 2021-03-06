import "vite/modulepreload-polyfill"
import { createApp } from "vue"
import type { BuildyInterface } from "./components/Buildy"
import App from "./App.vue"
import GlobalModuleBuilder from "./GlobalModuleBuilder.vue"
import { useBuilderStore, type BuildyConfig } from "./stores/builder"

import "bootstrap"

// const popoverTriggerList = document.querySelectorAll(
//   '[data-bs-toggle="popover"]'
// )
// const popoverList = [...popoverTriggerList].map((popoverTriggerEl) =>
//   createPopper(popoverTriggerEl, { placement: "right", trigger: "focus" })
// )

declare global {
  interface Window {
    Buildy: BuildyInterface
    builderContent?: string
    wp?: any
    tinymce?: any
  }
}

const configOptions: BuildyConfig = JSON.parse(
  document.querySelector("#config")?.innerHTML || ""
)

const app = configOptions.is_global_module
  ? createApp(GlobalModuleBuilder)
  : createApp(App)

import { Buildy } from "./components/Buildy"
window.Buildy = new Buildy(app)

// Setup main store system
import { createPinia } from "pinia"
app.use(createPinia())

import PortalVue from "portal-vue"
app.use(PortalVue)

import draggable from "vuedraggable"
window.Buildy.registerComponent("draggable", draggable)

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core"

/* import specific icons */
import {
  faPlusCircle,
  faPenToSquare,
  faCopy,
  faTrash,
  faImages,
  faEarthOceania,
  faTrashAlt,
  faEllipsisVertical,
  faPlus,
  faColumns,
  faParagraph,
  faAnchor,
  faWandMagicSparkles,
  faChevronUp,
  faChevronDown,
  faStop,
  faHeading,
  faEquals,
  faCircleQuestion,
} from "@fortawesome/free-solid-svg-icons"

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome"

/* add icons to the library */
library.add(
  faPlusCircle,
  faPenToSquare,
  faPlus,
  faColumns,
  faCopy,
  faTrash,
  faImages,
  faEarthOceania,
  faTrashAlt,
  faEllipsisVertical,
  faParagraph,
  faAnchor,
  faWandMagicSparkles,
  faChevronUp,
  faChevronDown,
  faStop,
  faHeading,
  faEquals,
  faCircleQuestion
)
/* add font awesome icon component */
window.Buildy.registerComponent("font-awesome-icon", FontAwesomeIcon)

const bundledComponents = import.meta.globEager("./components/**/*.vue")
Object.entries(bundledComponents).forEach(([path, m]) => {
  const name =
    path
      ?.split("/")
      ?.pop()
      ?.replace(/\.\w+$/, "") || ""
  window.Buildy.registerComponent(name, m.default)
})

const { setRegisteredComponents, setConfig } = useBuilderStore()

if (configOptions) {
  setConfig(configOptions)
}

setRegisteredComponents(app?._context?.components || {})

// if (configOptions.globalSections) {
//   setGlobals(configOptions.globalSections, "sections")
// }

// if (configOptions.globalModules) {
//   setGlobals(configOptions.globalModules, "modules")
// }

import { useFieldType, commonProps } from "./components/fields/useFieldType"
window.Buildy.$composables = {
  useFieldType,
}
window.Buildy.$propTypes.moduleProps = {
  commonProps,
}

window.tinymce.baseURL = `${configOptions?.theme_url}/backend-editor/gui/src/lib/tinymce`
window.tinymce.baseURI.source = `${configOptions?.theme_url}/backend-editor/gui/src/lib/tinymce`

window.dispatchEvent(new Event("buildy:ready"))
