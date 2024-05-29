<script setup>
import { ref } from "vue";
import BreadcrumbDefault from "@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue";
import MerchantTable from "@/Components/Admin/Merchant/MerchantTable.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

const pageTitle = ref("Merchant Management");
</script>

<template>
  <DefaultLayout>
    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-1">
      <MerchantTable />
    </div>
  </DefaultLayout>
</template>
