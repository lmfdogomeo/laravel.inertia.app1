<script setup>
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import CalendarCard from '@/Components/TailAdmin/CalendarCard.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const pageTitle = ref('Calender')
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <CalendarCard />
    </div>
  </DefaultLayout>
</template>
