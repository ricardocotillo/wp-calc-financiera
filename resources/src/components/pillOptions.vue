<template>
  <div class="grid grid-cols-3 lg:grid-cols-5 lg:gap-3 gap-2">
    <div
      v-for="(opt, i) in displayOptions"
      :key="opt"
      class="rounded-full py-2 px-4 text-white text-center font-bold cursor-pointer"
      :class="{
        'bg-blue-900': i == value,
        'bg-gray-400': i != value,
        'ring-1 ring-red-500': error,
      }"
      @click="$emit('input', i)"
    >
      {{ opt }}
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    showThird: {
      type: Boolean,
      default: false,
    },
    value: Number,
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
});
</script>