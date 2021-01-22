<template>
  <Modal :isOpen="isOpen" @close="close" mw="max-w-lg">
    <template v-slot:header>
      <div class="max-w-sm">
        <h3
          class="font-black text-5xl text-gray-900 text-center mb-2 font-montserrat"
        >
          Cronograma de pagos
        </h3>
        <p class="text-center text-xl mb-2">{{ typeText }}</p>
        <p class="text-center">
          Monto solicitado S/ {{ formatAmount(amount) }}
        </p>
      </div>
    </template>
    <template v-slot:body>
      <div class="flex justify-center">
        <table
          class="text-gray-500 border-none"
          :class="type == 2 ? 'md:w-full w-full' : 'md:w-1/2 w-3/5'"
        >
          <thead v-if="type == 2">
            <tr>
              <th class="w-3/12 border-none"></th>
              <th class="text-center w-5/12 border-none">Intereses generados</th>
              <th class="text-center w-4/12 border-none">Cuota</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="i in (periods + 1) * 12" :key="i" class="text-base">
              <td
                class="text-center py-1 border-none"
                :class="type == 2 ? 'w-1/3' : 'w-2/5'"
              >
                Mes {{ i }}
              </td>
              <td
                class="py-1 border-none text-center"
                :class="type == 2 ? 'w-1/3' : 'w-3/5'"
              >
                S/
                {{
                  type == 1 && i == 12
                    ? formatAmount(cuota + amount, 2)
                    : formatAmount(cuota, 2)
                }}
              </td>
              <td class="border-none text-center py-1 w-1/3" v-if="type == 2">
                S/ 0
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
    <template v-slot:footer>
      <div class="flex flex-col items-center max-w-sm mb-10">
        <template v-if="type == 2">
          <div class="text-sm">
            Total mes 12: S/
            <strong>{{
              formatAmount(cuota * (periods + 1) * 12 + amount, 2)
            }}</strong>
          </div>
          <div class="text-sm mb-2">
            <strong>(Intereses acumulados + capital)</strong>
          </div>
        </template>
        <div
          @click="$emit('solicitar')"
          class="rounded bg-blue-900 text-white font-bold px-4 py-3 mb-5 w-3/4 text-center cursor-pointer"
        >
          SOLICITA TU PRÉSTAMO
        </div>
        <p class="text-md text-gray-500 text-center px-7">
          <template v-if="type == 0">
            Tasa Efectiva Annual (TEA) del 36% promedio, sujeto a calificación
            crediticia en el sistema financiero.
            <br /><br />
            La cuota incluye amortización alcapital más el interés respectivo a
            la tasa efectiva anual pactada.
            <br /><br />
            No te pediremos ningún pago adelantado ni pagos adicionales en el
            proceso
          </template>
          <template v-else-if="type == 1">
            <strong
              >Puedes amortizar libremente a partir de la cuota N°4 del préstamo
              y así disminuir tu cuota mensual.</strong
            >
            <br /><br />
            En el último mes puedes rembolsar el capital o solicitar la
            renovación del contrato.<br /><br />
            Tasa Efectiva Anual (TEA) del 31.20% sujeto a evaluación crediticia
            en el sistema financiero.<br /><br />
            La cuota mensual incluye solo los intereses a la tasa efectiva anual
            pactada.<br /><br />
            No te pediremos ningún pago adelantado ni pagos adicionales en el
            proceso.
          </template>
          <template v-else>
            Puedes cancelar el préstamo a partir de la cuota N°6, pagando el
            capital solicitado más los intereses generados hasta la fecha de
            pago indicada en el cronograma.<br /><br />
            En el último mes puedes reembolsar el capital o solicitar la
            renovación del contrato.<br /><br />
            Tasa Efectiva Anual (TEA) del 38.4% sujeto a evaluación crediticia
            en el sistema financiero.<br /><br />
            No te pediremos ningún pago adelantado ni pagos adicionales en el
            proceso.
          </template>
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
    typeText: String,
    type: Number,
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