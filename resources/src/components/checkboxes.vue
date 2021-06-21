<template>
  <div>
    <div v-if="label" class="text-center font-bold text-gray-600 py-2">
      {{ label }}
    </div>
    <div class="flex flex-row">
      <div
        @click="change(1)"
        class="flex flex-col items-center mr-2 border border-gray-300 rounded-md cursor-pointer p-2 w-1/2"
      >
        <input
          id="radio1"
          type="radio"
          name="type"
          :checked="modelValue == 1"
        />
        <div
          class="w-3 h-3 rounded-full ring-1 ring-gray-300"
          :class="modelValue == 1 ? 'bg-blue-900 ring-offset-2' : 'ring-offset-1'"
        ></div>
        <div class="text-xs text-center font-bold mt-2">
          Préstamo con garantia hipotecaria
        </div>
      </div>

      <div
        @click="change(2)"
        class="flex flex-col items-center ml-2 border border-gray-300 rounded-md cursor-pointer p-2 w-1/2"
      >
        <input
          id="radio2"
          type="radio"
          name="type"
          class="hidden"
          :checked="modelValue == 2"
        />
        <div
          class="w-3 h-3 rounded-full ring-1 ring-gray-300"
          :class="modelValue == 2 ? 'bg-blue-900 ring-offset-2' : 'ring-offset-1'"
        ></div>
        <div class="text-xs text-center font-bold mt-2">Factoring</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: Number,
      default: 1,
    },
    label: String,
  },
  methods: {
    change(e) {
      this.$emit("update:modelValue", e);
    },
  },
};
</script>

<style scoped>
  input {
    display: none;
  }
</style>