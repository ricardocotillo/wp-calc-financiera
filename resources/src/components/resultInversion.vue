<template>
  <div>
    <div class="text-center flex flex-col items-center">
      <div class="font-bold text-gray-600">En {{ label }} ganarías</div>
      <div class="text-2xl font-bold mb-1 mt-2">
        S/ {{ formatAmount(intereses, 2) }}
      </div>
      <div
        @click="registrarme = true"
        class="rounded-sm w-32 bg-yellow-400 px-3 py-2 cursor-pointer text-white font-bold text-sm my-3"
      >
        Regístrate
      </div>
    </div>
    <Registrarme
      :isOpen="registrarme"
      @close="registrarme = false"
      @submit="submit"
    />
    <Waiting
      :isOpen="showWaiting"
      :loading="loading"
      @close="showWaiting = false"
    />
  </div>
</template>

<script>
/*global wp_ajax*/
import { formatAmount } from "../mixins/formatAmount";
import Registrarme from "./registrarme";
import Waiting from "./waiting";
export default {
  props: {
    label: String,
    type: Number,
    period: Number,
    amount: Number,
  },
  data() {
    return {
      prestamoTea: 0.36,
      factoringTea: 0.39,
      registrarme: false,
      showWaiting: false,
      loading: false,
    };
  },
  methods: {
    formatAmount,
    submit(solicitud) {
      this.showWaiting = true;
      this.loading = true;
      this.registrarme = false;
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
      const tea = this.type === 1 ? this.prestamoTea : this.factoringTea;
      return Math.pow(1 + tea, 1 / 12) - 1;
    },
    rperiod() {
      return this.type === 1 ? this.period * 12 : this.period;
    },
    intereses() {
      return this.cuota * this.rperiod - this.amount;
    },
    cuota() {
      return (
        (this.tem * this.amount) /
        (1 - Math.pow(1 + this.tem, this.rperiod * -1))
      );
    },
  },
  created() {
    const app = document.querySelector("#app");
    this.prestamoTea = Number(app.dataset.prestamoTea);
    this.factoringTea = Number(app.dataset.factoringTea);
  },
  components: { Registrarme, Waiting },
};
</script>

<style>
</style>