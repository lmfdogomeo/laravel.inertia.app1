<script setup>
import { ref, useModel, watch } from 'vue';

const props = defineProps(['label', 'type', 'placeholder', 'modelValue'])
// const props = defineProps({
//   label: String,
//   type: String,
//   placeholder: String,
//   modelValue: {
//     type: String,
//     required: true,
//   },
// })

const emits = defineEmits(['update:modelValue']);

</script>

<template>
  <div class="mb-4">
    <label class="mb-2.5 block font-medium text-black dark:text-white">{{ props.label }}</label>
    <div class="relative">
      <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="props.type"
        :placeholder="props.placeholder"
        class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-lg outline-none border-stroke focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:text-white"
      />

      <span class="absolute right-4 top-4">
        <slot></slot>
      </span>

      <slot name="error"></slot>
    </div>
  </div>
</template>
