<script setup>
import { computed, onMounted, ref } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { STOCK_STATUSES } from "@/Utils/Constant";

import PaginationLink from "@/Components/PaginationLink.vue";
import EyeSvgIcon from "@/assets/svg/EyeSvgIcon.vue";
import DeleteSvgIcon from "@/assets/svg/DeleteSvgIcon.vue";
import Confirmation from "@/Helpers/Confirmation";
import Notification from "@/Helpers/Notification";
import StockStatusDropdown from "../StockStatusDropdown.vue";
import axios from "axios";

const page = usePage();
const emptyForm = useForm({});
const stockStatus = ref("");
const productCategory = ref("");
const merchant = ref("");
const selectAction = ref("");
const stockStatusOptions = ref(STOCK_STATUSES);
const categoryOptions = ref([]);
const merchantOptions = ref([]);

const form = useForm({});
const onResetFilter = () => {
  stockStatus.value = "";
  productCategory.value = "";
  merchant.value = "";

  if (!hasMerchant.value) {
    router.get(route('admin.products.index'));
  }
  else {
    router.get(route('admin.products.index', { merchant: hasMerchant.value }));
  }
};

const onApplyFilter = () => {
  let queryParams = {};

  if (stockStatus.value?.trim()) {
    queryParams['stock-status'] = stockStatus.value?.trim();
  }
  if (productCategory.value?.trim()) {
    queryParams['category'] = productCategory.value?.trim();
  }
  if (merchant.value?.trim()) {
    queryParams['merchant'] = merchant.value?.trim();
  }
  if (Object.keys(queryParams).length > 0) {
    if (!hasMerchant.value) {
      form.get(route('admin.products.filter', queryParams), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (response) => {
          console.log('success', response)
        }
      })
    }
    else {
      queryParams['merchant'] = hasMerchant.value;
      form.get(route('admin.products.index', queryParams), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (response) => {
          console.log('success', response)
        }
      })
    }
  }
};

const handleShowProduct = (data) => {
  router.get(route('admin.products.show', { product: data.uuid, ... hasMerchant.value ? { merchant: hasMerchant.value } : {} }))
}

