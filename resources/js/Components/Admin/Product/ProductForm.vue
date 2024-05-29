<script setup>
import DefaultCard from "@/Components/TailAdmin/Forms/DefaultCard.vue";
import InputGroup from "@/Components/TailAdmin/Forms/InputGroup.vue";
import SelectGroup from "@/Components/TailAdmin/Forms/SelectGroup/SelectGroup.vue";
import { computed, onMounted, ref } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import ButtonDefault from "@/Components/TailAdmin/Buttons/ButtonDefault.vue";
import DragInDropFile from "@/Components/TailAdmin/Forms/DragInDropFile.vue";
import InputError from "@/Components/InputError.vue";
import CategoryDropdown from "@/Components/Admin/CategoryDropdown.vue"
import StockStatusDropdown from "@/Components/Admin/StockStatusDropdown.vue"
import UnitDropdown from "@/Components/Admin/UnitDropdown.vue"
import Notification from "@/Helpers/Notification";
import Confirmation from "@/Helpers/Confirmation";
import DangerButton from "@/Components/DangerButton.vue";

const page = usePage();
const emptyForm = useForm({});
const form = useForm({
  uuid: "",
  sku: "",
  brand_name: "",
  product_name: "",
  product_description: "",
  price: "",
  sale_price: "",
  is_sale: "",
  quantity: "",
  sale: "",
  stock_status: "",
  stock_quantity: "",
  sold_quantity: "",
  unit: "",
  start_date: "",
  size: "",
  weight: "",
  rate: "",
  category_id: "",
  merchant_id: "",
  image1: null,
  image2: null,
  image3: null,
  image4: null,
  _method: "post"
});

const handleFileChange = (file, index) => {
  if (index === 0) {
    form.image1 = file;
  }
  else if (index === 1) {
    form.image2 = file;
  }
  else if (index === 2) {
    form.image3 = file;
  }
  else if (index === 3) {
    form.image4 = file;
  }
};

const handleSubmitForm = () => {
  form.price = Number(form.price || "0").toFixed(2);
  form.sale_price = Number(form.sale_price || "0").toFixed(2);

  let endpoint = route('admin.products.store', hasMerchant.value ? { merchant: hasMerchant.value } : {});
  let method = "post";
  if (isUpdate.value) {
    endpoint = route('admin.products.update', { product: uuid.value, ...hasMerchant.value ? { merchant: hasMerchant.value } : {} });
    method = "put";
  }

  form[method](endpoint, {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: (response) => {
      Notification.fire({
        title: "Success",
        message:
          response.props.flash.message ||
          "Product has been successfully added",
        duration: 5000,
      });

      if (!isUpdate.value) {
        form.reset();
        form.merchant_id = hasMerchant.value || null;
      }

      console.log('response', response)
    },
    onError: (error) => {
      console.log("onError", error);
    },
  });
}

const handleBack = () => {
  router.get(route('admin.products.index', hasMerchant.value ? { merchant: hasMerchant.value } : {}))
}

const handleDelete = () => {
  Confirmation.confirm({
    title: "Confirmation",
    type: "warning",
    text: "Are you sure you want to delete this product?",
    cancelButtonText: "Cancel",
    confirmButtonText: "Continue",
  }).then((result) => {
    if (result.isConfirm) {
      onDeleteProduct();
    }
  });
}

const onDeleteProduct = () => {
  emptyForm.delete(route("admin.products.destroy", { product: uuid.value, ...hasMerchant.value ? { merchant: hasMerchant.value } : {} }), {
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
  });
};

const hasMerchant = computed(() => {
  return page.props?.merchant_uuid || null;
})

const isUpdate = computed(() => page.props.state === "update");
const uuid = computed(() => page.props.data?.uuid || null);

onMounted(() => {
  form.merchant_id = hasMerchant.value || null;

  console.log('app', page.props)

  const productData = page.props?.data || {};

  for(let key in productData) {
    if (typeof form[key] !== 'undefined') {
      if (['sale_price', 'price', 'stock_quantity', 'sold_quantity'].includes(key)) {
        form[key] = productData[key].toString();
      }
      else {
        form[key] = productData[key];
      }
    }
    else if (key === 'category') {
      form['category_id'] = productData[key].uuid || null;
    }
    else if (key === 'merchant') {
      form['merchant_id'] = productData[key].uuid || null;
    }
  }
})

</script>

