<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";
import DangerSvgIcon from "@/assets/svg/DangerSvgIcon.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DangerHoverButton from "@/Components/DangerHoverButton.vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxWidth: {
    type: String,
    default: "2xl",
  },
  closeable: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(["close"]);
const dialog = ref();
const showSlot = ref(props.show);

watch(
  () => props.show,
  () => {
    if (props.show) {
      document.body.style.overflow = "hidden";
      showSlot.value = true;
      dialog.value?.showModal();
    } else {
      document.body.style.overflow = null;
      setTimeout(() => {
        dialog.value?.close();
        showSlot.value = false;
      }, 200);
    }
  }
);

const close = () => {
  if (props.closeable) {
    emit("close");
  }
};

const closeOnEscape = (e) => {
  if (e.key === "Escape" && props.show) {
    close();
  }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
  document.removeEventListener("keydown", closeOnEscape);
  document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
  return {
    sm: "sm:max-w-sm",
    md: "sm:max-w-md",
    lg: "sm:max-w-lg",
    xl: "sm:max-w-xl",
    "2xl": "sm:max-w-2xl",
  }[props.maxWidth];
});
</script>

<template>
  <div
    class="fixed top-0 left-0 flex items-center justify-center w-full h-full min-h-screen px-4 py-5 z-999999 bg-black/90"
    style=""
  >
    <div
      class="w-full max-w-142.5 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5"
    >
      <span class="inline-block mx-auto">
        <DangerSvgIcon />
      </span>
      <h3
        class="mt-5.5 pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl"
      >
        Deactivate Your Account
      </h3>
      <p class="mb-10 font-medium">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry Lorem Ipsum been.
      </p>
      <div class="flex flex-wrap -mx-3 gap-y-4">
        <div class="w-full px-3 2xsm:w-1/2">
          <DangerHoverButton>
            Cancel
          </DangerHoverButton>
        </div>
        <div class="w-full px-3 2xsm:w-1/2">
          <DangerButton>
            Deactivate
          </DangerButton> 
        </div>
      </div>
    </div>
  </div>
</template>
