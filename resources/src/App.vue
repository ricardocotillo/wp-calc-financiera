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
    state.direction = settings.direccion
    state.type = settings.tipo ?? 'prestamo'
    state.primaryColor = settings.calc_financiera_primary_color
    state.secondaryColor = settings.calc_financiera_secondary_color
  },
  data() {
    return {
      type: null,
      direction: null,
      baseUrl,
    }
  },
  created() {
    // const dataset = document.querySelector('#app').dataset
    const settings = {direccion: null, tipo: null} //JSON.parse(dataset.settings)
    const direccion = settings.direccion
    this.type = settings.tipo ?? 'prestamo'
    this.direction =
      direccion === 'horizontal' ? 0 : direccion === 'vertical' ? 1 : 0
  },
  components: { Prestamo, Inversion },
}
</script>