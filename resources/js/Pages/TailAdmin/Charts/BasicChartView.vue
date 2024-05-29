<script setup>
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import ChartOne from '@/Components/TailAdmin/Charts/ChartOne.vue'
import ChartThree from '@/Components/TailAdmin/Charts/ChartThree.vue'
import ChartTwo from '@/Components/TailAdmin/Charts/ChartTwo.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

import { ref } from 'vue'

const pageTitle = ref('Basic Chart')
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
      <!-- ====== Chart One Start -->
      <ChartOne />
      <!-- ====== Chart One End -->

      <!-- ====== Chart Two Start -->
      <ChartTwo />
      <!-- ====== Chart Two End -->

      <!-- ====== Chart Three Start -->
      <ChartThree />
      <!-- ====== Chart Three End -->
    </div>
  </DefaultLayout>
</template>
