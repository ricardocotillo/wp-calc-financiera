<template>
  <Modal :isOpen="isOpen" @close="close">
    <template v-slot:header>
      <h3 class="font-bold text-2xl text-gray-900 text-center mb-2">
        Cronograma de pagos
      </h3>
      <p class="text-center text-xl mb-2">{{ type }}</p>
      <p class="text-center">Monto solicitado S/ {{ formatAmount(amount) }}</p>
    </template>
    <template v-slot:body>
      <table class="w-full text-blue-900 font-bold">
        <tbody>
          <tr v-for="i in (periods + 1) * 12" :key="i" class="text-lg">
            <td class="text-center py-1">Mes {{ i }}</td>
            <td class="text-center py-1">S/ {{ formatAmount(cuota, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </template>
    <template v-slot:footer>
      <div class="flex flex-col items-center">
        <button @click="$emit('solicitar')" class="btn mb-5">Solicita tu prestamo</button>
        <p class="text-md text-gray-500">
          Tasa Efectiva Annual (TEA) del 36% promedio, sujeto a calificación
          crediticia en el sistema financiero.
          <br />
          La cuota incluye amortización alcapital más el interés respectivo a la
          tasa efectiva anual pactada.
          <br />
          No te pediremos ningún pago adelantado ni pagos adicionales en el
          proceso
        </p>
      </div>
    </template>
  </Modal>
</template>

<script>
import Modal from "../layouts/modal";
import { formatAmount } from "../mixins/formatAmount";
export default {
  props: {
    isOpen: Boolean,
    amount: Number,
    cuota: Number,
    periods: Number,
    type: String,
  },
  methods: {
    close() {
      this.$emit("close");
    },
    formatAmount,
  },
  components: { Modal },
};
</script>

<style>
</style>