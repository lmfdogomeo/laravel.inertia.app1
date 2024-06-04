<script setup>
import SelectGroup from "@/Components/TailAdmin/Forms/SelectGroup/SelectGroup.vue";
import { onMounted, ref } from "vue";
import { PRODUCT_CATEGORIES } from "@/Utils/Constant";

const modelValue = defineModel();

const options = ref([]);

const fetchCategories = async() => {
  try {
    const {data, status} = await axios.get(route('api.product-categories.list'));
    if ([200,201].includes(status)) {
      options.value = data?.data || [];
    }
  } catch (error) {
    console.log('error', error?.response?.data?.message || error)
  }
}

onMounted(() => {
  fetchCategories();
});
</script>

<template>
  <SelectGroup label="Category" class="w-full xl:w-1/2" v-model="modelValue">
    <option value="" disabled selected>Select Category</option>
    <option :value="item.uuid" v-for="(item, key) in options" :key="key">
      {{ item.category }}
    </option>

    <template v-slot:error>
      <slot name="error"></slot>
    </template>
  </SelectGroup>
</template>
