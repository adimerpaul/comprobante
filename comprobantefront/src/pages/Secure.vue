<template>
  <q-page class="q-px-md q-pt-lg">
    <div class="row">
      <div class="col-12 col-md-6 q-pa-xs ">
        <q-form
        >
          <div class="row">
            <div class="col-6">
              <q-input label="No Tramite:"
                       outlined
                       v-model="nrotramite"
                       lazy-rules
                       :rules="[ val => val && val.length > 0 || 'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-6">
              <q-input label="No Comprobante:"
                       outlined
                       v-model="nrocomprobante"
                       lazy-rules
                       :rules="[ val => val && val.length > 0 || 'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-6">
              <q-input label="CI NIT RUC:"
                       outlined
                       v-model="ci"
                       @keyup.prevent="buscarcliente"
                       lazy-rules
                       :rules="[ val => val && val.length > 0 || 'Porfavor llenar este campo']"
              />
              <i v-if="spinner" class="fa fa-spinner"></i>
            </div>
            <div class="col-6">
              <q-input
                outlined
                label="Paterno o razon"
                v-model="paterno"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-6">
              <q-input
                outlined
                label="Materno"
                v-model="materno"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-6">
              <q-input
                outlined
                label="Nombres"
                v-model="nombre"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-6">
              <q-input
                outlined
                label="Padron"
                v-model="padron"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12 col-md-6 q-pa-xs">
        <q-select
          @input="buscarsubitems()"
          outlined
          v-model="item"
          lazy-rules
          :options="items" label="Selecionar item"
          option-value="id"
          option-label="nombre"
        />
        <q-select
          @input="val=>colocarprecio(val)"
          outlined
          v-model="subitem"
          lazy-rules
          :options="subitems" label="Selecionar Subitem"
          option-value="id"
          option-label="nombre"
        />
        <q-input
          outlined
          label="Detalle"
          v-model="detalle"
          lazy-rules
          :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
        />
        <div class="row">
          <div class="col-1">
            <q-btn color="positive" @click="cantidad++" icon="add_circle" class="full-width full-height" text-color="white" />
          </div>
          <div class="col-2">
            <q-input outlined label="Precio" v-model="precio"/>
          </div>
          <div class="col-2">
            <q-input outlined label="Cantidad" v-model="cantidad"/>
          </div>
          <div class="col-1">
            <q-btn color="negative" @click="cantidad--" icon="remove_circle" class="full-width full-height" text-color="white" />
          </div>
          <div class="col-2">
            <q-input outlined label="Subtotal" v-model="subtotal"/>
          </div>
          <div class="col-4">
            <q-btn color="positive" @click="cantidad++" label="Agregar"  class="full-width full-height" text-color="white" />
          </div>
        </div>
      </div>
      <div class="col-12">
        <q-table
          title="Pagos"
          dense

        >
        </q-table>
      </div>
    </div>
  </q-page>
</template>

<script>

export default {
  data () {
    return {
      columns:[
        
      ],
      nrotramite: '',
      nrocomprobante:'',
      ci:'',
      detalle:'',
      paterno:'',
      materno:'',
      nombre:'',
      padron:'',
      item:'',
      subitem:'',
      subitems:[],
      items: [],
      precio:0,
      cantidad:1,
      spinner:false,
    }
  },
  created() {
    this.$axios.get(process.env.URL+'/comprobante/1').then(res=>{
      // console.log(res.data);
      this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
    })
    this.$axios.get(process.env.URL+'/item').then(res=>{
      console.log(res.data);
      this.items=[];
      res.data.forEach(r=>{
        this.items.push({id:r.id,nombre:r.nombre+' '+r.codigo})
      });
      // this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
    })
  },
  methods: {
    colocarprecio(val){
      // console.log(this.subitem)
      this.precio=this.subitem.monto;
    },
    buscarsubitems(){
      // console.log('a');
      // console.log(this.item);
      this.subitems=[];
      this.$axios.get(process.env.URL+'/subitem/'+this.item.id).then(res=>{
        // console.log(res.data);
        res.data.forEach(r=>{
          this.subitems.push({id:r.id,nombre:r.nombre+' '+r.monto+'Bs',monto:r.monto})
        });
      })
    },
    buscarcliente(){
      // console.log(this.ci)
      this.paterno=''
      this.materno=''
      this.nombre=''
      this.paterno=''
      this.padron=''
      this.spinner=true
      this.$axios.get(process.env.URL+'/cliente/'+this.ci).then(res=>{
        // console.log(res.data);
        this.spinner=false;
        if (res.data.length>0){
          this.paterno=res.data[0].paterno
          this.materno=res.data[0].materno
          this.nombre=res.data[0].nombre
          this.padron=res.data[0].padron
          this.spinner=false;
        }
      })
    },
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
    subtotal(){
      return this.precio*this.cantidad
    }
  }
}
</script>

<style scoped>

</style>
