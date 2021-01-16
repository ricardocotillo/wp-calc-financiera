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
      <label for="dni" class="font-bold text-base">DNI *</label>
      <input
        required
        type="text"
        name="dni"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.dni.$model"
        @keypress="isNumber"
      />
      <small v-if="$v.dni.$error" class="text-xs text-red-500 block"
        >Por favor ingresa un DNI válido</small
      >

      <label for="nombre" class="font-bold text-base">Nombres *</label>
      <input
        required
        type="text"
        name="nombre"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.nombre.$model"
      />
      <small v-if="$v.nombre.$error" class="text-xs text-red-500 block"
        >Por favor ingresa un Nombre válido</small
      >
      <label for="apellido" class="font-bold text-base">Apellidos *</label>
      <input
        required
        type="text"
        name="apellido"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.apellido.$model"
      />
      <small v-if="$v.apellido.$error" class="text-xs text-red-500 block"
        >Por favor ingresa un Apellido válido</small
      >
      <h1 class="text-xl font-bold text-center my-7">Datos de contacto</h1>
      <label for="telefono1" class="font-bold text-base"
        >Teléfono de contacto *</label
      >
      <input
        required
        type="tel"
        name="telefono1"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="$v.phone1.$model"
        @keypress="isNumber"
      />
      <label for="telefono2" class="font-bold text-base"
        >Otro teléfono de contacto</label
      >
      <input
        type="tel"
        name="telefono2"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model.number="phone2"
        placeholder="(Opcional)"
        @keypress="isNumber"
      />
      <label for="email" class="font-bold text-base"
        >Correo electrónico *</label
      >
      <input
        required
        type="email"
        name="email"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        v-model="email"
      />
      <div class="text-center" v-if="incomplete">
        <small class="text-red-500"
          >Por favor completa los campos requeridos</small
        >
      </div>
      <div class="flex justify-center mt-7">
        <button
          class="rounded bg-blue-900 text-white font-bold px-4 py-2"
          @click="validateFirst"
        >
          Continuar
          <img
            class="w-5 h-5 inline-block transform -rotate-90"
            :src="`${baseUrl}/img/arrow-white.svg`"
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
        >Ubicación de la propiedad que puedes poner en garantía *</label
      >
      <Dropdown
        v-if="departamentos.length > 0"
        v-model="$v.departamento.$model"
        @input="
          provincia = null;
          distrito = null;
        "
        w="full"
        :options="departamentos"
      />
      <div class="h-4"></div>
      <Dropdown
        v-model="$v.provincia.$model"
        @input="distrito = null"
        w="full"
        :options="provincias"
        label="Seleccionar provincia"
      />
      <div class="h-4"></div>
      <Dropdown
        v-model="$v.distrito.$model"
        w="full"
        :options="distritos"
        label="Seleccionar distrito"
      />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Tipo de propiedad *</label
      >
      <p class="mb-3">Selecciona un tipo de propiedad</p>
      <CardOptions
        v-model="$v.typeOfProperty.$model"
        :options="propertyTypes"
      />
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Área total de la propiedad *</label
      >
      <input
        required
        type="text"
        name="area"
        v-model.number="$v.area.$model"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
        placeholder="m²"
        @keypress="isNumber"
      />
      <small v-if="$v.area.$error" class="text-xs text-red-500 block"
        >Por favor ingresa un Área válida</small
      >
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >Dueño(s) de la propiedad *</label
      >
      <Dropdown :options="ownerOptions" w="full" v-model="$v.owner.$model" />
      <small v-if="$v.owner.$error" class="text-xs text-red-500 block"
        >Por favor escoge una opción</small
      >
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿La propiedad está inscrita en SUNARP? *</label
      >
      <PillOptions v-model="$v.sunarp.$model" />
      <small v-if="$v.sunarp.$error" class="text-xs text-red-500 block"
        >Por favor escoge una opción</small
      >

      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿Cuenta con un embargo vigente? *</label
      >
      <PillOptions v-model="$v.embargo.$model" :showThird="true" />
      <small v-if="$v.embargo.$error" class="text-xs text-red-500 block"
        >Por favor escoge una opción</small
      >
      <label for="type-of-property" class="font-bold text-sm block my-3"
        >¿Cuenta con una hipoteca vigente? *</label
      >
      <PillOptions v-model="$v.hipoteca.$model" :showThird="true" />
      <small v-if="$v.hipoteca.$error" class="text-xs text-red-500 block"
        >Por favor escoge una opción</small
      >
      <div class="text-center mt-2" v-if="incomplete">
        <small class="text-red-500"
          >Por favor completa los campos requeridos</small
        >
      </div>
      <div class="grid grid-cols-6 mt-4">
        <div
          class="flex flex-row items-center cursor-pointer pr-4 py-2 mr-5 col-span-2"
          @click="
            step = 0;
            incomplete = false;
          "
        >
          <img
            :src="`${baseUrl}/img/arrow.svg`"
            class="w-5 h-6 transform rotate-90 mr-2"
          />
          <span>Paso 1</span>
        </div>
        <button
          @click="validateSecond"
          class="rounded bg-blue-900 text-white font-bold px-4 py-2 inline-block col-span-2"
        >
          Enviar datos
        </button>
      </div>
    </template>
  </div>
