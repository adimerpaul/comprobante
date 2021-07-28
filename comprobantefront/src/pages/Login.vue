<template>
  <q-page class="q-pt-md">
    <div class="row">
      <div class="col-12 col-md-2"></div>
      <div class="col-12 col-md-8">
        <q-card class="">
          <q-card-section class="bg-secondary text-white">
            <div class="text-h6">
              <q-icon name="login" />
              Ingreso al sistemas
            </div>
            <div class="text-subtitle2">ingresar nombre y contraseña</div>
          </q-card-section>
          <q-card-section>
            <q-form
              @submit="login"
              @reset="onReset"
              class="q-gutter-md"
            >
              <q-input
                filled
                v-model="email"
                label="Ingresa tu email *"
                hint="Email de ingreso"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Please type something']"
              />
              <q-input
                type="password"
                filled
                v-model="password"
                label="Password *"
                hint="Contraseña "
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Please type something']"
              />

<!--              <q-input-->
<!--                filled-->
<!--                type="number"-->
<!--                v-model="age"-->
<!--                label="Your age *"-->
<!--                lazy-rules-->
<!--                :rules="[-->
<!--          val => val !== null && val !== '' || 'Please type your age',-->
<!--          val => val > 0 && val < 100 || 'Please type a real age'-->
<!--        ]"-->
<!--              />-->
<!--              <q-toggle v-model="accept" label="I accept the license and terms" />-->
              <div>
                <q-btn label="Ingresar" type="submit" icon="login" color="positive"/>
                <q-btn label="Reset" type="reset" icon="restart_alt" color="negative" class="q-ml-sm" />
              </div>
            </q-form>

          </q-card-section>
          <q-separator dark />
<!--          <q-card-actions>-->
<!--            <q-btn flat>Action 1</q-btn>-->
<!--            <q-btn flat>Action 2</q-btn>-->
<!--          </q-card-actions>-->
        </q-card>
      </div>
      <div class="col-12 col-md-2"></div>
    </div>
  </q-page>
<!--  <div>-->
<!--    <form class="login" @submit.prevent="login">-->
<!--      <h1>Sign in</h1>-->
<!--      <label>Email</label>-->
<!--      <input required v-model="email" type="email" placeholder="Name"/>-->
<!--      <label>Password</label>-->
<!--      <input required v-model="password" type="password" placeholder="Password"/>-->
<!--      <hr/>-->
<!--      <button type="submit">Login</button>-->
<!--    </form>-->
<!--  </div>-->
</template>

<script>
export default {
  data(){
    return {
      email : "",
      password : ""
    }
  },
  methods: {
    login: function () {
      this.$q.loading.show()
      let email = this.email
      let password = this.password
      this.$store.dispatch('login', { email, password })
        .then(() =>{
          this.$q.loading.hide()
          this.$router.push('/')
        })
        .catch(err => {
          this.$q.loading.hide();
          // console.log(err.response.data)
          this.$q.notify({
            message:err.response.data.res,
            color:'red',
            icon:'error'
          })
        })
    },
    onReset(){
      this.email=null;
      this.password=null;
    }
  },
}
</script>

<style scoped>

</style>
