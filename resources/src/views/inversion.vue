<template>
  <div class="p-10">
    <div
      class="rounded shadow-lg bg-white grid grid-cols-1 gap-2"
      :class="direction === 0 ? 'lg:grid-cols-4 lg:gap-4 lg:grid-rows-2' : ''"
    >
      <div class="px-3 pt-3 pb-2">
        <Checkboxes
          v-model="type"
          label="Tipo de inversión"
          @update:modelValue="period = 0"
        />
      </div>
      <div class="px-3 pt-3 pb-2">
        <Amount
          v-model="amount"
          label="Monto a invertir"
          :min="500"
          :max="100000"
          :step="10000"
        />
      </div>
      <div class="px-3 pt-3 pb-2 flex justify-center items-start">
        <Dropdown
          label="Pagando con"
          v-model="period"
          :options="periods[type]"
        />
      </div>
      <div
        class="px-3 pt-4 pb-2"
        :class="direction === 0 ? 'lg:col-start-1 lg:col-end-4' : ''"
      >
        <div class="text-xs text-gray-800">
          Rentabilidad anual promedio: {{ type === 1 ? "19.67%" : "17.66%"
          }}<br />
          La inversión conlleva un riesgo que el inversionista asume.
        </div>
      </div>
      <div
        class="px-3 pt-4 pb-2 bg-gray-100 flex justify-center items-center h-44"
        :class="
          direction === 0
            ? 'lg:h-auto lg:col-start-4 lg:col-end-5 lg:row-start-1 lg:row-end-3'
            : ''
        "
      >
        <ResultInversion
          :label="periods[type][period].title"
          :type="type"
          :period="periods[type][period].key"
          :amount="amount"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Checkboxes from "../components/checkboxes";
import Amount from "../components/amount";
import Dropdown from "../components/dropdown";
import ResultInversion from "../components/resultInversion";
export default {
  props: {
    direction: Number,
  },
  data() {
    return {
      type: 1,
      amount: 20000,
      period: 0,
      periods: {
        1: [
          { key: 1, title: "1 año" },
          { key: 2, title: "2 años" },
          { key: 3, title: "3 años" },
          { key: 4, title: "4 años" },
          { key: 5, title: "5 años" },
        ],
        2: [
          { key: 3, title: "3 meses" },
          { key: 6, title: "6 meses" },
          { key: 9, title: "9 meses" },
          { key: 12, title: "12 meses" },
        ],
      },
    };
  },
  components: { Checkboxes, Amount, Dropdown, ResultInversion },
};
</script>

<style>
</style>