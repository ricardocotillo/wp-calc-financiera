<template>
  <Modal :isOpen="isOpen" :showClose="!loading" @close="$emit('close')">
    <template v-slot:header>
      <div class="flex flex-col items-center text-center">
        <img
          v-if="loading"
          :src="`${baseUrl}/img/loader.svg`"
          class="w-10 mb-3"
        />
        <!-- <img v-else :src="`${baseUrl}/img/check.svg`" class="w-10 mb-3" /> -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-10 mb-3"
          :fill="primaryColor"
          viewBox="0 0 24 24"
        >
          <path
            d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"
          />
        </svg>
      </div>
    </template>
    <template v-slot:body>
      <template v-if="loading">
        <h1 class="text-lg font-bold text-center max-w-md">
          Estamos procesando tu solicitud
        </h1>
        <p class="text-center max-w-md">
          No cierras la ventana.<br />
          ¡En cuestión de segundos sabrás si pre calificas!<br />
          No cierres la ventana.
        </p>
      </template>
      <h1 v-else class="text-lg text-blue-900 font-bold text-center max-w-md">
        !Excelente!
      </h1>
      <p class="text-center max-w-md">
        En las próximas horas un asesor especializado se comunicará contigo para
        brindarte todos los detalles de tu solicitud.
      </p>
    </template>
  </Modal>
</template>

<script>
import Modal from '../layouts/modal'
import { baseUrl } from '../mixins/calcData'
export default {
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      baseUrl,
    }
  },
  components: { Modal },
}
</script>

<style>
</style>