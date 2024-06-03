<script setup>
import { onMounted, reactive, ref } from "vue";
// @ts-ignore
import VueApexCharts from "vue3-apexcharts";

const chartData = reactive({
  series: [
    {
      name: "Users",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    },
    {
      name: "Merchants",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    },
    {
      name: "Products",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    },
  ],
  labels: [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ],
});

const chart = ref(null);

const apexOptions = {
  legend: {
    show: false,
    position: "top",
    horizontalAlign: "left",
  },
  colors: ["#3C50E0", "#80CAEE", "#FF8888"],
  chart: {
    fontFamily: "Satoshi, sans-serif",
    height: 335,
    type: "area",
    dropShadow: {
      enabled: true,
      color: "#623CEA14",
      top: 10,
      blur: 4,
      left: 0,
      opacity: 0.1,
    },

    toolbar: {
      show: false,
    },
  },
  responsive: [
    {
      breakpoint: 1024,
      options: {
        chart: {
          height: 300,
        },
      },
    },
    {
      breakpoint: 1366,
      options: {
        chart: {
          height: 350,
        },
      },
    },
  ],
  stroke: {
    width: [2, 2],
    curve: "straight",
  },

  labels: {
    show: false,
    position: "top",
  },
  grid: {
    xaxis: {
      lines: {
        show: true,
      },
    },
    yaxis: {
      lines: {
        show: true,
      },
    },
  },
  dataLabels: {
    enabled: false,
  },
  markers: {
    size: 4,
    colors: "#fff",
    strokeColors: ["#3056D3", "#80CAEE", "#FF8888"],
    strokeWidth: 3,
    strokeOpacity: 0.9,
    strokeDashArray: 0,
    fillOpacity: 1,
    discrete: [],
    hover: {
      size: undefined,
      sizeOffset: 5,
    },
  },
  xaxis: {
    type: "category",
    categories: chartData.labels,
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    title: {
      style: {
        fontSize: "0px",
      },
    },
    min: 0,
    max: 100,
  },
};

const onGetTotalProductPerMothByYear = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total-per-month-by-year.product'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});

const onGetTotalMerchantPerMothByYear = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total-per-month-by-year.merchant'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});

const onGetTotalUserPerMothByYear = new Promise(async (resolve, reject) => {
	try {
    const {data, status} = await axios.get(route('admin.total-per-month-by-year.user'));
    if ([200,201].includes(status)) {
      resolve(data || 0);
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
    resolve(0);
  }
});

onMounted(async() => {
  const [product, merchant, user] = await Promise.all([
    onGetTotalProductPerMothByYear,
    onGetTotalMerchantPerMothByYear,
    onGetTotalUserPerMothByYear,
  ]);

  console.log('product', Object.values(product))
  console.log('merchant', merchant)
  console.log('user', user)

  chartData.series[0].data = Object.values(user) || [];
  chartData.series[1].data = Object.values(merchant) || [];
  chartData.series[2].data = Object.values(product) || [];

})
</script>

<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-7"
  >
    <div
      class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap"
    >
      <div class="flex flex-wrap w-full gap-3 sm:gap-5">
        <div class="flex min-w-full">
          <div class="w-full">
            <p class="font-semibold text-primary">Collected Data</p>
            <p class="text-sm font-medium">Year: 2024</p>
          </div>
        </div>
      </div>
      <div class="flex justify-end w-full max-w-45">
        <!--  -->
      </div>
    </div>
    <div>
      <div id="chartOne" class="-ml-5">
        <VueApexCharts
          type="area"
          height="350"
          :options="apexOptions"
          :series="chartData.series"
          ref="chart"
        />
      </div>
    </div>
  </div>
</template>
