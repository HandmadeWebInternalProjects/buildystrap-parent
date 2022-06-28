import "vite/modulepreload-polyfill"
import { createApp, provide } from "vue"
import type { BuildyInterface } from "./components/Buildy"
import App from "./App.vue"
const app = createApp(App)

import "bootstrap"

declare global {
  interface Window {
    Buildy: BuildyInterface
    builderContent?: string
    wp?: any
    tinymce?: any
  }
}

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
  faWandMagicSparkles
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

const moduleBlueprints: { [key: string]: any } = JSON.parse(
  document.querySelector("#moduleBlueprints")?.innerHTML || ""
)

import { Buildy } from "./components/Buildy"
window.Buildy = new Buildy(app)

import { useBuilderStore } from "./stores/builder"
const { setRegisteredComponents, setFieldDefaults } = useBuilderStore()

if (moduleBlueprints) {
  setFieldDefaults(moduleBlueprints)
}

setRegisteredComponents(app?._context?.components || {})

import { useFieldType, commonProps } from "./components/fields/useFieldType"
window.Buildy.$composables = {
  useFieldType,
}
window.Buildy.$propTypes.moduleProps = {
  commonProps,
}

window.Buildy.start()
