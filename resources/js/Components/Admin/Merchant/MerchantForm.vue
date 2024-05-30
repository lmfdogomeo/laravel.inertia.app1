<script setup>
import InputError from "@/Components/InputError.vue";
import DefaultCard from "@/Components/TailAdmin/Forms/DefaultCard.vue";
import InputGroup from "@/Components/TailAdmin/Forms/InputGroup.vue";
import SelectGroup from "@/Components/TailAdmin/Forms/SelectGroup/SelectGroup.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import Notify from "@/Helpers/Notification";
import Confirmation from "@/Helpers/Confirmation";

const page = usePage();
const alert = ref(null);
const emptyForm = useForm({});
const form = useForm({
  company_tax_id: "",
  company_name: "",
  contact_number: "",
  address: "",
  city: "",
  country: "",
  postal_code: "",
});

const cities = ref(
  [1, 2, 3, 4, 5].map((item) => {
    return {
      value: `City ${item}`,
      label: `City ${item}`,
    };
  })
);

const countries = ref(
  [1, 2, 3, 4, 5].map((item) => {
    return {
      value: `Country ${item}`,
      label: `Country ${item}`,
    };
  })
);

const handleSubmitForm = () => {
  let method = "post";
  let endpoint = route("admin.merchants.store");

  if (isUpdate.value) {
    method = "put";
    endpoint = route("admin.merchants.update", { merchant: uuid.value });
  }

  console.log(form.data())

  form[method](endpoint, {
    preserveScroll: true,
    onSuccess: (response) => {
      Notify.fire({
        title: "Success",
        message:
          response.props.flash.message ||
          "Merchant has been successfully submitted",
        duration: 5000,
      });

      if (!isUpdate.value) {
        form.reset();
      }
    },
    onError: (error) => {
      console.log("onError", error);
    },
  });
};

const handleCancel = () => {
  if (isUpdate.value) {
    router.get(route("admin.merchants.index"));
  } else {
    form.reset();
    form.clearErrors();
  }
};

const handleDelete = () => {
  Confirmation.confirm({
    title: "Confirmation",
    type: "warning",
    text: propsData.value?.products_count > 0 ? `There are ${propsData.value?.products_count} products listed in this merchant. Are you sure you want to delete this?` : 'Are you sure you want to delete this merchant?',
    cancelButtonText: "Cancel",
    confirmButtonText: "Continue",
  }).then((result) => {
    if (result.isConfirm) {
      onDeleteMerchant();
    }
  });
};

const onDeleteMerchant = () => {
  emptyForm.delete(route("admin.merchants.destroy", { merchant: uuid.value }), {
    preserveScroll: true,
    onSuccess: (response) => {
      Notify.fire({
        title: "Success",
        message:
          response.props.flash.message ||
          "Merchant has been successfully deleted",
        duration: 5000,
      });
    },
    onError: (error) => {
      console.log("onError", error);
    },
  });
};

const isUpdate = computed(() => page.props.state === "update");
const uuid = computed(() => page.props.data?.uuid || null);
const propsData = computed(() => page.props.data || {});

onMounted(() => {
  // alert.value.show({
  //       type: "success",
  //       message: "Merchant has been successfully submitted",
  //       title: "Success",
  //       duration: 5000,
  //     });

  // Alert.createAlert({ title: "Success", message: "Merchant has been successfully submitted", duration: 50000 });
  // Notify.fire({ title: "Success", message: "Merchant has been successfully submitted", duration: 5000 });

  console.log("xxx-app", page.props);

  const data = page.props.data || {};

  form.company_tax_id = data?.company_tax_id || "";
  form.company_name = data?.company_name || "";
  form.contact_number = data?.contact_number || "";
  form.address = data?.address || "";
  form.city = data?.city || "";
  form.country = data?.country || "";
  form.postal_code = data?.postal_code || "";
});
</script>

