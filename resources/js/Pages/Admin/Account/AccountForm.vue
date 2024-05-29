<script setup>
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue'
import AccountForm from '@/Components/Admin/Account/AccountForm.vue'

const pageTitle = ref('Account Form')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <!-- ====== Form Layout Section Start -->
    <AccountForm />
    <!-- ====== Form Layout Section End -->
  </DefaultLayout>
</template>
