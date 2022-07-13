<template>
<div class="q-pa-md">

    <q-form
      @submit="buscar"
      @reset="onResetBuscarComprobante"
      class="q-gutter-md"
    >
 <div class="row">
  <div class="col-2">
    <q-input outlined v-model="dato.ci" label="Carnet ID" counter >
        <template v-slot:append>
          <q-icon v-if="dato.ci !== ''" name="close" @click="dato.ci = ''" class="cursor-pointer" />
        </template>
      </q-input>
  </div>
  <div class="col-2">
    <q-input outlined v-model="dato.paterno" label="APELLIDO PATERNO" counter >
        <template v-slot:append>
          <q-icon v-if="dato.paterno !== ''" name="close" @click="dato.paterno = ''" class="cursor-pointer" />
        </template>
      </q-input>
  </div>
  <div class="col-2">
    <q-input outlined v-model="dato.materno" label="APELLIDO MATERNO" counter hide-hint>
        <template v-slot:append>
          <q-icon v-if="dato.materno !== ''" name="close" @click="dato.materno = ''" class="cursor-pointer" />
        </template>
      </q-input>
  </div>
  <div class="col-2">
    <q-input outlined v-model="dato.nombre" label="NOMBRE" counter >
        <template v-slot:append>
          <q-icon v-if="dato.nombre !== ''" name="close" @click="dato.nombre = ''" class="cursor-pointer" />
        </template>
      </q-input>
  </div>
  <div class="col-4"><q-btn type="submit" color="primary" size="lg" label="BUSCAR COMPROBANTE" /></div>
  </div>
  </q-form>


    <q-table dense :filter="filter" title="Comprobante" :data="data" :columns="columns" row-key="name" :rows-per-page-options="[10,20]">
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="nrocomprobante" :props="props">
            {{props.row.nrocomprobante}}
          </q-td>
          <q-td key="fecha" :props="props">
            {{props.row.fecha}}
          </q-td>
          <q-td key="ci" :props="props">
            {{props.row.ci}}
          </q-td>
          <q-td key="paterno" :props="props">
            {{props.row.paterno}}
          </q-td>
          <q-td key="materno" :props="props">
            {{props.row.materno}}
          </q-td>
          <q-td key="nombre" :props="props">
            {{props.row.nombre}}
          </q-td>
          <q-td key="opcion" :props="props">

            <q-btn
              dense
              round
              flat
              color="green-10"
              @click="imprimir(props.row)"
              icon="print"
            />
          </q-td>
        </q-tr>
      </template>

    </q-table>
  </div>
</template>

