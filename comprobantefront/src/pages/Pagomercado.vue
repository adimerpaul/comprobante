<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-table dense :rows-per-page-options="[20,100,200,0]" title="Mis Comprobantes" :data="miscomprobantes" :columns="columnscomprobantes" row-key="name" :filter="filter">
        <template v-slot:top-right>
          <q-btn label="crear comprobante" @click="nuevocomprobante" icon="add_circle" color="primary" />
          <q-input outlined dense  v-model="filter" placeholder="Buscar">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-opciones="props">
          <q-td :props="props">
            <q-btn v-if="props.row.estado=='CREADO'" @click="frmimprimir(props.row)" label="imprimir" icon="print" color="info" size="xs"/>
<!--            <q-btn v-if="props.row.estado=='IMPRESO'" @click="reimprimir(props.row)" label="reimprimir" icon="print" color="warning" size="xs"/>-->
            <q-badge v-if="props.row.estado=='ANULADO'" color="negative" label="ANULADO"/>
          </q-td>
        </template>
      </q-table>
    </div>
    <div class="col-12">
      <q-btn @click="reportecomprobantes" class="full-width" color="info" icon="print" label="Imprimir comprobantes usuario"/>
    </div>
    <div class="col-4">
      <q-input label="fecha" type="date" dense outlined v-model="fecha"/>
    </div>
    <div class="col-4">
      <q-input label="fecha" type="date" dense outlined v-model="fecha2"/>
    </div>
    <div class="col-4">
      <q-btn @click="reportecomprobantestotales" class="full-width" color="positive" icon="print" label="Imprimir comprobantes del dia"/>
    </div>
    <div class="col-4">
      <q-input label="fecha" type="date" dense outlined v-model="fechames1"/>
    </div>
    <div class="col-4">
      <q-input label="fecha" type="date" dense outlined v-model="fechames2"/>
    </div>
    <div class="col-4">
      <q-btn @click="reportecomprobantesmes" class="full-width" color="secondary" icon="print" label="Imprimir comprobantes del mes"/>
    </div>
  </div>
  <q-dialog v-model="dialogcomprobante" full-width>
    <q-card >
      <q-card-section class="bg-green text-white">
        <div class="text-h6 "> <q-icon name="add_circle"/> DE INGRESOS</div>
      </q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit="crearcomprobante">
          <div class="row">
            <div class="col-12 col-sm-3 bg-blue flex flex-center ">
              <div class="text-subtitle2">NRO TRAMITE</div>
            </div>
            <div class="col-12 col-sm-9 ">
              <q-input square disable dense outlined v-model="nrotramite" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">CI/NIT/RUC</div>
            </div>
            <div class="col-12 col-sm-5">
              <q-input @input="buscarcliente" square dense outlined v-model="ci" />
            </div>
            <div class="col-12 col-sm-4">
              <q-select :options="['CH','LP','CB','OR','PT','TJ','SC','BE','PD','OTROS']" outlined dense square label="Expedido" v-model="expedido"
              />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">PATERNO</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input   dense outlined v-model="paterno" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">MATERNO</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input   dense outlined v-model="materno" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">NOMBRES</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input   dense outlined v-model="nombre" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">DIRECCION</div>
            </div>
            <div class="col-12 col-sm-7">
              <q-input   dense outlined v-model="direccion" />
            </div>
            <div class="col-12 col-sm-2">
              <q-input   dense outlined v-model="numcasa" label="Num casa" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">PADRON MUNICIPAL</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input   dense outlined v-model="padron" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">ITEM</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-select :options="items" @input="buscarsubitems()" square dense outlined v-model="item" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">SUBITEM</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-select :options="subitems" square  dense outlined v-model="subitem" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">MONTO BS</div>
            </div>
            <div class="col-12 col-sm-2">
              <q-input color="red" label-color="red" square label="Tasa" dense outlined v-model="subitem.monto"/>
            </div>
            <div class="col-12 col-sm-2">
              <q-input color="red" label-color="red" square label="Cantidad" dense outlined v-model="subitem.cantidad"/>
            </div>
            <div class="col-12 col-sm-2">
              <q-input color="red" disable label-color="red" square label="Monto" dense outlined :value="subtotal" />
            </div>
            <div class="col-12 col-sm-3 flex flex-center">
              <q-btn @click="agregardetalle" icon="add_circle" color="primary" label="Agregar"/>
            </div>
            <div class="col-12 ">
              <q-table :rows-per-page-options="[1000]" dense :columns="columnsdetalles" :data="detalles">
                <template v-slot:body-cell-detalle="props">
                  <q-td  :props="props">
                    <q-input dense outlined v-model="props.row.detalle"/>
                  </q-td>
                </template>
                <template v-slot:body-cell-coditem="props">
                  <q-td auto-width :props="props">
                    {{props.row.coditem}}<q-icon @click="quitardetalle(props.pageIndex)" name="delete" color="negative"/>
                  </q-td>
                </template>
                <template v-slot:body-cell-monto="props">
                  <q-td auto-width :props="props">
                    <q-input style="width: 4em" dense outlined v-model="props.row.monto"/>
                  </q-td>
                </template>
                <template v-slot:bottom >
                  <div class="text-subtitle2 full-width " style="text-align: right">Total {{ total }} Bs</div>
                </template>
              </q-table>
            </div>
            <div class="col-12">
              <q-btn type="submit" class="full-width" icon="check_circle" color="positive" :label="'Grabar comprobante '+ total +' Bs'"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-actions align="right" class="bg-white text-teal">
        <q-btn icon="delete" color="negative" label="cancelar" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
  <q-dialog v-model="dialogimprimir" full-width>
    <q-card >
      <q-card-section class="bg-red-8 text-white">
        <div class="text-h6">IMPRIMIR COMPROBANTE</div>
      </q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit="imprimircomprobante">
          <div class="row">
            <div class="col-12 col-sm-3 bg-blue flex flex-center ">
              <div class="text-subtitle2">NRO COMPROBANTE</div>
            </div>
            <div class="col-12 col-sm-7 ">
              <q-input @input="mirango" square required dense ref="nrocomprobanteinput" outlined v-model="nrocomprobante" />
            </div>
            <div class="col-12 col-sm-2 ">
              <q-badge :color="boolrango?'red':'green'" class="full-width full-height" text-color="white">
                Disponibles {{unidad.inicio}}-{{unidad.fin}}
              </q-badge>
            </div>
            <div class="col-12 col-sm-3 bg-blue flex flex-center ">
              <div class="text-subtitle2">NRO TRAMITE</div>
            </div>
            <div class="col-12 col-sm-9 ">
              <q-input square disable dense  outlined v-model="nrotramite" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">CI/NIT/RUC</div>
            </div>
            <div class="col-12 col-sm-5">
              <q-input disable @input="buscarcliente" square dense outlined v-model="ci" />
            </div>
            <div class="col-12 col-sm-4">
              <q-select :options="['CH','LP','CB','OR','PT','TJ','SC','BE','PD','OTROS']" outlined dense square label="Expedido" v-model="expedido"
              />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">PATERNO</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input  disable dense outlined v-model="paterno" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">MATERNO</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input  disable dense outlined v-model="materno" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">NOMBRES</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input  disable dense outlined v-model="nombre" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">DIRECCION</div>
            </div>
            <div class="col-12 col-sm-7">
              <q-input  disable dense outlined v-model="direccion" />
            </div>
            <div class="col-12 col-sm-2">
              <q-input  disable dense outlined v-model="numcasa" label="Num casa" />
            </div>
            <div class="col-12 col-sm-3 bg-red flex flex-center ">
              <div class="text-subtitle2">PADRON MUNICIPAL</div>
            </div>
            <div class="col-12 col-sm-9">
              <q-input  disable dense outlined v-model="padron" />
            </div>
