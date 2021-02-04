<template>
  <div>
    <Prestamo v-if="direction !== null && type == 'prestamo'" :direction="direction" />
    <div v-else class="flex justify-center items-center">
      <img :src="`${baseUrl}/img/loader.svg`" class="w-16" />
    </div>
  </div>
</template>

<script>
import Prestamo from "./views/prestamo";
import { baseUrl } from "./mixins/calcData";
export default {
  data() {
    return {
      type: null,
      direction: null,
      baseUrl,
    };
  },
  created() {
    const dataset = document.querySelector("#app").dataset;
    const direccion = dataset.direccion;
    this.type = dataset.tipo;
    this.direction =
      direccion === "horizontal" ? 0 : direccion === "vertical" ? 1 : 0;
  },
  components: { Prestamo },
};
</script>
<style scoped>
</style>