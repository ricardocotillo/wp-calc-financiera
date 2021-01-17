<template>
  <div>
    <Calculadora v-if="direction !== null" :direction="direction" />
    <div v-else class="flex justify-center items-center">
      <img :src="`${baseUrl}/img/loader.svg`" class="w-16" />
    </div>
  </div>
</template>

<script>
import Calculadora from "./components/calculadora.vue";
import { baseUrl } from "./mixins/calcData";
/*global wp_ajax*/
export default {
  data() {
    return {
      direction: null,
      baseUrl,
    };
  },
  created() {
    fetch(`${wp_ajax.ajax_url}?action=calc_ajax_option`)
      .then((res) => res.json())
      .then((data) => (this.direction = Number(data.direccion)));
  },
  components: { Calculadora },
};
</script>
<style scoped>
</style>