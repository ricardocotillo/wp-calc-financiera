<template>
  <div>
    <Modal :isOpen="isOpen" @close="$emit('close')" padding="px-0 pt-0">
      <template v-slot:body>
        <div
          class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7 max-w-screen-lg"
        >
          <div class="lg:ml-10 lg:mr-0 ml-4 mr-4 mt-8">
            <div>
              <div class="text-xs">Quiero</div>
              <Amount :value="amount" @input="$emit('change:amount', $event)" />
            </div>
            <div class="pt-2 pb-2">
              <div class="text-xs mb-3">Pagando con</div>
              <Dropdown
                :value="type"
                @input="$emit('change:type', $event)"
                :options="typeOfPayments"
              />
            </div>
            <div class="pt-2 pb-2">
              <div class="text-xs mb-3">En un plazo de</div>
              <Dropdown
                :value="period"
                @input="$emit('change:period', $event)"
                :options="type === null ? [] : periods[type]"
              />
            </div>
            <div class="pt-4 pb-2 text-center">
              <p class="text-gray-500">
                <template v-if="type == 2">Pago único de:</template>
                <template v-else>Tu cuota mensual sería:</template>
              </p>
              <h2 class="text-blue-900 text-lg font-bold">
                S/
                {{
                  type == 2
                    ? formatAmount(cuota * (period + 1) * 12 + amount, 2)
                    : formatAmount(cuota, 2)
                }}
              </h2>
              <p class="text-gray-500 p-2 bg-blue-200 mt-2 rounded">
                Tasa de interés mensual desde 1.6%
              </p>
              <p class="text-gray-500 text-xs mt-3">
                La simulación de la cuota y el cronograma puede variar según tu
                perfil crediticio y otros factores.
              </p>
            </div>
            <div class="flex items-center mb-5 mt-7">
              <img class="w-5 mr-4" :src="`${baseUrl}/img/lock.svg`" />
              <div class="font-bold text-gray-700 text-sm">
                ¿Es seguro dar mis datos a Grupo Imagen?
              </div>
            </div>
            <div class="text-xs mb-12">
              Sí. Grupo Imagen es una empresa registrada en la Superintendencia
              de Banca y Seguros (SBS – Resolución Nº00046-2020), y se rige por
              la Ley de Protección de Datos Personales.
            </div>
          </div>
          <div
            class="row-start-3 row-end-4 lg:col-start-2 lg:col-end-4 lg:row-start-1 lg:row-end-2 ml-4 mr-4 lg:ml-32 lg:mr-10 mt-8"
          >
            <Form @submit="submit" @step="step = $event" />
          </div>
          <div
            class="row-start-2 row-end-3 lg:col-start-2 lg:col-end-4 lg:row-start-1 lg:row-end-2 lg:-mr-px ml-0 lg:ml-32"
            style="align-self: start"
          >
            <div
              class="h-3 w-1/2 inline-block"
              :class="step == 0 ? 'bg-green-500' : 'bg-gray-100'"
            ></div>
            <div
              class="h-3 w-1/2 inline-block lg:rounded-tr-lg"
              :class="step == 1 ? 'bg-green-500' : 'bg-gray-100'"
            ></div>
          </div>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script>
import Modal from "../layouts/modal";
import Amount from "./amount";
import Dropdown from "./dropdown";
import Form from "./form";
import { baseUrl } from "../mixins/calcData";
import { formatAmount } from "../mixins/formatAmount";

import { initialMsg, msgs, typeOfPayments, periods } from "../mixins/calcData";
export default {
  props: {
    amount: {
      type: Number,
      default: 50000,
    },
    type: {
      type: Number,
      default: 0,
    },
    period: {
      type: Number,
      default: 0,
    },
    cuota: Number,
    isOpen: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      step: 0,
      baseUrl,
      initialMsg,
      msgs,
      typeOfPayments,
      periods,
    };
  },
  methods: {
    formatAmount,
    submit(e) {
      this.$emit("submit", e);
      this.step = 0;
    },
  },
  components: { Modal, Amount, Dropdown, Form },
};
</script>

<style>
</style>