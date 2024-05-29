<script setup>
import { ref } from 'vue'

const checkboxToggle = ref(false)
</script>

<template>
  <div>
    <label for="checkboxLabelOne" class="flex items-center cursor-pointer select-none">
      <div class="relative">
        <input
          type="checkbox"
          id="checkboxLabelOne"
          class="sr-only"
          @change="checkboxToggle = !checkboxToggle"
        />
        <div
          :class="checkboxToggle && 'border-primary bg-gray dark:bg-transparent'"
          class="flex items-center justify-center w-5 h-5 mr-4 border rounded"
        >
          <span :class="checkboxToggle && 'bg-primary'" class="h-2.5 w-2.5 rounded-sm"></span>
        </div>
      </div>
      Checkbox Text
    </label>
  </div>
</template>
