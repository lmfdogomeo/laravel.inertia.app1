<script setup>
import { usePage, Link, router } from '@inertiajs/vue3';
import {computed} from "vue";

const page = usePage();
const props = defineProps({
    links: {
        type: Array,
        default: []
    },
    from: {
        type: Number,
        default: 0
    },
    to: {
        type: Number,
        default: 0
    },
    total: {
        type: Number,
        default: 0
    },
    onChange: Function
});

const handleClickPaginate = (params) => {
    if (typeof props.onChange === "function") {
        props.onChange(params);
    }
    else {
        router.get(params.url)
    }
}
</script>

<template>
    <div
        class="flex items-center justify-between px-4 py-3 mt-5 bg-white border-gray-200 sm:px-6"
    >
        <div
            class="sm:flex sm:flex-1 sm:items-center sm:justify-between"
        >
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
                        v-for=" (link, index) in links" 
                        :key="index" 
                        :href="link.url || '#'"
                        @click.prevent="handleClickPaginate(link)"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold"
                        :class="{
                            'z-10 text-white bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.active,
                            'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0': !link.active,
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
</template>
