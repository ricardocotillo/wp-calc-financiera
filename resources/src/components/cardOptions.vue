<template>
  <div class="grid grid-cols-3 lg:grid-cols-5 lg:gap-3 gap-2">
    <div
      v-for="(opt, i) in options"
      :key="opt.key"
      @click="$emit('input', i)"
      class="w-full p-2 border border-gray-300 rounded flex flex-col items-center justify-center cursor-pointer"
      :class="{
        'bg-blue-900': value == i,
        'border-gray-300': !error,
        'border-red-500': error,
      }"
    >
      <img
        :src="opt.icon"
        :style="{ filter: `brightness(${value == i ? 100 : 1})` }"
      />
      <span
        class="font-bold"
        :class="value == i ? 'text-white' : 'text-gray-500'"
        >{{ opt.title }}</span
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: Number,
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