const fetchCategories = async() => {
  try {
    const {data, status} = await axios.get(route('api.product-categories.list'));
    console.log('data', data)
    console.log('status', status)
    if ([200,201].includes(status)) {
      categoryOptions.value = data?.data || [];
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
  }
}

const fetchMerchants = async() => {
  try {
    const {data, status} = await axios.get(route('api.merchant.list'));
    console.log('data', data)
    console.log('status', status)
    if ([200,201].includes(status)) {
      merchantOptions.value = data?.data || [];
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
  }
}

const handleDelete = (data) => {
  Confirmation.confirm({
    title: "Confirmation",
    type: "warning",
    text: "Are you sure you want to delete this product?",
    cancelButtonText: "Cancel",
    confirmButtonText: "Continue",
  }).then((result) => {
    if (result.isConfirm) {
      onDeleteProduct(data?.uuid || "");
    }
  })
};

const onDeleteProduct = (uuid) => {
  emptyForm.delete(route('admin.products.destroy', { product: uuid, ...hasMerchant.value ? { merchant: hasMerchant.value } : {} }), {
    preserveScroll: true,
    onSuccess: (response) => {
      Notification.fire({
        title: "Success",
        message:
          response.props.flash.message ||
          "Product has been successfully deleted",
        duration: 5000,
      });
    },
    onError: (error) => {
      console.log("onError", error);
    },
  })
}

const hasMerchant = computed(() => {
  return usePage().props?.merchant_uuid || null;
})

const products = computed(() => page.props.paginate?.data || []);
const from = computed(() => page.props.paginate?.from || 0);
const to = computed(() => page.props.paginate?.to || 0);
const total = computed(() => page.props.paginate?.total || 0);
const links = computed(() => page.props.paginate?.links || []);

onMounted(() => {
  fetchCategories();
  if (!hasMerchant.value) {
    fetchMerchants();
  }
})

</script>

<template>
  <div
    class="flex flex-col-reverse gap-4 mb-5 md:flex-col lg:flex-row lg:justify-between"
  >
    <div class="flex flex-col gap-4 md:flex-row md:gap-[14px]">
      <Link :href="route('admin.merchants.show', { merchant: hasMerchant })" class="border btn"
        v-if="hasMerchant"
      >
        <i class="fas fa-arrow-left"></i> Back
      </Link>

      <Link :href="route('admin.products.create', hasMerchant ? { merchant: hasMerchant } : {})" class="btn btn--primary">
        Add new product <i class="icon-circle-plus-regular"></i>
      </Link>
    </div>
    <div class="relative lg:w-[326px]">
      <input
        class="field-input !pr-[60px]"
        type="search"
        placeholder="Search Product"
        value=""
      /><button
        class="field-btn text-red !right-[40px] transition opacity-0"
        aria-label="Clear all"
      >
        <i class="fas fa-close"></i></button
      ><button class="field-btn icon" aria-label="Search">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div
    class="flex flex-wrap gap-2 p-3 mb-0 bg-white border rounded-md shadow-default border-stroke"
  >
    <span class="text-header">Products:</span>
    <div>
      <button class="btn-tab btn-tab-active">
        <span class="btn-tab-text subheading-2">All</span>
        <span class="text-sm text-highlight-inverse">(16)</span>
      </button>
      <button class="btn-tab">
        <span class="btn-tab-text subheading-2">Published</span>
        <span class="text-sm text-highlight-inverse">(7)</span>
      </button>
      <button class="btn-tab">
        <span class="btn-tab-text subheading-2">Drafts</span>
        <span class="text-sm text-highlight-inverse">(5)</span>
      </button>
      <button class="btn-tab">
        <span class="btn-tab-text subheading-2">Trash</span>
        <span class="text-sm text-highlight-inverse">(4)</span>
      </button>
    </div>
  </div>

  <div
    class="grid items-end grid-cols-1 gap-3 py-4 sm:grid-cols-2 md:grid-cols-3 md:gap-x-6 xl:grid-cols-4"
  >
    <div>
      <select
        v-model="stockStatus"
        class="relative z-20 w-full px-5 py-2 transition bg-white border rounded outline-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
      >
        <option value="" disabled selected>Stock Status</option>
        <option :value="item.value" v-for="(item, key) in stockStatusOptions" :key="key">
          {{ item.name }}
        </option>
      </select>
    </div>

    <div>
      <!-- <label>Product Category</label> -->
      <select
        v-model="productCategory"
        class="relative z-20 w-full px-5 py-2 transition bg-white border rounded outline-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
      >
        <option value="" disabled selected>Product Category</option>
        <option :value="item.uuid" v-for="(item, key) in categoryOptions" :key="key">
          {{ item.category }}
        </option>
      </select>
    </div>

    <div>
      <!-- <label>Product Type</label> -->
      <select
        v-model="merchant"
        class="relative z-20 w-full px-5 py-2 transition bg-white border rounded outline-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
        v-if="!hasMerchant"
      >
        <option value="" disabled selected>Merchants</option>
        <option :value="item.uuid" v-for="(item, key) in merchantOptions" :key="key">
          {{ item.company_name }}
        </option>
      </select>
    </div>

    <div class="grid grid-cols-2 gap-2">
      <button class="btn btn--secondary !gap-[5px]" @click="onApplyFilter">
        Apply
        <i class="text-sm fas fa-arrow-right"></i>
      </button>

      <button class="btn btn--outline blue !h-[44px]" @click="onResetFilter">
        Clear
      </button>
    </div>
  </div>

  <div
    class="flex flex-col-reverse items-center gap-4 mt-3 mb-3 md:flex-row md:justify-between md:mt-3 md:mb-4"
  >
    <p>View products: <span class="font-semibold">{{ from }}-{{ to }}</span>/{{ total }}</p>
    <div class="md:min-w-[280px]">
      <select
        v-model="selectAction"
        class="relative z-20 w-full px-5 py-2 transition bg-white border rounded outline-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
      >
        <option value="" disabled selected>Select Action</option>
        <option value="update" class="text-body dark:text-bodydark">
          Update
        </option>
        <option value="delete" class="text-body dark:text-bodydark">
          Delete
        </option>
      </select>
    </div>
  </div>

  <div
    class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="max-w-full overflow-x-auto">
      <table class="w-full table-auto">
        <thead>
          <tr class="text-left border border-l-0 border-r-0 border-stroke">
            <th
              class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-6 border border-t-0 border-b-0 border-l-0 border-stroke"
            >
              Product Name
            </th>
            <th
              class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white"
            >
              SKU
            </th>
            <th
              class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white"
            >
              Stock
            </th>
            <th
              class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white"
            >
              Stock Status
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white">
              Price
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white">
              Rate
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white">
              Date
            </th>
            <th
              class="px-4 py-4 font-medium text-black border border-t-0 border-b-0 border-r-0 border-stroke dark:text-white"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in products" :key="index" class="">
            <td
              class="px-4 py-5 pl-6 border border-t-0 border-b-0 border-l-0 xl:pl-6 border-stroke"
            >
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <!-- <div class="h-12.5 w-15 rounded-md">
                  <img
                    :src="product.imageSrc"
                    :alt="`Product: ${product.name}`"
                  />
                </div> -->
                <p class="text-sm font-medium text-black dark:text-white">
                  {{ product.product_name }}
                </p>
              </div>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ product.sku }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p
                class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-opacity-10"
              >
                {{ product.stock_quantity }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p
                class="inline-flex px-3 py-1 text-sm font-medium capitalize rounded-full bg-opacity-10"
              >
                {{ product.stock_status }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ product.price || 0 }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ product.rate || 0 }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ product.start_date || "" }}
              </p>
            </td>
            <td
              class="px-4 py-5 border border-t-0 border-b-0 border-r-0 border-stroke"
            >
              <div class="flex items-center space-x-3.5">
                <button class="hover:text-primary"
                  @click="handleShowProduct(product)"
                >
                  <EyeSvgIcon />
                </button>

                <button class="hover:text-primary"
                  @click="handleDelete(product)"
                >
                  <DeleteSvgIcon />
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="products.length === 0">
            <td colspan="7" class="px-4 py-5 italic font-bold text-center">
              No data found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <PaginationLink :links="links" :from="from" :to="to" :total="total" class="!bg-transparent" />
