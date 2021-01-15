<template>
  <div>
    <template v-if="step == 0">
      <h6 class="text-gray-400 font-bold text-sm text-center">
        Paso {{ step + 1 }} de 2
      </h6>
      <h1 class="text-xl font-bold text-center">Datos personales</h1>
      <h6 class="text-gray-400 text-sm text-center mb-7">
        De la persona que solicita el préstamo
      </h6>
      <label for="dni" class="font-bold text-base">DNI</label>
      <input
        type="text"
        name="dni"
        class="input my-1"
        v-model="dni"
        @keypress="isNumber"
      />
      <label for="nombre" class="font-bold text-base">Nombres</label>
      <input type="text" name="nombre" class="input my-1" v-model="nombre" />
      <label for="apellido" class="font-bold text-base">Apellidos</label>
      <input
        type="text"
        name="apellido"
        class="input my-1"
        v-model="apellido"
      />
      <h1 class="text-xl font-bold text-center my-7">Datos de contacto</h1>
      <label for="telefono1" class="font-bold text-base"
        >Teléfono de contacto</label
      >
      <input
        type="tel"
        name="telefono1"
        class="input my-1"
        v-model="phone1"
        @keypress="isNumber"
      />
      <label for="telefono2" class="font-bold text-base"
        >Otro teléfono de contacto</label
      >
      <input
        type="tel"
        name="telefono2"
        class="input my-1"
        v-model.number="phone2"
        @keypress="isNumber"
      />
      <label for="email" class="font-bold text-base">Correo electrónico</label>
      <input type="email" name="email" class="input my-1" v-model="email" />
      <div class="flex justify-center mt-7">
        <button class="btn" @click="step = 1">
          Continuar
          <img
            class="w-5 h-5 inline-block transform -rotate-90"
            src="/wp-content/plugins/calc-financiera/public/resources/dist/img/arrow-white.svg"
          />
        </button>
      </div>
    </template>
    <template v-else>
      <h6 class="text-gray-400 font-bold text-sm text-center">
        Paso {{ step + 1 }} de 2
      </h6>
      <h1 class="text-xl font-bold text-center mb-3">
        Datos de la propedad en garantía
      </h1>
      <div
        class="flex flex-row justify-between items-center py-10 px-5 bg-gray-100 rounded mb-5"
      >
        <img src="@/assets/info.svg" class="w-10 mr-3" alt="" srcset="" />
        <span
          >Recuerda que <b>para obtener el préstamo necesitas</b> contar con<b>
            una propiedad para poner en garantía.</b
          ></span
        >
      </div>
      <label for="location" class="font-bold text-sm block my-3"
        >Ubicación de la propiedad que puedes poner en garantía</label
      >
      <Dropdown
        v-if="departamentos"
        v-model="departamento"
        w="full"
        :options="departamentos"
      />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Tipo de propiedad</label
      >
      <p class="mb-3">Selecciona un tipo de propiedad</p>
      <CardOptions v-model="typeOfProperty" :options="propertyTypes" />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Área total de la propiedad</label
      >
      <input
        type="text"
        name="area"
        v-model.number="area"
        class="input my-1"
        placeholder="m²"
        @keypress="isNumber"
      />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Dueño(s) de la propiedad</label
      >
      <Dropdown :options="ownerOptions" w="full" v-model="owner" />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿La propiedad está inscrita en SUNARP?</label
      >
      <PillOptions v-model="sunarp" />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿Cuenta con un embargo vigente?</label
      >
      <PillOptions v-model="embargo" :showThird="true" />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿Cuenta con una hipoteca vigente?</label
      >
      <PillOptions v-model="hipoteca" :showThird="true" />
      <div class="grid grid-cols-6 mt-4">
        <div
          class="flex flex-row items-center cursor-pointer pr-4 py-2 mr-5 col-span-2"
          @click="step = 0"
        >
          <img
            src="/wp-content/plugins/calc-financiera/public/resources/dist/img/arrow.svg"
            class="w-5 h-6 transform rotate-90 mr-2"
          />
          <span>Paso 1</span>
        </div>
        <button class="btn inline-block col-span-2">Enviar datos</button>
      </div>
    </template>
  </div>
</template>

<script>
import Dropdown from "./dropdown";
import CardOptions from "./cardOptions";
import PillOptions from "./pillOptions";
import { isNumber } from "../mixins/isNumer";
import { departamentos } from "../mixins/departamentos";
export default {
  data() {
    return {
      step: 0,
      dni: "",
      nombre: "",
      apellido: "",
      phone1: "",
      phone2: "",
      email: "",
      sunarp: null,
      embargo: null,
      hipoteca: null,
      area: null,
      typeOfProperty: null,
      departamento: 14,
      departamentos: departamentos.map((v, i) => {
        return { key: i, title: v };
      }),
      owner: null,
      ownerOptions: [
        { key: 1, title: "Sólo yo" },
        { key: 2, title: "Otras personas y yo" },
        { key: 3, title: "Otras personas" },
      ],
      propertyTypes: [
        {
          key: 1,
          icon: "/wp-content/plugins/calc-financiera/public/resources/dist/img/building.svg",
          title: "Casa",
        },
        {
          key: 2,
          icon: "/wp-content/plugins/calc-financiera/public/resources/dist/img/building.svg",
          title: "Dpto",
        },
        {
          key: 3,
          icon: "/wp-content/plugins/calc-financiera/public/resources/dist/img/land.svg",
          title: "Terreno",
        },
        {
          key: 4,
          icon: "/wp-content/plugins/calc-financiera/public/resources/dist/img/local.svg",
          title: "Local",
        },
        {
          key: 5,
          icon: "/wp-content/plugins/calc-financiera/public/resources/dist/img/big-building.svg",
          title: "Edificio",
        },
      ],
    };
  },
  methods: {
    isNumber,
  },
  components: { Dropdown, CardOptions, PillOptions },
};
</script>

<style>
</style>