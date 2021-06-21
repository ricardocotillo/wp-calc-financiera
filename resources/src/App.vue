<template>
  <div>
    <Prestamo
      v-if="direction !== null && type == 'prestamo'"
      :direction="direction"
    />
    <Inversion
      v-else-if="direction !== null && type == 'inversion'"
      :direction="direction"
    />
    <div v-else class="flex justify-center items-center">
      <img :src="`${baseUrl}/img/loader.svg`" class="w-16" />
    </div>
  </div>
</template>

<script>
import Prestamo from './views/prestamo'
import Inversion from './views/inversion'
import { useState } from './store/store'
import { baseUrl } from './mixins/calcData'
export default {
  setup() {
    const state = useState()
    const dataset = document.querySelector('#app').dataset
    const settings = JSON.parse(dataset.settings)
    state.direction = settings.direccion === 'horizontal' ? 0 : 1
    state.type = settings.tipo ?? 'prestamo'
    state.tea = settings.cuotas_fijas_tea
    state.sitm = settings.solo_intereses_tasa
    state.pptm = settings.prestamo_puente_tasa
    state.prestamoTea = settings.prestamo_tea
    state.factoringTea = settings.factoring_tea
    state.primaryColor = settings.calc_financiera_primary_color
    state.secondaryColor = settings.calc_financiera_secondary_color
    state.colorOverPrimary = settings.calc_financiera_color_over_primary
    state.colorOverSecondary = settings.calc_financiera_color_over_secondary
    return { ...state, baseUrl }
  },
  components: { Prestamo, Inversion },
}
</script>