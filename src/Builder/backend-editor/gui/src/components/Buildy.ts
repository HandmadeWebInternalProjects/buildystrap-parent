import { createApp } from "vue";
import Hooks from "../bootstrap/Hooks";
import Components from "../bootstrap/Components";
import FieldConditions from "../bootstrap/FieldConditions";
const hooks = new Hooks();
const components = new Components();
const conditions = new FieldConditions();

export const buildyApp = createApp({
  data() {
    return {
      bootingCallbacks: [],
      bootedCallbacks: [],
    };
  },

  computed: {
    $components() {
      return components;
    },

    $hooks() {
      return hooks;
    },

    $conditions() {
      return conditions;
    },
  },

  methods: {
    booting(callback) {
      this.bootingCallbacks.push(callback);
    },

    booted(callback) {
      this.bootedCallbacks.push(callback);
    },

    app(app) {
      this.$app = app;
    },

    config(config) {
      this.$store.commit("statamic/config", config);
    },

    start() {
      this.bootingCallbacks.forEach((callback) => callback(this));
      this.bootingCallbacks = [];

      this.$app = new createApp(this.$app);

      this.$components.$root = this.$app;

      this.bootedCallbacks.forEach((callback) => callback(this));
      this.bootedCallbacks = [];
    },

    component(name, component) {
      buildyApp.component(name, component);
    },
  },
});
