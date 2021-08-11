<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12">
        <q-form @submit.prevent="subir">
          <div class="row">
            <div class="col-6 q-pa-xs">
              <q-input
                @change="onFileChange"
                filled
                type="file"
                required
                accept=".csv"
              />
            </div>
            <div class="col-6 q-pa-xs">
              <q-btn color="primary" type="submit" icon="send"  label="Subir archivo" class="full-width full-height" />
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12">
      <q-form @submit.prevent="historial">
        <div class="row">
          <div class="col-4 q-pa-xs">
            <q-input label="fecha de cobro" outlined type="date" v-model="fecha"/>
          </div>
          <div class="col-4 q-pa-xs">
    <!--        <q-input label="fecha de cobro" outlined type="date" v-model="fecha"/>-->
            <q-select v-model="unidad" outlined :options="unidades" option-label="nombre" option-value="id" required/>
          </div>
          <div class="col-4 q-pa-xs">
            <q-btn color="primary" type="submit" icon="search"  label="Buscar" class="full-width full-height" />
          </div>
        </div>
      </q-form>
      </div>
      <div class="col-12 q-pt-md">
        <q-table
        title="Historial de cobros"
        :columns="pcolumns"
        :data="pagos"
        />
      </div>
      <div class="col-12 q-pt-md">
        <q-btn color="info" :label="'Total '+ total +'BS'" class="full-width text-red text-bold"/>
<!--        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>-->
      </div>
    </div>
  </q-page>
