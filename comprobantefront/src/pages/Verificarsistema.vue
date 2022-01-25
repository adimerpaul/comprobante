<template>
  <q-page class="q-pa-md">
    <div class="row">
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
<!--        <q-checkbox v-model="selectodos" v-on:click.native="seleccionar" label="Seleccionar Todos" />-->

        <q-table
        title="Historial de cobros"
        :columns="pcolumns"
        :data="pagos">
        <template v-slot:body="props">
        <q-tr :props="props">
            <q-td key="nrocomprobante" :props="props">
            {{props.row.nrocomprobante}}
          </q-td>
                      <q-td key="unidad" :props="props">
            {{props.row.unid.codigo}}
          </q-td>
          <q-td key="total" :props="props">
            {{props.row.total}}
          </q-td>
          <q-td key="estado" :props="props">
            <q-badge :color="props.row.estado=='ANULADO'?'teal':'positive'" :label="props.row.estado"/>
          </q-td>
          <q-td key="cajero" :props="props">
            {{props.row.cajero}}
          </q-td>
          <q-td key="verificadosistema" :props="props" >
            <q-checkbox v-model="props.row.verificadosistema" />
          </q-td>
          </q-tr>
        </template>
        </q-table>
      </div>
      <div class="col-12 q-pt-md">
        <q-btn color="info" :label="'Total '+ total +'BS'" class="full-width text-red text-bold"/>
        <q-btn color="green" label="Registrar Verificados" class="full-width text-black text-bold" @click="verificar"/>
<!--        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>-->
      </div>
      <div class="col-12">
        <q-form @submit.prevent="reportecomp">
          <div class="row">
            <div class="col-4 q-pa-md"><q-input label="Fecha 1" type="date" outlined v-model="fecha" /></div>
            <div class="col-4 q-pa-md"><q-input label="Fecha 1" type="date" outlined v-model="fecha2" /></div>
            <div class="col-4 q-pa-md flex flex-center"><q-btn type="submit" label="consulta" color="accent" icon="search"/></div>
          </div>
        </q-form>
      </div>
      <div class="col-12">
        <q-form @submit.prevent="generarsubitem">
          <div class="row">
            <div class="col-4 q-pa-md"><q-input label="Fecha Inicio" type="date" outlined v-model="buscar.inicio" /></div>
            <div class="col-4 q-pa-md"><q-input label="Fecha Fin" type="date" outlined v-model="buscar.fin" /></div>
            <div class="col-4 q-pa-md flex flex-center"><q-btn type="submit" label="Generar item" color="warning" icon="search"/></div>
          </div>
        </q-form>
      </div>
    </div>
  </q-page>
</template>
<script>
import { jsPDF } from "jspdf";
import {date} from 'quasar'
const { addToDate } = date

