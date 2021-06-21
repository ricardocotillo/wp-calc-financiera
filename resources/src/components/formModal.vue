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
              <Amount
                :modelValue="amount"
                @update:modelValue="$emit('change:amount', $event)"
              />
            </div>
            <div class="pt-2 pb-2">
              <div class="text-xs mb-3">Pagando con</div>
              <Dropdown
                :modelValue="type"
                @update:modelValue="$emit('change:type', $event)"
                :options="typeOfPayments"
              />
            </div>
            <div class="pt-2 pb-2">
              <div class="text-xs mb-3">En un plazo de</div>
              <Dropdown
                :modelValue="period"
                @update:modelValue="$emit('change:period', $event)"
                :options="type === null ? [] : periods[type]"
              />
            </div>
            <div class="pt-4 pb-2 text-center">
              <p class="text-gray-500">
                <template v-if="type == 2">Pago único de:</template>
                <template v-else>Tu cuota mensual sería:</template>
              </p>
              <h2 class="text-lg font-bold" :style="{ color: primaryColor }">
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
              <!-- <img class="w-5 mr-4" :src="`${baseUrl}/img/lock.svg`" /> -->
              <svg
                class="w-5 mr-4"
                viewBox="0 0 40 52"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M19.9993 39.0832C21.2812 39.0832 22.5106 38.5739 23.417 37.6675C24.3235 36.7611 24.8327 35.5317 24.8327 34.2498C24.8327 32.968 24.3235 31.7386 23.417 30.8322C22.5106 29.9257 21.2812 29.4165 19.9993 29.4165C18.7175 29.4165 17.4881 29.9257 16.5817 30.8322C15.6752 31.7386 15.166 32.968 15.166 34.2498C15.166 35.5317 15.6752 36.7611 16.5817 37.6675C17.4881 38.5739 18.7175 39.0832 19.9993 39.0832ZM34.4993 17.3332C35.7812 17.3332 37.0106 17.8424 37.917 18.7488C38.8235 19.6552 39.3327 20.8846 39.3327 22.1665V46.3332C39.3327 47.6151 38.8235 48.8444 37.917 49.7509C37.0106 50.6573 35.7812 51.1665 34.4993 51.1665H5.49935C4.21747 51.1665 2.98809 50.6573 2.08167 49.7509C1.17524 48.8444 0.666016 47.6151 0.666016 46.3332V22.1665C0.666016 20.8846 1.17524 19.6552 2.08167 18.7488C2.98809 17.8424 4.21747 17.3332 5.49935 17.3332H7.91602V12.4998C7.91602 9.29514 9.18908 6.2217 11.4551 3.95563C13.7212 1.68957 16.7946 0.416504 19.9993 0.416504C21.5862 0.416504 23.1574 0.729049 24.6234 1.33629C26.0895 1.94354 27.4215 2.83359 28.5436 3.95563C29.6656 5.07767 30.5556 6.40973 31.1629 7.87575C31.7701 9.34176 32.0827 10.913 32.0827 12.4998V17.3332H34.4993ZM19.9993 5.24984C18.0765 5.24984 16.2325 6.01367 14.8728 7.37331C13.5132 8.73295 12.7493 10.577 12.7493 12.4998V17.3332H27.2493V12.4998C27.2493 10.577 26.4855 8.73295 25.1259 7.37331C23.7662 6.01367 21.9222 5.24984 19.9993 5.24984Z"
                  :fill="primaryColor"
                />
              </svg>

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
            class="
              row-start-3 row-end-4
              lg:col-start-2 lg:col-end-4
              lg:row-start-1 lg:row-end-2
              ml-4
              mr-4
              lg:ml-32
              lg:mr-10
              mt-8
            "
          >
            <Form @submit="submit" @step="step = $event" />
          </div>
          <div
            class="
              row-start-2 row-end-3
              lg:col-start-2 lg:col-end-4
              lg:row-start-1 lg:row-end-2
              lg:-mr-px
              ml-0
              lg:ml-32
            "
            style="align-self: start"
          >
            <div
              class="h-3 w-1/2 inline-block bg-gray-100"
              :style="{ backgroundColor: step == 0 ? secondaryColor : null }"
            ></div>
            <div
              class="h-3 w-1/2 inline-block lg:rounded-tr-lg bg-gray-100"
              :style="{ backgroundColor: step == 1 ? secondaryColor : null }"
            ></div>
          </div>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script>
import Modal from '../layouts/modal'
import Amount from './amount'
import Dropdown from './dropdown'
import Form from './form'
import { baseUrl } from '../mixins/calcData'
import { formatAmount } from '../mixins/formatAmount'

import { initialMsg, msgs, typeOfPayments, periods } from '../mixins/calcData'
import { useState } from '../store/store'
export default {
  setup() {
    const state = useState()
    console.log(state)
    return { ...state }
  },
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
    }
  },
  methods: {
    formatAmount,
    submit(e) {
      this.$emit('submit', e)
      this.step = 0
    },
  },
  components: { Modal, Amount, Dropdown, Form },
}
</script>

<style>
</style>