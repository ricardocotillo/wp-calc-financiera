import { reactive, provide, inject } from 'vue'

export const stateSymbol = Symbol('state')
export const createState = () => reactive({
  type: null,
  direction: null,
  primaryColor: null,
  secondaryColor: null,
})

export const useState = () => inject(stateSymbol)
export const provideState = () => provide(
  stateSymbol,
  createState()
)