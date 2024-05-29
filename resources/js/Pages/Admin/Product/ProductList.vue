<script setup>
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import ProductTable from '@/Components/Admin/Product/ProductTable.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const pageTitle = ref('Product Management')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-1">
      <ProductTable />
    </div>
  </DefaultLayout>
</template>
