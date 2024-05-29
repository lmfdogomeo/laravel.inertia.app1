<script setup>
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue'
import MerchantForm from '@/Components/Admin/Merchant/MerchantForm.vue'

const pageTitle = ref('Merchant Editor')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <!-- ====== Form Layout Section Start -->
    <MerchantForm/>
    <!-- ====== Form Layout Section End -->
  </DefaultLayout>
</template>
