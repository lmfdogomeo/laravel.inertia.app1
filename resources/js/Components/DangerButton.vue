<script setup>
defineProps({
  type: {
    type: String,
    default: "button",
  },
});
</script>

<template>
  <button
    :type="type"
    class="block w-full p-3 font-medium text-center text-white transition border rounded border-meta-1 bg-meta-1 hover:bg-opacity-90"
  >
    <slot />
  </button>
</template>
