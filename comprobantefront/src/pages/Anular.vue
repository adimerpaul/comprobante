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
        <q-table :columns="columcomprobantes" title="Comprobantes impresos" :data="comprobantes" >
          <template v-slot:body-cell-opcion="props">
            <q-td :props="props">
              <q-btn color="red" @click="anular(props)" label="Anular" size="md" icon="refresh"/>
            </q-td>
          </template>
        </q-table>
      </div>
      <div class="col-12 q-mt-ms">
        <q-table title="Historial Anulados" :columns="columns" :data="anulados"/>
      </div>
    </div>
  </q-page>
</template>

<script>
import $ from 'jquery'
import { jsPDF } from "jspdf";

export default {
  data() {
    return {
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
    anular(props){
      // console.log(props.row)
      this.$q.dialog({
        title:'Seguro de anular?',
        // message:'',
        cancel:true
      }).onOk(()=>{
        // console.log('a')
        this.$axios.post(process.env.URL+'/anulado',{comprobante_id:props.row.id}).then(res=>{
          console.log(res.data)
          this.miscomprobante()
          this.misanulados()
        })
      })
    },
    misanulados(){
      // console.log('a');
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/anulado').then(res=>{
        console.log(res.data)
        this.$q.loading.hide()
        this.anulados=[]
        res.data.forEach(r=>{
          this.anulados.push({
            // label:r.padron+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            id:r.id,
            fecha:r.fecha+' '+r.hora,
            // unidad:r.unid.nombre,
            nrocomprobante:r.nrocomprobante,
            // nrotramite:r.nrotramite,
            // detalles:r.detalles,
            // nombrecompleto:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            // padron:r.padron,
            // ci:r.cliente.ci,
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
            label:r.padron+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            id:r.id,
            fecha:r.fecha,
            unidad:r.unid.nombre,
            nrocomprobante:r.nrocomprobante,
            nrotramite:r.nrotramite,
            detalles:r.detalles,
            nombrecompleto:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
            padron:r.padron,
            ci:r.cliente.ci,
            total:r.total,
          })
        })
      })
    },
  },
};
</script>
