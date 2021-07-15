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
    token: localStorage.getItem('token') || '',
    user : {},
    boolcontribuyente:false,
    boolusuario:false,
    boolitem:false,
    boolunidad:false,
    boolcomprobante:false,
    boolpagocomprobante:false,
    boolcancelarcomprobante:false,
    boolempresa:false,
    boolverificar:false,
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
      state.boolcontribuyente=data.user.permisos.find( permiso => permiso.id === 1)!=undefined;
      state.boolusuario=data.user.permisos.find( permiso => permiso.id === 2)!=undefined;
      state.boolitem=data.user.permisos.find( permiso => permiso.id === 3)!=undefined;
      state.boolunidad=data.user.permisos.find( permiso => permiso.id === 4)!=undefined;
      state.boolcomprobante=data.user.permisos.find( permiso => permiso.id === 5)!=undefined;
      state.boolpagocomprobante=data.user.permisos.find( permiso => permiso.id === 6)!=undefined;
      state.boolcancelarcomprobante=data.user.permisos.find( permiso => permiso.id === 7)!=undefined;
      state.boolempresa=data.user.permisos.find( permiso => permiso.id === 8)!=undefined;
      state.boolverificar=data.user.permisos.find( permiso => permiso.id === 9)!=undefined;

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
      state.boolpagocomprobante=false
      state.boolcancelarcomprobante=false
      state.boolempresa=false
      state.boolverificar=false
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
            localStorage.setItem('token', token)
            axios.defaults.headers.common['Authorization'] = 'Bearer '+token
            commit('auth_success', {token, user})
            resolve(resp)
          })
          .catch(err => {
            commit('auth_error')
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    logout({commit}){
      return new Promise((resolve, reject) => {
        axios.post(process.env.URL+'/logout').then(res=>{
          commit('logout')
          localStorage.removeItem('token')
          delete axios.defaults.headers.common['Authorization']
          resolve()
        }).catch(err => {
          commit('auth_error')
          localStorage.removeItem('token')
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
