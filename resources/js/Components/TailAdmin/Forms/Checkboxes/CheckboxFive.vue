<script setup>
import { ref } from 'vue'

const checkboxToggle = ref(false)
</script>

<template>
  <div>
    <label for="checkboxLabelFive" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          type="checkbox"
          id="checkboxLabelFive"
          class="sr-only"
          @change="checkboxToggle = !checkboxToggle"
        />
        <div
          :class="checkboxToggle && '!border-4'"
          class="flex items-center justify-center w-5 h-5 mr-4 border rounded-full box border-primary"
        >
          <span class="h-2.5 w-2.5 rounded-full bg-white dark:bg-transparent"> </span>
        </div>
      </div>
      Checkbox Text
    </label>
  </div>
</template>
