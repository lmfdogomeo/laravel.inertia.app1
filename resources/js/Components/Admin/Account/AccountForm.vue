<script setup>
import DefaultCard from "@/Components/TailAdmin/Forms/DefaultCard.vue";
import InputGroup from "@/Components/TailAdmin/Forms/InputGroup.vue";
import SelectGroup from "@/Components/TailAdmin/Forms/SelectGroup/SelectGroup.vue";
import { computed, onMounted, reactive, ref } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import ButtonDefault from "@/Components/TailAdmin/Buttons/ButtonDefault.vue";
import DragInDropFile from "@/Components/TailAdmin/Forms/DragInDropFile.vue";
import InputError from "@/Components/InputError.vue";
import CategoryDropdown from "@/Components/Admin/CategoryDropdown.vue";
import StockStatusDropdown from "@/Components/Admin/StockStatusDropdown.vue";
import UnitDropdown from "@/Components/Admin/UnitDropdown.vue";
import Notification from "@/Helpers/Notification";
import Confirmation from "@/Helpers/Confirmation";
import DangerButton from "@/Components/DangerButton.vue";
import axios from "axios";

const page = usePage();
const profile = ref(null);

const search = ref("");

const foundMerchant = ref(null);
const merchantForm = useForm({
  address: "",
  city: "",
  company_name: "",
  company_tax_id: "",
  contact_number: "",
  country: "",
  postal_code: "",
  uuid: "",
});
const form = useForm({
  name: "",
  email: "",
  password: "",
  confirm_password: "",
  merchant_id: "",
});

const handleFileChange = (file) => {
  profile.value = file;
};

const handleSearch = async () => {
  foundMerchant.value = null;
  try {
    const { data, status } = await axios.get(
      route("admin.accounts.api-search"),
      { params: { search: search.value } }
    );
    console.log("data", data);
    console.log("status", status);

    if ([200, 201].includes(status) && data.data) {
      merchantForm.company_tax_id = data.data?.company_tax_id;
      merchantForm.company_name = data.data?.company_name;
      merchantForm.contact_number = data.data?.contact_number;
      merchantForm.address = data.data?.address;
      merchantForm.country = data.data?.country;
      merchantForm.city = data.data?.city;
      merchantForm.postal_code = data.data?.postal_code;
      merchantForm.uuid = data.data?.uuid;

      form.merchant_id = data.data?.uuid || null;
      foundMerchant.value = true;
    } else {
      foundMerchant.value = false;
    }
  } catch (error) {
    console.log("error", error);
  }
};

const handleSubmitForm = () => {
  form.price = Number(form.price || "0").toFixed(2);
  form.sale_price = Number(form.sale_price || "0").toFixed(2);

  let endpoint = route("admin.accounts.store");
  let method = "post";
  if (isUpdate.value) {
    endpoint = route("admin.accounts.update", {
      account: uuid.value,
    });
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
          "Account has been successfully created",
        duration: 5000,
      });

      if (!isUpdate.value) {
        form.reset();
        form.merchant_id = merchantForm.uuid || null;
      }

      console.log("response", response);
    },
    onError: (error) => {
      console.log("onError", error);
    },
  });
};

const handleCancel = () => {
  Confirmation.confirm({
    title: "Confirmation",
    type: "warning",
    text: "Are you sure you want to cancel?",
    cancelButtonText: "Cancel",
    confirmButtonText: "Continue",
  }).then((result) => {
    if (result.isConfirm) {
      foundMerchant.value = null;
      search.value = "";
      merchantForm.reset();
    }
  });
};

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
};

const onDeleteProduct = () => {
  emptyForm.delete(
    route("admin.products.destroy", {
      product: uuid.value,
      ...(hasMerchant.value ? { merchant: hasMerchant.value } : {}),
    }),
    {
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
    }
  );
};

const hasMerchant = computed(() => {
  return page.props?.merchant_uuid || null;
});

const isUpdate = computed(() => page.props.state === "update");
const uuid = computed(() => page.props.data?.uuid || null);

onMounted(() => {
  form.merchant_id = hasMerchant.value || null;

  console.log("app", page.props);

  const productData = page.props?.data || {};

  for (let key in productData) {
    if (typeof form[key] !== "undefined") {
      if (
        ["sale_price", "price", "stock_quantity", "sold_quantity"].includes(key)
      ) {
        form[key] = productData[key].toString();
      } else {
        form[key] = productData[key];
      }
    } else if (key === "category") {
      form["category_id"] = productData[key].uuid || null;
    } else if (key === "merchant") {
      form["merchant_id"] = productData[key].uuid || null;
    }
  }
});
</script>

