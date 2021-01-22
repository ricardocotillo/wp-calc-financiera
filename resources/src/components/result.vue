<template>
  <div class="text-xs">
    <div
      v-if="type === null || periods === null"
      class="text-center font-bold text-gray-500"
    >
      {{ msg }}
    </div>
    <div v-else class="text-center">
      <div class="font-bold text-gray-600">Mi cuota mensual sería</div>
      <div class="text-2xl font-bold mb-1 mt-2">
        S/
        {{
          type == 2
            ? formatAmount(cuota * (periods + 1) * 12 + amount, 2)
            : formatAmount(cuota, 2)
        }}
      </div>
      <div
        @click="showSolicitar = true"
        class="rounded-sm bg-yellow-400 px-3 py-2 cursor-pointer text-white font-bold text-sm my-3"
      >
        Precalifica aquí
      </div>
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
    <Waiting
      :isOpen="showWating"
      :loading="loading"
      @close="showWating = false"
    />
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
      showWating: false,
      tea: 0.36,
      sitm: 0.025,
      pptm: 0.032,
      loading: true,
    };
  },
  methods: {
    formatAmount,
    submit(solicitud) {
      this.showWating = true;
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
      }).then(() => {
        this.loading = false;
      });
    },
  },
  computed: {
    tem() {
      return Math.pow(1 + this.tea, 1 / 12) - 1;
    },
    ramount() {
      return this.amount < 20000 ? 20000 : this.amount;
    },
    cuota() {
      let c;
      switch (this.type) {
        case 0:
          c =
            (this.tem * this.ramount) /
            (1 - Math.pow(1 + this.tem, (this.periods + 1) * 12 * -1));
          break;
        case 1:
          c = this.ramount * this.sitm;
          break;
        default:
          c = this.ramount * this.pptm * (this.periods + 1);
          break;
      }
      return c;
    },
  },
  created() {
    const app = document.querySelector("#app");
    this.tea = Number(app.dataset.tea);
    this.sitm = Number(app.dataset.sitm);
    this.pptm = Number(app.dataset.pptm);
  },
  components: { Cronograma, FormModal, Waiting },
};
</script>

<style>
</style>