<script setup>
import TotalMerchant from '@/Components/Admin/Dashboard/TotalMerchant.vue'
import TotalUser from '@/Components/Admin/Dashboard/TotalUser.vue'
import TotalProduct from '@/Components/Admin/Dashboard/TotalProduct.vue'
import AnalyticChart from '@/Components/Admin/Dashboard/AnalyticChart.vue'
import LineChart from '@/Components/Admin/Dashboard/LineChart.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { useSessionStore } from '@/stores/session'
import { nextTick, onMounted, ref } from 'vue'
import ColyseusComponent from "@/Components/Admin/ColyseusComponent.vue";

const ready = ref(false);
const { initStore } = useSessionStore();
const { canEdit, canAdd, canDelete, canView } = useSessionStore();

onMounted(() => {
  initStore();

  nextTick(() => {
    ready.value = true;
  })
})

</script>

<template>
  <DefaultLayout v-if="ready">
    <ColyseusComponent />
    
    <!-- <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
      v-if="canView('total-merchant') || canView('total-product') || canView('total-user')"
    >
      <TotalMerchant v-if="canView('total-merchant')"/>
      <TotalProduct v-if="canView('total-product')"/>
      <TotalUser v-if="canView('total-user')"/>
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
      <AnalyticChart v-if="canView('analytic-chart')" />

      <LineChart v-if="canView('line-chart-user') || canView('line-chart-merchant') || canView('line-chart-product')" />
    </div> -->
  </DefaultLayout>
</template>
