<script setup>
import TotalMerchant from '@/Components/Admin/Dashboard/TotalMerchant.vue'
import TotalUser from '@/Components/Admin/Dashboard/TotalUser.vue'
import TotalProduct from '@/Components/Admin/Dashboard/TotalProduct.vue'
import AnalyticChart from '@/Components/Admin/Dashboard/AnalyticChart.vue'
import LineChart from '@/Components/Admin/Dashboard/LineChart.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
</script>

<template>
  <DefaultLayout>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
      <TotalMerchant />
      <TotalProduct />
      <TotalUser />
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
      <AnalyticChart />

      <LineChart />
    </div>
  </DefaultLayout>
</template>
