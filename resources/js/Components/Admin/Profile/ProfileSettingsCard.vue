<script setup>
import { computed, onMounted, ref } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import Notification from "@/Helpers/Notification";
import InputError from "@/Components/InputError.vue";

const page = usePage();
const form = useForm({
  _method: "PUT",
  name: "",
  email: "",
  role: "",
  photo: null,
});

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const accountForm = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const photoPreview = ref(null);
const photoInput = ref(null);

const handleSubmit = () => {
  if (photoInput.value) {
    form.photo = photoInput.value.files[0];
  }

  form.post(route("user-profile-information.update"), {
    errorBag: "updateProfileInformation",
    preserveScroll: true,
    onSuccess: (result) => {
      Notification.fire({
        title: "Success",
        message:
          result.props.flash.message ||
          "Profile information has been successfully updated",
        duration: 5000,
      });

      handleResetInfoForm();
      clearPhotoFileInput();
    },
    onError: (error) => {
      console.log("error", error);
    },
  });
};

const handleResetInfoForm = () => {
  form.name = user.value.name || "";
  form.email = user.value.email || "";
  form.role = user.value.role || "";
  form.photo = null;
  form.clearErrors();

  photoPreview.value = null;
};

const handleResetAccountInfoForm = () => {
  accountForm.reset();
  accountForm.clearErrors();
};

