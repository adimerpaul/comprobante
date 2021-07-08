import MainLayout from "../layouts/MainLayout";
import Index  from "../pages/Index";
import Secure  from "../pages/Secure";
import Login  from "../pages/Login";
import Cliente  from "../pages/Cliente";
import Item  from "../pages/Item";
import Empresa  from "../pages/Empresa";
import Unid  from "../pages/Unid";
import Pago from "pages/Pago";
const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: Index },
      { path: '/login', component: Login },
      { path: '/Secure', component: Secure,meta: {requiresAuth: true} },
      { path: '/Cliente', component: Cliente,meta: {requiresAuth: true} },
      { path: '/Item', component: Item,meta: {requiresAuth: true} },
      { path: '/Empresa', component: Empresa,meta: {requiresAuth: true} },
      { path: '/Unid', component: Unid,meta: {requiresAuth: true} },
      { path: '/pago', component: Pago,meta: {requiresAuth: true} },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
