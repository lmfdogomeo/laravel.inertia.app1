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
    class="block w-full p-3 font-medium text-center text-black transition border rounded border-stroke bg-gray hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1"
  >
    <slot />
  </button>
</template>
