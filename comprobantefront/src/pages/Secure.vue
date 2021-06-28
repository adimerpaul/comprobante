<template>
  <q-page class="q-px-md q-pt-lg">
    <div class="row">
      <div class="col-6">
        <q-form
        >
          <q-input label="No Tramite:"
                   filled
                   v-model="nrotramite"
                   lazy-rules
                   :rules="[ val => val && val.length > 0 || 'Please type something']"
          />
          <q-input label="No Comprobante:"
                   filled
                   v-model="nrocomprobante"
                   lazy-rules
                   :rules="[ val => val && val.length > 0 || 'Please type something']"
          />
          <q-input label="CI NIT RUC:"
                   filled
                   v-model="ci"
                   lazy-rules
                   :rules="[ val => val && val.length > 0 || 'Please type something']"
          />
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>

export default {
  data () {
    return {
      nrotramite: '',
      nrocomprobante:'',
      ci:''
    }
  },
  created() {
    this.$axios.get(process.env.URL+'/comprobante/1').then(res=>{
      // console.log(res.data);
      this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
    })
  },
  methods: {
    zfill(number, width){
      // return 'a';
      var numberOutput = Math.abs(number); /* Valor absoluto del número */
      var length = number.toString().length; /* Largo del número */
      var zero = "0"; /* String de cero */

      if (width <= length) {
        if (number < 0) {
          return ("-" + numberOutput.toString());
        } else {
          return numberOutput.toString();
        }
      } else {
        if (number < 0) {
          return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
        } else {
          return ((zero.repeat(width - length)) + numberOutput.toString());
        }
      }
    }
  },
  computed:{

  }
}
</script>

<style scoped>

</style>
