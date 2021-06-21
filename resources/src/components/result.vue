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
      <button
        @click="showSolicitar = true"
        class="block px-3 py-2 text-sm my-3"
        :style="{ backgroundColor: secondaryColor, color: colorOverSecondary }"
      >
        Precalifica aquí
      </button>
      <a href="#" @click.prevent="showPayTable = true">Ver cronograma</a>
    </div>
    <Cronograma
      @close="showPayTable = false"
      @solicitar="onSolicitar"
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
import Cronograma from './cronograma'
import FormModal from './formModal'
import Waiting from './waiting'
import { formatAmount } from '../mixins/formatAmount'
import { useState } from '../store/store'
import { ref, computed, toRefs } from 'vue'
export default {
  props: {
    amount: Number,
    type: Number,
    typeText: String,
    periods: Number,
  },
  setup(props) {
    const { amount, type, periods } = toRefs(props)
    const state = useState()

    const msg = 'Tus cuota se calculará al ingresar los datos anteriores'
    const loading = ref(true)
    const showWating = ref(false)
    const showForm = ref(false)
    const showSolicitar = ref(false)
    const showPayTable = ref(false)

    // computed
    const tem = computed(() => Math.pow(1 + state.tea, 1 / 12) - 1)
    const ramount = computed(() =>
      amount.value < 20000 ? 20000 : amount.value
    )
    const cuota = computed(() => {
      let c
      switch (type.value) {
        case 0:
          c =
            (tem.value * ramount.value) /
            (1 - Math.pow(1 + tem.value, (periods.value + 1) * 12 * -1))
          break
        case 1:
          c = ramount.value * state.sitm
          break
        default:
          c = ramount.value * state.pptm * (periods.value + 1)
          break
      }
      return c
    })

    // methods
    const submit = (solicitud) => {
      showWating.value = true
      loading.value = true
      showSolicitar.value = false
      const form = new FormData()
      Object.keys(solicitud).forEach((k) => form.append(k, solicitud[k]))
      form.append('action', 'calc_ajax_solicitud')
      fetch(wp_ajax.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Cache-Control': 'no-cache',
        },
        body: form,
      }).then(() => {
        loading.value = false
      })
    }
    const onSolicitar = () => {
      showPayTable = false
      showSolicitar = true
    }
    return {
      formatAmount,
      msg,
      loading,
      showWating,
      showForm,
      showSolicitar,
      showPayTable,
      cuota,
      submit,
      ...state,
    }
  },
  components: { Cronograma, FormModal, Waiting },
}
</script>

<style>
</style>