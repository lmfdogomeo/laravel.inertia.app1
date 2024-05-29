<script setup>
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import TableOne from '@/Components/TailAdmin/Tables/TableOne.vue'
import TableTwo from '@/Components/TailAdmin/Tables/TableTwo.vue'
import TableThree from '@/Components/TailAdmin/Tables/TableThree.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const pageTitle = ref('Tables')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-10">
      <TableOne />
      <TableTwo />
      <TableThree />
    </div>
  </DefaultLayout>
</template>
