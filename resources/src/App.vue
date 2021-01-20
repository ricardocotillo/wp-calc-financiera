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
export default {
  data() {
    return {
      direction: null,
      baseUrl,
    };
  },
  created() {
    const direccion = document.querySelector("#app").dataset.direccion;
    this.direction =
      direccion === "horizontal" ? 0 : direccion === "vertical" ? 1 : 0;
  },
  components: { Calculadora },
};
</script>
<style scoped>
</style>