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
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
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

      <label for="nombre" class="font-black text-black text-base"
        >Nombres *</label
      >
      <input
        required
        type="text"
        name="nombre"
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
        v-model="v$.nombre.$model"
      />
      <small v-if="v$.nombre.$error || incomplete" class="text-red-500 block">{{
        !v$.nombre.required
          ? 'Este campo es requerido'
          : !v$.nombre.minLength
          ? 'Mínimo 2 caracteres'
          : ''
      }}</small>
      <label for="apellido" class="font-black text-black text-base"
        >Apellidos *</label
      >
      <input
        required
        type="text"
        name="apellido"
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
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
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
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
      <label for="telefono2" class="font-black text-black text-base"
        >Otro teléfono de contacto</label
      >
      <input
        type="tel"
        name="telefono2"
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
        v-model.number="phone2"
        placeholder="(Opcional)"
        @keypress="isNumber"
      />
      <small v-if="v$.phone2.$error || incomplete" class="text-red-500 block">{{
        !v$.phone2.minLength ? 'Mínimo 7 dígitos' : ''
      }}</small>
      <label for="email" class="font-black text-black text-base block mb-0"
        >Correo electrónico *</label
      >
      <small class="text-xs block">Coloca un correo electrónico vigente</small>
      <input
        required
        type="email"
        name="email"
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
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
        class="
          flex flex-row
          justify-between
          items-center
          py-10
          px-5
          bg-gray-100
          rounded
          mb-5
        "
      >
        <svg
          version="1.1"
          id="Layer_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 330 330"
          style="enable-background: new 0 0 330 330"
          xml:space="preserve"
          :fill="primaryColor"
          class="w-10 mr-3"
        >
          <g>
            <g>
              <g>
                <path
                  d="M165,0.008C74.019,0.008,0,74.024,0,164.999c0,90.977,74.019,164.992,165,164.992s165-74.015,165-164.992
				C330,74.024,255.981,0.008,165,0.008z M165,299.992c-74.439,0-135-60.557-135-134.992S90.561,30.008,165,30.008
				s135,60.557,135,134.991C300,239.436,239.439,299.992,165,299.992z"
                />
                <path
                  d="M165,130.008c-8.284,0-15,6.716-15,15v99.983c0,8.284,6.716,15,15,15s15-6.716,15-15v-99.983
				C180,136.725,173.284,130.008,165,130.008z"
                />
                <path
                  d="M165,70.011c-3.95,0-7.811,1.6-10.61,4.39c-2.79,2.79-4.39,6.66-4.39,10.61s1.6,7.81,4.39,10.61
				c2.79,2.79,6.66,4.39,10.61,4.39s7.81-1.6,10.609-4.39c2.79-2.8,4.391-6.66,4.391-10.61s-1.601-7.82-4.391-10.61
				C172.81,71.61,168.95,70.011,165,70.011z"
                />
              </g>
            </g>
          </g>
        </svg>
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
        v-model="v$.departamento.$model"
        @update:modelValue="updateUbicacion"
        w="w-full"
        :options="departamentos"
      />
      <small
        v-if="v$.departamento.$error || incomplete"
        class="text-red-500 block"
        >{{
          !v$.departamento.required ? 'Seleccione un departamento' : ''
        }}</small
      >
      <div class="h-4"></div>
      <Dropdown
        v-model="v$.provincia.$model"
        @update:modelValue="distrito = null"
        w="w-full"
        :options="provincias"
        placeholder="Seleccionar provincia"
      />
      <small
        v-if="v$.provincia.$error || incomplete"
        class="text-red-500 block"
        >{{ !v$.provincia.required ? 'Seleccione una provincia' : '' }}</small
      >
      <div class="h-4"></div>
      <Dropdown
        v-model="v$.distrito.$model"
        w="w-full"
        :options="distritos"
        placeholder="Seleccionar distrito"
      />
      <small
        v-if="v$.distrito.$error || incomplete"
        class="text-red-500 block"
        >{{ !v$.distrito.required ? 'Seleccione un distrito' : '' }}</small
      >
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >Tipo de propiedad *</label
      >
      <p class="mb-3">Selecciona un tipo de propiedad</p>
      <CardOptions
        :error="incomplete && !v$.typeOfProperty.required"
        v-model="v$.typeOfProperty.$model"
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
        v-model.number="v$.area.$model"
        class="
          w-full
          border border-gray-300
          focus:outline-none
          focus:ring-1 focus:ring-blue-900
          focus:border-transparent
          block
          py-2
          px-3
          sm:text-sm
          rounded
          my-1
        "
        placeholder="m²"
        @keypress="isNumber"
      />
      <small v-if="v$.area.$error || incomplete" class="text-red-500 block"
        >{{ !v$.area.required ? 'El dato desde ser mayor o igual a 1 m²' : '' }}
      </small>
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >Dueño(s) de la propiedad *</label
      >
      <Dropdown
        :options="ownerOptions"
        w="w-full"
        v-model="v$.owner.$model"
        placeholder="¿Quién es dueño de la propiedad?"
      />
      <small v-if="v$.owner.$error || incomplete" class="text-red-500 block">{{
        !v$.owner.required ? 'Seleccione una opción' : ''
      }}</small>
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿La propiedad está inscrita en SUNARP? *</label
      >
      <PillOptions
        v-model="v$.sunarp.$model"
        :error="incomplete && !v$.sunarp.required"
      />

      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿Cuenta con un embargo vigente? *</label
      >
      <PillOptions
        v-model="v$.embargo.$model"
        :showThird="true"
        :error="incomplete && !v$.embargo.required"
      />
      <label
        for="type-of-property"
        class="font-black text-black text-sm block my-3"
        >¿Cuenta con una hipoteca vigente? *</label
      >
      <PillOptions
        v-model="v$.hipoteca.$model"
        :showThird="true"
        :error="incomplete && !v$.hipoteca.required"
      />
      <small class="block mt-1" v-if="hipoteca == 0"
        >Recuerda que parte del préstamo será destinado a la cancelación total
        de la hipoteca.</small
      >
      <div class="grid grid-cols-7 lg:grid-cols-6 gap-2 mt-4">
        <div
          class="
            flex flex-row
            items-center
            cursor-pointer
            pr-4
            py-2
            col-span-2
            lg:col-span-2
          "
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
          class="
            rounded
            font-bold
            px-4
            py-2
            inline-block
            col-span-3
            lg:col-span-2
            focus:outline-none
          "
          :style="{ backgroundColor: primaryColor, color: colorOverPrimary }"
        >
          Enviar datos
        </button>
      </div>
    </template>
  </div>
