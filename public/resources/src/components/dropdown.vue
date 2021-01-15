<template>
  <div class="relative text-left" :class="`w-${w}`" @blur="close">
    <div>
      <button
        @click="isOpen = !isOpen"
        type="button"
        class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
        id="options-menu"
        aria-haspopup="true"
        aria-expanded="true"
      >
        {{ value !== null ? options[value].title : selected }}
        <img class="-mr-1 ml-2 h-5 w-5" src="/wp-content/plugins/calc-financiera/public/img/arrow.svg" alt="" />
      </button>
    </div>
    <transition
      enter-active-class="transition ease-out duration-100 transform"
      enter-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75 transform"
      leave-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-show="isOpen"
        class="origin-top-right absolute right-0 mt-2 w-full ounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
      >
        <div class="py-1">
          <div
            v-for="(opt, i) in options"
            :key="opt.key"
            class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
            role="menuitem"
            @click="select(i)"
          >
            {{ opt.title }}
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    value: Number,
    options: {
      type: Array,
      default: () => [],
    },
    w: {
      type: String,
      default: "60",
    },
  },
  data() {
    return {
      selected: "Seleccionar",
      isOpen: false,
    };
  },
  methods: {
    close() {
      this.isOpen = false;
    },
    select(i) {
      this.$emit("input", i);
      this.close();
    },
  },
};
</script>
