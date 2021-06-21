<template>
  <Modal :isOpen="isOpen" @close="close">
    <template v-slot:header>
      <div
        class="
          max-w-sm
          font-black
          text-xl
          lg:text-2xl
          mb-2
          font-montserrat
          text-center
        "
        :style="{ color: primaryColor }"
      >
        Regístrate para acceder a las opciones de inversión
      </div>
      <div
        class="h-2 mb-4 w-full"
        :style="{ backgroundColor: secondaryColor }"
      ></div>
    </template>
    <template v-slot:body>
      <div class="text-center text-lg mb-4">Datos personales</div>
      <div class="text-base">DNI *</div>
      <input
        required
        type="text"
        name="dni"
        class="w-full py-2 px-3 sm:text-sm rounded my-1"
        v-model="v$.dni.$model"
        @keypress="isNumber"
      />
      <small v-if="v$.dni.$error || incomplete" class="text-red-500 block">{{
        !v$.dni.required
          ? 'Este campo es requerido'
          : !v$.dni.minLength
          ? 'Mínimo 8 dígitos'
          : !v$.dni.maxLength
          ? 'Máximo 8 dígitos'
          : ''
      }}</small>

      <div class="text-base">Nombres *</div>
      <input
        required
        type="text"
        name="nombre"
        class="w-full block py-2 px-3 sm:text-sm rounded my-1"
        v-model="v$.nombre.$model"
      />
      <small v-if="v$.nombre.$error || incomplete" class="text-red-500 block">{{
        !v$.nombre.required
          ? 'Este campo es requerido'
          : !v$.nombre.minLength
          ? 'Mínimo 2 caracteres'
          : ''
      }}</small>
      <div class="text-base">Apellidos *</div>
      <input
        required
        type="text"
        name="apellido"
        class="w-full block py-2 px-3 sm:text-sm rounded my-1"
        v-model="v$.apellido.$model"
      />
      <small
        v-if="v$.apellido.$error || incomplete"
        class="text-red-500 block"
        >{{
          !v$.apellido.required
            ? 'Este campo es requerido'
            : !v$.apellido.minLength
            ? 'Mínimo 2 caracteres'
            : ''
        }}</small
      >
      <div class="text-center text-lg my-4">Datos de contacto</div>
      <div class="text-base">Teléfono de contacto *</div>
      <small class="text-xs block"
        >Te llamaremos para continuar con el proceso de solicitud</small
      >
      <input
        required
        type="tel"
        name="telefono1"
        class="w-full block py-2 px-3 sm:text-sm rounded my-1"
        v-model="v$.phone1.$model"
        @keypress="isNumber"
      />
      <small v-if="v$.phone1.$error || incomplete" class="text-red-500 block">{{
        !v$.phone1.required
          ? 'Este campo es requerido'
          : !v$.phone1.minLength
          ? 'Mínimo 7 dígitos'
          : ''
      }}</small>
      <div class="text-base">Otro teléfono de contacto</div>
      <input
        type="tel"
        name="telefono2"
        class="w-full block py-2 px-3 sm:text-sm rounded my-1"
        v-model.number="phone2"
        placeholder="(Opcional)"
        @keypress="isNumber"
      />
      <small v-if="v$.phone2.$error || incomplete" class="text-red-500 block">{{
        !v$.phone2.minLength ? 'Mínimo 7 dígitos' : ''
      }}</small>
      <div class="text-base">Correo electrónico *</div>
      <small class="text-xs block">Coloca un correo electrónico vigente</small>
      <input
        required
        type="email"
        name="email"
        class="w-full block py-2 px-3 sm:text-sm rounded my-1"
        v-model="email"
      />
      <small v-if="v$.email.$error || incomplete" class="text-red-500 block">{{
        !v$.email.required
          ? 'Este campo es requerido'
          : !v$.email.email
          ? 'El correo no es válido'
          : ''
      }}</small>
      <div class="flex justify-center mt-7">
        <button
          class="rounded font-bold px-4 py-2"
          :style="{ backgroundColor: primaryColor, color: colorOverPrimary }"
          @click="validate"
        >
          Registrarme
        </button>
      </div>
    </template>
    <template v-slot:footer>
      <div class="max-w-sm px-5">
        <div class="flex items-center mb-5 mt-7">
          <svg
            class="w-5 mr-4"
            viewBox="0 0 40 52"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M19.9993 39.0832C21.2812 39.0832 22.5106 38.5739 23.417 37.6675C24.3235 36.7611 24.8327 35.5317 24.8327 34.2498C24.8327 32.968 24.3235 31.7386 23.417 30.8322C22.5106 29.9257 21.2812 29.4165 19.9993 29.4165C18.7175 29.4165 17.4881 29.9257 16.5817 30.8322C15.6752 31.7386 15.166 32.968 15.166 34.2498C15.166 35.5317 15.6752 36.7611 16.5817 37.6675C17.4881 38.5739 18.7175 39.0832 19.9993 39.0832ZM34.4993 17.3332C35.7812 17.3332 37.0106 17.8424 37.917 18.7488C38.8235 19.6552 39.3327 20.8846 39.3327 22.1665V46.3332C39.3327 47.6151 38.8235 48.8444 37.917 49.7509C37.0106 50.6573 35.7812 51.1665 34.4993 51.1665H5.49935C4.21747 51.1665 2.98809 50.6573 2.08167 49.7509C1.17524 48.8444 0.666016 47.6151 0.666016 46.3332V22.1665C0.666016 20.8846 1.17524 19.6552 2.08167 18.7488C2.98809 17.8424 4.21747 17.3332 5.49935 17.3332H7.91602V12.4998C7.91602 9.29514 9.18908 6.2217 11.4551 3.95563C13.7212 1.68957 16.7946 0.416504 19.9993 0.416504C21.5862 0.416504 23.1574 0.729049 24.6234 1.33629C26.0895 1.94354 27.4215 2.83359 28.5436 3.95563C29.6656 5.07767 30.5556 6.40973 31.1629 7.87575C31.7701 9.34176 32.0827 10.913 32.0827 12.4998V17.3332H34.4993ZM19.9993 5.24984C18.0765 5.24984 16.2325 6.01367 14.8728 7.37331C13.5132 8.73295 12.7493 10.577 12.7493 12.4998V17.3332H27.2493V12.4998C27.2493 10.577 26.4855 8.73295 25.1259 7.37331C23.7662 6.01367 21.9222 5.24984 19.9993 5.24984Z"
              :fill="primaryColor"
            />
          </svg>

          <div class="font-bold text-gray-700 text-sm">
            ¿Es seguro dar mis datos a Grupo Imagen?
          </div>
        </div>
        <div class="text-xs mb-12">
          Sí. Grupo Imagen es una empresa registrada en la Superintendencia de
          Banca y Seguros (SBS – Resolución Nº00046-2020), y se rige por la Ley
          de Protección de Datos Personales.
        </div>
      </div>
    </template>
  </Modal>
