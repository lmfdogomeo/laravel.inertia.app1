<script setup>
import { ref } from 'vue'
// @ts-ignore
import VueApexCharts from 'vue3-apexcharts'

const chartData = {
  series: [65, 34, 45, 12],
  labels: ['Desktop', 'Tablet', 'Mobile', 'Unknown']
}

const chart = ref(null)

const apexOptions = {
  chart: {
    type: 'donut',
    width: 380
  },
  colors: ['#3C50E0', '#6577F3', '#8FD0EF', '#0FADCF'],
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
}
</script>

<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
  >
    <div class="justify-between gap-4 mb-3 sm:flex">
      <div>
        <h4 class="text-xl font-bold text-black dark:text-white">Visitors Analytics</h4>
      </div>
      <div>
        <div class="relative z-20 inline-block">
          <select
            name="year-month"
            id=""
            class="relative z-20 inline-flex py-1 pl-3 pr-8 text-sm font-medium bg-transparent outline-none appearance-none"
          >
            <option value="">Monthly</option>
            <option value="">Yearly</option>
          </select>
        </div>
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
    <div class="flex flex-wrap items-center justify-center -mx-8 gap-y-3">
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="block w-full h-3 mr-2 rounded-full max-w-3 bg-primary"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Desktop </span>
            <span> 65% </span>
          </p>
        </div>
      </div>
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#6577F3]"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Tablet </span>
            <span> 34% </span>
          </p>
        </div>
      </div>
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#8FD0EF]"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Mobile </span>
            <span> 45% </span>
          </p>
        </div>
      </div>
      <div class="w-full px-8 sm:w-1/2">
        <div class="flex items-center w-full">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#0FADCF]"></span>
          <p class="flex justify-between w-full text-sm font-medium text-black dark:text-white">
            <span> Unknown </span>
            <span> 12% </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