<!--            <div class="col-12 col-sm-3 bg-red flex flex-center ">-->
<!--              <div class="text-subtitle2">ITEM</div>-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-9">-->
<!--              <q-select :options="items" @input="buscarsubitems()" square dense outlined v-model="item" />-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-3 bg-red flex flex-center ">-->
<!--              <div class="text-subtitle2">SUBITEM</div>-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-9">-->
<!--              <q-select :options="subitems" square  dense outlined v-model="subitem" />-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-3 bg-red flex flex-center ">-->
<!--              <div class="text-subtitle2">MONTO BS</div>-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-2">-->
<!--              <q-input color="red" label-color="red" square label="Tasa" dense outlined v-model="subitem.monto"/>-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-2">-->
<!--              <q-input color="red" label-color="red" square label="Cantidad" dense outlined v-model="subitem.cantidad"/>-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-2">-->
<!--              <q-input color="red" disable label-color="red" square label="Monto" dense outlined :value="subtotal" />-->
<!--            </div>-->
<!--            <div class="col-12 col-sm-3 flex flex-center">-->
<!--              <q-btn @click="agregardetalle" icon="add_circle" color="primary" label="Agregar" disable/>-->
<!--            </div>-->
            <div class="col-12 ">
              <q-table :rows-per-page-options="[1000]" dense :columns="columnsdetalles" :data="detalles">
                <template v-slot:body-cell-detalle="props">
                  <q-td  :props="props">
                    <q-input dense outlined v-model="props.row.detalle" disable/>
                  </q-td>
                </template>
                <template v-slot:body-cell-monto="props">
                  <q-td auto-width :props="props">
                    <q-input style="width: 4em" dense outlined v-model="props.row.monto" disable/>
                  </q-td>
                </template>
                <template v-slot:body-cell-coditem="props">
                  <q-td auto-width :props="props">
                    {{props.row.coditem}}<q-icon @click="quitardetalle(props.pageIndex)" name="delete" color="negative"/>
                  </q-td>
                </template>
                <template v-slot:bottom >
                  <div class="text-subtitle2 full-width " style="text-align: right">Total {{ total }} Bs</div>
                </template>
              </q-table>
            </div>
            <div class="col-6">
              <q-btn type="button" @click="proforma" class="full-width" icon="warning" color="warning" :label="'Imprimir proforma'"/>
            </div>
            <div class="col-6">
              <q-btn :disable="boolrango" type="submit" class="full-width" icon="print" color="info" :label="'Imprimir comprobante '+ total +' Bs'"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-actions align="right" class="bg-white text-teal">
        <q-btn icon="delete" color="negative" label="cancelar" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
  <div id="qr_code">
  </div>
</q-page>
</template>

<script>
import {jsPDF} from "jspdf";
import $ from "jquery";
import {date} from "quasar";
const conversor = require('conversor-numero-a-letras-es-ar');

