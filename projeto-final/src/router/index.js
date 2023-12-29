import { createRouter, createWebHistory } from 'vue-router'
import LoginSistema from '@/components/LoginSistema.vue';
import PaginaPaciente from '@/views/PaginaPaciente.vue';



const routes = [
  { path: '/', name: 'login', component: LoginSistema},

  { path: '/paciente', name: 'paciente', component: PaginaPaciente},

  
  { path: '/cadmedico',
    name: "cadmedico",
    component: ()=>import("@/views/CadMedico.vue")
  },

  { path: '/cadpaciente',
    name: "cadpaciente",
    component: ()=>import("@/views/CadPaciente.vue")
  },

  {
    path: '/cadespecialidade',
    name: 'cadespecialidade',
    component: ()=>import("@/views/PaginaEspecialidade.vue")
  },
  
  {
    path: '/cadreceituario',
    name: 'cadreceituario',
    component: ()=>import("@/components/formCadReceituario.vue")
  },
  
  {
    path: '/consultamedico',
    name: 'consultamedico',
    component: ()=>import("@/views/ConsultaMedico.vue")
  },

  {
    path: '/consultapaciente',
    name: 'consultapaciente',
    component: ()=>import("@/views/ConsultaPaciente.vue")
  }

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
