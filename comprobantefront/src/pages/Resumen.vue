<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12">
        <div class="text-h5 bg-amber-14 text-center text-white" >Reporte por unidad Pagado</div>
      </div>
      <div class="col-12">
        <q-form @submit="imprimir">
          <div class="row">
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Inicial"
                v-model="fecha.inicio"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val<=this.fecha.fin || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Final"
                v-model="fecha.fin"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val>=this.fecha.inicio || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 flex flex-center">
              <q-btn class="" type="submit" color="secondary"  icon="print" label="Imprimir"/>
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12">
        <div class="text-h5 bg-blue-14 text-center text-white" >Reporte por Unidad de Impresos</div>
      </div>
      <div class="col-12">
        <q-form @submit="impresosunidad">
          <div class="row">
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Inicial"
                v-model="fecha.inicio"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val<=this.fecha.fin || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Final"
                v-model="fecha.fin"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val>=this.fecha.inicio || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 flex flex-center">
              <q-btn class="" type="submit" color="secondary"  icon="print" label="Imprimir"/>
            </div>
          </div>
        </q-form>
      </div>
      
      <div class="col-12">
        <div class="text-h5 bg-green-14 text-center text-white" >Reporte por Unidad de Creado</div>
      </div>
      <div class="col-12">
        <q-form @submit="impresocreado">
          <div class="row">
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Inicial"
                v-model="fecha.inicio"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val<=this.fecha.fin || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 q-pa-xs">
              <q-input
                outlined
                type="date"
                label="Fecha Final"
                v-model="fecha.fin"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val>=this.fecha.inicio || 'Ingrese la fecha correcta']"
              />
            </div>
            <div class="col-12 col-sm-4 flex flex-center">
              <q-btn class="" type="submit" color="secondary"  icon="print" label="Imprimir"/>
            </div>
          </div>
        </q-form>
      </div>

    </div>
  </q-page>
</template>

