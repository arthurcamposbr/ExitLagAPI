import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './views/pages/Home.vue'
import Pesquisa from './views/pages/Pesquisa.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/pesquisa',
    name: 'Pesquisa',
    component: Pesquisa
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
