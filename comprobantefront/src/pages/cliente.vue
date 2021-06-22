<template>
  <q-page class="q-pt-md q-pl-lg">
    <div class="row">
      <div class="col-12 col-sm-6">
          <q-input
          type="text"
          v-model="dato.ci"
          @keydown.enter.prevent="llenar"
          :error="!valido"
          label="Cedula Identidad"
          />
<template v-if="valor">
          <q-input
          type="text"
          v-model="dato.nombre"
          label="Nombre"
          />

            
          <q-input
          type="text"
          v-model="dato.paterno"
          label="Paterno"
          />

          
         <q-input
          type="text"
          v-model="dato.materno"
          label="Materno"
          /> 

         <q-input
          type="text"
          v-model="dato.casada"
          label="Ap Casada"
          />

           <q-input
          type="text"
          v-model="dato.direccion"
          label="Direccion"
          />
          
        <q-input
          type="text"
          v-model="dato.numcasa"
          label="Numero Casa"
          />
        
        <q-input
          type="text"
          v-model="dato.telefono"
          label="Materno"
          />

       </template>
      </div>
      <div class="col-12 col-sm-6"></div>
    </div>

  </q-page>
</template>

<script>
//const stringOptions = [
  //'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
//]

export default {
  data () {
    return {
      model: null,
      options: [],
      cadena:[],
      dato:[],
      valido:false,
      aux:'',
      valor:false,
    }
  },
  created() {
    this.$axios.get(process.env.URL+'/cliente').then(res=>{
      console.log(res.data)
    });
  },
  methods: {
    
    llenar(){
        this.datoscliente(this.cl);
        this.valor=true;
    },
    datoscliente(ci){
        this.cadena=[];
        this.$axios.get(process.env.URL+'/list/'+this.dato.ci).then(res=>{
        console.log(res.data)
        if(res.data.length==1) {this.valido=true; 
            this.dato=res.data[0];
        }else {this.valido=false;
            this.aux=this.dato.ci;
            this.dato=[];
            this.dato.ci=this.aux;
        
        }
        res.data.forEach(row => {
            this.cadena.push(row.ci);
        });
        this.options=this.cadena;
    });
    }
  }
}
</script>

<style scoped>

</style>
