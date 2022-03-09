<template>
  <q-page class="q-px-md q-pt-lg">
    <div class="row">
      <div class="col-12 col-md-6 q-pa-xs ">
        <q-form ref="myForm">
          <div class="row">
            <div class="col-12">
              <q-input label="No Tramite:"
                       outlined
                       v-model="nrotramite"
                       lazy-rules
                       :rules="[
                         val => val && val.length > 0 || 'Porfavor llenar este campo',
                         ]"
                       disable
              />
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
                       v-model="ci"
                       @input="buscarcliente"
                       lazy-rules
                       :rules="[ val => val && val.length > 0 || 'Porfavor llenar este campo']"
              />
              <i v-if="spinner" class="fa fa-spinner"></i>
            </div>
            <div class="col-4">
              <q-select
                :options="['CH','LP','CB','OR','PT','TJ','SC','BE','PD','OTROS']"
                outlined
                label="Expedido"
                v-model="expedido"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Paterno o razon"
                v-model="paterno"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Materno"
                v-model="materno"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Nombres"
                v-model="nombre"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
            <div class="col-4">
              <q-input
                outlined
                label="Padron"
                v-model="padron"
                lazy-rules
                style="text-transform: uppercase"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>

            <div class="col-8">
              <q-input
                outlined
                label="Direccion"
                v-model="direccion"
                lazy-rules
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>

            <div class="col-4">
              <q-input
                outlined
                label="Numero casa"
                v-model="numcasa"
                lazy-rules
                type="number"
                :rules="[val=>val && val.length>0||'Porfavor llenar este campo']"
              />
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12 col-md-6 q-pa-xs">
        <div class="row">
          <div class="col-11">
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
          </div>
          <div class="col-1 flex flex-center">
            <q-btn size="xs" icon="refresh" color="primary" @click="misitems" />
          </div>
        </div>
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
            <q-btn color="positive" @click="agregar" label="Agregar"  icon="add_circle" class="full-width full-height" text-color="white" />
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
          :data="data"
          row-key="nombre"
        >
          <template v-slot:body-cell-precio="props">
            <q-td :props="props">
              <q-input style="width: 4em" outlined dense v-model="props.row.precio" />
            </q-td>
          </template>
          <template v-slot:body-cell-cantidad="props">
            <q-td :props="props">
              <q-input style="width: 4em" outlined dense v-model="props.row.cantidad" />
            </q-td>
          </template>
          <template v-slot:body-cell-subtotal="props">
            <q-td :props="props">
              {{props.row.precio*props.row.cantidad}}
            </q-td>
          </template>
        </q-table>
        <div class="bg-info q-ma-xs text-center text-red-7 text-h5 text-weight-bold">Total: {{total}} Bs </div>
        <q-btn @click="crear" icon="add_circle" label="Crear comprobante" color="positive" class="full-width"></q-btn>
      </div>
    </div>
  </q-page>
</template>
<script>

export default {
  data () {
    return {
      formulario:true,
      columns:[
        {name:'coditem',label:'Codigo', align:'left',field:'coditem',sortable:true},
        {name:'referencia',label:'Referencia', align:'left',field:'detalle',sortable:true},
        {name:'precio',label:'Precio', align:'left',field:'precio',    format: val => `${val} Bs`,sortable:true},
        {name:'cantidad',label:'Cantidad', align:'left',field:'cantidad', sortable:true},
        {name:'subtotal',label:'Subtotal', align:'left',field:'subtotal',    format: val => `${val} Bs`,sortable:true},
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
      nrotramite: '',
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
    this.numcomprobante()
    this.misitems()
  },
  methods: {
    misitems(){
      this.$axios.get(process.env.URL+'/item').then(res=>{
        // console.log(res.data)
        // return false
        // return false
        this.items=[]
        res.data.forEach(r=>{
          this.items.push({id:r.id,nombre:r.nombre+' '+r.codigo,codigo:r.codigo,nombre2:r.nombre})
        })
        // this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
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
    numcomprobante(){
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/comprobante/1').then(res=>{
        // console.log(res.data);
        this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
        this.$q.loading.hide()
      })
    },
    crear(){
      if (this.ci==''){
        this.$q.dialog({
          title:'Falta colocar carnet de identidad'
        })
        return false
      }
      if (this.detalle==''){
        this.$q.dialog({
          title:'Falta colocar detalle'
        })
        return false
      }
      if (this.nrotramite==''){
        this.$q.dialog({
          title:'Falta numero de tramite'
        })
        return false
      }
      this.$q.dialog({
        message:'Seguro de crear?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=>{
        // console.log('ok')
        this.$q.loading.show()
        this.data.forEach(r=>{
          this.data.subtotal=this.data.precio*this.data.cantidad
        })
        this.$axios.post(process.env.URL+'/comprobante',{
          nrotramite:this.nrotramite,
          padron:this.padron,
          total:this.total,
          ci:this.ci,
          paterno:this.paterno,
          materno:this.materno,
          nombre:this.nombre,
          expedido:this.expedido,
          direccion:this.direccion,
          numcasa:this.numcasa,
          data:this.data,
        }).then((res)=>{
          // console.log(res.data)
          this.$refs.myForm.resetValidation()
          this.numcomprobante()
          this.item=''
          this.subitem=''
          this.$q.loading.hide()
          this.mireset()
          this.detalle=''
          this.ci='';
          this.paterno='';
          this.materno='';
          this.nombre='';
          this.padron='';
          this.expedido='';
          this.direccion='';
          this.numcasa='';
          // this.$q.dialog({
          //   title:'Correctamente ',
          //   message:'Creado!!!'
          // });
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
      this.data=[
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
      if (this.detalle==''){
        this.$q.dialog({
          dark: true,
          title: 'Error',
          message: 'Debes colocar detalle',
          icon:'error'
        })
        return false;
      }
      this.data.push({
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
      this.detalle=this.subitem.nombre;
    },
    buscarsubitems(){
      // console.log(this.item);
      // return false
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
    buscarcliente(){
      // console.log(this.ci)
      this.paterno=''
      this.materno=''
      this.nombre=''
      this.paterno=''
      this.padron=''
      this.expedido=''
      this.direccion=''
      this.numcasa=''
      this.spinner=true
      if (this.ci!='')
      this.$axios.get(process.env.URL+'/cliente/'+this.ci).then(res=>{
        // console.log(res.data);
        this.spinner=false;
        if (res.data.length>0){
          this.paterno=res.data[0].paterno
          this.materno=res.data[0].materno
          this.nombre=res.data[0].nombre
          this.padron=res.data[0].padron
          this.expedido=res.data[0].expedido
          this.direccion=res.data[0].direccion
          this.numcasa=res.data[0].numcasa
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
    },
    total(){
      let total=0
      this.data.forEach(r=>{
        total+=r.subtotal;
      })
      return total
    }
  }
}
</script>

<style scoped>

</style>
