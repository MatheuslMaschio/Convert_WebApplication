import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    redirect: '/login',
  
  },

  {
    path: '/cadastrarUsuario',
    name: 'cadastrarUsuario',
    component: () => import('../views/cadastrar_usuario.vue')
  },
  

  {
    path:'/login',
    name: 'login',
    component: () => import('../views/login.vue')
  },
  {
    path: '/cadastrar_usuario',
    name: 'cadastrar_usuario',
    component: () => import('../views/cadastrar_usuario.vue')
  },

  {
    path:'/portal',
    component: () => import('../views/template.vue'),
    children: [ 
      {
        path: '',
        name: 'inicio',
        component: () => import('../views/HomeView.vue')
      },

      {
        path:'cadastrar_atividade',
        name:'cadastrar_atividade',
        component: () => import('../views/cadastrar_atividade.vue')
      },

      {
        path:'cadastrar_tp_at',
        name: 'cadastrar_tp_at',
        component: () => import('../views/cadastrar_tp_at.vue')
      },

      {
        path:'usuarios',
        name:'usuarios',
        component: () => import('../views/usuarios.vue')
      }

    ]
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
