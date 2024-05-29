<script setup>
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import ProfileCard from '@/Components/TailAdmin/ProfileCard.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const pageTitle = ref('Profile')
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-242.5">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <ProfileCard />
    </div>
  </DefaultLayout>
</template>
