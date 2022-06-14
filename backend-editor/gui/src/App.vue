<script setup lang="ts">
import { ref } from "vue";
import { recursifyID } from "./utils/id";

// interface Section {
//   type: string;
//   uuid: string;
//   rows: Row[];
// }

// interface Row {
//   type: string;
//   uuid: string;
//   columns: Column[];
// }

// interface Column {
//   type: string;
//   uuid: string;
//   modules: Module[];
// }

// interface Module {
//   type: string;
//   uuid: string;
//   value: object[];
// }

const builder = ref([
  {
    uuid: "1",
    type: "section",
    rows: [
      {
        uuid: "2",
        type: "row",
        columns: [
          {
            uuid: "3",
            type: "column",
            modules: [
              {
                uuid: "6",
                type: "text-module",
                fields: ["text-fieldtype"],
                value: "",
              },
            ],
          },
          {
            uuid: "4",
            type: "column",
            modules: [],
          },
          {
            uuid: "5",
            type: "column",
            modules: [],
          },
        ],
      },
      {
        uuid: "2",
        type: "row",
        columns: [
          {
            uuid: "3",
            type: "column",
            modules: [],
          },
          {
            uuid: "4",
            type: "column",
            modules: [],
          },
          {
            uuid: "5",
            type: "column",
            modules: [],
          },
        ],
      },
    ],
  },
  {
    uuid: "10",
    type: "section",
    rows: [
      {
        uuid: "2",
        type: "row",
        columns: [
          {
            uuid: "3",
            type: "column",
            modules: [],
          },
          {
            uuid: "4",
            type: "column",
            modules: [],
          },
          {
            uuid: "5",
            type: "column",
            modules: [],
          },
        ],
      },
      {
        uuid: "2",
        type: "row",
        columns: [
          {
            uuid: "3",
            type: "column",
            modules: [],
          },
          {
            uuid: "4",
            type: "column",
            modules: [],
          },
          {
            uuid: "5",
            type: "column",
            modules: [],
          },
        ],
      },
    ],
  },
]);
recursifyID(builder.value);
</script>

<template>
  <div class="container py-3 d-flex flex-column rounded gap-3">
    <draggable
      v-model="builder"
      handle=".sortable-handle"
      group="sections"
      item-key="uuid"
      class="section-draggable d-flex flex-grow flex-column gap-3 group"
    >
      <template #item="{ element, index }">
        <component
          :is="`grid-${element.type}`"
          :section-index="index"
          :sections="builder"
          :component="element"
        />
      </template>
    </draggable>
  </div>
</template>

<style lang="scss">
@import "./scss/app.scss";

.sortable-handle {
  width: 1rem;
  padding: 8px;
  cursor: -webkit-grab;
  cursor: grab;
  border: 1px solid rgba(0, 0, 0, 0.06);
  background-color: rgba(0, 0, 0, 0.03);
  background-image: url(../images/drag-dots.svg);
  background-position: 50% 50%;
  background-repeat: no-repeat;
}
</style>
