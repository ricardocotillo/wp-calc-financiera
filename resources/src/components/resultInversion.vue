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
    <Registrarme :isOpen="registrarme" @close="registrarme = false" />
  </div>
</template>

<script>
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