<template>
  <Modal :isOpen="isOpen" :showClose="false">
    <template v-slot:header>
      <div class="flex flex-col items-center text-center">
        <img :src="`${baseUrl}/img/loader.svg`" class="w-10 mb-3" />
      </div>
    </template>
    <template v-slot:body>
      <h1 class="text-lg text-blue-900 font-bold text-center max-w-md">
        Estamos procesando tu solicitud
      </h1>
      <p class="text-center max-w-md">
        Excelente, en las próximas horas un asesor especializado se comunicará
        contigo para brindarte todos los detalles de tu solicitud.
      </p>
      <p class="text-center max-w-md">No cierres la ventana.</p>
    </template>
  </Modal>
</template>

<script>
import Modal from "../layouts/modal";
import { baseUrl } from "../mixins/calcData";
export default {
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      baseUrl,
    };
  },
  components: { Modal },
};
</script>

<style>
</style>