<template>
  <form @submit.prevent="handleSubmitForm">
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-12">
      <div class="flex flex-col gap-2 sm:col-span-7">
        <!-- Sign Up Start -->
        <DefaultCard cardTitle="Product Images">
          <div class="p-6.5">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
              <div class="">
                <DragInDropFile :onChange="(e) => handleFileChange(e, 0)" />
              </div>
              <div class="">
                <DragInDropFile :onChange="(e) => handleFileChange(e, 1)" />
              </div>
              <div class="">
                <DragInDropFile :onChange="(e) => handleFileChange(e, 2)" />
              </div>
              <div class="">
                <DragInDropFile :onChange="(e) => handleFileChange(e, 3)" />
              </div>
            </div>
          </div>
        </DefaultCard>
        <!-- Sign Up End -->

        <!-- Sign In Start -->
        <DefaultCard cardTitle="Product Attributes">
          <div class="p-6.5">
            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              <InputGroup
                label="Size"
                type="text"
                placeholder="L * W * H, Inches"
                customClasses="w-full xl:w-1/2"
                v-model="form.size"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.size" />
                </template>
              </InputGroup>

              <InputGroup
                label="Weight"
                type="text"
                placeholder="kg"
                customClasses="w-full xl:w-1/2"
                v-model="form.weight"
                >
                <template v-slot:error>
                  <InputError :message="form.errors.weight" />
                </template>
              </InputGroup>
            </div>

            <div class="mb-6">
              <label class="mb-2.5 block text-black dark:text-white">
                Description
              </label>
              <textarea
                rows="6"
                placeholder="Description here..."
                class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                v-model="form.product_description"
              ></textarea>

              <InputError :message="form.errors.product_description" />
            </div>
          </div>
        </DefaultCard>
        <!-- Sign In End -->

      </div>

      <div class="flex flex-col gap-2 sm:col-span-5">
        <!-- Contact Form Start -->
        <DefaultCard cardTitle="Product Settings">
          <div class="p-6.5">
            <InputGroup
              label="Product Name"
              type="text"
              placeholder="Product Name"
              customClasses="mb-4.5"
              required
              v-model="form.product_name"
            >
              <template v-slot:error>
                <InputError :message="form.errors.product_name" />
              </template>
            </InputGroup>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              <InputGroup
                label="Brand name"
                type="text"
                placeholder="Brand Name"
                customClasses="w-full xl:w-1/2"
                v-model="form.brand_name"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.brand_name" />
                </template>
              </InputGroup>

              <!-- <SelectGroup label="Category" class="w-full xl:w-1/2" v-model="form.category_id">
                <option value="" disabled selected>Category</option>
                <option value="USA">USA</option>
                <option value="UK">UK</option>
                <option value="Canada">Canada</option>
                
                <template v-slot:error>
                  <InputError :message="form.errors.category_id" />
                </template>
              </SelectGroup> -->

              <CategoryDropdown v-model="form.category_id">
                <template v-slot:error>
                  <InputError :message="form.errors.category_id" />
                </template>
              </CategoryDropdown>
            </div>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              <InputGroup
                label="Regular Price"
                type="number"
                placeholder="0.00"
                customClasses="w-full xl:w-1/2"
                v-model="form.price"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.price" />
                </template>
              </InputGroup>

              <InputGroup
                label="Sale Price"
                type="number"
                placeholder="0.00"
                customClasses="w-full xl:w-1/2"
                v-model="form.sale_price"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.sale_price" />
                </template>
              </InputGroup>
            </div>

            <InputGroup
              label="SKU"
              type="text"
              placeholder="XX-XXXX"
              customClasses="mb-4.5"
              v-model="form.sku"
              inputClass="uppercase"
            >
              <template v-slot:error>
                <InputError :message="form.errors.sku" />
              </template>
            </InputGroup>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              
              <StockStatusDropdown label="Stock Status" v-model="form.stock_status">
                <template v-slot:error>
                  <InputError :message="form.errors.stock_status" />
                </template>
              </StockStatusDropdown>

              <InputGroup
                label="Stock Qty."
                type="number"
                placeholder="0"
                customClasses="w-full xl:w-1/2"
                v-model="form.stock_quantity"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.stock_quantity" />
                </template>
              </InputGroup>

              <UnitDropdown label="Unit" v-model="form.unit">
                <template v-slot:error>
                  <InputError :message="form.errors.unit" />
                </template>
              </UnitDropdown>
            </div>
          </div>
        </DefaultCard>
        <!-- Contact Form End -->

        <div class="flex justify-end gap-2 mt-5">
          <DangerButton type="button" class="rounded-3xl"
            @click="handleDelete"
            v-if="isUpdate"
          >
            Delete
          </DangerButton>

          <button
            type="submit"
            class="flex justify-center w-full p-3 font-medium rounded-3xl bg-primary text-gray hover:bg-opacity-90"
          >
            {{ isUpdate ? "Update Product" : "Save Product" }}
          </button>
        </div>

        <button
          type="button"
          class="flex justify-center w-full p-3 font-medium border rounded-3xl border-danger text-danger hover:bg-opacity-90"
          @click="handleBack"
        >
          Cancel
        </button>
      </div>
    </div>
  </form>
</template>

<style scoped></style>
