<script setup lang="ts">
import { ref, watch } from "vue"
import { useStacks } from "./components/stacks/useStacks"

const contentEl = document.getElementById("content")
const builder = ref<{ [key: string]: any }[]>([])

const { getStacks } = useStacks()

if (contentEl && contentEl.innerText) {
  builder.value = [JSON.parse(contentEl.innerText)]
}

const toggleModuleSelection = ref(false)

watch(
  builder,
  (newValue) => {
    console.log(JSON.stringify(newValue[0]))
    contentEl && (contentEl.innerText = JSON.stringify(newValue[0]))
  },
  {
    deep: true,
  }
)
</script>

<template>
  <stacks v-if="getStacks.length"></stacks>
  <div class="container d-flex flex-column rounded gap-3 mt-4 px-0 pb-5">
    <div
      class="promote d-flex align-items-center bg-indigo-500 text-white rounded p-3">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        xml:space="preserve"
        width="98.96"
        height="91.04"
        style="-webkit-text-stroke-color: #fff"
        fill="#fff"
        stroke="#fff">
        <path
          stroke-miterlimit="10"
          d="M27.168 58.107s-.5 2.377 4.333 5.113c4.833 2.736 6.833 2.736 6.833 2.736s-2.75-3-2.417-4.417c.333-1.417 5.417 4.083 10.333 2.417 0 0-1.655-1.591-2.953-5.004-1.089-2.725-2.157-3.59-3.006-4.288 0 0 6.708-7.125 4.958-17.125 0 0-.75-4.75-3.5-7.75 0 0 6.167 8.167 16.5 3.417 0 0-1.167-3.75-5.833-6.917s-8.25-1.333-12.583-1.417c-4.333-.083-5.25-3.667-5.25-3.667s-3 2.75-6.333 1.667-3.25-3.25-8.167-1.667-9.083 7.5-9.083 7.5 8.333 5.333 12.833-2.583c0 0-4 10.5-5.667 14-1.667 3.5-7.5 20.5 14 17.667"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M24.351 20.87s6.901-7.705 11.401-8.893c4.5-1.188 6.334-1.185 8.438-.625l-2.691 2.683-7.956 7.932s8.96-10.616 18.147-7.991l-8.535 10.687"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <circle
          stroke-miterlimit="10"
          cx="23.252"
          cy="36.29"
          r=".75"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <circle
          stroke-miterlimit="10"
          cx="38.418"
          cy="37.79"
          r=".75"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M21.168 49.54s3.292.75 3.625 3.208M28.203 53.597s1.625-2.417 4.917-1.875"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M45.484 39.375s2.851 6.582 12.101 6.415c9.25-.167 22.167 4 23.417 11.167s-1.062 22.25-4.146 23.083h-6.167l-.438-11.5s-2.083 1.583-7.583 1.583-8.5-3.667-8.5-3.667"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M42.626 64.086s6.209 15.537 9.875 15.954h6.584V69.57"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M38.335 65.957s4.583 14.083 8.667 14.083h5.5M64.834 70.032l2 10.008h4.418M79.389 53.522s4.946 3.81 8.571.268c0 0-1.308 7.958-6.613 8.083"
          fill="none"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round" />
        <path
          stroke-miterlimit="10"
          d="M27.973 16.588s3.216 2.827 7.466 2.452M32.903 12.96s1.211 3.19 6.842 2.823M38.02 18.165s2.262 4.237 8.059 2.837M43.11 14.793s.857 2.958 5.749 2.728"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>
      <h2 style="font-size: 32px">BuildyStrap Global Module</h2>
    </div>
    <div class="section p-4 bg-300">
      <module-base
        v-if="builder.length"
        :component="builder[0]"
        :columns="builder"
        :component-index="0"
        :custom-settings="{ clone: false }" />
      <button
        v-else
        @click="toggleModuleSelection = !toggleModuleSelection"
        type="button"
        class="bg-200 text-800 border-0 rounded-1">
        <font-awesome-icon
          :icon="['fas', 'plus-circle']"
          width="25"
          height="25"
          fill="currentColor"
          class="cursor-pointer pulse"></font-awesome-icon>
      </button>
      <buildy-stack
        @close="toggleModuleSelection = false"
        v-if="toggleModuleSelection"
        narrow
        name="module-selector">
        <div class="p-4 py-5">
          <module-selector :parent-array="builder" />
        </div>
      </buildy-stack>
    </div>
  </div>
</template>