</template>

<style scoped>
.btn-tab:not(:last-child) {
  padding-right: 14px;
  margin-right: 14px;
  border-right: 2px solid #00193b5e; /** #00193b; **/
}
.btn-tab {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-tab.btn-tab-active .btn-tab-text,
.btn-tab:hover .btn-tab-text,
.btn-tab:focus .btn-tab-text {
  color: var(--header);
}

.btn-tab .btn-tab-text {
  color: #035efc;
  transition: color 0.3s ease-in-out;
}

@media screen and (min-width: 768px) {
  .subheading-2 {
    font-size: 14px;
  }
}
.subheading-1,
.subheading-2,
.subheading-3 {
  color: #035ecf;
}
.subheading-2 {
  font-size: 13px;
}
h1,
h2,
h3,
h4,
h5,
h6,
.h1,
.h2,
.h3,
.h4,
.h5,
.h6,
.subheading-1,
.subheading-2,
.subheading-3 {
  font-family: Archivo SemiExpanded, sans-serif;
  color: #00193b;
  font-weight: 700;
  line-height: 1.1;
}

.btn--primary {
  background-color: #00ba9d;
  border: 1px solid #01c8a9;
  color: #fff;
  box-shadow: 0 1px 10px #02caab59;
}

.btn {
  height: 44px;
  border-radius: 23px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  line-height: 1;
  font-size: 16px;
  font-family: "Archivo SemiExpanded", sans-serif;
  font-weight: 600;
  padding: 0 26px;
  transition: 0.3s ease-in-out;
  cursor: pointer;
}

.field-input {
  height: 44px;
  padding: 0 20px;
  background: #ffffff;
  border-radius: 8px;
  border: 1px solid #e2e1e1;
  width: 100%;
  transition: all 0.3s ease-in-out;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

.field-btn {
  position: absolute;
  right: 12px;
  top: 50%;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  line-height: 0;
}

.btn--secondary {
  background-color: #035ecf;
  color: #fff;
  box-shadow: 0 1px 8px #035ecf80;
}

.btn--outline.blue {
  border: 1px solid #035ecf;
  color: #035ecf;
}
.btn--outline {
  height: 38px;
  font-size: 16px;
  gap: 7px;
  background: #ffffff;
}
</style>
