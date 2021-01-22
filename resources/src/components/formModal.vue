<template>
  <div>
    <Modal :isOpen="isOpen" @close="$emit('close')" @>
      <template v-slot:body>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 max-w-screen-lg">
          <div>
            <div class="pt-4">
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
            <div class="text-xs mb-4">
              Sí. Grupo Imagen es una empresa registrada en la Superintendencia
              de Banca y Seguros (SBS – Resolución Nº00046-2020), y se rige por
              la Ley de Protección de Datos Personales.
            </div>
          </div>
          <div class="col-span-2 md:pl-32 md:pr-28">
            <Form @submit="$emit('submit', $event)" />
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
      baseUrl,
      initialMsg,
      msgs,
      typeOfPayments,
      periods,
    };
  },
  methods: {
    formatAmount,
  },
  components: { Modal, Amount, Dropdown, Form },
};
</script>

<style>
</style>