<script>
import {jsPDF} from "jspdf";
import { date } from 'quasar'
const { addToDate } = date
import $ from "jquery";
import conversor from "conversor-numero-a-letras-es-ar";
export default {
  data() {
    return {
      filter:'',
      model:'',
      dato:{ci: '',
      paterno: '',
      materno: '',
      nombre: ''},

      options: [],
      props: [],
      modelpermiso:false,
      columns: [
        {name: "nrocomprobante", align: "left", label: "Nro. Comprobante ", field: "nrocomprobante", sortable: true,},
        {name: "fecha", align: "left", label: "Fecha", field: "fecha", sortable: true,},
        {name: "ci", align: "left", label: "Carnet", field: "ci", sortable: true,},
        {name: "paterno", align: "left", label: "Paterno", field: "paterno", sortable: true,},
        {name: "materno", align: "left", label: "Materno", field: "materno", sortable: true,},
        {name: "nombre", align: "left", label: "Nombre", field: "nombre", sortable: true,},
        { name: "opcion", label: "Opcion", field: "action", sortable: false },
      ],
      data: [],
      ci:'',
      materno:'',
      nombre:'',
      paterno:'',
      padron:'',
      expedido:'',
      direccion:'',
      numcasa:'',
      tipocatastro:'',
      nrotramite:'',
      codcatastral:'',
      nrocomprobante:'',
      subitems:[],
      subitem:{monto:0,cantidad:0,label:''},
       micomprobante:{},
    };
  },
  created() {
  },
  methods: {
    misdatos() {
      this.$q.loading.show();
      this.$axios.post(process.env.URL + "/buscarcomprobante").then((res) => {
        console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },

    editRow(item) {
      this.dato2 = item.row
      this.dato2.unid_id = item.row.unid
      // console.log(this.dato2)
      this.dialog_mod = true;

    },
    buscar(){
      this.$q.loading.show();
      this.$axios.post(process.env.URL + "/buscarcomprobante",this.dato).then((res) => {
        console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },
    onResetBuscarComprobante(){

    },
    imprimir(i){
      console.log(i)
      // this.subitem={monto:0,cantidad:0,label:''}
      // this.micomprobante=i
      // this.detalles=[]
      // this.micomprobante.detalles.forEach(r=>{
      //   let d={
      //     coditem:r.coditem,
      //     nombreitem:r.nombreitem,
      //     codsubitem:r.codsubitem,
      //     nombresubitem:r.nombresubitem,
      //     detalle:r.detalle,
      //     precio:r.precio,
      //     cantidad:r.cantidad,
      //     monto:r.subtotal,
      //   }
      //   this.detalles.push(d)
      // })
      // this.ci = this.micomprobante.ci
      // this.paterno = this.micomprobante.paterno
      // this.materno = this.micomprobante.materno
      // this.nombre = this.micomprobante.nombre
      // this.tipocatastro = this.micomprobante.tipocatastro
      // this.expedido = this.micomprobante.cliente.expedido
      // this.direccion = this.micomprobante.cliente.direccion
      // this.numcasa = this.micomprobante.cliente.numcasa
      // this.nrotramite=this.micomprobante.nrotramite

       this.$q.dialog({
        message:'Seguro de imprimir?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=> {
        this.$q.loading.show()
            this.$q.notify({
              title:'Impreso exitosamente',
              message:'Impreso exitosamente',
              color:'green',
              icon:'check'
            })
            this.reporte(i)
          this.$q.loading.hide()
      })
    },
    reporte(dat){
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 15, 1, 3, 3)
      var width = doc.internal.pageSize.getWidth()
      doc.setFont("courier",'bold');
      doc.setFontSize(14);
      var x=2,y=4;
      doc.text(x+1, y, 'NRO COMPROBANTE: '+dat.nrocomprobante.toString());
      doc.setFontSize(11);
      doc.text(x+1, y+0.5, 'TRAMITE N '+dat.nrotramite.toString());
      // console.log(dat.tipocatastro)
      doc.text(x+1, y+1,dat.tipocatastro==null?'':'TIPO: '+dat.tipocatastro.toString());
      //doc.text(x+1, y+1.5,'Contribuyente: '+ dat.paterno.toString()+' '+dat.materno.toString()+' '+dat.nombre.toString());
      let contnom=0
      let finnom=60
      let xxnom=x
      let yynom=y
      if(dat.paterno.toString().length<60)
      {
        doc.setFontSize(11);
        doc.text(x+1, y+1.5, dat.paterno.toString()+' '+dat.materno.toString()+' '+dat.nombre.toString());
      }
      else
      {
        doc.setFontSize(11)
        while(dat.paterno.toString().length>=contnom){
          doc.text(xxnom+1, yynom+1.5, dat.paterno.toString().substring(contnom,finnom));
          contnom+=60;
          finnom+=60
          yynom+=0.3;
        }
      }

      doc.setFontSize(11);
      let cont=0
      let fin=40
      let xx=x
      let yy=y
      if(dat.cliente.direccion.toString().length<40)
        doc.text(x+1, y+2.5,'Direccion: '+ dat.cliente.direccion.toString()+' '+dat.cliente.numcasa.toString());
      else{
        doc.text(xx+1, yy+2.5,'Direccion: ')
        while (dat.cliente.direccion.toString().length>=cont){
          // doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
          doc.text(xx+4, yy+2.5,dat.cliente.direccion.toString().substring(cont,fin)+' '+dat.cliente.numcasa.toString());
          cont+=40;
          fin+=40
          yy+=0.5;
        }
      }
      doc.setFontSize(11);
      doc.text(x+1, y+3,'CI: '+ dat.cliente.ci.toString());
      doc.text(x+1, y+3.5, 'Telefono: '+dat.cliente.telefono.toString());
      doc.text(x+1, y+4, 'Varios: '+dat.varios.toString());
      doc.text(x+1, y+4.5, 'Fecha: OR '+ dat.fecha.toString());
      doc.text(x+1, y+5,  dat.codcatastral==null?'':'Codigo Catastral: '+dat.codcatastral.toString());
      doc.setFontSize(11);
      doc.text(x+1, y+5.5, 'TOTAL:'+dat.total.toString()+' Bs');
      doc.text(x+1, y+6, 'DETALLE');
      xx=x+1.2
      yy=y+7
      let lin=yy
      cont=0
      fin=50
      doc.setFontSize(10);
      dat.detalles.forEach(r=>{
        doc.text(xx, yy, r.coditem.toString());
        doc.text(xx+2, yy, r.nombreitem.toString());
        // doc.text(xx, yy, r.codsubitem.toString());
        doc.text(xx+14.5, yy, r.subtotal.toString()+' Bs');
        //count=r.detalle.toString().length
        if(r.detalle.toString().length<50)
          doc.text(xx+2, yy+0.3, r.detalle.toString());
        else{
          while (r.detalle.toString().length>=cont){
            doc.text(xx+2, yy+0.3, r.detalle.substring(cont,fin));
            cont+=50;
            fin+=50
            yy+=0.3;
          }}
        yy+=0.6
        // console.log(r)
      })

       doc.text(width/2-2, yy+2,this.$store.state.user.name.toString());
       doc.text(width/2-2, yy+2.5,this.$store.state.user.unid.nombre.toString());


      window.open(doc.output('bloburl'), '_blank');

    },
  },
};
</script>