<template>
  <form @submit.prevent="handleSubmitForm">
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
      <div class="flex flex-col gap-2">
        <!-- Contact Form Start -->
        <DefaultCard cardTitle="Merchant Information">
          <div class="p-6.5">
            <InputGroup
              label="Company ID"
              type="text"
              placeholder="Company Tax Identification"
              customClasses="mb-4.5"
              required
              v-model="form.company_tax_id"
            >
              <template v-slot:error>
                <InputError :message="form.errors.company_tax_id" />
              </template>
            </InputGroup>

            <InputGroup
              label="Company Name"
              type="text"
              placeholder="Company Name"
              customClasses="mb-4.5"
              required
              v-model="form.company_name"
            >
              <template v-slot:error>
                <InputError :message="form.errors.company_name" />
              </template>
            </InputGroup>

            <InputGroup
              label="Contact Number"
              type="text"
              placeholder="Contact Number"
              customClasses="mb-4.5"
              required
              v-model="form.contact_number"
            >
              <template v-slot:error>
                <InputError :message="form.errors.contact_number" />
              </template>
            </InputGroup>
          </div>
        </DefaultCard>
        <!-- Contact Form End -->

        <div class="mt-[20px]" v-if="isUpdate">
          <div
            id="alert-additional-content-3"
            class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert"
          >
            <div class="flex items-center">
              <svg
                class="flex-shrink-0 w-4 h-4 me-2"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                />
              </svg>
              <span class="sr-only">Info</span>
              <h3 class="text-lg font-medium">Products</h3>
            </div>
            <div class="mt-2 mb-4 text-sm">
              There are
              <b>{{ propsData?.products_count || "0" }}</b> products listed in
              this merchant
            </div>
            <div class="flex">
              <button
                type="button"
                class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-600 dark:border-green-600 dark:text-green-400 dark:hover:text-white dark:focus:ring-green-800"
                data-dismiss-target="#alert-additional-content-3"
                aria-label="Close"
                @click="router.get(route('admin.products.index', { merchant: propsData?.uuid }))"
              >
                Manage Products
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-2">
        <!-- Contact Form Start -->
        <DefaultCard cardTitle="Merchant Address">
          <div class="p-6.5">
            <InputGroup
              label="Address"
              type="text"
              placeholder="Street / Build # / Sub-Division"
              customClasses="mb-4.5"
              required
              v-model="form.address"
            >
              <template v-slot:error>
                <InputError :message="form.errors.address" />
              </template>
            </InputGroup>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              <SelectGroup
                label="City"
                class="w-full xl:w-1/2"
                v-model="form.city"
              >
                <option value="" disabled selected>Select City</option>
                <option
                  :value="city.value"
                  v-for="(city, key) in cities"
                  :key="key"
                >
                  {{ city.label }}
                </option>

                <template v-slot:error>
                  <InputError :message="form.errors.city" />
                </template>
              </SelectGroup>

              <SelectGroup
                label="Country"
                class="w-full xl:w-1/2"
                v-model="form.country"
              >
                <option value="" disabled selected>Select Country</option>
                <option
                  :value="country.value"
                  v-for="(country, key) in countries"
                  :key="key"
                >
                  {{ country.label }}
                </option>

                <template v-slot:error>
                  <InputError :message="form.errors.country" />
                </template>
              </SelectGroup>
            </div>

            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
              <InputGroup
                label="Postal Code"
                type="text"
                placeholder="0000"
                customClasses="w-full xl:w-1/2"
                v-model="form.postal_code"
              >
                <template v-slot:error>
                  <InputError :message="form.errors.postal_code" />
                </template>
              </InputGroup>
            </div>
          </div>
        </DefaultCard>
        <!-- Contact Form End -->

        <div class="flex justify-end gap-2 mt-5">
          <button
            type="button"
            class="flex items-center justify-center w-full gap-3 p-3 font-medium text-white border disabled:opacity-30 rounded-3xl bg-danger hover:bg-opacity-90 disabled:cursor-not-allowed"
            :disabled="form.processing"
            @click="handleDelete"
            v-if="isUpdate"
          >
            Delete
          </button>

          <button
            type="button"
            class="flex items-center justify-center w-full gap-3 p-3 font-medium border disabled:opacity-30 rounded-3xl border-danger text-danger hover:bg-opacity-90 disabled:cursor-not-allowed"
            :disabled="form.processing"
            @click="handleCancel"
          >
            {{ isUpdate ? "Cancel" : "Reset Form" }}
          </button>

          <button
            type="submit"
            class="flex justify-center w-full p-3 font-medium disabled:cursor-not-allowed rounded-3xl bg-primary text-gray hover:bg-opacity-90 disabled:bg-opacity-70"
            :disabled="form.processing"
          >
            {{
              form.processing
                ? "Processing..."
                : isUpdate
                ? "Update Merchant"
                : "Save Merchant"
            }}
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<style scoped></style>
