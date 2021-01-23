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
      <label for="dni" class="font-black text-black text-base">DNI *</label>
      <input
        required
        type="text"
        name="dni"
        class="w-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-transparent block py-2 px-3 sm:text-sm rounded my-1"
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

      <label for="nombre" class="font-black text-black text-base"
        >Nombres *</label
      >
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
      <label for="apellido" class="font-black text-black text-base"
        >Apellidos *</label
      >
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
      <h1 class="text-xl font-bold text-center my-7">Datos de contacto</h1>
      <label for="telefono1" class="font-black text-black text-base block mb-0"
        >Teléfono de contacto *</label
      >
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
      <label for="telefono2" class="font-black text-black text-base"
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
      <small v-if="$v.phone2.$error || incomplete" class="text-red-500 block">{{
        !$v.phone2.minLength ? "Mínimo 7 dígitos" : ""
      }}</small>
      <label for="email" class="font-black text-black text-base block mb-0"
        >Correo electrónico *</label
      >
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
        <img
          :src="`${baseUrl}/img/info.svg`"
          class="w-10 mr-3"
          alt=""
          srcset=""
        />
        <span
          >Recuerda que
          <span class="font-bold text-black"
            >para obtener el préstamo necesitas</span
          >
          contar con<span class="font-bold text-black">
            una propiedad para poner en garantía.</span
          ></span
        >
      </div>
      <label for="location" class="font-black text-black text-sm block my-3"
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
      <small
        v-if="$v.departamento.$error || incomplete"
        class="text-red-500 block"
        >{{
          !$v.departamento.required ? "Seleccione un departamento" : ""
        }}</small
      >
      <div class="h-4"></div>
      <Dropdown
        v-model="$v.provincia.$model"
        @input="distrito = null"
        w="full"
        :options="provincias"
        placeholder="Seleccionar provincia"
      />
      <small
        v-if="$v.provincia.$error || incomplete"
        class="text-red-500 block"
        >{{ !$v.provincia.required ? "Seleccione una provincia" : "" }}</small
      >
      <div class="h-4"></div>
      <Dropdown
        v-model="$v.distrito.$model"
        w="full"
        :options="distritos"
        placeholder="Seleccionar distrito"
      />
      <small
        v-if="$v.distrito.$error || incomplete"
        class="text-red-500 block"
        >{{ !$v.distrito.required ? "Seleccione un distrito" : "" }}</small
      >
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >Tipo de propiedad *</label
      >
      <p class="mb-3">Selecciona un tipo de propiedad</p>
      <CardOptions
        :error="incomplete && !$v.typeOfProperty.required"
        v-model="$v.typeOfProperty.$model"
        :options="propertyTypes"
      />
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >Área total de la propiedad en m² *</label
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
      <small v-if="$v.area.$error || incomplete" class="text-red-500 block"
        >{{ !$v.area.required ? "El dato desde ser mayor o igual a 1 m²" : "" }}
      </small>
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >Dueño(s) de la propiedad *</label
      >
      <Dropdown
        :options="ownerOptions"
        w="full"
        v-model="$v.owner.$model"
        placeholder="¿Quién es dueño de la propiedad?"
      />
      <small v-if="$v.owner.$error || incomplete" class="text-red-500 block">{{
        !$v.owner.required ? "Seleccione una opción" : ""
      }}</small>
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿La propiedad está inscrita en SUNARP? *</label
      >
      <PillOptions
        v-model="$v.sunarp.$model"
        :error="incomplete && !$v.sunarp.required"
      />

      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿Cuenta con un embargo vigente? *</label
      >
      <PillOptions
        v-model="$v.embargo.$model"
        :showThird="true"
        :error="incomplete && !$v.embargo.required"
      />
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿Cuenta con una hipoteca vigente? *</label
      >
      <PillOptions
        v-model="$v.hipoteca.$model"
        :showThird="true"
        :error="incomplete && !$v.hipoteca.required"
      />
      <small class="block mt-1" v-if="hipoteca == 0"
        >Recuerda que parte del préstamo será destinado a la cancelación total
        de la hipoteca.</small
      >
      <div class="grid grid-cols-7 lg:grid-cols-6 gap-2 mt-4">
        <div
          class="flex flex-row items-center cursor-pointer pr-4 py-2 col-span-2 lg:col-span-2"
          @click="goBack"
        >
          <img
            :src="`${baseUrl}/img/arrow.svg`"
            class="w-5 h-6 transform rotate-90 mr-1 lg:mr-2"
          />
          <span>Paso 1</span>
        </div>
        <button
          @click="validateSecond"
          class="rounded bg-blue-900 text-white font-bold px-4 py-2 inline-block col-span-3 lg:col-span-2 focus:outline-none"
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
import { baseUrl } from "../mixins/calcData";
import {
  required,
  email,
  numeric,
  maxLength,
  between,
  minLength,
} from "vuelidate/lib/validators";
export default {
  data() {
    return {
      baseUrl,
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
      area: "",
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
    phone1: { required, numeric, minLength: minLength(7) },
    phone2: { numeric, minLength: minLength(7) },
    dni: {
      required,
      numeric,
      maxLength: maxLength(8),
      minLength: minLength(8),
    },
    nombre: { required, minLength: minLength(2) },
    apellido: { required, minLength: minLength(2) },
    email: { required, email },
    typeOfProperty: { required },
    area: { required },
    owner: { required },
    sunarp: { required },
    embargo: { required },
    hipoteca: { required },
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
    goBack() {
      this.step = 0;
      this.incomplete = false;
      this.$emit("step", 0);
    },
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
      this.$emit("step", 1);
    },
    validateSecond() {
      if (this.$v.$invalid) {
        this.incomplete = true;
      } else {
        this.send();
      }
    },
    send() {
      const solicitud = {
        nombres: this.nombre,
        apellidos: this.apellido,
        dni: this.dni,
        telefono1: this.phone1,
        telefono2: this.phone2,
        email: this.email,
        departamento: this.departamentos[this.departamento].title,
        provincia: this.provincias[this.provincia].title,
        distrito: this.distritos[this.distrito].title,
        tipo_de_propiedad: this.typeOfProperty,
        area: this.area,
        dueno: this.owner,
        sunarp: this.sunarp,
        embargo: this.embargo,
        hipoteca: this.hipoteca,
      };
      this.$emit("submit", solicitud);
    },
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