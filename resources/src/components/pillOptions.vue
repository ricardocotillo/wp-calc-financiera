<template>
  <div class="grid grid-cols-3 lg:grid-cols-5 lg:gap-3 gap-2">
    <div
      v-for="(opt, i) in displayOptions"
      :key="opt"
      class="rounded-full py-2 px-4 text-white text-center font-bold cursor-pointer bg-gray-400"
      :class="{
        'ring-1 ring-red-500': error,
      }"
      :style="{backgroundColor: i == modelValue ? primaryColor : null, color: i == modelValue ? colorOverPrimary : null}"
      @click="$emit('update:modelValue', i)"
    >
      {{ opt }}
    </div>
  </div>
</template>

<script>
import { useState } from '../store/store';
export default {
  setup() {
    const state = useState()
    return {...state}
  },
  props: {
    showThird: {
      type: Boolean,
      default: false,
    },
    modelValue: Number,
    error: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      options: ["Si", "No", "No sé"],
    };
  },
  computed: {
    displayOptions() {
      return this.options.filter((v, i) => i < 2 || this.showThird);
    },
  },
};
</script>

<style>
</style>