export default {
  data(){
    return{
      fecha:date.formatDate(new  Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new  Date(),'YYYY-MM-DD'),
      fechames1:date.formatDate(new  Date(),'YYYY-MM-DD'),
      fechames2:date.formatDate(new  Date(),'YYYY-MM-DD'),
      fechahoy:date.formatDate(new  Date(),'YYYY-MM-DD'),
      nrocomprobante:'',
      dialogimprimir:false,
      dialogcomprobante:false,
      comprobante:{},
      filter:'',
      items:[],
      item:'',
      subitems:[],
      subitem:{monto:0,cantidad:0,label:''},
      nrotramite:'',
      miscomprobantes:[],
      miscomprobantestotales:[],
      micomprobante:{},
      columnscomprobantes:[
        {name:'nrocomprobante',label:'nrocomprobante',field:'nrocomprobante',sortable:true},
        {name:'fecha',label:'fecha',field:'fecha',sortable:true},
        {name:'nrotramite',label:'nrotramite',field:'nrotramite',sortable:true},
        {name:'contribuyente',label:'contribuyente',field:'contribuyente',sortable:true},
        {name:'opciones',label:'opciones',field:'opciones'},
      ],
      columnsdetalles:[
        {name:'coditem',label:'coditem',field:'coditem'},
        {name:'detalle',label:'detalle',field:'detalle',align:'left'},
        {name:'monto',label:'monto',field:'monto',align:'center'},
        // {name:'opciones',label:'opciones',field:'opciones'},
      ],
      detalles:[{
        coditem:'1220007',
        nombreitem:'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES',
        codsubitem:'122000701',
        nombresubitem:'Venta y reposición de formulario',
        detalle:'Venta y reposicion de formulario',
        precio:2,
        cantidad:1,
        monto:2
      }],
      ci:'',
      materno:'',
      nombre:'',
      paterno:'',
      padron:'',
      expedido:'',
      direccion:'',
      numcasa:'',
      max:0,
      min:0,
      color:'',
      msg:'',
      unidad:{},
    }
  },
  created() {
    this.numcomprobante()
    this.misitems()
    this.miscomprobantesmercados()
    this.mirango()

  },
  methods:{
    mirango(){
      this.$axios.get(process.env.URL + '/mercado/create').then(res=>{
        this.unidad=res.data
      })
    },
    reportecomprobantesmes(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/mercado',{fecha1:this.fechames1,fecha2:this.fechames2}).then(res=>{
        console.log(res.data)
        this.miscomprobantestotales=res.data
        // console.log(this.miscomprobantestotales)
        let cm=this;
        function header(fecha){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.setFontSize(8);
          doc.text(15, 0.5, 'fecha de proceso: '+cm.fechahoy)
          doc.setFontSize(11);
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS DE LA UNIDAD DE ')
          doc.text(5, 1.5, cm.$store.state.user.unid.nombre+' '+cm.fechames1+' AL '+cm.fechames2)
          doc.text(1, 3, '_____________________________________________________________________________________')
          doc.text(2, 3, 'FECHA DE PAGO')
          // doc.text(4, 3, 'Nº TRAMITE')
          doc.text(8, 3, 'N TRAMITES')
          // doc.text(13.5, 3, 'CI/RUN/RUC')
          doc.text(15, 3, 'MONTO PAGADO BS.')
          // doc.text(18, 3, 'OPERADOR')
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        doc.setFont("courier");
        doc.setFontSize(11);
        header(this.fecha)
        let y=0
        let sumtotal=0
        let sumcomp=0
        let con=0
        this.miscomprobantestotales.forEach(r=>{
          // if (r.nrocomprobante!=''){
          // console.log(r)
            y+=0.5
            con++
            doc.text(2, y+3, r.fecha)
            // doc.text(4, y+3, r.nrotramite)
            doc.text(8, y+3, r.num.toString())
            // // doc.text(13.5, y+3, r.ci)
            doc.text(15, y+3, r.total.toString())
            sumtotal+=parseInt(r.total)
            sumcomp+=parseInt(r.num)
            // // console.log(r.total)
            // // doc.text(18, y+3, r.user.codigo )
            if (con==55){
              con=0
              doc.addPage();
              header(this.fecha)
              y=0
            }
          // }
        })
        doc.setFont(undefined,'bold')
        doc.text(2, y+3.5, 'TOTALES:                  '+sumcomp+' ')
        doc.text(12, y+3.5, 'TOTAL RECAUDADCION: ')
        let ClaseConversor = conversor.conversorNumerosALetras;
        let miConversor = new ClaseConversor();

        let a = miConversor.convertToText(sumtotal);
        doc.text(1.5, y+4.4, 'SON: ')
        doc.setFont(undefined,'normal')
        doc.text(2.5, y+4.4, a.toUpperCase())
        doc.setFont(undefined,'bold')
        // console.log(a)
        doc.text(1.8, y+5.9, '___________________      __________________________        ____________________')
        doc.text(2, y+6.3, 'FIRMA SELLO CAJERO')
        doc.text(7.5, y+6.3, 'FIRMA SELLO CONTROL INTERNO')
        doc.text(15.5, y+6.3, 'FIRMA SELLO LIQUIDADOR')
        // doc.setFont(undefined,'normal')
        doc.text(18, y+3.5, sumtotal+ ' Bs')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');
        // console.log(res.data)
        this.$q.loading.hide()
      })
      // .catch(err=>{
      //   this.$q.loading.hide()
      //   // this.$q.notify({
      //   //   message:err.response.data.res,
      //   //   color:'red',
      //   //   icon:'error'
      //   // })
      // })
    },
    reportecomprobantestotales(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/reportemes',{inicio:this.fecha,fin:this.fecha2}).then(res=>{
        this.miscomprobantestotales=res.data
        let cm=this;
        function header(fecha){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
          doc.text(5, 1.5, cm.$store.state.user.unid.nombre+' DEL '+fecha+' AL '+ cm.fecha2)
          doc.text(1, 3, '__________________________________________________________________________________________________')
          doc.text(1, 3, 'FECHA')
          doc.text(3.5, 3, 'Nº COM')
          doc.text(5.5, 3, 'Nº TRA')
          doc.text(7.5, 3, 'CONTRIBUYENTE')
          doc.text(13.5, 3, 'CI/RUN/RUC')
          doc.text(16, 3, 'MONTO BS.')
          doc.text(18, 3, 'OPERADOR')
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        doc.setFont("courier");
        doc.setFontSize(9);
        header(this.fecha)
        let y=0
        let sumtotal=0
        let con=0
        this.miscomprobantestotales.forEach(r=>{
          if (r.nrocomprobante!='' && r.nrocomprobante!=null){
            y+=0.4
            con++
            doc.text(1, y+3, r.fecha)
            doc.text(3.5, y+3, r.nrocomprobante)
            doc.text(5.5, y+3, r.nrotramite)
            doc.text(7.5, y+3, (r.paterno).substring(0,15)+' '+(r.materno).substring(0,15)+' '+(r.nombre).substring(0,15))
            doc.text(13.5, y+3, r.ci)
            doc.text(16, y+3, r.total)
            sumtotal+=parseInt(r.total)
            // console.log(r.total)
            doc.text(18, y+3, r.user.codigo )
            if (con==55){
              con=0
              doc.addPage();
              header(this.fecha)
              y=0
            }
          }
        })
        doc.setFont(undefined,'bold')
        doc.text(3, y+3.5, 'SON: '+con+' COMPROBANTES')
        doc.text(12, y+3.5, 'TOTAL RECAUDACION: ')
        doc.text(1.8, y+5, '_____________________          _____________________________       _________________________')
        doc.text(2, y+5.3, 'FIRMA SELLO CAJERO')
        doc.text(8, y+5.3, 'FIRMA SELLO CONTROL INTERNO')
        doc.text(15, y+5.3, 'FIRMA SELLO LIQUIDADOR')
        // doc.setFont(undefined,'normal')
        doc.text(18, y+3.5, sumtotal+ ' Bs')
        const conversor = require('conversor-numero-a-letras-es-ar');

        let ClaseConversor = conversor.conversorNumerosALetras;
        let miConversor = new ClaseConversor();

        var a = miConversor.convertToText(sumtotal);
        doc.text(1, y+4, 'SON: '+ a.toUpperCase()+' BS')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');
        // console.log(res.data)
        this.$q.loading.hide()
      })
    },
    reportecomprobantes(){
      let cm=this;
      function header(fecha){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
        doc.text(5, 1.5, cm.$store.state.user.unid.nombre+' '+fecha)
        doc.text(1, 3, 'Nº COMPROBANTE')
        doc.text(4, 3, 'Nº TRAMITE')
        doc.text(7, 3, 'CONTRIBUYENTE')
        doc.text(13.5, 3, 'CI/RUN/RUC')
        doc.text(16, 3, 'MONTO BS.')
        doc.text(18, 3, 'OPERADOR')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header(this.fechahoy)
      // let xx=x
      // let yy=y
      let y=0
      let sumtotal=0
      this.miscomprobantes.forEach(r=>{
        // xx+=0.5
        y+=0.5
        console.log(r)
        doc.text(1, y+3, r.nrocomprobante)
        doc.text(4, y+3, r.nrotramite)
        doc.text(7, y+3, r.paterno+' '+r.materno+' '+r.nombre)
        doc.text(13.5, y+3, r.ci)
        doc.text(16, y+3, r.total)
        sumtotal+=parseInt(r.total)
        doc.text(18, y+3, r.user.codigo )
        // if (y+3>25){
        //   doc.addPage();
        //   header(this.fecha)
        //   y=0
        // }
      })
      doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4, sumtotal+'Bs')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    proforma(){
      if (this.micomprobante==''){
        this.$q.dialog({
          title:'Seleccione comprobante'
        })
        return false;
      }
      this.$axios.post(process.env.URL+'/proforma/'+this.micomprobante.id).then(
        async res=>{
          // console.log(res.data)
          let dat2=res.data[0];


          var doc = new jsPDF('p','cm','letter')
          // console.log(dat);
          doc.setFont("courier");
          doc.setFontSize(9);
          var x=0,y=4;
          doc.text(x+=1, y+=1, 'HONORABLE GOBIERNO MUNICIPAL DE ORURO');
          doc.text(x+=1, y+=.5, dat2.unid.nombre.toString());
          doc.text(x+=14, y-=0.5,   'OPERADOR:'+dat2.user.name.toString());
          doc.text(x, y+=0.5, 'FECHA   :'+dat2.fecha.toString());

          doc.text(x-=5, y+=1, 'PROFORMA DE PAGO');
          doc.text(x-=10, y+=0.5, '-------------------------------------------------------------------------------');
          doc.text(x, y+=0.5, 'TRAMITE : '+dat2.nrotramite.toString());
          doc.text(x, y+=0.5, 'NOMBRE O RAZON SOCIAL CONTRIBUYENTE: '+dat2.cliente.paterno.toString()+' '+dat2.cliente.materno.toString()+' '+dat2.cliente.nombre.toString()+'  C.I./RUC: '+dat2.cliente.ci.toString()+' '+dat2.cliente.expedido.toString());
          doc.text(x, y+=0.5, 'DIRECCION : '+dat2.cliente.direccion.toString() + '   PADRON MUNICIPAL : '+dat2.cliente.padron.toString());
          doc.text(x, y+=0.5, '---------------------------------------------------------------------------------');

          let xx=x
          let yy=y+0.3
          // dat2.detalles.forEach(r=>{
          //   doc.text(xx, yy, r.coditem.toString());
          //   doc.text(xx+2.5, yy, r.nombreitem.toString());
          //   // doc.text(xx, yy, r.codsubitem.toString());
          //   doc.text(xx+14.5, yy, r.subtotal.toString());
          //   doc.text(xx+2.5, yy+0.5, r.detalle.toString());
          //   yy++
          // })
          let cont=0
          let fin=50
          dat2.detalles.forEach(r=>{
            doc.text(xx, yy, r.coditem.toString());
            // doc.text(xx+2.5, yy, r.nombreitem.toString());
            // doc.text(xx, yy, r.codsubitem.toString());
            doc.text(xx+14.5, yy, r.subtotal.toString()+' Bs');
            //count=r.detalle.toString().length
            if(r.detalle.toString().length<50)
              doc.text(xx+2.5, yy, r.detalle.toString());
            else{
              while (r.detalle.toString().length>=cont){
                doc.text(xx+2.5, yy, r.detalle.substring(cont,fin));
                //console.log(r.detalle.substring(cont,fin));
                //console.log(cont+ ' '+ fin)
                cont+=50;
                fin+=50
                yy+=0.3;
              }}
            yy+=0.6
            // console.log(r)
          })


          doc.text(xx+5.5, yy+1, 'TOTAL A PAGAR POR SERVICIOS TECNICOS: '+dat2.total.toString()+' Bs');

          // succesMessage es lo que sea que pasamos en la función resolve(...) de arriba.
          // No tiene por qué ser un string, pero si solo es un mensaje de éxito, probablemente lo sea.
          // console.log("¡Sí! " + successMessage);


          window.open(doc.output('bloburl'), '_blank');


        })
    },
    misrangos(){
      if (this.nrocomprobante!=''){
        this.$axios.get(process.env.URL+'/unid/'+this.nrocomprobante).then(res=>{
          if (res.data=='usado'){
            this.max=0
            this.min=0
            this.msg='En uso'
            this.color='negative'
          }else if (res.data=='anulado'){
            this.max=0
            this.min=0
            this.msg='Anulado'
            this.color='negative'
          }else{
            // console.log(res.data)
            this.min=res.data.inicio
            this.max=res.data.fin
            this.msg='Disponible'
            this.color='positive'
          }
          // console.log(res.data)

        }).catch(err=>{
          this.$q.notify({
            message:err.response.data.message,
            icon:'error',
            color:'red'
          })
        })
      }
    },
    imprimircomprobante(){
      // console.log('imprimir')
      this.$q.dialog({
        message:'Seguro de imprimir?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=> {
        this.$q.loading.show()
        this.$axios.put(process.env.URL+'/comprobante/'+this.micomprobante.id,{nrocomprobante:this.nrocomprobante}).then(
          async res=>{
            // console.log(res.data)
            this.nrocomprobante=''
            this.$q.loading.hide()
            this.model=''
            this.$q.notify({
              title:'Impreso exitosamente',
              message:'Impreso exitosamente',
              color:'green',
              icon:'check'
            })
            this.miscomprobantesmercados()
            this.dialogimprimir=false
            // this.ultimoscomprobante()
            let dat=res.data[0]
            this.reporte(dat)
            // var doc = new jsPDF('p','cm','letter')
            // // console.log(dat);
            // doc.setFont("courier",'bold');
            // doc.setFontSize(11);
            // var x=1,y=-3;
            // doc.text(x+14.5, y+5.1, 'TRAMITE N '+dat.nrotramite.toString());
            // doc.text(x+9.5, y+7.5, dat.cliente.paterno.toString()+' '+dat.cliente.materno.toString()+' '+dat.cliente.nombre.toString());
            // doc.setFontSize(10);
            // let cont=0
            // let fin=25
            // let xx=x
            // let yy=y
            // if(dat.cliente.direccion.toString().length<25)
            //   doc.text(x+9, y+8.5, dat.cliente.direccion.toString());
            // else{
            //   while (dat.cliente.direccion.toString().length>=cont){
            //     // doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
            //     doc.text(xx+9, yy+8.5, dat.cliente.direccion.toString().substring(cont,fin));
            //     cont+=25;
            //     fin+=25
            //     yy+=0.2;
            //   }
            // }
            // doc.setFontSize(11);
            // doc.text(x+14, y+8.5, dat.cliente.numcasa.toString());
            // // console.log(dat.cliente)
            // doc.text(x+15.6, y+8.5, dat.cliente.ci.toString()+dat.cliente.expedido.toString()+'  ');
            // doc.text(x+18, y+8.5, dat.cliente.telefono.toString());
            // doc.text(x+3, y+10.5, dat.padron.toString());
            // doc.text(x+9.5, y+10.5, 'OR '+ dat.fecha.toString());
            // xx=x+0.7
            // yy=y+11.7
            // let lin=yy
            // cont=0
            // fin=50
            // doc.setFontSize(10);
            // dat.detalles.forEach(r=>{
            //   doc.text(xx, yy, r.coditem.toString());
            //   doc.text(xx+2.5, yy, r.nombreitem.toString());
            //   // doc.text(xx, yy, r.codsubitem.toString());
            //   doc.text(xx+15.5, yy, r.subtotal.toString()+' Bs');
            //   //count=r.detalle.toString().length
            //   if(r.detalle.toString().length<50)
            //     doc.text(xx+2.5, yy+0.3, r.detalle.toString());
            //   else{
            //     while (r.detalle.toString().length>=cont){
            //       doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
            //       cont+=50;
            //       fin+=50
            //       yy+=0.3;
            //     }}
            //   yy+=0.6
            //   // console.log(r)
            // })
            // doc.setFontSize(12);
            // doc.text(x+16.5, y+15.5, dat.total.toString()+' Bs');
            // doc.text(x+16.5, y+20, dat.total.toString()+' Bs');
            // doc.text(x+2, y+17.5, dat.literal.toString()+' 00/100Bs');
            //
            // // doc.text(x+8.7, y+20.5, dat.controlinterno.toString());
            // // doc.save("Comprobante.pdf");
            //
            // // var qrcode = await new QRCode(document.getElementById("qr_code"), {
            // //   text: "https://cravecookie.com/",
            // //   width: 128,
            // //   height: 128,
            // //   colorDark : "#000000",
            // //   colorLight : "#ffffff",
            // //   correctLevel : QRCode.CorrectLevel.H
            // // });
            // // let base64Image =  await $('#qr_code img').attr('src');
            // // await  console.log(base64Image);
            // //
            // // await doc.addImage(base64Image, 'png', 0, 0, 2, 2);
            // //
            // // await  window.open(doc.output('bloburl'), '_blank');
            // let miPrimeraPromise = new Promise((resolve, reject) => {
            //   // Llamamos a resolve(...) cuando lo que estabamos haciendo finaliza con éxito, y reject(...) cuando falla.
            //   // En este ejemplo, usamos setTimeout(...) para simular código asíncrono.
            //   // En la vida real, probablemente uses algo como XHR o una API HTML5.
            //   var qrcode = new QRCode(document.getElementById("qr_code"), {
            //     text: dat.controlinterno.toString(),
            //     width: 128,
            //     height: 128,
            //     colorDark : "#000000",
            //     colorLight : "#ffffff",
            //     correctLevel : QRCode.CorrectLevel.H
            //   });
            //
            //   setTimeout(function(){
            //     resolve("¡Éxito!"); // ¡Todo salió bien!
            //   }, 500);
            // });
            // miPrimeraPromise.then((successMessage) => {
            //   // succesMessage es lo que sea que pasamos en la función resolve(...) de arriba.
            //   // No tiene por qué ser un string, pero si solo es un mensaje de éxito, probablemente lo sea.
            //   // console.log("¡Sí! " + successMessage);
            //   let base64Image = $('#qr_code img').attr('src');
            //   // console.log(base64Image);
            //   doc.addImage(base64Image, 'png', x+9, y+20, 2, 2);
            //   window.open(doc.output('bloburl'), '_blank');
            // });
          }).catch(err=>{
          console.error(err);
          this.$q.notify({
            message:err.response.data.res,
            icon:'error',
            color:'red'
          })
          this.$q.loading.hide()
        })

      })
    },
    miscomprobantesmercados(){
      this.$q.loading.show()
      this.$axios.get(process.env.URL + '/mercado/1/edit').then(res=>{
        this.miscomprobantes=[]
        res.data.forEach(r=>{
          let d=r
          d.contribuyente=(r.paterno+'').substring(0,50)+' '+r.materno+' '+r.nombre
          this.miscomprobantes.push(d)
        })
        this.$q.loading.hide()
      })
    },
    crearcomprobante(){
      this.$q.dialog({
        message:'Seguro de crear?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=> {
        this.$q.loading.show()
        this.detalles.forEach(r => {
          r.subtotal = r.precio * r.cantidad
        })
        this.$axios.post(process.env.URL + '/comprobante', {
          nrotramite: this.nrotramite,
          padron: this.padron,
          total: this.total,
          ci: this.ci,
          paterno: this.paterno,
          materno: this.materno,
          nombre: this.nombre,
          expedido: this.expedido,
          direccion: this.direccion,
          numcasa: this.numcasa,
          data: this.detalles,
        }).then((res) => {
          // console.log(res.data)
          // return false
          this.miscomprobantesmercados()
          this.$q.loading.hide()
          this.numcomprobante()
          this.item = ''
          this.subitem = ''
          this.detalle = ''
          this.ci = ''
          this.paterno = ''
          this.materno = ''
          this.nombre = ''
          this.padron = ''
          this.expedido = ''
          this.direccion = ''
          this.numcasa = ''
          this.$q.notify({
            title: 'Creado ',
            message:'Creado correctamente',
            color: 'green',
            icon: 'check'
          })
          this.dialogcomprobante=false
        }).catch(err => {
          this.$q.loading.hide()
          this.$q.notify({
            title: 'Error ',
            message: err.response.data.message,
            color: 'red',
            icon: 'error'
          })
        })
      })
    },
    buscarcliente(){
      this.paterno=''
      this.materno=''
      this.nombre=''
      this.padron=''
      this.expedido=''
      this.direccion=''
      this.numcasa=''
      if (this.ci!='')
        this.$axios.get(process.env.URL+'/cliente/'+this.ci).then(res=>{
          if (res.data.length>0){
            this.paterno=res.data[0].paterno
            this.materno=res.data[0].materno
            this.nombre=res.data[0].nombre
            this.padron=res.data[0].padron
            this.expedido=res.data[0].expedido
            this.direccion=res.data[0].direccion
            this.numcasa=res.data[0].numcasa
          }
        })
    },
    agregardetalle(){
      this.detalles.push({
        coditem:this.item.codigo,
        nombreitem:this.item.nombre.trim(),
        codsubitem:this.subitem.codigo,
        nombresubitem:this.subitem.nombre.trim(),
        detalle:this.subitem.nombre.trim(),
        precio:this.subitem.monto,
        cantidad:this.subitem.cantidad,
        monto:Math.round(this.subitem.monto*this.subitem.cantidad)
      })
    },
    quitardetalle(item){
      this.detalles.splice(item, 1)
    },
    reporte(dat){
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier",'bold');
      doc.setFontSize(11);
      var x=1,y=-3;
      doc.text(x+14.5, y+5.1, 'TRAMITE N '+dat.nrotramite.toString());
      doc.text(x+9.5, y+7.5, dat.paterno.toString()+' '+dat.materno.toString()+' '+dat.nombre.toString());
      doc.setFontSize(10);
      let cont=0
      let fin=22
      let xx=x
      let yy=y
      if(dat.cliente.direccion.toString().length<22)
        doc.text(x+9, y+8.5, dat.cliente.direccion.toString());
      else{
        while (dat.cliente.direccion.toString().length>=cont){
          // doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
          doc.text(xx+9, yy+8.5, dat.cliente.direccion.toString().substring(cont,fin));
          cont+=22;
          fin+=22
          yy+=0.3;
        }
      }
      doc.setFontSize(11);
      doc.text(x+14, y+8.5, dat.cliente.numcasa.toString());
      // console.log(dat.cliente)
      doc.text(x+15.6, y+8.5, dat.cliente.ci.toString()+dat.cliente.expedido.toString()+'  ');
      doc.text(x+18, y+8.5, dat.cliente.telefono.toString());
      doc.text(x+3, y+10.5, dat.padron.toString());
      doc.text(x+9.5, y+10.5, 'OR '+ dat.fecha.toString());
      xx=x+0.7
      yy=y+11.7
      cont=0
      fin=55
      doc.setFontSize(10);
      dat.detalles.forEach(r=>{
        doc.text(xx, yy, r.coditem.toString());
        doc.text(xx+2.5, yy, r.nombreitem.toString());
        // doc.text(xx, yy, r.codsubitem.toString());
        doc.text(xx+15.5, yy, r.subtotal.toString()+' Bs');
        //count=r.detalle.toString().length
        // console.log(r.detalle.toString().length)
        if(r.detalle.toString().length<55){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString());
        }else if (r.detalle.toString().length<110){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          // while (r.detalle.toString().length>=cont){
          //   console.log(r.detalle.toString())
          //   doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(cont,fin));
          //   cont+=55;
          //   fin+=55
          //   yy+=0.3;
          // }
        }else if (r.detalle.toString().length<165){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
        }else if (r.detalle.toString().length<220){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
        }else if (r.detalle.toString().length<275){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
        }else if (r.detalle.toString().length<330){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
        }else if (r.detalle.toString().length<385){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
        }else if (r.detalle.toString().length<440){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(385,440));
        } else if (r.detalle.toString().length<495){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(385,440));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(440,495));
        }else if (r.detalle.toString().length<550){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(385,440));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(440,495));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(495,550));
        }else if (r.detalle.toString().length<605){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(385,440));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(440,495));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(495,550));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(550,605));
        }else if (r.detalle.toString().length<660){
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(0,55));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(55,110));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(110,165));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(165,220));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(220,275));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(275,330));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(330,385));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(385,440));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(440,495));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(495,550));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(550,605));
          yy+=0.3
          doc.text(xx+2.5, yy+0.3, r.detalle.toString().substring(605,660));
        }
        yy+=0.6
        // console.log(r)
      })
      doc.setFontSize(12);
      doc.text(x+16.5, y+15.5, dat.total.toString()+' Bs');
      doc.text(x+16.5, y+20, dat.total.toString()+' Bs');
      doc.text(x+2, y+17.5, dat.literal.toString()+' 00/100Bs');

      // doc.text(x+8.7, y+20.5, dat.controlinterno.toString());
      // doc.save("Comprobante.pdf");

      // var qrcode = await new QRCode(document.getElementById("qr_code"), {
      //   text: "https://cravecookie.com/",
      //   width: 128,
      //   height: 128,
      //   colorDark : "#000000",
      //   colorLight : "#ffffff",
      //   correctLevel : QRCode.CorrectLevel.H
      // });
      // let base64Image =  await $('#qr_code img').attr('src');
      // await  console.log(base64Image);
      //
      // await doc.addImage(base64Image, 'png', 0, 0, 2, 2);
      //
      // await  window.open(doc.output('bloburl'), '_blank');
      let miPrimeraPromise = new Promise((resolve, reject) => {
        // Llamamos a resolve(...) cuando lo que estabamos haciendo finaliza con éxito, y reject(...) cuando falla.
        // En este ejemplo, usamos setTimeout(...) para simular código asíncrono.
        // En la vida real, probablemente uses algo como XHR o una API HTML5.
        var qrcode = new QRCode(document.getElementById("qr_code"), {
          text: dat.controlinterno.toString(),
          width: 128,
          height: 128,
          colorDark : "#000000",
          colorLight : "#ffffff",
          correctLevel : QRCode.CorrectLevel.H
        });

        setTimeout(function(){
          resolve("¡Éxito!"); // ¡Todo salió bien!
        }, 500);
      });
      miPrimeraPromise.then((successMessage) => {
        // succesMessage es lo que sea que pasamos en la función resolve(...) de arriba.
        // No tiene por qué ser un string, pero si solo es un mensaje de éxito, probablemente lo sea.
        // console.log("¡Sí! " + successMessage);
        let base64Image = $('#qr_code img').attr('src');
        // console.log(base64Image);
        doc.addImage(base64Image, 'png', x+9, y+20, 2, 2);
        window.open(doc.output('bloburl'), '_blank');
      });
    },
    reimprimir(comprobante){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/imprimir',{id:comprobante.id}).then(res=>{
        // console.log(res.data)
        // this.reimprimir=res.data
        this.$q.loading.hide()
        let dat=res.data[0]
        this.reporte(dat)
      })
    },
    reimprimir2(comprobante){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/imprimir',{id:comprobante.id}).then(res=>{
        // console.log(res.data)
        // this.reimprimir=res.data
        this.$q.loading.hide()
        let dat=res.data[0];
        var doc = new jsPDF('p','cm','letter')
        // console.log(dat);
        doc.setFont("courier",'bold');
        doc.setFontSize(11);
        var x=0,y=-2;
        doc.text(x+14.5, y+5.1, 'TRAMITE N '+dat.nrotramite.toString());
        doc.text(x+9.5, y+7.5, dat.paterno.toString()+' '+dat.materno.toString()+' '+dat.nombre.toString());
        doc.setFontSize(7);
        let cont=0
        let fin=20
        let xx=x
        let yy=y
        if(dat.cliente.direccion.toString().length<20)
          doc.text(x+9.5, y+8.5, dat.cliente.direccion.toString());
        else{
          while (dat.cliente.direccion.toString().length>=cont){
            // doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
            doc.text(xx+9.5, yy+8.5, dat.cliente.direccion.toString().substring(cont,fin));
            cont+=20;
            fin+=20
            yy+=0.2;
          }
        }
        doc.setFontSize(11);
        doc.text(x+14, y+8.7, dat.cliente.numcasa.toString());
        // console.log(dat.cliente)
        doc.text(x+15.6, y+8.7, dat.cliente.ci.toString()+dat.cliente.expedido.toString()+'  ');
        doc.text(x+18, y+8.7, dat.cliente.telefono.toString());
        doc.text(x+3, y+10.5, dat.padron.toString());
        doc.text(x+9.5, y+10.5, 'OR '+ dat.fecha.toString());
        xx=x+1.2
        yy=x+9.7
        let lin=yy
        cont=0
        fin=50
        doc.setFontSize(10);
        dat.detalles.forEach(r=>{
          doc.text(xx, yy, r.coditem.toString());
          doc.text(xx+2.5, yy, r.nombreitem.toString());
          // doc.text(xx, yy, r.codsubitem.toString());
          doc.text(xx+15.5, yy, r.subtotal.toString()+' Bs');
          //count=r.detalle.toString().length
          if(r.detalle.toString().length<50)
            doc.text(xx+2.5, yy+0.3, r.detalle.toString());
          else{
            while (r.detalle.toString().length>=cont){
              doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
              cont+=50;
              fin+=50
              yy+=0.3;
            }}
          yy+=0.6
          // console.log(r)
        })
        doc.setFontSize(12);
        doc.text(x+16.5, y+15.5, dat.total.toString()+' Bs');
        doc.text(x+2, y+17.5, dat.literal.toString()+' 00/100Bs');

        // doc.text(x+8.7, y+20.5, dat.controlinterno.toString());
        // doc.save("Comprobante.pdf");

        // var qrcode = await new QRCode(document.getElementById("qr_code"), {
        //   text: "https://cravecookie.com/",
        //   width: 128,
        //   height: 128,
        //   colorDark : "#000000",
        //   colorLight : "#ffffff",
        //   correctLevel : QRCode.CorrectLevel.H
        // });
        // let base64Image =  await $('#qr_code img').attr('src');
        // await  console.log(base64Image);
        //
        // await doc.addImage(base64Image, 'png', 0, 0, 2, 2);
        //
        // await  window.open(doc.output('bloburl'), '_blank');
        let miPrimeraPromise = new Promise((resolve, reject) => {
          // Llamamos a resolve(...) cuando lo que estabamos haciendo finaliza con éxito, y reject(...) cuando falla.
          // En este ejemplo, usamos setTimeout(...) para simular código asíncrono.
          // En la vida real, probablemente uses algo como XHR o una API HTML5.
          var qrcode = new QRCode(document.getElementById("qr_code"), {
            text: dat.controlinterno.toString(),
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
          });

          setTimeout(function(){
            resolve("¡Éxito!"); // ¡Todo salió bien!
          }, 500);
        });
        miPrimeraPromise.then((successMessage) => {
          // succesMessage es lo que sea que pasamos en la función resolve(...) de arriba.
          // No tiene por qué ser un string, pero si solo es un mensaje de éxito, probablemente lo sea.
          // console.log("¡Sí! " + successMessage);
          let base64Image = $('#qr_code img').attr('src');
          // console.log(base64Image);
          doc.addImage(base64Image, 'png', x+9, y+20, 2, 2);
          window.open(doc.output('bloburl'), '_blank');
        });
      })
    },
    frmimprimir(i){
      this.subitem={monto:0,cantidad:0,label:''}
      this.dialogimprimir=true
      this.micomprobante=i
      // console.log(this.micomprobante)
      this.detalles=[]
      this.micomprobante.detalles.forEach(r=>{
        let d={
            coditem:r.coditem,
            nombreitem:r.nombreitem,
            codsubitem:r.codsubitem,
            nombresubitem:r.nombresubitem,
            detalle:r.detalle,
            precio:r.precio,
            cantidad:r.cantidad,
            monto:r.subtotal,
        }
        this.detalles.push(d)
      })
      // this.$refs.nrocomprobanteinput.focus();
      // this.$refs.nrocomprobanteinput.focus();
      const vm = this

      setTimeout(() => {
        vm.$refs.nrocomprobanteinput.focus()
      }, 20)
      // this.detalle = this.micomprobante.cliente.detalle
      this.ci = this.micomprobante.ci
      this.paterno = this.micomprobante.paterno
      this.materno = this.micomprobante.materno
      this.nombre = this.micomprobante.nombre
      this.padron = this.micomprobante.cliente.padron
      this.expedido = this.micomprobante.cliente.expedido
      this.direccion = this.micomprobante.cliente.direccion
      this.numcasa = this.micomprobante.cliente.numcasa
      this.nrotramite=this.micomprobante.nrotramite

    },
    nuevocomprobante(){
      this.item=''
      this.subitem={monto:0,cantidad:0,label:''}
      this.dialogcomprobante=true
      this.ci=''
      this.paterno=''
      this.materno=''
      this.nombre=''
      this.padron=''
      this.expedido=''
      this.direccion=''
      this.numcasa=''
      this.numcomprobante()
      this.detalles=[{
        coditem:'1220007',
        nombreitem:'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES',
        codsubitem:'122000701',
        nombresubitem:'Venta y reposición de formulario',
        detalle:'Venta y reposicion de formulario',
        precio:2,
        cantidad:1,
        monto:2
      }]
    },
    buscarsubitems(){
      this.$q.loading.show()
      this.subitems=[]
      this.$axios.get(process.env.URL+'/subitem/'+this.item.id).then(res=>{
        this.$q.loading.hide()
        res.data.forEach(r=>{
          let d=r
          d.cantidad=1
          // d.subtotal=r.monto
          d.label=r.codigo+' '+r.nombre+' '+r.monto+'Bs'
          this.subitems.push(d)
        });
      })
    },
    numcomprobante(){
      // this.$q.loading.show()
      this.$axios.get(process.env.URL+'/comprobante/1').then(res=>{
        this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
        // this.$q.loading.hide()
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
    },
    misitems(){
      this.$axios.get(process.env.URL+'/item').then(res=>{
        this.items=[]
        res.data.forEach(r=>{
          let d=r
          d.label=r.codigo+' '+r.nombre
          this.items.push(d)
        })
      })
    },
  },
  computed:{
    subtotal(){
      return Math.round(this.subitem.monto*this.subitem.cantidad)
    },
    boolrango(){
      if (this.nrocomprobante>=this.unidad.inicio && this.nrocomprobante<=this.unidad.fin){
        return false
      }else{
        return true
      }
    },
    total(){
      let s=0
      this.detalles.forEach(r=>{
        s+= parseInt( r.monto)
      })
      return s;
    }
  }
}
</script>

<style scoped>
#qr_code{
  display: none;
}
</style>
