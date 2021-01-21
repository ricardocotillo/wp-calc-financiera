<template>
  <div>
    <div class="text-center font-bold text-gray-600 py-2 ">Quiero</div>
    <div class="grid grid-cols-6 gap-1 place-content-start place-items-center">
      <div
        @click="decrease"
        class="rounded-full bg-blue-900 w-7 h-7 text-white focus:outline-none cursor-pointer flex justify-center items-center font-bold select-none"
      >
        -
      </div>
      <div class="mt-1 relative inline-block rounded-md shadow-sm col-span-4 w-full">
        <div
          class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none"
        >
          <span class="text-gray-500 sm:text-sm"> S/ </span>
        </div>
        <input
          v-show="showFormatted"
          @click="toggleInputs"
          :value="formattedAmount"
          type="text"
          class="border border-gray-300 bg-white focus:outline-none focus:border-transparent block w-full py-2 pl-7 pr-7 sm:text-sm rounded text-center"
        />
        <input
          ref="amountInput"
          type="text"
          @keypress="isNumber"
          v-show="!showFormatted"
          @blur="showFormatted = !showFormatted"
          v-model.number="ramount"
          @input="handleInput"
          class="border border-gray-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block w-full py-2 pl-7 pr-7 sm:text-sm rounded text-center"
        />
      </div>
      <div
        @click="increase"
        class="rounded-full bg-blue-900 w-7 h-7 text-white focus:outline-none cursor-pointer flex justify-center items-center font-bold select-none"
      >
        +
      </div>
    </div>
    <p class="text-xs text-center font-bold mt-2 text-gray-700">
      Desde S/ {{ formatAmount(min) }}
    </p>
  </div>
</template>

<script>
import { formatAmount } from "../mixins/formatAmount";
import { isNumber } from "../mixins/isNumer";
export default {
  props: {
    value: Number,
  },
  data() {
    return {
      showFormatted: true,
      ramount: this.value,
      step: 100,
      min: 20000,
      max: 1000000,
    };
  },
  methods: {
    handleInput() {
      this.$emit("input", this.ramount);
    },
    isNumber,
    increase() {
      const amt = this.value + this.step;
      this.ramount = amt > this.max ? this.max : amt;
      this.emit();
    },
    decrease() {
      const amt = this.value - this.step;
      this.ramount = amt < this.min ? this.min : amt;
      this.emit();
    },
    formatAmount,
    toggleInputs() {
      this.showFormatted = !this.showFormatted;
      this.$nextTick(() => this.$refs.amountInput.focus());
    },
    emit() {
      this.$emit("input", this.ramount);
    },
  },
  computed: {
    formattedAmount() {
      return this.formatAmount(Number(this.value));
    },
  },
};
</script>

<style>
</style>