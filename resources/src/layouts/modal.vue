<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 overflow-y-auto"
    style="z-index: 9999"
  >
    <div
      class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 sm:p-0"
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
          class="inline-block align-bottom bg-white text-left shadow-xl transform transition-all sm:my-8 sm:align-middle rounded-lg"
          :class="mw"
          role="dialog"
          aria-modal="true"
          aria-labelledby="modal-headline"
        >
          <div
            v-if="showClose"
            class="font-bold text-4xl inline-block absolute right-2 transform rotate-45 cursor-pointer z-20"
            @click="close"
          >
            +
          </div>

          <div class="pb-4" :class="padding">
            <slot name="border-top"> </slot>
            <div class="sm:flex sm:items-start justify-center">
              <div class="mt-3 sm:mt-0">
                <slot name="header"></slot>
                <div>
                  <slot name="body"></slot>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 py-3 sm:px-8">
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
    mw: {
      type: String,
      default: "",
    },
    showClose: {
      type: Boolean,
      default: true,
    },
    padding: {
      type: String,
      default: "px-4 sm:px-8 sm:pt-6",
    },
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