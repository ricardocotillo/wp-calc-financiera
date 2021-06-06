import { reactive, provide, inject } from 'vue'

export const stateSymbol = Symbol('state')
export const createState = () => reactive({
  type: null,
  direction: null,
  tea: 0.36,
  sitm: 0.025,
  pptm: 0.032,
  secondaryColor: null,
})

export const useState = () => inject(stateSymbol)
export const provideState = () => provide(
  stateSymbol,
  createState()
)