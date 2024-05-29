<script setup>
import { ref } from 'vue'

const switcherToggle = ref(false)
</script>

<template>
  <div>
    <label for="toggle1" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          type="checkbox"
          id="toggle1"
          class="sr-only"
          @change="switcherToggle = !switcherToggle"
        />
        <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"></div>
        <div
          :class="switcherToggle && '!right-1 !translate-x-full !bg-primary dark:!bg-white'"
          class="absolute w-6 h-6 transition bg-white rounded-full left-1 top-1"
        ></div>
      </div>
    </label>
  </div>
</template>
