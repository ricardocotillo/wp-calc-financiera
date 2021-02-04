<template>
  <div>
    <div class="text-center">
      <div class="font-bold text-gray-600">En {{ label }} ganarías</div>
      <div class="text-2xl font-bold mb-1 mt-2">
        S/ {{ formatAmount(intereses, 2) }}
      </div>
      <div
        @click="registrarme = true"
        class="rounded-sm bg-yellow-400 px-3 py-2 cursor-pointer text-white font-bold text-sm my-3"
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
      :isOpen="showWating"
      :loading="loading"
      @close="showWating = false"
    />
  </div>
</template>

<script>
/*global wp_ajax*/
import { formatAmount } from "../mixins/formatAmount";
import Registrarme from "./registrarme";
export default {
  props: {
    label: String,
    type: Number,
    period: Number,
    amount: Number,
  },
  data() {
    return {
      tea: 0.36,
      registrarme: false,
      showWaiting: false,
      loading: false,
    };
  },
  methods: {
    formatAmount,
  },
  computed: {
    tem() {
      return Math.pow(1 + this.tea, 1 / 12) - 1;
    },
    ramount() {
      return this.amount < 20000 ? 20000 : this.amount;
    },
    intereses() {
      return this.cuota * this.period * 12 - this.ramount;
    },
    cuota() {
      return (
        (this.tem * this.ramount) /
        (1 - Math.pow(1 + this.tem, this.period * 12 * -1))
      );
    },
    submit(solicitud) {
      this.showWating = true;
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
  created() {
    const app = document.querySelector("#app");
    this.tea = Number(app.dataset.tea);
  },
  components: { Registrarme },
};
</script>

<style>
</style>