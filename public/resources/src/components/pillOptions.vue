<template>
  <div class="grid grid-cols-3 lg:grid-cols-5 lg:gap-3 gap-2">
    <div
      v-for="(opt, i) in displayOptions"
      :key="opt"
      class="rounded-full py-2 px-4 text-white text-center font-bold cursor-pointer"
      :class="i == value ? 'bg-blue-900' : 'bg-gray-400'"
      @click="$emit('input', i)"
    >
      {{ opt }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showThird: {
      type: Boolean,
      default: false,
    },
    value: Number,
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