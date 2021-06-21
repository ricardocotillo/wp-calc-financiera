<template>
  <div>
    <div v-if="label" class="text-center font-bold text-gray-600 py-2">
      {{ label }}
    </div>
    <div class="grid grid-cols-6 gap-1 place-content-start place-items-center">
      <div
        @click="decrease"
        class="
          rounded-full
          w-7
          h-7
          focus:outline-none
          cursor-pointer
          flex
          justify-center
          items-center
          font-bold
          select-none
          justify-self-start
        "
        :style="{ backgroundColor: primaryColor }"
      >
        <div class="h-0.5 w-2 bg-white"></div>
      </div>
      <div
        class="
          input-amount-container
          mt-1
          relative
          inline-block
          col-span-4
          w-full
        "
      >
        <input
          @focus="toggleInput"
          @input="handleInput"
          @blur="toggleInput"
          :value="formattedAmount"
          type="text"
          class="block w-full sm:text-sm text-center"
        />
      </div>
      <div
        @click="increase"
        class="
          rounded-full
          w-7
          h-7
          focus:outline-none
          cursor-pointer
          flex
          justify-center
          items-center
          font-bold
          justify-self-end
        "
        :style="{ backgroundColor: primaryColor }"
      >
        <div
          class="h-0.5 w-2 transform translate-x-2/4"
          :style="{ backgroundColor: colorOverPrimary }"
        ></div>
        <div
          class="h-0.5 w-2 transform rotate-90 -translate-x-2/4"
          :style="{ backgroundColor: colorOverPrimary }"
        ></div>
      </div>
    </div>
    <p
      class="text-xs text-center font-bold mt-2"
      :class="ramount < min ? 'text-red-500' : 'text-gray-700'"
    >
      Desde S/ {{ formatAmount(min) }}
    </p>
  </div>
</template>

<script>
import { formatAmount } from '../mixins/formatAmount'
import { isNumber } from '../mixins/isNumer'
import { useState } from '../store/store'
export default {
  setup() {
    const state = useState()

    return { ...state }
  },
  props: {
    modelValue: Number,
    label: String,
    min: {
      type: Number,
      default: 20000,
    },
    max: {
      type: Number,
      default: 1000000,
    },
    step: {
      type: Number,
      default: 100,
    },
  },
  data() {
    return {
      showFormatted: true,
      ramount: this.modelValue,
    }
  },
  methods: {
    handleInput(e) {
      const amount = Number(e.target.value)
      this.ramount = amount
      this.emit()
    },
    isNumber,
    increase() {
      const amt = this.modelValue + this.step
      this.ramount = amt > this.max ? this.max : amt
      this.emit()
    },
    decrease() {
      const amt = this.modelValue - this.step
      this.ramount = amt < this.min ? this.min : amt
      this.emit()
    },
    formatAmount,
    toggleInput() {
      this.showFormatted = !this.showFormatted
      if (this.modelValue < this.min) {
        this.ramount = this.min
        this.emit()
      }
    },
    emit() {
      this.$emit('update:modelValue', this.ramount)
    },
  },
  computed: {
    formattedAmount() {
      if (this.showFormatted) return this.formatAmount(Number(this.modelValue))
      return this.ramount
    },
  },
}
</script>

<style scoped>
.input-amount-container::before {
  content: 'S/';
  position: absolute;
  height: 100%;
  display: flex;
  align-items: center;
  left: 0.5em;
}
</style>