const handleAccountInfoSubmit = () => {
  accountForm.put(route("user-password.update"), {
    errorBag: "updatePassword",
    preserveScroll: true,
    onSuccess: (result) => {
      Notification.fire({
        title: "Success",
        message:
          result.props.flash.message ||
          "Account information has been successfully updated",
        duration: 5000,
      });

      handleResetAccountInfoForm();
    },
    onError: () => {
      if (accountForm.errors.password) {
        accountForm.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }

      if (accountForm.errors.current_password) {
        accountForm.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};

const selectNewPhoto = () => {
  photoInput.value.click();
};

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0];

  if (!photo) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};

const deletePhoto = () => {
  if (photoPreview.value) {
    photoPreview.value = null;
    clearPhotoFileInput();
    form.clearErrors("photo");
  } else {
    router.delete(route("current-user-photo.destroy"), {
      preserveScroll: true,
      onSuccess: (result) => {
        // photoPreview.value = null;
        handleResetInfoForm();
        clearPhotoFileInput();

        Notification.fire({
          title: "Success",
          message:
            result.props.flash.message || "Photo has been successfully deleted",
          duration: 5000,
        });
      },
    });
  }
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};

const user = computed(() => page.props.auth?.user || {});

onMounted(() => {
  form.name = user.value.name || "";
  form.email = user.value.email || "";
  form.role = user.value.role || "";
});
</script>

<template>
  <div class="grid grid-cols-5 gap-8">
    <!-- Personal Information Section -->
    <div class="col-span-5 xl:col-span-3">
      <div
        class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
      >
        <div class="py-4 border-b border-stroke px-7 dark:border-strokedark">
          <h3 class="font-medium text-black dark:text-white">
            Personal Information
          </h3>
        </div>
        <div class="p-7">
          <form @submit.prevent="handleSubmit">
            <div class="mb-10">
              <div class="flex items-center gap-3">
                <div class="rounded-full h-14 w-14">
                  <img
                    :src="user.profile_photo_url"
                    alt="User"
                    class="border-2 border-blue-400 rounded-full"
                    v-show="!photoPreview"
                  />

                  <div v-show="photoPreview">
                    <span
                      class="block bg-center bg-no-repeat bg-cover border-2 border-blue-400 rounded-full w-14 h-14"
                      :style="
                        'background-image: url(\'' + photoPreview + '\');'
                      "
                    ></span>
                  </div>
                </div>
                <div>
                  <span class="mb-1.5 font-medium text-black dark:text-white">
                    Your Profile Picture
                  </span>
                  <span
                    class="flex gap-2.5"
                    v-if="page.props.jetstream.managesProfilePhotos"
                  >
                    <button
                      type="button"
                      class="text-sm font-bold text-red hover:text-danger"
                      @click="deletePhoto"
                    >
                      {{ photoPreview ? "Cancel" : " Delete" }}
                    </button>
                    <button
                      type="button"
                      class="text-sm font-bold hover:text-primary"
                      @click="selectNewPhoto"
                    >
                      Update
                    </button>
                  </span>
                  <span class="flex gap-2.5" v-else> Read Only </span>
                </div>

                <input
                  type="file"
                  accept="image/*"
                  class="hidden"
                  @change="updatePhotoPreview"
                  ref="photoInput"
                  v-if="page.props.jetstream.managesProfilePhotos"
                />
              </div>
              <InputError :message="form.errors.photo" class="" />
            </div>

            <!-- Full Name Section -->
            <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
              <div class="w-full sm:w-1/2">
                <label
                  class="block mb-3 text-sm font-medium text-black dark:text-white"
                  for="fullName"
                >
                  Full Name
                </label>
                <div class="relative">
                  <span class="absolute left-4.5 top-4">
                    <svg
                      class="fill-current"
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g opacity="0.8">
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M3.72039 12.887C4.50179 12.1056 5.5616 11.6666 6.66667 11.6666H13.3333C14.4384 11.6666 15.4982 12.1056 16.2796 12.887C17.061 13.6684 17.5 14.7282 17.5 15.8333V17.5C17.5 17.9602 17.1269 18.3333 16.6667 18.3333C16.2064 18.3333 15.8333 17.9602 15.8333 17.5V15.8333C15.8333 15.1703 15.5699 14.5344 15.1011 14.0655C14.6323 13.5967 13.9964 13.3333 13.3333 13.3333H6.66667C6.00363 13.3333 5.36774 13.5967 4.8989 14.0655C4.43006 14.5344 4.16667 15.1703 4.16667 15.8333V17.5C4.16667 17.9602 3.79357 18.3333 3.33333 18.3333C2.8731 18.3333 2.5 17.9602 2.5 17.5V15.8333C2.5 14.7282 2.93899 13.6684 3.72039 12.887Z"
                          fill=""
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M9.99967 3.33329C8.61896 3.33329 7.49967 4.45258 7.49967 5.83329C7.49967 7.214 8.61896 8.33329 9.99967 8.33329C11.3804 8.33329 12.4997 7.214 12.4997 5.83329C12.4997 4.45258 11.3804 3.33329 9.99967 3.33329ZM5.83301 5.83329C5.83301 3.53211 7.69849 1.66663 9.99967 1.66663C12.3009 1.66663 14.1663 3.53211 14.1663 5.83329C14.1663 8.13448 12.3009 9.99996 9.99967 9.99996C7.69849 9.99996 5.83301 8.13448 5.83301 5.83329Z"
                          fill=""
                        />
                      </g>
                    </svg>
                  </span>
                  <input
                    v-model="form.name"
                    class="w-full rounded border border-stroke bg-white py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                    type="text"
                    name="fullName"
                    id="fullName"
                    placeholder=""
                  />
                  <InputError :message="form.errors.name" class="mt-2" />
                </div>
              </div>

              <!-- Phone Number Section -->
              <div class="w-full sm:w-1/2">
                <label
                  class="block mb-3 text-sm font-medium text-black dark:text-white"
                  for="phoneNumber"
                >
                  Phone Number
                </label>
                <input
                  class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="text"
                  name="phoneNumber"
                  id="phoneNumber"
                  placeholder=""
                  disabled
                />
              </div>
            </div>

            <!-- Email Address Section -->
            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="emailAddress"
              >
                Email Address
              </label>
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <svg
                    class="fill-current"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g opacity="0.8">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M3.33301 4.16667C2.87658 4.16667 2.49967 4.54357 2.49967 5V15C2.49967 15.4564 2.87658 15.8333 3.33301 15.8333H16.6663C17.1228 15.8333 17.4997 15.4564 17.4997 15V5C17.4997 4.54357 17.1228 4.16667 16.6663 4.16667H3.33301ZM0.833008 5C0.833008 3.6231 1.9561 2.5 3.33301 2.5H16.6663C18.0432 2.5 19.1663 3.6231 19.1663 5V15C19.1663 16.3769 18.0432 17.5 16.6663 17.5H3.33301C1.9561 17.5 0.833008 16.3769 0.833008 15V5Z"
                        fill=""
                      />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.983719 4.52215C1.24765 4.1451 1.76726 4.05341 2.1443 4.31734L9.99975 9.81615L17.8552 4.31734C18.2322 4.05341 18.7518 4.1451 19.0158 4.52215C19.2797 4.89919 19.188 5.4188 18.811 5.68272L10.4776 11.5161C10.1907 11.7169 9.80879 11.7169 9.52186 11.5161L1.18853 5.68272C0.811486 5.4188 0.719791 4.89919 0.983719 4.52215Z"
                        fill=""
                      />
                    </g>
                  </svg>
                </span>
                <input
                  :value="form.email"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="email"
                  name="emailAddress"
                  id="emailAddress"
                  placeholder=""
                  disabled
                />
                <InputError :message="form.errors.email" class="mt-2" />
              </div>
            </div>

            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="role"
              >
                Role
              </label>
              <input
                class="capitalize w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Role"
                id="role"
                placeholder=""
                :value="form.role"
                disabled
              />
              <InputError :message="form.errors.role" class="mt-2" />
            </div>

            <!-- Bio Section -->
            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="bio"
              >
                BIO
              </label>
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <svg
                    class="fill-current"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g opacity="0.8" clip-path="url(#clip0_88_10224)">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M1.56524 3.23223C2.03408 2.76339 2.66997 2.5 3.33301 2.5H9.16634C9.62658 2.5 9.99967 2.8731 9.99967 3.33333C9.99967 3.79357 9.62658 4.16667 9.16634 4.16667H3.33301C3.11199 4.16667 2.90003 4.25446 2.74375 4.41074C2.58747 4.56702 2.49967 4.77899 2.49967 5V16.6667C2.49967 16.8877 2.58747 17.0996 2.74375 17.2559C2.90003 17.4122 3.11199 17.5 3.33301 17.5H14.9997C15.2207 17.5 15.4326 17.4122 15.5889 17.2559C15.7452 17.0996 15.833 16.8877 15.833 16.6667V10.8333C15.833 10.3731 16.2061 10 16.6663 10C17.1266 10 17.4997 10.3731 17.4997 10.8333V16.6667C17.4997 17.3297 17.2363 17.9656 16.7674 18.4344C16.2986 18.9033 15.6627 19.1667 14.9997 19.1667H3.33301C2.66997 19.1667 2.03408 18.9033 1.56524 18.4344C1.0964 17.9656 0.833008 17.3297 0.833008 16.6667V5C0.833008 4.33696 1.0964 3.70107 1.56524 3.23223Z"
                        fill=""
                      />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M16.6664 2.39884C16.4185 2.39884 16.1809 2.49729 16.0056 2.67253L8.25216 10.426L7.81167 12.188L9.57365 11.7475L17.3271 3.99402C17.5023 3.81878 17.6008 3.5811 17.6008 3.33328C17.6008 3.08545 17.5023 2.84777 17.3271 2.67253C17.1519 2.49729 16.9142 2.39884 16.6664 2.39884ZM14.8271 1.49402C15.3149 1.00622 15.9765 0.732178 16.6664 0.732178C17.3562 0.732178 18.0178 1.00622 18.5056 1.49402C18.9934 1.98182 19.2675 2.64342 19.2675 3.33328C19.2675 4.02313 18.9934 4.68473 18.5056 5.17253L10.5889 13.0892C10.4821 13.196 10.3483 13.2718 10.2018 13.3084L6.86847 14.1417C6.58449 14.2127 6.28409 14.1295 6.0771 13.9225C5.87012 13.7156 5.78691 13.4151 5.85791 13.1312L6.69124 9.79783C6.72787 9.65131 6.80364 9.51749 6.91044 9.41069L14.8271 1.49402Z"
                        fill=""
                      />
                    </g>
                    <defs>
                      <clipPath id="clip0_88_10224">
                        <rect width="20" height="20" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </span>
                <textarea
                  class="min-h-25 w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  name="bio"
                  id="bio"
                  rows="6"
                  placeholder="Write your bio here"
                  disabled
                ></textarea>
              </div>
            </div>

            <!-- Save and Cancel Buttons -->
            <div class="flex justify-end gap-4.5">
              <button
                class="flex justify-center px-6 py-2 font-medium text-black border rounded border-stroke hover:shadow-1 dark:border-strokedark dark:text-white"
                type="button"
                @click="handleResetInfoForm"
              >
                Reset
              </button>
              <button
                class="flex justify-center px-6 py-2 font-medium rounded bg-primary text-gray hover:bg-opacity-90"
                type="submit"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Your Photo Section -->
    <div class="col-span-5 xl:col-span-2">
      <div
        class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
      >
        <div class="py-4 border-b border-stroke px-7 dark:border-strokedark">
          <h3 class="font-medium text-black dark:text-white">
            Account Information
          </h3>
        </div>
        <div class="p-7">
          <form @submit.prevent="handleAccountInfoSubmit">
            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="current_password"
              >
                Current Password
              </label>
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <i class="fas fa-lock"></i>
                </span>
                <input
                  v-model="accountForm.current_password"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="password"
                  name="current_password"
                  id="current_password"
                  placeholder=""
                  ref="currentPasswordInput"
                />
                <InputError
                  :message="accountForm.errors.current_password"
                  class="mt-2"
                />
              </div>
            </div>

            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="password"
              >
                New Password
              </label>
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <i class="fas fa-lock"></i>
                </span>
                <input
                  v-model="accountForm.password"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="password"
                  name="password"
                  id="password"
                  placeholder=""
                  ref="passwordInput"
                />
                <InputError
                  :message="accountForm.errors.password"
                  class="mt-2"
                />
              </div>
            </div>

            <div class="mb-5.5">
              <label
                class="block mb-3 text-sm font-medium text-black dark:text-white"
                for="password_confirmation"
              >
                Confirm Password
              </label>
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <i class="fas fa-lock"></i>
                </span>
                <input
                  v-model="accountForm.password_confirmation"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="password"
                  name="password_confirmation"
                  id="password_confirmation"
                  placeholder=""
                />
                <InputError
                  :message="accountForm.errors.password_confirmation"
                  class="mt-2"
                />
              </div>
            </div>

            <!-- Save and Cancel Buttons for Photo Section -->
            <div class="flex justify-end gap-4.5">
              <button
                class="flex justify-center px-6 py-2 font-medium text-black border rounded border-stroke hover:shadow-1 dark:border-strokedark dark:text-white"
                type="button"
                @click="handleResetAccountInfoForm"
              >
                Reset
              </button>
              <button
                class="flex justify-center px-6 py-2 font-medium rounded bg-primary text-gray hover:bg-opacity-90"
                type="submit"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
