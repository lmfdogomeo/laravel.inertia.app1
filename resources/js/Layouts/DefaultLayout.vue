<script setup>
import HeaderArea from '@/Components/TailAdmin/Header/HeaderArea.vue'
import SidebarArea from '@/Components/TailAdmin/Sidebar/SidebarArea.vue'
import { onMounted, ref } from 'vue';

const isLoading = ref(false);

</script>

<template>
  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    <SidebarArea />
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
      <!-- ===== Header Start ===== -->
      <HeaderArea />
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
      <div class="flex items-center justify-center flex-1" v-if="isLoading">
        <div class="w-[150px] h-[150px] text-accent">
          <svg
            width="100%"
            height="100%"
            viewBox="0 0 38 38"
            xmlns="http://www.w3.org/2000/svg"
            stroke="currentColor"
          >
            <g fill="none" fill-rule="evenodd">
              <g transform="translate(1 1)" stroke-width="2">
                <circle stroke-opacity="0.5" cx="18" cy="18" r="18"></circle>
                <path d="M36 18c0-9.94-8.06-18-18-18">
                  <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="0 18 18"
                    to="360 18 18"
                    dur="2s"
                    repeatCount="indefinite"
                  />
                </path>
              </g>
            </g>
          </svg>
        </div>
      </div>
  
      <main v-show="!isLoading">
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
          <slot></slot>
        </div>
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
  </div>
  <!-- ===== Page Wrapper End ===== -->
</template>