</template>

<script>
import Dropdown from './dropdown'
import CardOptions from './cardOptions'
import PillOptions from './pillOptions'
import { isNumber } from '../mixins/isNumer'
import { baseUrl } from '../mixins/calcData'
import useVuelidate from '@vuelidate/core'
import { reactive, computed, ref, toRefs } from 'vue'
import {
  required,
  email,
  numeric,
  maxLength,
  minLength,
} from '@vuelidate/validators'
import { useState } from '../store/store'
export default {
  setup(_, { emit }) {
    const globalState = useState()
    const ownerOptions = [
      { key: 1, title: 'Sólo yo' },
      { key: 2, title: 'Otras personas y yo' },
      { key: 3, title: 'Otras personas' },
    ]
    const step = ref(0)
    const incomplete = ref(false)
    const state = reactive({
      dni: '',
      nombre: '',
      apellido: '',
      phone1: '',
      phone2: '',
      email: '',
      sunarp: null,
      embargo: null,
      hipoteca: null,
      area: '',
      typeOfProperty: null,
      departamento: 15,
      provincia: null,
      distrito: null,
      departamentos: [],
      owner: null,
      propertyTypes: [],
      ubigeo: [],
    })

    const rules = {
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
    }

    const v$ = useVuelidate(rules, state)

    // computed
    const provincias = computed(() => {
      if (state.departamento >= 0) {
        return state.ubigeo
          .filter(
            (u) =>
              u.departamento === state.departamentos[state.departamento].key &&
              u.distrito === 0 &&
              u.provincia !== 0
          )
          .map((p) => {
            return { key: p.provincia, title: p.nombre }
          })
      }
      return []
    })

    const distritos = computed(() => {
      if (state.provincia !== null && state.provincia >= 0) {
        return state.ubigeo
          .filter(
            (u) =>
              u.departamento === state.departamentos[state.departamento].key &&
              u.provincia === provincias.value[state.provincia].key &&
              u.distrito !== 0
          )
          .map((d) => {
            return { key: d.distrito, title: d.nombre }
          })
      }
      return []
    })

    // methods
    const goBack = () => {
      step.value = 0
      incomplete.value = false
      emit('step', 0)
    }

    const filterDepartamentos = () => {
      return state.ubigeo.filter((u) => u.provincia === 0 && u.distrito === 0)
    }

    const validateFirst = () => {
      if (
        v$.value.dni.$invalid ||
        v$.value.nombre.$invalid ||
        v$.value.apellido.$invalid ||
        v$.value.phone1.$invalid ||
        v$.value.phone2.$invalid ||
        v$.value.email.$invalid
      ) {
        incomplete.value = true
      } else {
        incomplete.value = false
        step.value = 1
      }
      emit('step', 1)
    }

    const validateSecond = () => {
      if (v$.value.$invalid) {
        incomplete.value = true
      } else {
        send()
      }
    }

    const send = () => {
      const solicitud = {
        tipo_de_solicitud: 'prestamo',
        nombres: state.nombre,
        apellidos: state.apellido,
        dni: state.dni,
        telefono1: state.phone1,
        telefono2: state.phone2,
        email: state.email,
        departamento: state.departamentos[state.departamento].title,
        provincia: provincias.value[state.provincia].title,
        distrito: distritos.value[state.distrito].title,
        tipo_de_propiedad: state.typeOfProperty,
        area: state.area,
        dueno: state.owner,
        sunarp: state.sunarp,
        embargo: state.embargo,
        hipoteca: state.hipoteca,
      }
      emit('submit', solicitud)
    }

    const updateUbicacion = () => {
      state.provincia = null
      state.distrito = null
    }

    // created
    state.propertyTypes = [
      {
        key: 1,
        icon: `${baseUrl}/img/building.svg`,
        title: 'Casa',
      },
      {
        key: 2,
        icon: `${baseUrl}/img/building.svg`,
        title: 'Dpto',
      },
      {
        key: 3,
        icon: `${baseUrl}/img/land.svg`,
        title: 'Terreno',
      },
      {
        key: 4,
        icon: `${baseUrl}/img/local.svg`,
        title: 'Local',
      },
      {
        key: 5,
        icon: `${baseUrl}/img/big-building.svg`,
        title: 'Edificio',
      },
    ]

    fetch(`${baseUrl}/misc/ubigeo.json`)
      .then((res) => res.json())
      .then((data) => {
        state.ubigeo = data
        state.departamentos = filterDepartamentos().map((d) => {
          return { key: d.departamento, title: d.nombre }
        })
      })

    return {
      v$,
      provincias,
      distritos,
      updateUbicacion,
      isNumber,
      goBack,
      filterDepartamentos,
      validateFirst,
      validateSecond,
      send,
      baseUrl,
      ownerOptions,
      step,
      incomplete,
      ...toRefs(state),
      ...globalState,
    }
  },
  components: { Dropdown, CardOptions, PillOptions },
}
</script>