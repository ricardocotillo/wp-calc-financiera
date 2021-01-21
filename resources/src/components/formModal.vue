<template>
  <div>
    <Modal :isOpen="isOpen" @close="$emit('close')" @>
      <template v-slot:body>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
          <div>
            <div class="pt-4 pb-2 px-3">
              <Amount :value="amount" @input="$emit('change:amount', $event)" />
            </div>
            <div class="px-3 pt-4 pb-2 flex justify-center items-start">
              <Dropdown
                :value="type"
                @input="$emit('change:type', $event)"
                :options="typeOfPayments"
              />
            </div>
            <div class="px-3 pt-4 pb-2 flex justify-center items-start">
              <Dropdown
                :value="period"
                @input="$emit('change:period', $event)"
                :options="type === null ? [] : periods[type]"
              />
            </div>
            <div class="pt-4 pb-2 text-center">
              <p class="text-gray-500">Tu cuota mensual sería:</p>
              <h2 class="text-blue-900 text-lg font-bold">
                S/
                {{
                  type == 2
                    ? formatAmount(cuota * (period + 1) * 12 + amount, 2)
                    : formatAmount(cuota, 2)
                }}
              </h2>
              <p class="text-gray-500 p-2 bg-blue-200 mt-2">
                Tasa de interés mensual desde 1.6%
              </p>
              <p class="text-gray-500 text-xs mt-3">
                La simulación de la cuota y el cronograma puede variar según tu
                perfil crediticio y otros factores.
              </p>
            </div>
          </div>
          <div>
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