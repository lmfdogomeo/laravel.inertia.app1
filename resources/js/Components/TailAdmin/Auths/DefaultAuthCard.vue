<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['subtitle', 'title', 'customClasses'])
</script>

<template>
  <!-- ====== Forms Section Start -->
  <div
    class="flex-1 bg-white border rounded-sm md:flex-none border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="flex flex-wrap items-center">
      <div class="hidden w-full xl:block xl:w-1/2">
        <div class="py-17.5 px-26 text-center">
          <Link class="mb-5.5 inline-block" :href="route('landing')">
            <img class="hidden dark:block" src="@/assets/images/logo/logo.svg" alt="Logo" />
            <img class="dark:hidden" src="@/assets/images/logo/logo-dark.svg" alt="Logo" />
          </Link>

          <p class="font-medium 2xl:px-20">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit suspendisse.
          </p>

          <span class="inline-block mt-15">
            <img src="@/assets/images/illustration/illustration-03.svg" alt="illustration" />
          </span>
        </div>
      </div>
      <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 xl:border-l-2">
        <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
          <span class="mb-1.5 block font-medium">{{ props.subtitle }}</span>
          <h2 class="text-2xl font-bold text-black mb-9 dark:text-white sm:text-title-xl2">
            {{ props.title }}
          </h2>

          <slot></slot>
        </div>
      </div>
    </div>
  </div>
  <!-- ====== Forms Section End -->
</template>
