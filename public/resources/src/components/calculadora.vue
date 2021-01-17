<template>
  <div class="p-10">
    <div
      class="rounded shadow-lg grid grid-cols-1 gap-2"
      :class="direction === 0 ? 'lg:grid-cols-4 lg:gap-4 lg:grid-rows-2' : ''"
    >
      <div class="px-3 pt-4 pb-2">
        <Amount v-model="amount" />
      </div>
      <div class="px-3 pt-4 pb-2 flex justify-center items-start">
        <Dropdown
          v-model="selectedType"
          @input="changePeriod"
          :options="typeOfPayments"
        />
      </div>
      <div class="px-3 pt-4 pb-2 flex justify-center items-start">
        <Dropdown
          v-model="selectedPeriod"
          :options="selectedType === null ? [] : periods[selectedType]"
        />
      </div>
      <div
        class="px-3 pt-4 pb-2 bg-gray-200 flex justify-center items-center h-44"
        :class="
          direction === 0
            ? 'lg:h-auto lg:col-stat-4 lg:col-end-5 lg:row-start-1 lg:row-end-3'
            : ''
        "
      >
        <Result
          :amount="amount"
          :type="selectedType"
          :typeText="
            typeOfPayments[selectedType]
              ? typeOfPayments[selectedType].title
              : ''
          "
          :periods="selectedPeriod"
          @change:amount="amount = $event"
          @change:type="
            selectedType = $event;
            selectedPeriod = 0;
          "
          @change:period="selectedPeriod = $event"
        />
      </div>
      <div
        v-if="selectedPeriod !== null"
        class="px-3 pt-4 pb-2 flex justify-center items-center"
      >
        <p class="font-bold text-xs">Tasa de interés mensual desde 1.6%</p>
      </div>
      <div
        class="px-3 pt-4 pb-2 flex justify-center items-center"
        :class="
          direction === 0
            ? selectedPeriod === null
              ? 'lg:col-span-3'
              : 'lg:col-span-2'
            : ''
        "
      >
        <p class="text-gray-400 text-xs">
          <strong v-if="selectedType !== null"
            >{{ typeOfPayments[selectedType].title }}: </strong
          >{{ selectedType === null ? initialMsg : msgs[selectedType] }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from "./dropdown";
import Amount from "./amount";
import Result from "./result";
export default {
  props: {
    direction: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      initialMsg:
        "La simulación de la cuota y el cronograma puede variar según tu evaluación.",
      msgs: {
        0: "Las cuotas incluyen interés y amortización . La simulación de la cuota y el cronograma puede variar según tu evaluación.",
        1: "Las cuotas no incluyen amortización , reembolsas el capital a tu ritmo. La simulación de la cuota y el cronograma puede variar según tu evaluación.",
        2: "No hay cuotas mensuales, todo se paga al finalizar el plazo. La simulación de la cuota y el cronograma puede variar según tu evaluación.",
      },
      amount: 50000,
      selectedType: null,
      selectedPeriod: null,
      typeOfPayments: [
        { key: 1, title: "Cuotas fijas" },
        { key: 2, title: "Sólo intereses" },
        { key: 3, title: "Préstamo puente" },
      ],
      periods: {
        0: [
          { key: 1, title: "1 año" },
          { key: 2, title: "2 años" },
          { key: 3, title: "3 años" },
          { key: 4, title: "4 años" },
          { key: 5, title: "5 años" },
        ],
        1: [{ key: 1, title: "1 año" }],
        2: [{ key: 1, title: "1 año" }],
      },
    };
  },
  methods: {
    changePeriod() {
      this.selectedPeriod = 0;
    },
  },
  computed: {
    msg() {
      if (!this.selectedType) {
        return this.initialMsg;
      }
      return this.msgs[this.selectedType];
    },
  },
  components: { Dropdown, Amount, Result },
};
</script>
