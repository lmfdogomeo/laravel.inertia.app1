<script setup>
import { computed } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";

import PaginationLink from "@/Components/PaginationLink.vue";
import EyeSvgIcon from "@/assets/svg/EyeSvgIcon.vue";
import DeleteSvgIcon from "@/assets/svg/DeleteSvgIcon.vue";
import Confirmation from "@/Helpers/Confirmation";
import Notification from "@/Helpers/Notification";

const page = usePage();
const emptyForm = useForm({});

const handleShowAccount = (data) => {
  router.get(
    route("admin.accounts.show", {
      account: data.uuid,
    })
  );
};

const handleDelete = (data) => {
  Confirmation.confirm({
    title: "Confirmation",
    type: "warning",
    text: "Are you sure you want to delete this account?",
    cancelButtonText: "Cancel",
    confirmButtonText: "Continue",
  }).then((result) => {
    if (result.isConfirm) {
      onDeleteAccount(data?.uuid || "");
    }
  });
};

const onDeleteAccount = (uuid) => {
  emptyForm.delete(
    route("admin.accounts.destroy", {
      account: uuid
    }),
    {
      preserveScroll: true,
      onSuccess: (response) => {
        Notification.fire({
          title: "Success",
          message:
            response.props.flash.message ||
            "Account has been successfully deleted",
          duration: 5000,
        });
      },
      onError: (error) => {
        console.log("onError", error);
      },
    }
  );
};

const accounts = computed(() => page.props.paginate?.data || []);
const from = computed(() => page.props.paginate?.from || 0);
const to = computed(() => page.props.paginate?.to || 0);
const total = computed(() => page.props.paginate?.total || 0);
const links = computed(() => page.props.paginate?.links || []);
const currentAccount = computed(() => page.props.auth.user);

</script>

<template>
  <div
    class="flex flex-col-reverse gap-4 mb-5 md:flex-col lg:flex-row lg:justify-between"
  >
    <div class="flex flex-col gap-4 md:flex-row md:gap-[14px]">
      <Link :href="route('admin.accounts.create')" class="btn btn--primary">
        Add New Account <i class="fas fa-plus"></i>
      </Link>
    </div>
    <div class="relative lg:w-[326px]">
      <input
        class="field-input !pr-[60px]"
        type="search"
        placeholder="Search Accounts"
        value=""
      />
      <button
        class="field-btn text-red !right-[40px] transition opacity-0"
        aria-label="Clear all"
      >
        <i class="fas fa-close"></i>
      </button>
      <button class="field-btn icon" aria-label="Search">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div
    class="flex flex-col-reverse items-center gap-4 mt-3 mb-3 md:flex-row md:justify-between md:mt-3 md:mb-4"
  >
    <p>
      View accounts: <span class="font-semibold">{{ from }}-{{ to }}</span
      >/{{ total }}
    </p>
  </div>

  <div
    class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="max-w-full overflow-x-auto">
      <table class="w-full table-auto">
        <thead>
          <tr class="text-left border border-l-0 border-r-0 border-stroke">
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Name
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Email
            </th>
            <th
              class="px-4 py-4 font-medium text-black border border-t-0 border-b-0 border-l-0 dark:text-white border-stroke text-nowrap"
            >
              Role
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Company ID
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Company Name
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Contact
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Address
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              City
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Country
            </th>
            <th class="px-4 py-4 font-medium text-black dark:text-white text-nowrap">
              Postal Code
            </th>
            <th
              class="px-4 py-4 font-medium text-black border border-t-0 border-b-0 border-r-0 border-stroke dark:text-white text-nowrap"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(account, index) in accounts" :key="index" class="">
            <td class="px-4 py-5 text-nowrap">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="h-12.5 w-15 rounded-md">
                  <img
                    :src="account.profile_photo_path || `https://ui-avatars.com/api/?name=A+I&color=7F9CF5&background=EBF4FF`"
                    :alt="`Product: ${account.name}`"
                  />
                </div>
                <p class="text-sm font-medium text-black dark:text-white">
                  {{ account.name }}
                </p>
              </div>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.email }}
              </p>
            </td>
            <td class="px-4 py-5 pl-6 capitalize border border-t-0 border-b-0 border-l-0 xl:pl-6 border-stroke">
              <p class="text-black dark:text-white">
                {{ account.role }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p
                class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-opacity-10"
              >
                {{ account.merchant_user?.merchant?.company_tax_id || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p
                class="inline-flex px-3 py-1 text-sm font-medium capitalize rounded-full bg-opacity-10"
              >
                {{ account.merchant_user?.merchant?.company_name || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.merchant_user?.merchant?.contact_number || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.merchant_user?.merchant?.address || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.merchant_user?.merchant?.city || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.merchant_user?.merchant?.country || "-" }}
              </p>
            </td>
            <td class="px-4 py-5">
              <p class="text-black dark:text-white">
                {{ account.merchant_user?.merchant?.postal_code || "-" }}
              </p>
            </td>
            <td
              class="px-4 py-5 border border-t-0 border-b-0 border-r-0 border-stroke"
            >
              <div class="flex items-center space-x-3.5">
                <button
                  class="hover:text-primary"
                  @click="handleShowAccount(account)"
                >
                  <EyeSvgIcon />
                </button>

                <button
                  class="hover:text-primary"
                  @click="handleDelete(account)"
                  v-if="currentAccount.uuid !== account.uuid"
                >
                  <DeleteSvgIcon />
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="accounts.length === 0">
            <td colspan="10" class="px-4 py-5 italic font-bold text-center">
              No data found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <PaginationLink
    :links="links"
    :from="from"
    :to="to"
    :total="total"
    class="!bg-transparent"
  />
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
