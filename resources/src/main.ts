import Vue, { createApp } from 'vue'
import App from './App.vue'
import { VuelidatePlugin } from '@vuelidate/core'

import './index.css'
const app = createApp(App)
app.use(VuelidatePlugin)
app.mount('#app')
