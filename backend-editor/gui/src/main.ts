import "vite/modulepreload-polyfill"
import { createApp } from "vue"
import type { BuildyInterface } from "./components/Buildy"
import App from "./App.vue"
import GlobalModuleBuilder from "./GlobalModuleBuilder.vue"
import { useBuilderStore, type BuildyConfig } from "./stores/builder"

import * as Vue from "vue"
window.Vue = <any>Vue

import "bootstrap"

declare global {
  interface Window {
    app: any
    Buildy: BuildyInterface
    builderContent?: string
    wp?: any
    tinymce?: any
    jQuery: any
    wpLink: any
  }
}

const configOptions: BuildyConfig = JSON.parse(
  document.querySelector("#config")?.innerHTML || ""
)

const app = configOptions.is_global_module
  ? createApp(GlobalModuleBuilder)
  : createApp(App)

import { Buildy } from "./components/Buildy"
window.app = app
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
  faPlay,
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
  faMobileAlt,
  faClipboard,
  faClipboardCheck,
  faArrowUpRightFromSquare,
  faLink,
} from "@fortawesome/free-solid-svg-icons"

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome"

/* add icons to the library */
library.add(
  faPlusCircle,
  faPenToSquare,
  faPlus,
  faPlay,
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
  faCircleQuestion,
  faMobileAlt,
  faClipboard,
  faClipboardCheck,
  faArrowUpRightFromSquare,
  faLink
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
