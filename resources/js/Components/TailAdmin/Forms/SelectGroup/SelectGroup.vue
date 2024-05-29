<script setup>
import { ref } from 'vue'

const { label, placeholder, modelValue } = defineProps(['label', 'options', 'modelValue']);
const emits = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="">
    <label class="mb-2.5 block text-black dark:text-white">{{ label || "" }}</label>

    <div class="relative z-20 bg-transparent dark:bg-form-input">
      <select
        :value="modelValue"
        class="relative z-20 w-full px-5 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
        @change="(e) => emits('update:modelValue', e.target.value)"
      >
      <slot></slot>
      </select>
    </div>

    <slot name="error"></slot>
  </div>
</template>
