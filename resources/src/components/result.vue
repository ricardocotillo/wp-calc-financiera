<template>
  <div class="text-xs">
    <p v-if="type === null || periods === null" class="text-center">
      <strong>{{ msg }}</strong>
    </p>
    <div v-else class="text-center">
      <p class="font-bold text-gray-600">Mi cuota mensual sería</p>
      <h1 class="text-2xl font-bold">S/ {{ formatAmount(cuota, 2) }}</h1>
      <a href="#" @click.prevent="showPayTable = true">Ver cronograma</a>
      <Cronograma
        @close="showPayTable = false"
        @solicitar="
          showPayTable = false;
          showSolicitar = true;
        "
        :isOpen="showPayTable"
        :type="typeText"
        :cuota="cuota"
        :amount="amount"
        :periods="periods"
      />
      <FormModal
        :isOpen="showSolicitar"
        :amount="amount"
        :type="type"
        :period="periods"
        :cuota="cuota"
        @close="showSolicitar = false"
        @change:amount="$emit('change:amount', $event)"
        @change:type="$emit('change:type', $event)"
        @change:period="$emit('change:period', $event)"
      />
      <FormModal :isOpen="showForm" />
    </div>
  </div>
</template>

<script>
import Cronograma from "./cronograma";
import FormModal from "./formModal";
import { formatAmount } from "../mixins/formatAmount";
export default {
  props: {
    amount: Number,
    type: Number,
    typeText: String,
    periods: Number,
  },
  data() {
    return {
      msg: "Tus cuota se calculará al ingresar los datos anteriores",
      showPayTable: false,
      showSolicitar: false,
      showForm: false,
      tea: 0.36,
    };
  },
  methods: {
    tem() {
      return Math.pow(1 + this.tea, 1 / 12) - 1;
    },
    formatAmount,
  },
  computed: {
    cuota() {
      return (
        (this.tem() * this.amount) /
        (1 - Math.pow(1 + this.tem(), (this.periods + 1) * 12 * -1))
      );
    },
  },
  components: { Cronograma, FormModal},
};
</script>

<style>
</style>