<template>
  <div>
    <div class="text-center flex flex-col items-center">
      <div class="font-bold text-gray-600">En {{ label }} ganarías</div>
      <div class="text-2xl font-bold mb-1 mt-2">
        S/ {{ formatAmount(intereses, 2) }}
      </div>
      <div
        @click="registrarme = true"
        class="rounded-sm w-32 px-3 py-2 cursor-pointer font-bold text-sm my-3"
        :style="{ backgroundColor: secondaryColor, color: colorOverSecondary }"
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
import { ref, toRefs, computed } from 'vue'
import { formatAmount } from '../mixins/formatAmount'
import Registrarme from './registrarme'
import Waiting from './waiting'
import { useState } from '../store/store'
export default {
  props: {
    label: String,
    type: Number,
    period: Number,
    amount: Number,
  },
  setup(props) {
    const { type, period, amount } = toRefs(props)
    const state = useState()
    const registrarme = ref(false)
    const showWaiting = ref(false)
    const loading = ref(false)

    // computed
    const tem = computed(() => {
      const tea = type.value === 1 ? state.prestamoTea : state.factoringTea
      return Math.pow(1 + tea, 1 / 12) - 1
    })
    
    const rperiod = computed(() => type.value === 1 ? period.value * 12 : period.value)

    const cuota = computed(() => (
        (tem.value * amount.value) /
        (1 - Math.pow(1 + tem.value, rperiod.value * -1))
      ))

    const intereses = computed(() => cuota.value * rperiod.value - amount.value)

    // methds
    const submit = (solicitud) => {
      showWaiting.value = true
      loading.value = true
      registrarme.value = false
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

    return {formatAmount, registrarme, showWaiting, loading, submit, intereses, ...state }
  },
  components: { Registrarme, Waiting },
}
</script>

<style>
</style>