export default {
  data() {
    return {
      model:'',
      unidad:'',
      // fecha2:date.formatDate(Date.now(),'YYYY-MM-DD'),
      //
      // fecha:date.formatDate( addToDate(Date.now(),{days:-1}) ,'YYYY-MM-DD'),
      fecha2:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      buscar:{inicio:date.formatDate(Date.now(),'YYYY-MM-DD'),fin:date.formatDate(Date.now(),'YYYY-MM-DD')},
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
        {name:'unidad',label:'Unidad', align:'left',field:row=>row.unidad.codigo,sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'estado',label:'Estado', align:'left',field:'estado'},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero'},
        {name:'verificadosistema',label:'Verificar', align:'left',field:'verificadosistema'},
      ],
      comprobantes:[],
      pagos:[],
      unidades:[],
      selectodos:false,
      item:[]
    };
  },
  created() {
    // this.miscomprobante()
    // this.mispagos()
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      this.unidades=res.data
      // console.log(res.data)
    })
  },
  methods: {
          generarsubitem(){
        if(this.buscar.inicio<=this.buscar.fin){
         this.$axios.post(process.env.URL+'/reportitem',this.buscar)
         .then(res=>{
           //console.log(res.data)
           //return false
           this.item=res.data;
            // console.log(res.data);
            this.imprimiritem();
         })
        }
      },
        imprimiritem(){
      function header(fecha1,fecha2,hoy){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.setFontSize(5);

        doc.text(2,1,'GOBIERNO AUTONOMO MUNICIPAL DE ORURO')
        doc.text(2.5,1.2,'DIRECCION DE INGRESOS')
        doc.setFontSize(7);
        doc.text(15,1,'Fecha de Consulta:'+hoy);
        doc.setFontSize(9);
        doc.text(6, 2, 'RESUMEN DE INGRESOS POR COMPROBANTE DE CAJA')
        doc.text(6.5, 2.5, 'DEL: '+fecha1+' AL '+fecha2)

        doc.text(0.5, 3.5, 'ITEM')
        doc.text(3, 3.5, 'DESCRIPCION')
        doc.text(15, 3.5, 'NRO TRAMITES')
        doc.text(18, 3.5, 'MONTO BS')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.buscar.inicio,this.buscar.fin,date.formatDate(Date.now(),'YYYY-MM-DD'))
      // let xx=x
      // let yy=y
      let y=0;
      this.item.forEach(item=>{
               y+=0.5
        doc.text(0.5, y+4, item.cod);
        doc.text(3, y+4, item.nombre.substring(0,70));
        doc.text(15, y+4, ''+item.cantidad);
        doc.text(19, y+4, ''+item.monto,{align: 'right',});
        // doc.text(19, y+4, item.monto ,{align: 'right',});

        if (y+4>25){
          doc.addPage();
           header(this.buscar.inicio,this.buscar.fin,date.formatDate(Date.now(),'YYYY-MM-DD'));
          y=0;
        }});
      doc.text(4, y+4, '____________________________________________________________________________')
      doc.text(4, y+4.5, 'TOTAL RECAUDACION: ')
      doc.text(15, y+4.5, ''+this.tramite)
      doc.text(18, y+4.5, ''+this.total)


      window.open(doc.output('bloburl'), '_blank');
    },
    reportecomp(){
      this.$q.loading.show()
      function header(un,fec1,fec2,fec3){
        doc.setFont("courier");
        doc.setFontSize(9);

        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(3, 1, 'H. GOBIERNO MUNICIPAL DE ORURO')
        // doc.text(3, 1.5, '  JEFATURA DE RECAUDACIONES')
        doc.text(15, 1.5, 'Fecha de Proceso '+fec1)
        doc.text(8, 2.5, 'REGISTRO DE COMPROBANTES DE CAJA ')
        doc.text(5, 3, 'RESUMEN MENSUAL DE COMPROBANTES DEL ' + fec2 +' AL '+ fec3)
        // doc.setFontSize(6);
        // doc.text(.5, 4, 'FECHA DE PAGO')
        // doc.text(3, 4, 'Nº COMPROBANTE')
        // doc.text(5, 4, 'Nº TRAMITE')
        // doc.text(7, 4, 'CONTRIBUYENTE')
        // doc.text(15, 4, 'CI/RUN/RUC')
        // doc.text(17, 4, 'MONTO BS.')
        // doc.text(19, 4, 'USUARIO')
        // doc.text(20, 4, 'ESTADO')
        doc.setFont(undefined,'normal')
        doc.setFontSize(6);
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);

      // var x=0,y=
      header(this.$store.state.user.unid.nombre,date.formatDate(Date.now(),'YYYY-MM-DD'),this.fecha,this.fecha)

      this.$axios.post(process.env.URL+'/reportecomp',{inicio:this.fecha,fin:this.fecha2,}).then(res=>{
        console.log(res.data)
        doc.setFontSize(6)
        let y=0
        let x=0
        let f='*'
        let a=0.5
        let cont=0;
        res.data.forEach(r=>{
          // xx+=0.5
          cont++
          a=0
          if (f!=r.fechasistema){

            doc.setFont(undefined,'bold')
            f=r.fechasistema
            doc.text(x+1, y+3.5, r.fechasistema)
            doc.text(x+4.5, y+3.5, 'TALONARIO' )
            a=0.28
            doc.setFont(undefined,'normal')
            cont++
          }
          doc.text(x+0.5, y+a+3.5, r.nombre.substring(0,30))
          doc.text(x+4.5, y+a+3.5, r.menor)
          doc.text(x+5.5, y+a+3.5, r.mayor )

          if (cont==80){
            // doc.addPage();
            // cont=0
            // header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
            y=0
            x+=7
          }
          if (cont==160){
            y=0
            x+=7
          }
          if (cont==240){
            y=0
            x=0.5
            cont=0
            doc.addPage();
            header(this.$store.state.user.unid.nombre,date.formatDate(Date.now(),'YYYY-MM-DD'),this.fecha,this.fecha)
          }

          if (a==0){
            y+=0.28
          }else{
            y=y+0.28+a
          }

        })

        window.open(doc.output('bloburl'), '_blank');
        this.$q.loading.hide()
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
        this.$q.loading.hide()
      })
    },
      seleccionar(){
          this.pagos.forEach(element => {
              element.verificadosistema=this.selectodos;
          });

      },
      verificar(){
        this.pagos.forEach(elemt=>{
                if(elemt.verificadosistema)
                 this.$axios.post(process.env.URL+'/verificadosistema',elemt);
        // console.log(res.data)

        });
        this.$q.dialog({
          title:'Verificado Exitoso'
        })
        this.historial();
      },
    historial(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/historial3',{fecha:this.fecha,unid_id:this.unidad.id}).then(res=>{
        console.log(res.data)
        this.$q.loading.hide()
        this.pagos=[];
        res.data.forEach(element => {
            if(element.verificadosistema==1)
            element.verificadocaja=true;
            else
            element.verificadosistema=false;
            this.pagos.push(element);

        });
        this.pagos=res.data;


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
      this.item.forEach(r=>{
        total+=parseFloat(r.monto);
      })
      return total;
    },
          tramite() {
      let tramite=0
      this.item.forEach(r=>{
        tramite+=parseInt(r.cantidad);
      })
      return tramite;
    }
  }
};
</script>

<style scoped></style>