</template>

<script>
import Modal from '../layouts/modal'
import { isNumber } from '../mixins/isNumer'
import { baseUrl } from '../mixins/calcData'
import useVuelidate from '@vuelidate/core'
import {
  required,
  numeric,
  maxLength,
  minLength,
  email,
} from '@vuelidate/validators'
import { reactive, ref, toRefs } from 'vue'
import { useState } from '../store/store'
export default {
  props: {
    isOpen: Boolean,
  },
  setup(_, { emit }) {
    const globalState = useState()
    const incomplete = ref(false)
    const state = reactive({
      dni: '',
      nombre: '',
      apellido: '',
      phone1: '',
      phone2: '',
      email: '',
    })

    const rules = {
      dni: {
        required,
        numeric,
        maxLength: maxLength(8),
        minLength: minLength(8),
      },
      nombre: { required, minLength: minLength(2) },
      apellido: { required, minLength: minLength(2) },
      phone1: { required, numeric, minLength: minLength(7) },
      phone2: { numeric, minLength: minLength(7) },
      email: { required, email },
    }

    const v$ = useVuelidate(rules, state)

    // methods
    const close = () => {
      emit('close')
    }
    const send = () => {
      const solicitud = {
        tipo_de_solicitud: 'inversion',
        nombres: state.nombre,
        apellidos: state.apellido,
        dni: state.dni,
        telefono1: state.phone1,
        telefono2: state.phone2,
        email: state.email,
      }
      emit('submit', solicitud)
    }

    const validate = () => {
      if (v$.value.$invalid) {
        incomplete.value = true
      } else {
        incomplete.value = false
        send()
      }
    }

    return {
      v$,
      close,
      send,
      validate,
      isNumber,
      baseUrl,
      incomplete,
      ...toRefs(state),
      ...globalState,
    }
  },
  components: { Modal },
}
</script>

<style>
</style>