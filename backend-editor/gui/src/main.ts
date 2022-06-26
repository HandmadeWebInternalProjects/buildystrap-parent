import "vite/modulepreload-polyfill"
import { createApp, provide } from "vue"
import type { BuildyInterface } from "./components/Buildy"
import App from "./App.vue"
const app = createApp(App)

// import "bootstrap";

declare global {
  interface Window {
    Buildy: BuildyInterface
    builderContent?: string
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
  faEllipsisVertical,
  faPlus,
  faColumns,
  faParagraph,
  faAnchor,
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
  faEllipsisVertical,
  faParagraph,
  faAnchor
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

import { Buildy } from "./components/Buildy"
window.Buildy = new Buildy(app)

import { useBuilderStore } from "./stores/builder"
const { setRegisteredComponents } = useBuilderStore()
setRegisteredComponents(app?._context?.components || {})

import { $buildy } from "./injection_keys/buildy"

window.Buildy.start()
