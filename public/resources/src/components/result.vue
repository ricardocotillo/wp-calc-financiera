<template>
  <div class="text-xs">
    <p v-if="type === null || periods === null" class="text-center">
      <strong>{{ msg }}</strong>
    </p>
    <div v-else class="text-center">
      <p class="font-bold text-gray-600">Mi cuota mensual sería</p>
      <h1 class="text-2xl font-bold">
        S/
        {{
          type == 2
            ? formatAmount(cuota * (periods + 1) * 12 + amount, 2)
            : formatAmount(cuota, 2)
        }}
      </h1>
      <a href="#" @click.prevent="showPayTable = true">Ver cronograma</a>
    </div>
    <Cronograma
      @close="showPayTable = false"
      @solicitar="
        showPayTable = false;
        showSolicitar = true;
      "
      :isOpen="showPayTable"
      :typeText="typeText"
      :type="type"
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
      @submit="submit"
    />
    <Waiting :isOpen="loading" />
  </div>
</template>

<script>
/*global wp_ajax*/
import Cronograma from "./cronograma";
import FormModal from "./formModal";
import Waiting from "./waiting";
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
      loading: false,
    };
  },
  methods: {
    tem() {
      let t;
      switch (this.type) {
        case 0:
          t = Math.pow(1 + this.tea, 1 / 12) - 1;
          break;
        case 1:
          t = 0.025;
          break;
        default:
          t = 0.032;
          break;
      }
      return t;
    },
    formatAmount,
    submit(solicitud) {
      this.loading = true;
      this.showSolicitar = false;
      const form = new FormData();
      Object.keys(solicitud).forEach((k) => form.append(k, solicitud[k]));
      form.append("action", "calc_ajax_solicitud");
      fetch(wp_ajax.ajax_url, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Cache-Control": "no-cache",
        },
        body: form,
      }).then((res) => {
        setTimeout(() => (this.loading = false), 3000);
      });
    },
  },
  computed: {
    cuota() {
      let c;
      switch (this.type) {
        case 0:
          c =
            (this.tem() * this.amount) /
            (1 - Math.pow(1 + this.tem(), (this.periods + 1) * 12 * -1));
          break;
        case 1:
          c = this.amount * this.tem();
          break;
        default:
          c = this.amount * this.tem() * (this.periods + 1);
          break;
      }
      return c;
    },
  },
  components: { Cronograma, FormModal, Waiting },
};
</script>

<style>
</style>