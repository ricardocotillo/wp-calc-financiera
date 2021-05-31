<template>
  <Modal :isOpen="isOpen" @close="close">
    <template v-slot:header>
      <div
        class="max-w-sm font-black text-xl lg:text-2xl text-blue-900 mb-2 font-montserrat text-center"
      >
        Regístrate para acceder a las opciones de inversión
      </div>
      <div class="h-2 mb-4 w-full bg-yellow-400"></div>
    </template>
    <template v-slot:body>
      <div class="text-center text-lg mb-4">Datos personales</div>
      <div class="text-base">DNI *</div>
      <input
        required
        type="text"
        name="dni"
        class="w-full border border-gray-300 focus:border-blue-900 focus:outline-none focus:ring-0 py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.dni.$model"
        @keypress="isNumber"
      />
      <small v-if="$v.dni.$error || incomplete" class="text-red-500 block">{{
        !$v.dni.required
          ? "Este campo es requerido"
          : !$v.dni.minLength
          ? "Mínimo 8 dígitos"
          : !$v.dni.maxLength
          ? "Máximo 8 dígitos"
          : ""
      }}</small>

      <div class="text-base">Nombres *</div>
      <input
        required
        type="text"
        name="nombre"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.nombre.$model"
      />
      <small v-if="$v.nombre.$error || incomplete" class="text-red-500 block">{{
        !$v.nombre.required
          ? "Este campo es requerido"
          : !$v.nombre.minLength
          ? "Mínimo 2 caracteres"
          : ""
      }}</small>
      <div class="text-base">Apellidos *</div>
      <input
        required
        type="text"
        name="apellido"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.apellido.$model"
      />
      <small
        v-if="$v.apellido.$error || incomplete"
        class="text-red-500 block"
        >{{
          !$v.apellido.required
            ? "Este campo es requerido"
            : !$v.apellido.minLength
            ? "Mínimo 2 caracteres"
            : ""
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
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.phone1.$model"
        @keypress="isNumber"
      />
      <small v-if="$v.phone1.$error || incomplete" class="text-red-500 block">{{
        !$v.phone1.required
          ? "Este campo es requerido"
          : !$v.phone1.minLength
          ? "Mínimo 7 dígitos"
          : ""
      }}</small>
      <div class="text-base">Otro teléfono de contacto</div>
      <input
        type="tel"
        name="telefono2"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model.number="phone2"
        placeholder="(Opcional)"
        @keypress="isNumber"
      />
      <small v-if="$v.phone2.$error || incomplete" class="text-red-500 block">{{
        !$v.phone2.minLength ? "Mínimo 7 dígitos" : ""
      }}</small>
      <div class="text-base">Correo electrónico *</div>
      <small class="text-xs block">Coloca un correo electrónico vigente</small>
      <input
        required
        type="email"
        name="email"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="email"
      />
      <small v-if="$v.email.$error || incomplete" class="text-red-500 block">{{
        !$v.email.required
          ? "Este campo es requerido"
          : !$v.email.email
          ? "El correo no es válido"
          : ""
      }}</small>
      <div class="flex justify-center mt-7">
        <button
          class="rounded bg-blue-900 text-white font-bold px-4 py-2"
          @click="validate"
        >
          Registrarme
        </button>
      </div>
    </template>
    <template v-slot:footer>
      <div class="max-w-sm px-5">
        <div class="flex items-center mb-5 mt-7">
          <img class="w-5 mr-4" :src="`${baseUrl}/img/lock.svg`" />
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
import Modal from "../layouts/modal";
import { isNumber } from "../mixins/isNumer";
import { baseUrl } from "../mixins/calcData";
import useVuelidate from '@vuelidate/core';
import { required, numeric, maxLength, minLength, email } from "@vuelidate/validators";
import { reactive } from 'vue';
export default {
  props: {
    isOpen: Boolean,
  },
  setup() {
    const state = reactive({
      dni: "",
      nombre: "",
      apellido: "",
      phone1: "",
      phone2: "",
      email: "",
      incomplete: false,
      baseUrl,
    });

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

    const $v = useVuelidate(rules, state);

    // methods
    const close = () => {
      this.$emit("close");
    }
    const send = () => {
      const solicitud = {
        tipo_de_solicitud: "inversion",
        nombres: this.nombre,
        apellidos: this.apellido,
        dni: this.dni,
        telefono1: this.phone1,
        telefono2: this.phone2,
        email: this.email,
      };
      this.$emit("submit", solicitud);
    }

    const validate = () => {
      if ($v.$invalid) {
        state.incomplete = true;
      } else {
        state.incomplete = false;
        send();
      }
    }

    return { $v, state, close, send, validate, isNumber }
  },
  components: { Modal },
};
</script>

<style>
</style>