</template>
<script>
import { jsPDF } from "jspdf";
import {date} from 'quasar'
export default {
  data() {
    return {
      model:'',
      file:null,
      unidad:'',
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      options: [
        // 'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
      ],
      nrocomprobante:'',
      columns:[
        {name:'codsubitem',label:'Codigo', align:'left',field:'codsubitem',sortable:true},
        {name:'referencia',label:'Referencia', align:'left',field:'detalle',sortable:true},
        {name:'precio',label:'Precio', align:'left',field:'precio',    format: val => `${val} Bs`,sortable:true},
        {name:'cantidad',label:'Cantidad', align:'left',field:'cantidad',sortable:true},
        {name:'subtotal',label:'Subtotal', align:'left',field:'subtotal',    format: val => `${val} Bs`,sortable:true},
      ],
      pcolumns:[
        {name:'nrocomprobante',label:'N comprobante', align:'left',field:'nrocomprobante',sortable:true},
        {name:'nrotramite',label:'N tramite', align:'left',field:'nrotramite',sortable:true},
        {name:'unidad',label:'Unidad', align:'left',field:'unidad',sortable:true},
        {name:'cliente',label:'Contribuyente', align:'left',field:'cliente', sortable:true},
        {name:'ci',label:'Carnet identidad', align:'left',field:'ci',sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero',sortable:true},
      ],
      comprobantes:[],
      pagos:[],
      unidades:[]
    };
  },
  created() {
    // this.miscomprobante()
    // this.mispagos()
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      this.unidades=res.data
      // console.log(res.data)
    })
    // this.$q.notify({
    //   message: 'Jim pinged you.',
    //   color: 'purple'
    // })
    // this.$q.loading.hide()
  },
  methods: {
    onFileChange(e) {
//console.log(e.target.files[0]);
//       this.filename = "Selected File: " + e.target.files[0].name;
      this.file = e.target.files[0];
    },
    subir(){
      this.$q.loading.show()
      let formData = new FormData()
      formData.append('file', this.file)

      const config = {
        url: '/subir',
        method: 'post',
        baseURL: process.env.URL,
        data:formData,
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          "contentType" : 'multipart/form-data',
        }
      };
      let cm=this
      this.$axios
        .request(config)
        .then(function(response) {
          // handle success
          cm.$q.notify({
            message:'Cargado los datos correctamente',
            icon:'info',
            color:'positive'
          })
          cm.$q.loading.hide()
          // console.log(response.data);
        })
        .catch(function(error) {
          // handle error
          // console.log(error.response.data);
          cm.$q.notify({
            message:error.response.data.res,
            icon:'error',
            color:'red'
          })
          cm.$q.loading.hide()
        })
        .finally(function() {
          // always executed
        });

      // this.$axios.post(process.env.URL+'/subir',formData).then(res=>{
      //   console.log(res.data)
      // }).catch(err=>{
      //   console.log(err.response)
      //   this.$q.notify({
      //     message:err.response.data.message,
      //     color:'red',
      //     icon:'error'
      //   })
      // })

    },
    historial(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/historial',{fecha:this.fecha,unid_id:this.unidad.id}).then(res=>{
        console.log(res.data)
        this.$q.loading.hide()
        this.pagos=[]
        res.data.forEach(r=>{
          this.pagos.push({
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            cajero:r.cajero,
            ci:r.cliente.ci,
            total:r.total,
            unidad:r.unid.nombre,
          })
        })
      }).catch(err=>{
        // console.log(err.response)
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    imprimir(){
      function header(fecha){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
        doc.text(5, 1.5, 'REGULACION URBANA DE '+fecha)
        doc.text(1, 3, 'Nº COMPROBANTE')
        doc.text(4, 3, 'Nº TRAMITE')
        doc.text(7, 3, 'CONTRIBUYENTE')
        doc.text(12, 3, 'CI / RUN / RUC')
        doc.text(16, 3, 'MONTO BS.')
        doc.text(18, 3, 'CAJERO')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.fecha)
      // let xx=x
      // let yy=y
      let y=0
      this.pagos.forEach(r=>{
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.nrocomprobante)
        doc.text(4, y+3, r.nrotramite)
        doc.text(7, y+3, r.cliente)
        doc.text(12, y+3, r.ci)
        doc.text(16, y+3, r.total)
        doc.text(18, y+3, r.cajero )
        if (y+3>25){
          doc.addPage();
          header(this.fecha)
          y=0
        }
      })
      doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4, this.total+'Bs')


      doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
    },
    // miscomprobante(){
    //   this.$axios.post(process.env.URL+'/buscarimpreso').then(res=>{
    //     this.comprobantes=[]
    //     res.data.forEach(r=>{
    //       this.comprobantes.push({
    //         label:r.varios+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre+' '+r.nrocomprobante,
    //         id:r.id,
    //         detalles:r.detalles,
    //         nombrecompleto:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
    //         padron:r.padron,
    //         ci:r.cliente.ci,
    //         total:r.total,
    //       })
    //     })
    //   })
    // },
    mispagos(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/mispagos',{fecha:this.fecha}).then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.pagos=[]
        res.data.forEach(r=>{
          this.pagos.push({
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            cajero:r.cajero,
            ci:r.cliente.ci,
            total:r.total,
          })
        })
      }).catch(err=>{
        // console.log(err.response)
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    cancelar(){
      // if (this.nrocomprobante==''){
      //   this.$q.dialog({
      //     title:'Falta numero comprobante'
      //   })
      //   return false;
      // }
      if (this.model==''){
        this.$q.dialog({
          title:'Seleccione comprobante'
        })
        return false;
      }
      // console.log(      parseInt(this.nrocomprobante)+'---'+this.$store.state.user.unid.fin)
      if ( parseInt(this.nrocomprobante)< parseInt(this.$store.state.user.unid.inicio) || parseInt(this.nrocomprobante)> parseInt(this.$store.state.user.unid.fin)){
        this.$q.dialog({
          title:'Rango de comprobantes no permitidos'
        })
        return false;
      }
      // return  false;
      this.$q.loading.show()
      this.$axios.put(process.env.URL+'/pago/'+this.model.id,{nrocomprobante:this.nrocomprobante})
        .then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.model=''
        this.$q.dialog({
          title:'Cobro exitoso'
        })
        this.miscomprobante()
          this.mispagos()
        // let dat=res.data[0];
        // var doc = new jsPDF('p','cm','letter')
        // console.log(dat);
        // doc.setFont("courier");
        // doc.setFontSize(9);
        // var x=0,y=0;
        // doc.text(x+14.5, y+3.7, 'TRAMITE N '+dat.nrotramite.toString());
        // doc.text(x+9.5, y+6, dat.cliente.paterno.toString()+' '+dat.cliente.materno.toString()+' '+dat.cliente.nombre.toString());
        // doc.text(x+9.5, y+7.5, dat.cliente.direccion.toString());
        // doc.text(x+14, y+7.5, dat.cliente.numcasa.toString());
        // doc.text(x+15.6, y+7.5, dat.cliente.ci.toString()+' '+dat.cliente.expedido.toString());
        // doc.text(x+18, y+7.5, dat.cliente.telefono.toString());
        // doc.text(x+3, y+9, dat.varios.toString());
        // doc.text(x+9.5, y+9, 'OR '+ dat.fechapago.toString());
        // let xx=x+1.2
        // let yy=x+9.7
        // dat.detalles.forEach(r=>{
        //   doc.text(xx, yy, r.codsubitem.toString());
        //   doc.text(xx+2.5, yy, r.nombreitem.toString());
        //   // doc.text(xx, yy, r.codsubitem.toString());
        //   doc.text(xx+14.5, yy, r.subtotal.toString());
        //   doc.text(xx+2.5, yy+0.5, r.detalle.toString());
        //   yy++
        //   // console.log(r)
        // })
        //
        // doc.text(x+15.5, y+18, dat.total.toString()+' Bs');
        // doc.text(x+2, y+16, dat.literal.toString()+' 00/100Bs');
        // doc.text(x+8.7, y+20.5, dat.controlinterno.toString());
        // doc.save("Comprobante.pdf");
      }).catch(err=>{
        // console.log(err.response.data)
        this.$q.notify({
          // title:'Error',
          icon:'error',
          color:'red',
          message:err.response.data.message
        })
        this.$q.loading.hide()
      })
    },
      filterFn (val, update) {
        if (val === '') {
          update(() => {
            this.options = this.comprobantes

            // with Quasar v1.7.4+
            // here you have access to "ref" which
            // is the Vue reference of the QSelect
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.options = this.comprobantes.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      },
  },
  computed:{
    total() {
      let total=0
      this.pagos.forEach(r=>{
        total+=parseFloat(r.total);
      })
      return total;
    }
  }
};
</script>

<style scoped></style>
