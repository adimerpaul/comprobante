<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12">
<!--        <table border="1" style="width: 100%">-->
<!--          <thead>-->
<!--          <tr>-->
<!--            <th>#</th>-->
<!--            <th>N comprobante</th>-->
<!--            <th>M tramite</th>-->
<!--            <th>Cliente</th>-->
<!--            <th>Opciones</th>-->
<!--          </tr>-->
<!--          </thead>-->
<!--          <tbody>-->
<!--          <tr v-for="(comprobante,index) in comprobantes" :key="index">-->
<!--            <td>{{comprobante.id}}</td>-->
<!--            <td>{{comprobante.nrocomprobante}}</td>-->
<!--            <td>{{comprobante.nrotramite}}</td>-->
<!--            <td>{{comprobante.nombrecompleto }}</td>-->
<!--            <th> <q-btn label="Anular" color="red" icon="refresh"/> </th>-->
<!--          </tr>-->
<!--          </tbody>-->
<!--        </table>-->
        <q-table dense :columns="columcomprobantes" title="Comprobantes impresos" :data="comprobantes" >
          <template v-slot:body-cell-opcion="props">
            <q-td :props="props">
              <q-btn  color="red" @click="anular(props)" label="Anular" size="xs" icon="refresh"/>
            </q-td>
          </template>
        </q-table>
      </div>
      <div class="col-12 col-md-6 q-pa-xs">
        <q-input outlined dense type="date" v-model="fecha" label="Fecha de consulta"/>
      </div>
      <div class="col-12 col-md-6 q-pa-xs" >
        <q-btn label="Consultar"  @click="misanulados" icon="send" color="warning" class="full-width full-height "/>
      </div>
      <div class="col-12 q-mt-ms">
        <q-table title="Historial Anulados" :columns="columns" :data="anulados" dense/>
      </div>
      <div class="col-12">
        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>
      </div>
    </div>
  </q-page>
</template>

<script>
import $ from 'jquery'
import { jsPDF } from "jspdf";
import {date} from 'quasar'
export default {
  data() {
    return {
      fecha: date.formatDate(Date.now(),'YYYY-MM-DD'),
      comprobantes:[],
      columcomprobantes:[
        {name:'id',label:'#',field:'id',sort:true},
        {name:'nrocomprobante',label:'N Comprobante',field:'nrocomprobante',sort:true},
        {name:'nrotramite',label:'N Tramite',field:'nrotramite',sort:true},
        {name:'nombrecompleto',label:'Cliente',field:'nombrecompleto',sort:true},
        {name:'unidad',label:'Unidad',field:'unidad',sort:true},
        {name:'fecha',label:'Fecha',field:'fecha',sort:true},
        {name:'opcion',label:'Opcion',field:'opcion',sort:true},
      ],
      columns:[
        {name:'id',label:'#',field:'id',sort:true},
        {name:'nrocomprobante',label:'N Comprobante',field:'nrocomprobante',sort:true},
        {name:'nrotramite',label:'N Tramite',field:'nrotramite',sort:true},
        {name:'cliente',label:'Cliente',field:'cliente',sort:true},
        {name:'unidad',label:'Unidad',field:'unidad',sort:true},
        {name:'usuario',label:'Usuario',field:'usuario',sort:true},
        {name:'fecha',label:'Fecha',field:'fecha',sort:true},
      ],
      anulados:[]
    }
  },
  created() {
    this.miscomprobante()
    this.misanulados()
  },
  methods: {
    imprimir(){
      function header(fecha){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE ANULADOS')
        doc.text(5, 1.5, 'REGULACION DE '+fecha)
        doc.text(1, 3, 'Nº COMPROBANTE')
        doc.text(4, 3, 'Nº TRAMITE')
        doc.text(6.2, 3, 'CONTRIBUYENTE')
        doc.text(11.5, 3, 'UNIDAD')
        doc.text(15, 3, 'USUARIO')
        doc.text(17.5, 3, 'FECHA Y HORA')
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
      this.anulados.forEach(r=>{
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.nrocomprobante)
        doc.text(4, y+3, r.nrotramite)
        doc.text(6.2, y+3, r.cliente)
        doc.text(11.5, y+3, r.unidad)
        doc.text(15, y+3, r.usuario)
        doc.text(17.5, y+3, r.fecha )
        if (y+3>25){
          doc.addPage();
          header(this.fecha)
          y=0
        }
      })
      // doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      // doc.text(18, y+4, this.total+'Bs')
      doc.save("Anulados"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
    },
    anular(props){
      // console.log(props.row)
      this.$q.dialog({
        title:'Seguro de anular?',
        // message:'',
        cancel:true
      }).onOk(()=>{
        // console.log('a')
        this.$axios.post(process.env.URL+'/anulado',{comprobante_id:props.row.id}).then(res=>{
          // console.log(res.data)
          this.miscomprobante()
          this.misanulados()
        })
      })
    },
    misanulados(){
      // console.log(this.fecha);
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/anulado/'+this.fecha).then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        // return false

        this.anulados=[]
        res.data.forEach(r=>{
          this.anulados.push({
            // label:r.padron+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            id:r.id,
            fecha:r.fecha,
            // unidad:r.unid.nombre,
            nrocomprobante:r.nrocomprobante,
            nrotramite:r.nrotramite,
            // detalles:r.detalles,
            cliente:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            unidad:r.unid.nombre,
            usuario:r.user.name,
            // total:r.total,
          })
        })
        // console.log('s')
      })
    },
    miscomprobante(){
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/anulado/create').then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.comprobantes=[]
        res.data.forEach(r=>{
          this.comprobantes.push({
            label:r.padron+' '+r.paterno+' '+r.materno+' '+r.nombre,
            id:r.id,
            fecha:r.fecha,
            unidad:r.unid.nombre,
            nrocomprobante:r.nrocomprobante,
            nrotramite:r.nrotramite,
            detalles:r.detalles,
            nombrecompleto:r.paterno+' '+r.materno+' '+r.nombre,
            padron:r.padron,
            ci:r.ci,
            total:r.total,
          })
        })
      })
    },
  },
};
</script>
