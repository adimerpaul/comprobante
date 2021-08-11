import Vue from 'vue'
import axios from 'axios'
import store from '../store'

Vue.prototype.$axios = axios
// Vue.prototype.$http = Axios;
const token = localStorage.getItem('tokencom')
if (token) {
  Vue.prototype.$axios.defaults.headers.common['Authorization'] = 'Bearer '+token
  Vue.prototype.$axios.post(process.env.URL+'/me').then(res=>{
    // console.log(res.data);
    // return false;
    // store.state.user=res.data;
    store.commit('auth_success', {token:token,user:res.data})
  })
}else{
  // store.dispatch('logout')
}
