<script setup>
import { ref } from 'vue'

const checkboxToggle = ref(false)
</script>

<template>
  <div>
    <label for="checkboxLabelThree" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          type="checkbox"
          id="checkboxLabelThree"
          class="sr-only"
          @change="checkboxToggle = !checkboxToggle"
        />
        <div
          :class="checkboxToggle && 'border-primary bg-gray dark:bg-transparent'"
          class="flex items-center justify-center w-5 h-5 mr-4 border rounded box"
        >
          <span :class="checkboxToggle && '!opacity-100'" class="opacity-0 text-primary">
            <svg
              class="h-3.5 w-3.5 stroke-current"
              fill="none"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </span>
        </div>
      </div>
      Checkbox Text
    </label>
  </div>
</template>
