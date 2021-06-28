import Vue from 'vue'
import axios from 'axios'
import store from '../store'

Vue.prototype.$axios = axios
// Vue.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$axios.defaults.headers.common['Authorization'] = 'Bearer '+token
  axios.post(process.env.URL+'/me').then(res=>{
    // console.log(res.data);
    store.state.user=res.data;
  })
}
