<template>
  <q-page class="q-px-md q-pt-lg">
    <div class="row">
      <div class="col-12 col-md-6 q-pa-xs ">
        <q-form ref="myForm">
          <div class="row">
            <div class="col-12">
              <q-select :options="tramites" v-model="nrotramite" label="Nro Tramites" />
<!--              {{nrotramite}}-->
            </div>
<!--            <div class="col-6">-->
<!--              <q-input label="No Comprobante:"-->
<!--                       outlined-->
<!--                       type="number"-->
<!--                       v-model="nrocomprobante"-->
<!--                       lazy-rules-->
<!--                       :rules="[-->
<!--                         val => val && val.length > 0 || 'Porfavor llenar este campo',-->
<!--                         val => val >= $store.state.user.unid.inicio && val <= $store.state.user.unid.fin || 'Tiene que estar en el rango de formularios '-->

<!--                         ]"-->
<!--              />-->
<!--            </div>-->
            <div class="col-4">
              <q-input label="CI NIT RUC:"
                       outlined
                       v-model="nrotramite.cliente.ci"
                       lazy-rules
                       disable
                       :rules="[ val => val && val.length > 0 || 'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-select
                :options="['CH','LP','CB','OR','PT','TJ','SC','BE','PD','OTROS']"
                outlined
                label="Expedido"
                v-model="nrotramite.cliente.expedido"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Paterno o razon"
                v-model="nrotramite.cliente.paterno"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Materno"
                v-model="nrotramite.cliente.materno"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Nombres"
                v-model="nrotramite.cliente.nombre"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Padron"
                v-model="nrotramite.cliente.padron"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>

            <div class="col-8">
              <q-input
                outlined
                label="Direccion"
                v-model="nrotramite.cliente.direccion"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>

            <div class="col-4">
              <q-input
                outlined
                label="Numero casa"
                v-model="nrotramite.cliente.numcasa"
                lazy-rules
                type="number"
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
          :options="items"
          label="Selecionar item"
          option-value="id"
          option-label="nombre"
        />
        <q-select
          @input="val=>colocarprecio(val)"
          outlined
          v-model="subitem"
          lazy-rules
          use-input
          :options="subitems"
          @filter="filter"
          label="Selecionar Subitem"
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
            <q-input outlined label="Precio" v-model="precio" />
          </div>
          <div class="col-2">
            <q-input outlined label="Cantidad" v-model="cantidad"/>
          </div>
          <div class="col-1">
            <q-btn color="negative" @click="cantidad--" icon="remove_circle" class="full-width full-height" text-color="white" />
          </div>
          <div class="col-2">
            <q-input outlined label="Subtotal" v-model="subtotal" />
          </div>
          <div class="col-4">
            <q-btn color="positive" @click="agregar" label="Agregar"  class="full-width full-height" text-color="white" />
          </div>
        </div>
      </div>
      <div class="col-12">
        <q-btn label="Reset" icon="delete" color="negative" @click="reset" class="q-mb-xs"/>
        <q-toggle
          v-model="formulario"
          color="positive"
          label="Cobrar fomulario"
          @input="cambio"
        />
      </div>
      <div class="col-12">

        <q-table
          dense
          :columns="columns"
          :data="nrotramite.detalles"
          row-key="nombre"
        >
            <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
                </q-td>
            </template>

        </q-table>
        <div class="bg-info q-ma-xs text-center text-red-7 text-h5 text-weight-bold">Total: {{total}} Bs </div>
        <q-btn @click="crear" icon="add_circle" label="Modificar comprobante" color="positive" class="full-width"></q-btn>
      </div>
    </div>
  </q-page>
</template>
<script>

