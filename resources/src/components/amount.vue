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
          bg-blue-900
          w-7
          h-7
          text-white
          focus:outline-none
          cursor-pointer
          flex
          justify-center
          items-center
          font-bold
          select-none
          justify-self-start
        "
      >
        <div class="h-0.5 w-2 bg-white"></div>
      </div>
      <div
        class="
          mt-1
          relative
          inline-block
          rounded-md
          shadow-sm
          col-span-4
          w-full
        "
      >
        <div
          class="
            absolute
            inset-y-0
            left-0
            pl-5
            flex
            items-center
            pointer-events-none
          "
        >
          <span class="text-gray-500 sm:text-sm"> S/ </span>
        </div>
        <input
          @focus="toggleInput"
          @input="handleInput"
          @blur="toggleInput"
          :value="formattedAmount"
          type="text"
          class="
            border
            shadow-none
            border-gray-300
            focus:ring-1 focus:ring-blue-900
            :focus:ring-blue-900
            bg-white
            focus:outline-none
            focus:border-transparent
            block
            w-full
            py-2
            pl-7
            pr-7
            sm:text-sm
            rounded
            text-center
          "
        />
      </div>
      <div
        @click="increase"
        class="
          rounded-full
          bg-blue-900
          w-7
          h-7
          text-white
          focus:outline-none
          cursor-pointer
          flex
          justify-center
          items-center
          font-bold
        "
      >
        <div class="h-0.5 w-2 bg-white transform translate-x-2/4"></div>
        <div class="h-0.5 w-2 bg-white transform rotate-90 -translate-x-2/4"></div>
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
export default {
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

<style>
</style>