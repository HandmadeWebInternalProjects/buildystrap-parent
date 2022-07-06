import "vite/modulepreload-polyfill"
import { createApp } from "vue"
import type { BuildyInterface } from "./components/Buildy"
import App from "./App.vue"
import GlobalModuleBuilder from "./GlobalModuleBuilder.vue"
import { useBuilderStore, type BuildyConfig } from "./stores/builder"
import "bootstrap"

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

// Setup main store system
import { createPinia } from "pinia"
app.use(createPinia())

import PortalVue from "portal-vue"
app.use(PortalVue)

import draggable from "vuedraggable"
app.component("draggable", draggable)

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core"

/* import specific icons */
import {
  faPlusCircle,
  faPenToSquare,
  faCopy,
  faTrash,
  faTrashAlt,
  faEllipsisVertical,
  faPlus,
  faColumns,
  faParagraph,
  faAnchor,
  faWandMagicSparkles,
  faChevronUp,
  faChevronDown,
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
  faTrashAlt,
  faEllipsisVertical,
  faParagraph,
  faAnchor,
  faWandMagicSparkles,
  faChevronUp,
  faChevronDown
)
/* add font awesome icon component */
app.component("font-awesome-icon", FontAwesomeIcon)

const bundledComponents = import.meta.globEager("./components/**/*.vue")
Object.entries(bundledComponents).forEach(([path, m]) => {
  const name =
    path
      ?.split("/")
      ?.pop()
      ?.replace(/\.\w+$/, "") || ""
  app.component(name, m.default)
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

import { Buildy } from "./components/Buildy"
window.Buildy = new Buildy(app)

import { useFieldType, commonProps } from "./components/fields/useFieldType"
window.Buildy.$composables = {
  useFieldType,
}
window.Buildy.$propTypes.moduleProps = {
  commonProps,
}

window.tinymce.baseURL = `${configOptions?.theme_url}/backend-editor/gui/src/lib/tinymce`
window.tinymce.baseURI.source = `${configOptions?.theme_url}/backend-editor/gui/src/lib/tinymce`

window.Buildy.start()
