<script setup>
import Confirmation from "@/Helpers/Confirmation";
import Notification from "@/Helpers/Notification";
import { useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const fileInput = ref(null);
const photoPreview = ref(null);
const { onChange, disabled, defaultValue, isUpdate, uuid } = defineProps({
  onChange: Function,
  disabled: [String, Boolean, null],
  defaultValue: String,
  isUpdate: Boolean,
  uuid: String
});

const handleFileChange = (e) => {
  console.log("fileInput", fileInput.value?.files);
  if (typeof onChange === "function" && !disabled) {
    onChange(e.target.files);
  }

  updatePhotoPreview();
};

const updatePhotoPreview = () => {
  const photo = fileInput.value?.files[0];

  if (!photo) {
    photoPreview.value = null;
    return;
  }

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};

const handleRemoveImage = () => {
  if (isUpdate) {
    Confirmation.confirm({
      title: "Confirmation",
      type: "warning",
      text: "Are you sure you want to delete this image?",
      cancelButtonText: "Cancel",
      confirmButtonText: "Continue",
    }).then((result) => {
      if (result.isConfirm) {
        onDeleteImage();
      }
    });
  }
  else {
    photoPreview.value = null;
    fileInput.value = null;
    if (typeof onChange === "function") {
      onChange(null);
    }
  }
}

const onDeleteImage = () => {
  useForm({ _method: "DELETE" }).post(route("admin.product-image.destroy", { uuid: uuid }), {
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

const reset = () => {
  handleRemoveImage();
}

const hasFile = computed(() => {
  return photoPreview.value ? true : false;
});

onMounted(() => {
  if (defaultValue) {
    photoPreview.value = defaultValue;
  }
})

defineExpose({
  reset
});
</script>

<template>
  <div v-if="photoPreview" class="relative border-2 group preview">
    <div
      class="relative flex items-center w-full p-0 m-auto h-30 max-w-30 bg-white/20 backdrop-blur sm:h-44 sm:max-w-44"
    >
      <div class="relative drop-shadow-2" v-show="photoPreview">
        <img :src="photoPreview" alt="profile" class="w-full h-full" />
      </div>
    </div>
    <label
      for="profile"
      class="absolute items-center justify-center invisible px-2 py-1 text-sm text-white cursor-pointer bottom-1 right-1 group-hover:visible preview:block bg-danger hover:bg-red"
      @click="handleRemoveImage"
    >
      <i class="fas fa-times"></i>
      Remove
    </label>
  </div>
  <div
    id="FileUpload"
    class="relative block cursor-pointer appearance-none rounded border border-dashed border-[#E2E1E1] bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5"
    :class="{ '!cursor-not-allowed': disabled }"
    v-if="!photoPreview"
  >
    <input
      type="file"
      accept=".png,.jpg,.jpeg"
      class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
      :class="{ '!cursor-not-allowed': disabled }"
      @change="handleFileChange"
      :disabled="disabled"
      ref="fileInput"
    />
    <div
      class="flex flex-col items-center justify-center space-y-3"
      v-if="!hasFile"
    >
      <span
        class="flex items-center justify-center w-10 h-10 bg-white border rounded-full border-stroke dark:border-strokedark dark:bg-boxdark"
      >
        <svg
          width="16"
          height="16"
          viewBox="0 0 16 16"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M1.99967 9.33337C2.36786 9.33337 2.66634 9.63185 2.66634 10V12.6667C2.66634 12.8435 2.73658 13.0131 2.8616 13.1381C2.98663 13.2631 3.1562 13.3334 3.33301 13.3334H12.6663C12.8431 13.3334 13.0127 13.2631 13.1377 13.1381C13.2628 13.0131 13.333 12.8435 13.333 12.6667V10C13.333 9.63185 13.6315 9.33337 13.9997 9.33337C14.3679 9.33337 14.6663 9.63185 14.6663 10V12.6667C14.6663 13.1971 14.4556 13.7058 14.0806 14.0809C13.7055 14.456 13.1968 14.6667 12.6663 14.6667H3.33301C2.80257 14.6667 2.29387 14.456 1.91879 14.0809C1.54372 13.7058 1.33301 13.1971 1.33301 12.6667V10C1.33301 9.63185 1.63148 9.33337 1.99967 9.33337Z"
            fill="#3C50E0"
          />
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.5286 1.52864C7.78894 1.26829 8.21106 1.26829 8.4714 1.52864L11.8047 4.86197C12.0651 5.12232 12.0651 5.54443 11.8047 5.80478C11.5444 6.06513 11.1223 6.06513 10.8619 5.80478L8 2.94285L5.13807 5.80478C4.87772 6.06513 4.45561 6.06513 4.19526 5.80478C3.93491 5.54443 3.93491 5.12232 4.19526 4.86197L7.5286 1.52864Z"
            fill="#3C50E0"
          />
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.99967 1.33337C8.36786 1.33337 8.66634 1.63185 8.66634 2.00004V10C8.66634 10.3682 8.36786 10.6667 7.99967 10.6667C7.63148 10.6667 7.33301 10.3682 7.33301 10V2.00004C7.33301 1.63185 7.63148 1.33337 7.99967 1.33337Z"
            fill="#3C50E0"
          />
        </svg>
      </span>
      <p class="text-sm font-medium">
        <span class="text-primary">Browse Image</span>
      </p>
      <p class="mt-1.5 text-sm font-medium">PNG, JPG</p>
      <!-- <p class="text-sm font-medium">(max, 800 X 800px)</p> -->
    </div>

    <div v-if="false">
      <div class="bg-white/20 backdrop-blur">
        <div class="drop-shadow-2" v-show="photoPreview">
          <img :src="photoPreview" alt="profile" class="w-auto h-[10rem]" />
          <!-- <label
            for="profile"
            class="absolute bottom-0 right-0 flex h-8.5 w-8.5 cursor-pointer items-center justify-center rounded-full bg-primary text-white hover:bg-opacity-90 sm:bottom-2 sm:right-2"
          >
            <CameraSvgIcon />
            <input type="file" name="profile" id="profile" class="sr-only" 
              @change="updatePhotoPreview"
            />
          </label> -->
        </div>

        <!-- <div class="drop-shadow-2" v-show="photoPreview">
          <div class="">
            <span
              class="block w-full h-full bg-center bg-no-repeat bg-cover"
              :style="'background-image: url(\'' + photoPreview + '\');'"
            ></span>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</template>
