<template>
  <div>
    <div class="flex flex-row flex-nowrap justify-center items-center">
      <button @click="decrease" class="amount-btn">-</button>
      <div class="mt-1 relative inline-block rounded-md shadow-sm">
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
          class="border border-white-300 bg-white focus:outline-none focus:border-transparent block w-40 py-2 pl-7 pr-12 sm:text-sm rounded mx-2 text-center"
        />
        <input
          ref="amountInput"
          type="text"
          @keypress="isNumber"
          v-show="!showFormatted"
          @blur="showFormatted = !showFormatted"
          v-model.number="ramount"
          @input="handleInput"
          class="border border-gray-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block w-40 py-2 pl-7 pr-12 sm:text-sm rounded mx-2 text-center"
        />
      </div>
      <button @click="increase" class="amount-btn">+</button>
    </div>
    <p class="text-xs text-center font-bold mt-2 text-gray-400">
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