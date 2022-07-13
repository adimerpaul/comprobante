import MainLayout from "../layouts/MainLayout";
import Index  from "../pages/Index";
import Secure  from "../pages/Secure";
import Login  from "../pages/Login";
import Cliente  from "../pages/Cliente";
import Item  from "../pages/Item";
import Empresa  from "../pages/Empresa";
import Unid  from "../pages/Unid";
import Pago from "pages/Pago";
import User from "pages/User";
import Cancelar from "pages/Cancelar";
import Verificar from "pages/Verificar";
import Verificarcaja from "pages/Verificarcaja";
import Pagocaja from "pages/Pagocaja";
import Anular from "pages/Anular";
import Resumen from "pages/Resumen";
import Exportar from "pages/Exportar";
import Importar from "pages/Importar";
import Verificarsistema from "pages/Verificarsistema";
import Misitems from "pages/Misitems";
import Actualizarcomprobante from "pages/Actualizarcomprobante";
import Reimprimir from "pages/Reimprimir";
import Pagomercado from "pages/Pagomercado";
import Modificarcomprobante from "pages/Modificarcomprobante";
import Pagourbano from "pages/Pagourbano";
import Pagocatastro from "pages/Pagocatastro";
import Pagocatastronombres from "pages/Pagocatastronombres";
import Pagocatastrovehiculos from "pages/Pagocatastrovehiculos";
import Temporada from "pages/Temporada";
import Verificarconsulta from "pages/Verificarconsulta";
import Buscarcomprobante from "pages/Buscarcomprobante";
const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: Index },
      { path: '/login', component: Login },
      { path: '/secure', component: Secure,meta: {requiresAuth: true} },
      { path: '/cliente', component: Cliente,meta: {requiresAuth: true} },
      { path: '/item', component: Item,meta: {requiresAuth: true} },
      { path: '/empresa', component: Empresa,meta: {requiresAuth: true} },
      { path: '/unid', component: Unid,meta: {requiresAuth: true} },
      { path: '/pago', component: Pago,meta: {requiresAuth: true} },
      { path: '/user', component: User,meta: {requiresAuth: true} },
      { path: '/cancelar', component: Cancelar,meta: {requiresAuth: true} },
      { path: '/verificar', component: Verificar,meta: {requiresAuth: true} },
      { path: '/verificarcaja', component: Verificarcaja,meta: {requiresAuth: true} },
      { path: '/verificarsistema', component: Verificarsistema,meta: {requiresAuth: true} },
      { path: '/pagocaja', component: Pagocaja,meta: {requiresAuth: true} },
      { path: '/anular', component: Anular,meta: {requiresAuth: true} },
      { path: '/resumen', component: Resumen,meta: {requiresAuth: true} },
      { path: '/exportar', component: Exportar,meta: {requiresAuth: true} },
      { path: '/importar', component: Importar,meta: {requiresAuth: true} },
      { path: '/misitems', component: Misitems,meta: {requiresAuth: true} },
      { path: '/pagomercado', component: Pagomercado,meta: {requiresAuth: true} },
      { path: '/pagourbano', component: Pagourbano,meta: {requiresAuth: true} },
      { path: '/pagocatastro', component: Pagocatastro,meta: {requiresAuth: true} },
      { path: '/pagocatastronombres', component: Pagocatastronombres,meta: {requiresAuth: true} },
      { path: '/actualizarcomprobante', component: Actualizarcomprobante,meta: {requiresAuth: true} },
      { path: '/reimprimir', component: Reimprimir,meta: {requiresAuth: true} },
      { path: '/modificarcomprobante', component: Modificarcomprobante,meta: {requiresAuth: true} },
      { path: '/pagocatastrovehiculos', component: Pagocatastrovehiculos,meta: {requiresAuth: true} },
      { path: '/temporada', component: Temporada,meta: {requiresAuth: true} },
      { path: '/verificarconsulta', component: Verificarconsulta,meta: {requiresAuth: true} },
      { path: '/buscarcomprobante', component: Buscarcomprobante,meta: {requiresAuth: true} },
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
