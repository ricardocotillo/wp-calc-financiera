<template>
  <div>
    <Calculadora v-if="direction !== null" :direction="direction" />
    <div v-else class="flex justify-center items-center">
      <img :src="`${baseUrl}/img/loader.svg`" class="w-16" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Calculadora from "./components/calculadora.vue";
import { baseUrl } from "./mixins/calcData";

export default defineComponent({
  data() {
    return {
      direction: 0,
      baseUrl,
    };
  },
  created() {
    const direccion = (document.querySelector("#app") as HTMLElement).dataset.direccion;
    this.direction =
      direccion === "horizontal" ? 0 : direccion === "vertical" ? 1 : 0;
  },
  components: {
   Calculadora
  }
});
</script>