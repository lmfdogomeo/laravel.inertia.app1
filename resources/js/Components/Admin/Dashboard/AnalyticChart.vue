<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

const chartData = reactive({
  series: [0, 0, 0],
  labels: ['Users', 'Merchants', 'Products']
});

const chart = ref(null)

const apexOptions = ref({
  chart: {
    type: 'donut',
    width: 380
  },
  colors: ['#3C50E0', '#6577F3', '#8FD0EF'],
  labels: chartData.labels,
  legend: {
    show: false,
    position: 'bottom'
  },
  plotOptions: {
    pie: {
      donut: {
        size: '65%',
        background: 'transparent'
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  responsive: [
    {
      breakpoint: 640,
      options: {
        chart: {
          width: 200
        }
      }
    }
  ]
})

const onGetTotalMerchant = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total.merchant'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});

const onGetTotalProduct = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total.product'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});


const onGetTotalUser = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total.user'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});

onMounted(async() => {
  const [totalMerchant, totalProduct, totalUser] = await Promise.all([
    onGetTotalMerchant,
    onGetTotalProduct,
    onGetTotalUser
  ]);

  chartData.series = [totalUser, totalMerchant, totalProduct]

})

</script>

<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
  >
    <div class="justify-between gap-4 mb-3 sm:flex">
      <div>
        <h4 class="text-xl font-bold text-black dark:text-white">Data Analytics</h4>
      </div>
    </div>
    <div class="mb-2">
      <div id="chartThree" class="flex justify-center mx-auto">
        <VueApexCharts
          type="donut"
          width="340"
          :options="apexOptions"
          :series="chartData.series"
          ref="chart"
        />
      </div>
    </div>
    <div class="flex flex-wrap items-center -mx-8 gap-y-3">
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="block w-full h-3 mr-2 rounded-full max-w-3 bg-primary"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Users </span>
            <span> {{ chartData.series[0] }}% </span>
          </p>
        </div>
      </div>
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#6577F3]"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Merchants </span>
            <span> {{ chartData.series[1] }}% </span>
          </p>
        </div>
      </div>
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#8FD0EF]"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Products </span>
            <span> {{ chartData.series[2] }}% </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