<script>
//const stringOptions = [
//'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
//]
import { jsPDF } from "jspdf";
import {date} from 'quasar'
export default {
  data() {
    return {
      model:'',
      un:'',
      opunid:[],
      literal:'',
      fecha:{"inicio":date.formatDate(Date.now(),'YYYY-MM-DD'),"fin":date.formatDate(Date.now(),'YYYY-MM-DD')},
      ahora:date.formatDate(Date.now(),'YYYY-MM-DD'),
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
        {name:'nrocomprobante',label:'Numero comprobante', align:'left',field:'nrocomprobante',sortable:true},
        {name:'nrotramite',label:'Numero tramite', align:'left',field:'nrotramite',sortable:true},
        {name:'cliente',label:'Contribuyente', align:'left',field:'cliente', sortable:true},
        {name:'ci',label:'Carnet identidad', align:'left',field:'ci',sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero',sortable:true},
      ],
      comprobantes:[],
      pagos:[],
    };
  },
  created() {
    // this.unidades();
    // this.mispagos();
  },
  methods: {
    imprimir(){
      this.$q.loading.show()
      function header(un,fec1,fec2,fec3){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(3, 1, 'GOBIERNO AUTONOMO MUNICIPAL DE ORURO')
        doc.text(3, 1.5, '  JEFATURA DE RECAUDACIONES')
        doc.text(15, 1.5, 'Fecha de Proceso '+fec1)
        doc.text(8, 2.5, 'RESUMEN DIARIO DE INGRESOS CAJA DE LA UNIDAD DE')
        doc.text(8, 3, un + ' DEL ' + fec2 +' AL '+ fec3)
        doc.setFontSize(6);
        doc.text(.5, 4, 'FECHA DE PAGO')
        doc.text(3, 4, 'Nº COMPROBANTE')
        doc.text(5, 4, 'Nº TRAMITE')
        doc.text(7, 4, 'CONTRIBUYENTE')
        doc.text(16, 4, 'CI/RUN/RUC')
        doc.text(18, 4, 'MONTO BS.')
        doc.text(20, 4, 'USUARIO')
        doc.setFont(undefined,'normal')
        doc.setFontSize(9);
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
      // let xx=x
      // let yy=y
        this.$axios.post(process.env.URL+'/misimpreso',this.fecha).then(res=>{

        console.log(res.data)
        this.pagos=[];
        res.data.forEach(r=>{
          this.pagos.push({
            fechaimpreso:r.fechaimpreso,
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            usuarioimp:r.cajero.codigo,
            ci:r.cliente.ci,
            total:r.total,
          });
      })

          doc.setFontSize(6);
      let y=0;
      this.pagos.forEach(r=>{
        // xx+=0.5
               y+=0.5
        doc.text(1, y+4, r.fechaimpreso)
        doc.text(3, y+4, r.nrocomprobante)
        doc.text(5, y+4, r.nrotramite)
        doc.text(7, y+4, r.cliente)
        doc.text(16, y+4, r.ci)
        doc.text(18, y+4, r.total)
        doc.text(20, y+4, r.usuarioimp )
        if (y+4>25){
          doc.addPage();
          header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
          y=0
        }

        })
        var c = this.total.toString().split(".")
        this.$axios.post(process.env.URL+'/convertirletra/'+c[0]).then(res=>{
          console.log(res.data);
          this.literal=res.data;
                doc.setFontSize(9);
      if(c[1] == null || c[1]=='')
      c[1]=0;
      doc.text(1, y+4.5, 'SON: '+this.literal+' '+c[1]+'/100 Bs')
      doc.text(12, y+4.5, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4.5, this.total+'Bs')
      doc.setFontSize(6);
      y+=4.5;
      doc.text(1, y+4,   '____________________                     _____________________________                    ________________________ ')
      doc.text(1, y+4.5, 'FIRMA Y SELLO CAJERO                     FIRMA Y SELLO CONTROL INTERNO                    FIRMA Y SELLO LIQUIDADOR')
      // doc.save("Impreso"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
          window.open(doc.output('bloburl'), '_blank');
          this.$q.loading.hide()
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

    impresosunidad(){
      this.$q.loading.show()
      function header(un,fec1,fec2,fec3){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(3, 1, 'GOBIERNO AUTONOMO MUNICIPAL DE ORURO')
        doc.text(3, 1.5, '  JEFATURA DE RECAUDACIONES')
        doc.text(15, 1.5, 'Fecha de Proceso '+fec1)
        doc.text(8, 2.5, 'RESUMEN DIARIO DE INGRESOS IMPRESOS DE LA UNIDAD DE')
        doc.text(8, 3, un + ' DEL ' + fec2 +' AL '+ fec3)
        doc.setFontSize(6);
        doc.text(.5, 4, 'FECHA DE PAGO')
        doc.text(3, 4, 'Nº COMPROBANTE')
        doc.text(5, 4, 'Nº TRAMITE')
        doc.text(7, 4, 'CONTRIBUYENTE')
        doc.text(15, 4, 'CI/RUN/RUC')
        doc.text(17, 4, 'MONTO BS.')
        doc.text(19, 4, 'USUARIO')
        doc.text(20, 4, 'ESTADO')
        doc.setFont(undefined,'normal')
        doc.setFontSize(9);
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
      // let xx=x
      // let yy=y
      this.$axios.post(process.env.URL+'/impresosunidad',this.fecha).then(res=>{

        // console.log(res.data)
        this.pagos=[];
        res.data.forEach(r=>{
          this.pagos.push({
            fechaimpreso:r.fechaimpreso,
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            usuarioimp:r.cajero.codigo,
            ci:r.cliente.ci,
            total:r.total,
            estado:r.estado,
          });
        })
        doc.setFontSize(6);
        let y=0;
        this.pagos.forEach(r=>{
          // xx+=0.5
          y+=0.5
          doc.text(1, y+4, r.fechaimpreso)
          doc.text(3, y+4, r.nrocomprobante)
          doc.text(5, y+4, r.nrotramite)
          doc.text(7, y+4, r.cliente)
          doc.text(15, y+4, r.ci)
          doc.text(17, y+4, r.total)
          doc.text(19, y+4, r.usuarioimp )
          doc.text(20, y+4, r.estado )
          if (y+4>25){
            doc.addPage();
            header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
            y=0
          }
        })
        var c = this.total.toString().split(".")
        this.$axios.post(process.env.URL+'/convertirletra/'+c[0]).then(res=>{
          console.log(res.data);
          this.literal=res.data;
          doc.setFontSize(9);
          if(c[1] == null || c[1]=='')
            c[1]=0;
          doc.text(1, y+4.5, 'SON: '+this.literal+' '+c[1]+'/100 Bs')
          doc.text(12, y+4.5, 'TOTAL RECAUDADCION: ')
          doc.text(18, y+4.5, this.total+'Bs')
          doc.setFontSize(6);
          y+=4.5;
          doc.text(1, y+4,   '____________________                     _____________________________                    ________________________ ')
          doc.text(1, y+4.5, 'FIRMA Y SELLO CAJERO                     FIRMA Y SELLO CONTROL INTERNO                    FIRMA Y SELLO LIQUIDADOR')
          // doc.save("Impreso"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
          window.open(doc.output('bloburl'), '_blank');
          this.$q.loading.hide()
        })


      }).catch(err=>{
        // console.log(err.response)
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })

    },

    unidades(){
      this.opunid=[];
      this.$axios.get(process.env.URL+'/unid').then(res=>{
          res.data.forEach(element => {
            this.opunid.push({label:element.nombre,value:element.id});

          });
      })

    },


    miscomprobante(){

      this.$axios.post(process.env.URL+'/buscarimpreso2',{unid_id:this.un.value}).then(res=>{
        console.log(res.data);
        this.comprobantes=[]
        res.data.forEach(r=>{
          this.comprobantes.push({
            label:'padron:'+r.varios+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre+' nro:'+r.nrocomprobante,
            id:r.id,
            detalles:r.detalles,
            nombrecompleto:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            padron:r.padron,
            ci:r.cliente.ci,
            total:r.total,
          })
        })
      })
    },
    impresocreado(){
      this.$q.loading.show()
      function header(un,fec1,fec2,fec3){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(3, 1, 'GOBIERNO AUTONOMO MUNICIPAL DE ORURO')
        doc.text(3, 1.5, '  JEFATURA DE RECAUDACIONES')
        doc.text(15, 1.5, 'Fecha de Proceso '+fec1)
        doc.text(8, 2.5, 'RESUMEN DIARIO DE INGRESOS DE LA UNIDAD DE')
        doc.text(8, 3, un + ' DEL ' + fec2 +' AL '+ fec3)
        doc.setFontSize(6);
        doc.text(.5, 4, 'FECHA DE PAGO')
        doc.text(3, 4, 'Nº COMPROBANTE')
        doc.text(5, 4, 'Nº TRAMITE')
        doc.text(7, 4, 'CONTRIBUYENTE')
        doc.text(15, 4, 'CI/RUN/RUC')
        doc.text(17, 4, 'MONTO BS.')
        doc.text(19, 4, 'USUARIO')
        doc.text(20, 4, 'ESTADO')
        doc.setFont(undefined,'normal')
        doc.setFontSize(9);
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
      // let xx=x
      // let yy=y
      this.$axios.post(process.env.URL+'/reporteunidad',this.fecha).then(res=>{

        // console.log(res.data)
        this.pagos=[];
        res.data.forEach(r=>{
          this.pagos.push({
            fechaimpreso:r.fechaimpreso,
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            usuarioimp:r.user.codigo,
            ci:r.cliente.ci,
            total:r.total,
            estado:r.estado,
          });
        })
        doc.setFontSize(6);
        let y=0;
        this.pagos.forEach(r=>{
          // xx+=0.5
          y+=0.5
          doc.text(1, y+4, r.fechaimpreso)
          doc.text(3, y+4, r.nrocomprobante)
          doc.text(5, y+4, r.nrotramite)
          doc.text(7, y+4, r.cliente)
          doc.text(15, y+4, r.ci)
          doc.text(17, y+4, r.total)
          doc.text(19, y+4, r.usuarioimp )
          doc.text(20, y+4, r.estado )
          if (y+4>25){
            doc.addPage();
            header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
            y=0
          }
        })
        var c = this.total.toString().split(".")
        this.$axios.post(process.env.URL+'/convertirletra/'+c[0]).then(res=>{
          console.log(res.data);
          this.literal=res.data;
          doc.setFontSize(9);
          if(c[1] == null || c[1]=='')
            c[1]=0;
          doc.text(1, y+4.5, 'SON: '+this.literal+' '+c[1]+'/100 Bs')
          doc.text(12, y+4.5, 'TOTAL RECAUDADCION: ')
          doc.text(18, y+4.5, this.total+'Bs')
          doc.setFontSize(6);
          y+=4.5;
          doc.text(1, y+4,   '____________________                     _____________________________                    ________________________ ')
          doc.text(1, y+4.5, 'FIRMA Y SELLO CAJERO                     FIRMA Y SELLO CONTROL INTERNO                    FIRMA Y SELLO LIQUIDADOR')
          // doc.save("Impreso"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
          window.open(doc.output('bloburl'), '_blank');
          this.$q.loading.hide()
        })


      }).catch(err=>{
        // console.log(err.response)
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })

    },
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
        console.log(err)
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