export default {
  data () {
    return {
      formulario:true,
      tramites:[],
      columns:[
        {name:'coditem',label:'Codigo', align:'left',field:'coditem',sortable:true},
        {name:'referencia',label:'Referencia', align:'left',field:'detalle',sortable:true},
        {name:'precio',label:'Precio', align:'left',field:'precio',    format: val => `${val} Bs`,sortable:true},
        {name:'cantidad',label:'Cantidad', align:'left',field:'cantidad', sortable:true},
        {name:'subtotal',label:'Subtotal', align:'left',field:'subtotal',    format: val => `${val} Bs`,sortable:true},
        {name:'opcion',label:'opcion', align:'left',field:'opcion'},
      ],
      data:[
        {
          coditem:'1220007',
          nombreitem:'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES',
          codsubitem:'122000701',
          nombresubitem:'Venta y reposición de formulario',
          detalle:'Venta y reposicion de formulario',
          precio:2,
          cantidad:1,
          subtotal:2
        }
      ],
      nrotramite: {label:''},
      nrocomprobante:'',
      ci:'',
      detalle:'',
      paterno:'',
      materno:'',
      nombre:'',
      padron:'',
      expedido:'',
      direccion:'',
      numcasa:'',
      item:'',
      subitem:'',
      subitems:[],
      subitems2:[],
      items: [],
      precio:0,
      cantidad:1,
      spinner:false,
    }
  },
  created() {
    //this.numcomprobante()
    // this.mistramites()

    this.$axios.get(process.env.URL+'/item').then(res=>{
      // console.log(res.data);
      this.items=[];
      res.data.forEach(r=>{
        this.items.push({id:r.id,nombre:r.nombre+' '+r.codigo,codigo:r.codigo,nombre2:r.nombre})
      });
      // this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
    })
  },
  methods: {
    delRow(props){
      // console.log(props);
      this.nrotramite.detalles.splice(props.rowIndex,1)
    },
    cargar(){
      // console.log(this.nrotramite)
      //return false;
      this.$axios.post(process.env.URL+'/modcomp/'+this.nrotramite.value).then(res=>{
        // console.log(res.data);
          this.padron=res.data[0].padron;
          //this.total=res.data[0].total;
          this.ci=res.data[0].cliente.ci;
          this.paterno=res.data[0].cliente.paterno;
          this.materno=res.data[0].cliente.materno;
          this.nombre=res.data[0].cliente.nombre;
          this.expedido=res.data[0].cliente.expedido;
          this.direccion=res.data[0].cliente.direccion;
          this.numcasa=res.data[0].cliente.numcasa;
          this.data=[];
          res.data[0].detalles.forEach(element => {
              this.data.push({
                coditem:element.coditem,
                nombreitem:element.nombreitem,
                codsubitem:element.codsubitem,
                nombresubitem:element.nombresubitem,
                detalle:element.detalle,
                precio:element.precio,
                cantidad:element.cantidad,
                subtotal:element.subtotal
              });
          });
      })
      },
    mistramites(){
      this.tramites=[];
      this.$axios.post(process.env.URL+'/mistramites').then(res=>{
        // console.log(res.data)
        this.tramites=[]
        if (res.data.length>0)
        res.data.forEach(e => {
          // console.log(e)
          let j=e
          j.label=e.nrotramite+' '+e.cliente.paterno+' '+e.cliente.materno+' '+e.cliente.nombre
          // this.tramites.push({label:e.nrotramite,value:e.id});
          this.tramites.push(j)
        });
        if(res.data.length>0){
          this.nrotramite=this.tramites[0];
        }else{

        }

        // this.cargar();
         //this.items=[];
        // res.data.forEach(r=>{
        //   this.items.push({id:r.id,nombre:r.nombre+' '+r.codigo,codigo:r.codigo,nombre2:r.nombre})
        // });
      })
    },
    filter(val, update){
      if (val === '') {
        update(() => {
          this.subitems = this.subitems2

          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.subitems = this.subitems2.filter(v => v.nombre.toLowerCase().indexOf(needle) > -1)
      })
    },
    cambio() {
      // console.log(this.formulario)
      if (this.formulario){
        this.reset()
      }else{
        this.data=[]
      }
    },

    crear(){
      if (this.nrotramite.cliente.ci==''){
        this.$q.dialog({
          title:'Falta colocar carnet de identidad'
        })
        return false
      }
      if (this.nrotramite.detalles==''){
        this.$q.dialog({
          title:'Falta colocar detalle'
        })
        return false
      }
      if (this.nrotramite.value==''){
        this.$q.dialog({
          title:'Falta numero de tramite'
        })
        return false
      }
      this.$q.dialog({
        message:'Seguro de Modificar?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=>{
        // console.log('ok')
        this.$q.loading.show()
        this.nrotramite.total=this.total;
        this.$axios.post(process.env.URL+'/modcomprobante',this.nrotramite).then((res)=>{
          // console.log(res.data)

          //this.numcomprobante()
          this.$q.loading.hide();
          this.$q.dialog({
            title:'Correctamente ',
            message:'Modificado!!!'
          });
        }).catch(err=>{
          // console.log(err.response);
          this.$q.loading.hide();
          this.$q.notify({
            title:'Error ',
            message:err.response.data.message,
            color:'red',
            icon:'error'
          });
        })
      })

    },
    reset(){
      this.mireset();
    },
    mireset(){
      this.nrotramite.detalles=[
        {
          coditem:'1220007',
          nombreitem:'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES',
          codsubitem:'122000701',
          nombresubitem:'Venta y reposición de formulario',
          detalle:'Venta y reposicion de formulario',
          precio:2,
          cantidad:1,
          subtotal:2
        }
      ]
    },
    agregar(){
      if (this.subitem==''){
        this.$q.dialog({
          dark: true,
          title: 'Error',
          message: 'Debes selecionar subitem',
          icon:'error'
        })
            .onOk(() => {
          // console.log('OK')
        })
            .onCancel(() => {
          // console.log('Cancel')
        })
            .onDismiss(() => {
          // console.log('I am triggered on both OK and Cancel')
        })
        return false;
      }
      if (this.nrotramite.detalles==''){
        this.$q.dialog({
          dark: true,
          title: 'Error',
          message: 'Debes colocar detalle',
          icon:'error'
        })
        return false;
      }
      this.nrotramite.detalles.push({
        coditem:this.item.codigo,
        nombreitem:this.item.nombre2,
        codsubitem:this.subitem.codigo,
        nombresubitem:this.subitem.nombre2,
        detalle:this.detalle,
        precio:this.precio,
        cantidad:this.cantidad,
        subtotal:this.subtotal
      })
      // this.detalle=''
    },
    colocarprecio(val){
      // console.log(this.subitem)
      this.precio=this.subitem.monto;
      this.detalle=''
    },
    buscarsubitems(){
      // console.log('a');
      // console.log(this.item);
      this.$q.loading.show()
      this.subitems=[]
      this.subitems2=[]
      this.subitem=''
      this.detalle=''
      this.$axios.get(process.env.URL+'/subitem/'+this.item.id).then(res=>{
        // console.log(res.data);
        this.$q.loading.hide()
        res.data.forEach(r=>{
          this.subitems.push({id:r.id,nombre:r.nombre+' '+ Math.round( r.monto)+'Bs',monto:Math.round(r.monto),codigo:r.codigo,nombre2:r.nombre})
          this.subitems2.push({id:r.id,nombre:r.nombre+' '+ Math.round( r.monto)+'Bs',monto:Math.round(r.monto),codigo:r.codigo,nombre2:r.nombre})
        });
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
    },
    total(){
      let total=0
      this.nrotramite.detalles.forEach(r=>{
        total+=r.subtotal;
      })
      return total
    }
  }
}
</script>

<style scoped>

</style>
