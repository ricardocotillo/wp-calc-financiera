<template>
  <div class="grid grid-cols-3 lg:grid-cols-5 lg:gap-3 gap-2">
    <div
      v-for="(opt, i) in options"
      :key="opt.key"
      @click="$emit('update:modelValue', i)"
      class="w-full p-2 border border-gray-300 rounded flex flex-col items-center justify-center cursor-pointer"
      :class="{
        'border-gray-300': !error,
        'border-red-500': error,
      }"
      :style="{backgroundColor: modelValue == i ? primaryColor : null}"
    >
      <img
        :src="opt.icon"
        :style="{ filter: `brightness(${modelValue == i ? 100 : 1})` }"
      />
      <span
        class="font-bold text-gray-500"
        :style="{color: modelValue == i ? colorOverPrimary : null}"
        >{{ opt.title }}</span
      >
    </div>
  </div>
</template>

<script>
import { useState } from '../store/store';
export default {
  setup() {
    const state = useState()
    return{...state}
  },
  props: {
    modelValue: Number,
    options: {
      type: Array,
      default() {
        return [];
      },
    },
    error: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style>
</style>