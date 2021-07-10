import metadata from '@scripts/store/metadata'
import settings from '@scripts/store/settings'
import user from '@scripts/store/user'
import { createStore } from 'vuex'
import VuexPersistence from 'vuex-persist'

const vuexLocalStorage = new VuexPersistence({
  modules: ['settings'],
  storage: window.localStorage
})

const vuexSessionStorage = new VuexPersistence({
  modules: ['user'],
  storage: window.sessionStorage
})

const store = createStore({
  modules: {
    metadata,
    settings,
    user
  },
  plugins: [
    vuexLocalStorage.plugin,
    vuexSessionStorage.plugin
  ]
})

export default store
