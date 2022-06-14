<template>
  <div
    class="module-controls d-flex text-center"
    :data-testid="`${type || component.type}-controls`"
  >
    <ul class="list-unstyled d-flex m-0 p-0 gap-3 overflow-x-auto pb-0">
      <li
        class="flex-shrink-0"
        v-for="(setting, i) in settings"
        :key="component.uuid + type + i"
        :title="setting.title"
      >
        <component
          v-if="setting.component"
          :component="component"
          :value="value"
          :index="index"
          :is="setting.component"
        />
        <font-awesome-icon
          v-else
          :icon="setting.icon"
          @click="setting.action"
          width="15"
          height="15"
          fill="currentColor"
          class="flex cursor-pointer pulse"
          :class="[setting.class || '']"
        ></font-awesome-icon>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { computed, ref } from "vue";
import { recursifyID } from "../utils/id";
// import { UCFirst } from "../../functions/helpers";
// import { createModule } from "../../factories/modules/moduleFactory";
// import { EvaIcon } from "vue-eva-icons";
// import ModuleSelector from "../ModuleSelector.vue";
// import SettingStack from "../shared/SettingStack.vue";
// import ClipboardFunctions from "../../mixins/ClipboardFunctions";

const props = defineProps({
  value: Array,
  index: {
    type: Number,
    default: 0,
  },
  customSettings: {
    type: Object,
    default: () => {},
  },
  direction: {
    type: String,
  },
  component: {
    type: Object,
    required: true,
  },
  type: String,
});

const parentArray = ref(props.value || []);
const index = ref(props.index);
const component = ref(props.component);

const settings = computed(() => {
  return Object.values({
    menu: {
      icon: ["fas", "pen-to-square"],
      title: "Open settings modal",
      // action: this.openModal,
      order: 10,
    },
    add: {
      icon: ["fas", "plus-circle"],
      title: "Add module right after this module",
      // action: this.addModule,
      order: 20,
    },
    clone: {
      icon: ["fas", "copy"],
      title: "Clone this module",
      action: cloneModule,
      // condition: this.component,
      order: 30,
    },
    // clipboardCopy: {
    //   // icon: this.isValidPasteLocation ? "clipboard" : "clipboard-outline",
    //   title: "Copy module to clipboard",
    //   // action: this.isValidPasteLocation
    //   //   ? this.pasteFromClipboard
    //   //   : this.copyToClipboard,
    //   order: 30,
    //   // class: this.isValidPasteLocation ? "pulse-constant" : "",
    // },
    delete: {
      icon: ["fas", "trash"],
      title: "Delete this module",
      // action: this.removeModule,
      order: 40,
    },
    // ...this.customSettings,
  })
    .filter((el: any) => el)
    .sort((a: { order: number }, b: { order: number }) => a.order - b.order);
});

const addModule = () => {
  // const newModule = createModule(UCFirst(this.type || this.component.type));
  // this.value.splice(this.index + 1, 0, newModule);
};

const cloneModule = () => {
  let clone = JSON.parse(JSON.stringify(component.value));
  // Generate ID's for each nested module
  recursifyID(clone);
  console.log({ clone });
  console.log(parentArray.value);
  parentArray.value.splice(index.value + 1, 0, clone);
};

const removeModule = () => {
  // this.value.splice(this.index, 1);
};

const openModal = () => {
  // this.$modals.open(name);
};
</script>
