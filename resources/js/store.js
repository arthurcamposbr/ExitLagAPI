import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    usuario: null,
    isMobile: false,
    windowHeight: window.innerHeight
  },
  mutations: {
    setUsuario(state, n){
        state.usuario = n;
    },
    setIsMobile(state, n){
        state.isMobile = n;
    },
    setIsWindowHeight(state, n){
        state.windowHeight = n;
    }
  },
  actions: {
  },
  getters: {
    getUsuario: state => {
      return state.usuario
    },
    getIsMobile: state => {
      return state.isMobile
    },
    getWindowHeight: state => {
      return state.windowHeight
    }
  },
  modules: {
  }
})
