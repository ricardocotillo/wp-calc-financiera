<template>
  <div class="relative text-left" :class="w">
    <div v-if="label" class="text-center font-bold py-2 rounded-t-md">
      {{ label }}
    </div>
    <div>
      <button
        ref="selectBtn"
        @click="isOpen = !isOpen"
        type="button"
        class="
          inline-flex
          justify-between
          w-full
          border
          shadow-sm
          px-4
          py-3
          bg-white
          text-sm
          font-medium
          rounded-md
        "
        id="options-menu"
        aria-haspopup="true"
        aria-expanded="true"
      >
        {{ modelValue !== null ? options[modelValue].title : placeholder }}
        <img
          class="-mr-1 ml-2 h-5 w-5"
          :src="`${baseUrl}/img/arrow.svg`"
          alt=""
        />
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
        class="
          origin-top-right
          absolute
          right-0
          mt-2
          w-full
          ounded-md
          shadow-lg
          bg-white
          ring-1 ring-black ring-opacity-5
          z-50
        "
      >
        <div class="py-1 max-h-80 overflow-y-auto">
          <div
            v-for="(opt, i) in options"
            :key="opt.key + '-' + opt.title"
            class="
              cursor-pointer
              block
              px-4
              py-2
              text-sm text-gray-700
              hover:bg-gray-100
              hover:text-gray-900
            "
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
import { baseUrl } from '../mixins/calcData'
import { useState } from '../store/store'
export default {
  setup() {
    const state = useState()

    return { ...state }
  },
  props: {
    modelValue: Number,
    options: {
      type: Array,
      default: () => [],
    },
    w: {
      type: String,
      default: 'w-full',
    },
    placeholder: {
      type: String,
      default: 'Seleccionar',
    },
    label: String,
    focused: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      baseUrl,
      isOpen: false,
    }
  },
  mounted() {
    document.addEventListener('click', (e) => {
      if (e.target !== this.$refs.selectBtn) {
        this.isOpen = false
      }
    })
  },
  methods: {
    close() {
      this.isOpen = false
    },
    select(i) {
      this.$emit('update:modelValue', i)
      this.close()
    },
  },
}
</script>
<style scoped>
button:hover,
button:focus {
  color: inherit;
}
</style>
