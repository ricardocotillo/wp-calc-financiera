<template>
  <div v-if="isOpen" class="fixed inset-0 overflow-y-auto" style="z-index: 9999;">
    <div
      class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
    >
      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
      </transition>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span
        class="hidden sm:inline-block sm:align-middle sm:h-screen"
        aria-hidden="true"
        >&#8203;</span
      >
      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      >
        <div
          class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl"
          role="dialog"
          aria-modal="true"
          aria-labelledby="modal-headline"
        >
          <div
            class="font-bold text-4xl inline-block absolute right-2 transform rotate-45 cursor-pointer"
            @click="close"
          >
            +
          </div>
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start justify-center">
              <div class="mt-3 text-center sm:mt-0 sm:text-left">
                <slot name="header"></slot>
                <div class="mt-2">
                  <slot name="body"></slot>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6">
            <slot name="footer"></slot>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isOpen: Boolean,
    width: Number,
  },
  data() {
    return {
      show: this.isOpen,
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
};
</script>

<style>
</style>