<script setup>
import SelectGroup from "@/Components/TailAdmin/Forms/SelectGroup/SelectGroup.vue";
import { onMounted, ref } from "vue";
import { UNITS } from "@/Utils/Constant";

const modelValue = defineModel();


const options = ref(UNITS);

onMounted(() => {
  //
});
</script>

<template>
  <SelectGroup label="Unit" class="w-full xl:w-1/2" v-model="modelValue">
    <option value="" disabled selected>Select Unit</option>
    <option :value="item.value" v-for="(item, key) in options" :key="key">
      {{ item.name }}
    </option>

    <template v-slot:error>
      <slot name="error"></slot>
    </template>
  </SelectGroup>
</template>
