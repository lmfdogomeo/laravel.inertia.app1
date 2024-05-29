<script setup>
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import NotFoundCard from '@/Components/TailAdmin/Pages/NotFoundCard.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const pageTitle = ref('404 Error Page')
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-270">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <NotFoundCard />
    </div>
  </DefaultLayout>
</template>
