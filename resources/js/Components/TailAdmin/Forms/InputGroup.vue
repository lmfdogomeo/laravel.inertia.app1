<script setup>
const { label, type, placeholder, customClasses, required, modelValue, inputClass, disabled } = defineProps({
  label: String,
  type: String,
  placeholder: String,
  customClasses: String,
  inputClass: String,
  required: {
    type: Boolean,
    default: false
  },
  modelValue: {
    type: [Object, String, Boolean]
  },
  disabled: [String, Boolean, null]
});

const emits = defineEmits(['update:modelValue']);
</script>

<template>
  <div :class="customClasses">
    <label class="mb-2.5 block text-black dark:text-white" v-if="label">
      {{ label }}
      <span v-if="required" class="text-meta-1">*</span>
    </label>
    <input
      :type="type"
      :placeholder="placeholder"
      class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
      :class="inputClass || ''"
      :value="modelValue"
      @change="(e) => emits('update:modelValue', e.target.value)"
      :disabled="disabled"
    />

    <slot name="error"></slot>
  </div>
</template>