</template>

<script>
import Dropdown from "./dropdown";
import CardOptions from "./cardOptions";
import PillOptions from "./pillOptions";
import { isNumber } from "../mixins/isNumer";
import {
  required,
  email,
  numeric,
  maxLength,
  between,
} from "vuelidate/lib/validators";
export default {
  data() {
    return {
      baseUrl:
        process.env.NODE_ENV === "development"
          ? "http://af17bba27b48.ngrok.io/wp-content/plugins/calc-financiera/public"
          : "/wp-content/plugins/calc-financiera/public/misc",
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
      departamento: 15,
      provincia: null,
      distrito: null,
      departamentos: [],
      owner: null,
      ownerOptions: [
        { key: 1, title: "Sólo yo" },
        { key: 2, title: "Otras personas y yo" },
        { key: 3, title: "Otras personas" },
      ],
      propertyTypes: [],
      ubigeo: [],
      incomplete: false,
    };
  },
  validations: {
    phone1: { required, numeric, maxLength: maxLength(9) },
    phone2: { numeric, maxLength: maxLength(9) },
    dni: { required, numeric, maxLength: maxLength(8) },
    nombre: { required },
    apellido: { required },
    email: { required, email },
    typeOfProperty: { required, between: between(0, 5) },
    area: { required, numeric },
    owner: { required, between: between(0, 2) },
    sunarp: { required, between: between(0, 1) },
    embargo: { required, between: between(0, 2) },
    hipoteca: { required, between: between(0, 2) },
    departamento: { required },
    provincia: { required },
    distrito: { required },
  },
  computed: {
    provincias() {
      if (this.departamento) {
        return this.ubigeo
          .filter(
            (u) =>
              u.departamento === this.departamentos[this.departamento].key &&
              u.distrito === 0 &&
              u.provincia !== 0
          )
          .map((p) => {
            return { key: p.provincia, title: p.nombre };
          });
      }
      return [];
    },
    distritos() {
      if (this.provincia !== null) {
        return this.ubigeo
          .filter(
            (u) =>
              u.departamento === this.departamentos[this.departamento].key &&
              u.provincia === this.provincias[this.provincia].key &&
              u.distrito !== 0
          )
          .map((d) => {
            return { key: d.distrito, title: d.nombre };
          });
      }
      return [];
    },
  },
  methods: {
    isNumber,
    filterDepartamentos() {
      return this.ubigeo.filter((u) => u.provincia === 0 && u.distrito === 0);
    },
    validateFirst() {
      if (
        this.$v.dni.$invalid ||
        this.$v.nombre.$invalid ||
        this.$v.apellido.$invalid ||
        this.$v.phone1.$invalid ||
        this.$v.phone2.$invalid ||
        this.$v.email.$invalid
      ) {
        this.incomplete = true;
      } else {
        this.incomplete = false;
        this.step = 1;
      }
    },
    validateSecond() {
      if (this.$v.$invalid) {
        this.incomplete = true;
      }
    },
    send() {},
  },
  created() {
    this.propertyTypes = [
      {
        key: 1,
        icon: `${this.baseUrl}/img/building.svg`,
        title: "Casa",
      },
      {
        key: 2,
        icon: `${this.baseUrl}/img/building.svg`,
        title: "Dpto",
      },
      {
        key: 3,
        icon: `${this.baseUrl}/img/land.svg`,
        title: "Terreno",
      },
      {
        key: 4,
        icon: `${this.baseUrl}/img/local.svg`,
        title: "Local",
      },
      {
        key: 5,
        icon: `${this.baseUrl}/img/big-building.svg`,
        title: "Edificio",
      },
    ];
    fetch(`${this.baseUrl}/misc/ubigeo.json`)
      .then((res) => res.json())
      .then((data) => {
        this.ubigeo = data;
        this.departamentos = this.filterDepartamentos().map((d) => {
          return { key: d.departamento, title: d.nombre };
        });
      });
  },
  components: { Dropdown, CardOptions, PillOptions },
};
</script>

<style>
</style>