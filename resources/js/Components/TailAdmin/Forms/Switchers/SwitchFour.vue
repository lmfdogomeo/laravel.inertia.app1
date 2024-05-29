<script setup>
import { ref } from 'vue'

const switcherToggle = ref(false)
</script>

<template>
  <div>
    <label for="toggle4" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          type="checkbox"
          id="toggle4"
          class="sr-only"
          @change="switcherToggle = !switcherToggle"
        />
        <div
          :class="switcherToggle && '!bg-primary'"
          class="block h-8 bg-black rounded-full w-14"
        ></div>
        <div
          :class="switcherToggle && '!right-1 !translate-x-full'"
          class="absolute flex items-center justify-center w-6 h-6 transition bg-white rounded-full left-1 top-1"
        ></div>
      </div>
    </label>
  </div>
</template>
