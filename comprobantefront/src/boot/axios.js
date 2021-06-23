import Vue from 'vue'
import axios from 'axios'

Vue.prototype.$axios = axios;
// Vue.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$axios.defaults.headers.common['Authorization'] = 'Bearer '+token
}
