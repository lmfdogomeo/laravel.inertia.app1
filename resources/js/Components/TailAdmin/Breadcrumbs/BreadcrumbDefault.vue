<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['pageTitle'])
</script>

<template>
  <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="font-semibold text-black text-title-md2 dark:text-white">
      {{ props.pageTitle }}
    </h2>

    <nav>
      <slot name="links">
        <ol class="flex items-center gap-2">
          <li>
            <Link class="font-medium" :href="route('dashboard')"> Dashboard / </Link>
          </li>
          <li class="font-medium text-primary">{{ props.pageTitle }}</li>
        </ol>
      </slot>
    </nav>
  </div>
</template>
