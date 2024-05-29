<script setup>
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue'
import ProductForm from '@/Components/Admin/Product/ProductForm.vue'

const pageTitle = ref('Product Editor')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <!-- ====== Form Layout Section Start -->
    <ProductForm />
    <!-- ====== Form Layout Section End -->
  </DefaultLayout>
</template>
