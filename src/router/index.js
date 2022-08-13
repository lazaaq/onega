import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import PrintView from '../views/PrintView.vue'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/',
    name: 'home',
    component: HomeView,
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')) {
        next()
      } else {
        next('/login')
      }
    }
  },
  {
    path: '/print',
    name: 'print',
    component: PrintView,
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')) {
        next()
      } else {
        next('/login')
      }
    }
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
