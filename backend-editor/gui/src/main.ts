import { createApp } from "vue";
import { createPinia } from "pinia";
import { Buildy } from "./components/Buildy";

import App from "./App.vue";

const app = createApp(App);
app.use(createPinia());

import draggable from "vuedraggable";
app.component("draggable", draggable);

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import specific icons */
import {
  faPlusCircle,
  faPenToSquare,
  faCopy,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

/* add icons to the library */
library.add(faPlusCircle, faPenToSquare, faCopy, faTrash);

/* add font awesome icon component */
app.component("font-awesome-icon", FontAwesomeIcon);

const bundledComponents = import.meta.globEager("./components/**/*.vue");
Object.entries(bundledComponents).forEach(([path, m]) => {
  const name =
    path
      ?.split("/")
      ?.pop()
      ?.replace(/\.\w+$/, "") || "";
  app.component(name, m.default);
});

declare global {
  interface Window {
    Buildy?: any;
  }
}

window.Buildy = new Buildy(app);

window.Buildy.start();
