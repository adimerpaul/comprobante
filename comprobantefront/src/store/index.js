import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

// import example from './module-example'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('tokencom') || '',
    user : {},
    boolcontribuyente:false,
    boolusuario:false,
    boolitem:false,
    boolunidad:false,
    boolcomprobante:false,
    boolimprimir:false,
    boolanular:false,
    boolpagounidad:false,
    boolpagocaja:false,
    boolresumencaja:false,
    boolempresa:false,
    boolexportar:false,
    boolimportar:false,
    boolverificar:false,
    boolverificarcaja:false,
    boolverificarsistema:false,
    boolmisitems:false,
    boolactualizarcomprobante:false,
    boolcomprobantemercado:false,
    boolmodificarcomprobante:false,
    boolcomprobanteurbano:false,
    boolcomprobantecatastro:false,
    booltemporada:false,
    boolverificarconsulta:false,
    boolbuscarcomprobante:false,
  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, data){
      state.status = 'success'
      state.token = data.token
      state.user = data.user
      // console.log(data.user)
      // state.boolcontribuyente=data.user.permisos.find( permiso => permiso.id === 1)!=undefined
      // state.boolusuario=data.user.permisos.find( permiso => permiso.id === 2)!=undefined
      // state.boolitem=data.user.permisos.find( permiso => permiso.id === 3)!=undefined
      // state.boolunidad=data.user.permisos.find( permiso => permiso.id === 4)!=undefined
      // state.boolcomprobante=data.user.permisos.find( permiso => permiso.id === 5)!=undefined
      // state.boolpagocomprobante=data.user.permisos.find( permiso => permiso.id === 6)!=undefined
      // state.boolcancelarcomprobante=data.user.permisos.find( permiso => permiso.id === 7)!=undefined
      // state.boolempresa=data.user.permisos.find( permiso => permiso.id === 8)!=undefined
      // state.boolverificar=data.user.permisos.find( permiso => permiso.id === 9)!=undefined
      // state.boolpagocaja=data.user.permisos.find( permiso => permiso.id === 10)!=undefined
      // state.boolanular=data.user.permisos.find( permiso => permiso.id === 11)!=undefined
      // state.boolresumen=data.user.permisos.find( permiso => permiso.id === 12)!=undefined
      // console.log(data.user.permisos)
        state.boolcontribuyente=data.user.permisos.find(permiso=>permiso.id===1)!=undefined
        state.boolusuario=data.user.permisos.find(permiso=>permiso.id===2)!=undefined
        state.boolitem=data.user.permisos.find(permiso=>permiso.id===3)!=undefined
        state.boolunidad=data.user.permisos.find(permiso=>permiso.id===4)!=undefined
        state.boolcomprobante=data.user.permisos.find(permiso=>permiso.id===5)!=undefined
        state.boolimprimir=data.user.permisos.find(permiso=>permiso.id===6)!=undefined
        state.boolanular=data.user.permisos.find(permiso=>permiso.id===7)!=undefined
        state.boolpagounidad=data.user.permisos.find(permiso=>permiso.id===8)!=undefined
        state.boolpagocaja=data.user.permisos.find(permiso=>permiso.id===9)!=undefined
        state.boolresumencaja=data.user.permisos.find(permiso=>permiso.id===10)!=undefined
        state.boolempresa=data.user.permisos.find(permiso=>permiso.id===11)!=undefined
        state.boolexportar=data.user.permisos.find(permiso=>permiso.id===12)!=undefined
        state.boolimportar=data.user.permisos.find(permiso=>permiso.id===13)!=undefined
        state.boolverificar=data.user.permisos.find(permiso=>permiso.id===14)!=undefined
        state.boolverificarcaja=data.user.permisos.find(permiso=>permiso.id===15)!=undefined
        state.boolverificarsistema=data.user.permisos.find(permiso=>permiso.id===16)!=undefined
        state.boolmisitems=data.user.permisos.find(permiso=>permiso.id===17)!=undefined
        state.boolactualizarcomprobante=data.user.permisos.find(permiso=>permiso.id===18)!=undefined
        state.boolcomprobantemercado=data.user.permisos.find(permiso=>permiso.id===19)!=undefined
        state.boolmodificarcomprobante=data.user.permisos.find(permiso=>permiso.id===20)!=undefined
        state.boolcomprobanteurbano=data.user.permisos.find(permiso=>permiso.id===21)!=undefined
      state.boolcomprobantecatastro=data.user.permisos.find(permiso=>permiso.id===22)!=undefined
      state.booltemporada=data.user.permisos.find(permiso=>permiso.id===23)!=undefined
      state.boolverificarconsulta=data.user.permisos.find(permiso=>permiso.id===24)!=undefined
      state.boolbuscarcomprobante=data.user.permisos.find(permiso=>permiso.id===25)!=undefined
    },
    auth_error(state){
      state.status = 'error'
    },
    logout(state){
      state.status = ''
      state.token = ''
      state.user = {}
      state.boolcontribuyente=false
      state.boolusuario=false
      state.boolitem=false
      state.boolunidad=false
      state.boolcomprobante=false
      state.boolimprimir=false
      state.boolanular=false
      state.boolpagounidad=false
      state.boolpagocaja=false
      state.boolresumencaja=false
      state.boolempresa=false
      state.boolexportar=false
      state.boolimportar=false
      state.boolverificar=false
      state.boolverificarcaja=false
      state.boolverificarsistema=false
      state.boolmisitems=false
      state.boolactualizarcomprobante=false
      state.boolcomprobantemercado=false
      state.boolmodificarcomprobante=false
      state.boolcomprobanteurbano=false
      state.boolcomprobantecatastro=false
      state.booltemporada=false
      state.boolverificarconsulta=false
      state.boolbuscarcomprobante=false
    },
  },
  actions: {
    login({commit}, user){
      return new Promise((resolve, reject) => {
        commit('auth_request')
        axios({url: process.env.URL+'/login', data: user, method: 'POST' })
          .then(resp => {
            const token = resp.data.token
            const user = resp.data.user
            // console.log(user)
            localStorage.setItem('tokencom', token)
            axios.defaults.headers.common['Authorization'] = 'Bearer '+token
            commit('auth_success', {token, user})
            resolve(resp)
          })
          .catch(err => {
            commit('auth_error')
            localStorage.removeItem('tokencom')
            reject(err)
          })
      })
    },
    logout({commit}){
      return new Promise((resolve, reject) => {
        axios.post(process.env.URL+'/logout').then(res=>{
          commit('logout')
          localStorage.removeItem('tokencom')
          delete axios.defaults.headers.common['Authorization']
          resolve()
        }).catch(err => {
          commit('auth_error')
          localStorage.removeItem('tokencom')
          reject(err)
        })
      })
    }
  },
  getters : {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
  }
})
