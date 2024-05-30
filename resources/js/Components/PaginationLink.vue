<script setup>
import { usePage, Link, router } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const props = defineProps({
  links: {
    type: Array,
    default: [],
  },
  from: {
    type: Number,
    default: 0,
  },
  to: {
    type: Number,
    default: 0,
  },
  total: {
    type: Number,
    default: 0,
  },
  onChange: Function,
});

const handleClickPaginate = (params) => {
  if (typeof props.onChange === "function") {
    props.onChange(params);
  } else {
    router.get(params.url);
  }
};
</script>

<template>
  <div
    class="flex items-center justify-between px-4 py-3 mt-5 bg-white border-gray-200 sm:px-6"
  >
    <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ from }}</span>
          to
          <span class="font-medium">{{ to }}</span>
          of
          <span class="font-medium">{{ total }}</span>
          results
        </p>
      </div>
      <div>
        <nav
          class="inline-flex -space-x-px rounded-md shadow-sm isolate"
          aria-label="Pagination"
        >
          <a
            v-for="(link, index) in links"
            :key="index"
            :href="link.url || '#'"
            @click.prevent="handleClickPaginate(link)"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold"
            :class="{
              'z-10 text-white bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600':
                link.active,
              'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0':
                !link.active,
              'cursor-not-allowed opacity-50 pointer-events-none': !link.url,
              'rounded-l-md': index === 0,
              'rounded-r-md': index === links.length - 1,
            }"
            v-html="link.label"
          ></a>
        </nav>
      </div>
    </div>
  </div>

  <!-- <div class="p-4 sm:p-6 xl:p-7.5 ml-auto">
    <nav>
      <ul class="flex flex-wrap items-center">
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="flex items-center justify-center w-8 h-8 rounded router-link-active router-link-exact-active hover:bg-primary hover:text-white"
            ><svg
              class="fill-current"
              width="8"
              height="16"
              viewBox="0 0 8 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M7.17578 15.1156C7.00703 15.1156 6.83828 15.0593 6.72578 14.9187L0.369531 8.44995C0.116406 8.19683 0.116406 7.80308 0.369531 7.54995L6.72578 1.0812C6.97891 0.828076 7.37266 0.828076 7.62578 1.0812C7.87891 1.33433 7.87891 1.72808 7.62578 1.9812L1.71953 7.99995L7.65391 14.0187C7.90703 14.2718 7.90703 14.6656 7.65391 14.9187C7.48516 15.0312 7.34453 15.1156 7.17578 15.1156Z"
                fill=""
              ></path>
            </svg>
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            1
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            2
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            3
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            4
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            5
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex h-9 w-7.5 items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            <svg
              class="fill-current"
              width="10"
              height="3"
              viewBox="0 0 10 3"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M0.927734 2.06738C1.41992 2.06738 1.8164 1.66406 1.8164 1.17871C1.8164 0.686523 1.41992 0.290039 0.927734 0.290039C0.442383 0.290039 0.0390625 0.686523 0.0390625 1.17871C0.0390625 1.66406 0.442383 2.06738 0.927734 2.06738ZM4.99998 2.06738C5.49217 2.06738 5.88865 1.66406 5.88865 1.17871C5.88865 0.686523 5.49217 0.290039 4.99998 0.290039C4.51463 0.290039 4.11131 0.686523 4.11131 1.17871C4.11131 1.66406 4.51463 2.06738 4.99998 2.06738ZM9.07224 2.06738C9.56443 2.06738 9.96091 1.66406 9.96091 1.17871C9.96091 0.686523 9.56443 0.290039 9.07224 0.290039C8.58689 0.290039 8.18357 0.686523 8.18357 1.17871C8.18357 1.66406 8.58689 2.06738 9.07224 2.06738Z"
                fill=""
              ></path>
            </svg>
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="router-link-active router-link-exact-active flex items-center justify-center rounded py-1.5 px-3 font-medium hover:bg-primary hover:text-white"
          >
            10
          </a>
        </li>
        <li>
          <a
            aria-current="page"
            href="/ui-elements/pagination#"
            class="flex items-center justify-center w-8 h-8 rounded router-link-active router-link-exact-active hover:bg-primary hover:text-white"
          >
            <svg
              class="fill-current"
              width="8"
              height="16"
              viewBox="0 0 8 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M0.819531 15.1156C0.650781 15.1156 0.510156 15.0593 0.369531 14.9468C0.116406 14.6937 0.116406 14.3 0.369531 14.0468L6.27578 7.99995L0.369531 1.9812C0.116406 1.72808 0.116406 1.33433 0.369531 1.0812C0.622656 0.828076 1.01641 0.828076 1.26953 1.0812L7.62578 7.54995C7.87891 7.80308 7.87891 8.19683 7.62578 8.44995L1.26953 14.9187C1.15703 15.0312 0.988281 15.1156 0.819531 15.1156Z"
                fill=""
              ></path>
            </svg>
          </a>
        </li>
      </ul>
    </nav>
  </div> -->
</template>
