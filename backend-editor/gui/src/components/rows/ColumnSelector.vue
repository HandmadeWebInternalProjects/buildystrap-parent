<script setup lang="ts">
import { createModule } from "../../factories/modules/moduleFactory"
import { ref } from "vue"

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits<{
  (event: "close", boolean: boolean): void
}>()

const row = ref(props.component)

const layouts = [
  "12",
  "6 6",
  "4 4 4",
  "3 3 3 3",
  "1 1 1 1 1",
  "2 2 2 2 2 2",
  "1 1 1 1 1 1 1",
  "3 6 3",
  "10 2",
  "2 10",
  "9 3",
  "3 9",
  "8 4",
  "4 8",
  "7 5",
  "5 7",
  "3 3 8",
  "8 3 3",
]
const changeLayout = (layout: string) => {
  const newLayout: object[] = []

  // Turn the clicked string into an array at each space e,g ["6", "6"]
  const layoutArr = layout.split(" ")

  // Loop the new array and create a column for each item
  layoutArr.forEach((col) => {
    let newCol = createModule("Column", {})

    // If we are divisible by 2, set the md breakpoint to 6 (translates to col-md-6)
    if (layoutArr.length > 3) {
      newCol.config.columnSizes.md = 12 / Math.ceil(layoutArr.length / 2)
      // Set the lg size to selected value
      newCol.config.columnSizes.lg = col
    } else {
      newCol.config.columnSizes.md = col
    }

    // Not the smallest "xs" (mobile) size will remain unchanged from the newColumnStructure object which is 12
    newLayout.push(newCol)
  })

  const oldModules: { [key: string]: any } = {}
  const oldSettings: any = {}
  const colCount = row.value.columns.length

  if (colCount) {
    row.value.columns.forEach((component: any, index: number) => {
      oldSettings[index] = {}
      oldSettings[index].inline = component.inline
      oldSettings[index].attributes = component.attributes
      if (component.modules.length) {
        oldModules[index] = []
        component.modules.forEach((oldModule: any) => {
          oldModules[index].push(oldModule)
        })
      }
    })
  }

  row.value.config.columnCount = layoutArr.reduce((a, b) => a + +b, 0)

  //   console.log(
  //     "LAYOUT CHANGE",
  //     layoutArr.reduce((a, b) => a + +b, 0)
  //   );

  // Change column layout
  row.value.columns.splice(0, colCount, ...newLayout)

  // Add old modules to new layout
  Object.keys(oldModules).forEach((key) => {
    if (row.value.columns[key]) {
      row.value.columns[key].modules.push(...oldModules[key])
    } else {
      row.value.columns[0].modules.push(...oldModules[key])
    }
  })

  // Add old settings to new layout
  Object.keys(oldSettings).forEach((key) => {
    if (row.value.columns[key]) {
      row.value.columns[key] = {
        ...row.value.columns[key],
        ...oldSettings[key],
      }
    }
  })
}
const colCount = (i: number) => {
  const count = layouts[i].split(" ").reduce((a, b) => a + +b, 0)

  return 12 % count !== 0 ? `--bs-columns: ${count}` : ""
}
const gridConversion = (string: string) => {
  // Turn the clicked string into an array at each space e,g ["6", "6"]
  let array = string.split(" ")

  // Loop through and create the (currently single-sized) preview thumbnail classes
  // So the same grid you click is what the builder uses
  array.forEach((column, index) => {
    array[index] = "g-col-" + column
  })

  // Return the array e.g ["col-md-6", "col-md-6"]
  return array
}

const selectorToggle = ref(true)

const handleClose = () => {
  selectorToggle.value = false
  emit("close", true)
}
</script>

<template>
  <buildy-stack
    @close="handleClose"
    v-if="selectorToggle"
    half
    name="column-selector">
    <div class="p-5 bg-grey-40 text-grey-80">
      <ul
        class="list-unstyled relative grid-cols-2 flex flex-wrap"
        style="columns: 2">
        <li
          class="column-section-wrapper flex-shrink-0 flex-grow px-2 mb-0 cursor-pointer"
          @click="changeLayout(layout)"
          v-for="(layout, i) in layouts"
          :key="layout">
          <div
            class="mb-2 w-full grid gap-2 bg-500 rounded p-1"
            :style="colCount(i)">
            <div
              v-for="(colClass, index) in gridConversion(layout)"
              :key="row.uuid + index"
              :class="colClass">
              <div class="bg-200" style="height: 60px"></div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </buildy-stack>
</template>

<style scoped>
.column-section-wrapper {
  flex-basis: 50%;
  box-sizing: border-box;
  transition: transform 0.2s;
}

.column-section-wrapper:hover {
  transform: scale(1.04);
}

.column-section-wrapper:active {
  transform: scale(0.9);
}
</style>
