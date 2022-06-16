<script setup lang="ts">
import { ref, watch, computed } from "vue";
import { recursifyID } from "./utils/id";

const pageBuilderOutput = computed((): string => {
  if (builder.value.length) {
    return JSON.stringify(builder.value);
  }
  return "";
});

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
  // {
  //   uuid: "10",
  //   type: "section",
  //   rows: [
  //     {
  //       uuid: "2",
  //       type: "row",
  //       columns: [
  //         {
  //           uuid: "3",
  //           type: "column",
  //           modules: [],
  //         },
  //         {
  //           uuid: "4",
  //           type: "column",
  //           modules: [],
  //         },
  //         {
  //           uuid: "5",
  //           type: "column",
  //           modules: [],
  //         },
  //       ],
  //     },
  //     {
  //       uuid: "2",
  //       type: "row",
  //       columns: [
  //         {
  //           uuid: "3",
  //           type: "column",
  //           modules: [],
  //         },
  //         {
  //           uuid: "4",
  //           type: "column",
  //           modules: [],
  //         },
  //         {
  //           uuid: "5",
  //           type: "column",
  //           modules: [],
  //         },
  //       ],
  //     },
  //   ],
  // },
]);
recursifyID(builder.value);

watch(
  builder,
  (newValue) => {
    console.log(newValue);
  },
  {
    deep: true,
  }
);
</script>

<template>
  <textarea
    id="buider-output"
    class="mt-1 mb-4 w-full invisible"
    name="content"
    :value="pageBuilderOutput"
  />
  <div class="container d-flex flex-column rounded gap-3">
    <draggable
      :list="builder"
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
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background: $gray-100;
  border-right: 1px solid $gray-300;
  &::before {
    width: 12px;
    height: 24px;
    content: "";
    display: block;
    background-image: radial-gradient($gray-400 0.05rem, transparent 0);
    background-repeat: both;
    background-size: 6px 6px;
    background-position: 1px -1px;
    position: absolute;
  }
}
</style>
