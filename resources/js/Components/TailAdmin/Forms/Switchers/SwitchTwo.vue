<script setup>
import { ref } from 'vue'

const switcherToggle = ref(false)
</script>

<template>
  <div>
    <label for="toggle2" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          id="toggle2"
          type="checkbox"
          class="sr-only"
          @change="switcherToggle = !switcherToggle"
        />
        <div class="h-5 w-14 rounded-full bg-meta-9 shadow-inner dark:bg-[#5A616B]"></div>
        <div
          :class="switcherToggle && '!right-0 !translate-x-full !bg-primary dark:!bg-white'"
          class="absolute left-0 transition bg-white rounded-full dot -top-1 h-7 w-7 shadow-switch-1"
        ></div>
      </div>
    </label>
  </div>
</template>