<template>
  <div class="grid grid-cols-1 gap-2 sm:grid-cols-12" v-if="!foundMerchant">
    <div class="flex flex-col gap-2 sm:col-span-5">
      <DefaultCard cardTitle="Search Merchant">
        <form @submit.prevent="handleSearch">
          <div class="p-6.5">
            <InputGroup
              type="search"
              placeholder="Company Name / Company ID"
              customClasses="w-full"
              v-model="search"
            >
              <template v-slot:error v-if="foundMerchant === false">
                <InputError message="No merchant found. Please try again." />
              </template>
            </InputGroup>

            <div class="py-3 text-right">
              <button
                type="submit"
                class="p-2 px-5 font-medium rounded-3xl bg-primary text-gray hover:bg-opacity-90"
              >
                Search Merchant
              </button>
            </div>
          </div>
        </form>
      </DefaultCard>
      <!-- Sign In End -->
    </div>
  </div>

  <form @submit.prevent="handleSubmitForm" v-else>
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-12">
      <div class="flex flex-col gap-2 sm:col-span-5">
        <!-- Sign Up Start -->
        <DefaultCard cardTitle="Profile Picture">
          <div class="p-6.5">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
              <div class="">
                <DragInDropFile :onChange="handleFileChange" />
              </div>
            </div>
          </div>
        </DefaultCard>
        <!-- Sign Up End -->

        <!-- Sign In Start -->
        <DefaultCard cardTitle="Account Information">
          <div class="p-6.5">
            <InputGroup
              label="Representative Name"
              type="text"
              placeholder="Representative Name"
              customClasses="w-full mb-4.5"
              v-model="form.name"
            >
              <template v-slot:error>
                <InputError :message="form.errors.name" />
              </template>
            </InputGroup>

            <InputGroup
              label="Email"
              type="email"
              placeholder="Email"
              customClasses="w-full mb-4.5"
              v-model="form.email"
            >
              <template v-slot:error>
                <InputError :message="form.errors.email" />
              </template>
            </InputGroup>

            <InputGroup
              label="Password"
              type="password"
              placeholder="*******"
              customClasses="w-full mb-4.5"
              v-model="form.password"
            >
              <template v-slot:error>
                <InputError :message="form.errors.password" />
              </template>
            </InputGroup>

            <InputGroup
              label="Confirm Password"
              type="password"
              placeholder="*******"
              customClasses="w-full mb-4.5"
              v-model="form.confirm_password"
            >
              <template v-slot:error>
                <InputError :message="form.errors.confirm_password" />
              </template>
            </InputGroup>
          </div>
        </DefaultCard>
        <!-- Sign In End -->
      </div>

      <div class="flex flex-col gap-2 sm:col-span-7">
        <!-- Contact Form Start -->
        <DefaultCard cardTitle="Merchant Details">
          <div class="p-6.5">
            <InputGroup
              label="Company ID"
              type="text"
              placeholder="Company ID"
              customClasses="mb-4.5"
              required
              v-model="merchantForm.company_tax_id"
              disabled
            />

            <InputGroup
              label="Company Name"
              type="text"
              placeholder="Company Name"
              customClasses="mb-4.5"
              required
              v-model="merchantForm.company_name"
              disabled
            />

            <InputGroup
              label="Contact Number"
              type="text"
              placeholder="Contact Number"
              customClasses="mb-4.5 w-full xl:w-1/2"
              required
              v-model="merchantForm.contact_number"
              disabled
            />

            <InputGroup
              label="Address"
              type="text"
              placeholder="Address"
              customClasses="mb-4.5"
              required
              v-model="merchantForm.address"
              disabled
            />

            <div class="mb-4.5 flex flex-col gap-3 xl:flex-row">
              <InputGroup
                label="Country"
                type="text"
                placeholder="Country"
                customClasses="w-full xl:w-1/2"
                v-model="merchantForm.country"
                disabled
              />

              <InputGroup
                label="City"
                type="text"
                placeholder="City"
                customClasses="w-full xl:w-1/2"
                v-model="merchantForm.city"
                disabled
              />
            </div>

            <div class="mb-4.5 flex flex-col gap-3 xl:flex-row">
              <InputGroup
                label="Postal Code"
                type="number"
                placeholder="0000"
                customClasses="w-full xl:w-1/2"
                v-model="merchantForm.postal_code"
                disabled
              />

              <div class="w-full xl:w-1/2"></div>
            </div>
          </div>
        </DefaultCard>
        <!-- Contact Form End -->

        <div class="flex justify-end gap-2 mt-5">
          <DangerButton
            type="button"
            class="rounded-3xl"
            @click="handleDelete"
            v-if="isUpdate"
          >
            Delete
          </DangerButton>

          <button
            type="submit"
            class="flex justify-center w-full p-3 font-medium rounded-3xl bg-primary text-gray hover:bg-opacity-90"
          >
            {{ isUpdate ? "Update Account" : "Save Account" }}
          </button>
        </div>

        <button
          type="button"
          class="flex justify-center w-full p-3 font-medium border rounded-3xl border-danger text-danger hover:bg-opacity-90"
          @click="handleCancel"
        >
          Cancel
        </button>
      </div>
    </div>
  </form>
</template>

<style scoped></style>
