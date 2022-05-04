<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12">
      <q-form @submit.prevent="historial">
        <div class="row">
          <div class="col-4">
            <q-input dense label="fecha de cobro" outlined type="date" v-model="fecha"/>
          </div>
          <div class="col-4 flex flex-center">
            <q-btn color="primary" type="submit" icon="search"  label="Consultar"  />
          </div>
          <div class="col-4 flex flex-center">
          </div>
        </div>
      </q-form>
      </div>
      <div class="col-12">
        <q-table :data="resumenunidad" dense title="Resumen por unidad">

        </q-table>
      </div>
<!--      <div class="col-12 q-pt-md">-->

<!--        <q-table-->
<!--          dense-->
<!--        title="Historial de cobros"-->
<!--        :columns="pcolumns"-->
<!--        :data="pagos"-->
<!--          :filter="filter"-->
<!--          :rows-per-page-options="[10,50,100,0]"-->
<!--        >-->
<!--        <template v-slot:body="props">-->
<!--        <q-tr :props="props">-->
<!--          <q-td key="nrocomprobante" :props="props">-->
<!--            {{props.row.nrocomprobante}} <q-badge v-if="props.row.salto!=''" :label="props.row.salto" color="negative" />-->
<!--          </q-td>-->
<!--          <q-td key="unidad" :props="props">-->
<!--            {{props.row.unid.codigo}} {{props.row.unid.nombre}}-->
<!--          </q-td>-->
<!--          <q-td key="total" :props="props">-->
<!--            {{props.row.total}} - {{sumar(props.row.detalles)}} Bs-->
<!--            <q-badge v-if="props.row.total!=sumar(props.row.detalles)"  color="negative">N</q-badge>-->
<!--          </q-td>-->
<!--          <q-td key="estado" :props="props">-->
<!--            <q-badge :color="props.row.estado=='ANULADO'?'teal':props.row.estado=='PAGADO'?'positive':'negative'" :label="props.row.estado"/>-->
<!--          </q-td>-->
<!--          <q-td key="cajero" :props="props">-->
<!--            {{props.row.cajero}}-->
<!--          </q-td>-->
<!--          <q-td key="verificadosistema" :props="props" >-->
<!--            <q-checkbox  @input="actualizar(props.row)" size="xs" v-model="props.row.verificadosistema" />-->
<!--            <q-btn flat size="xs" @click="borrarcomprobante(props.row)" color="negative" icon="delete"  />-->
<!--            <q-btn @click="frmmodificar(props.row)" color="warning" size="xs" label="modificar" icon="edit" />-->
<!--          </q-td>-->
<!--          </q-tr>-->
<!--        </template>-->
<!--          <template v-slot:top-right>-->
<!--            <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar">-->
<!--              <template v-slot:append>-->
<!--                <q-icon name="search" />-->
<!--              </template>-->
<!--            </q-input>-->
<!--          </template>-->
<!--        </q-table>-->
<!--      </div>-->
<!--      <div class="col-12 q-pt-md">-->
<!--        <q-btn color="info" :label="'Total '+ totalsinverificar+' - '+total +' BS Son ' +totalcomprobantes+' comprobantes verificados'" class="full-width  text-bold"/>-->
<!--      </div>-->
      <div class="col-12">
        <q-form @submit.prevent="reportecomp">
          <div class="row">
            <div class="col-4 q-pa-md"><q-input dense label="Fecha 1" type="date" outlined v-model="fecha" /></div>
            <div class="col-4 q-pa-md"><q-input dense label="Fecha 1" type="date" outlined v-model="fecha2" /></div>
            <div class="col-4 q-pa-md flex flex-center"><q-btn type="submit" label="Resumen mes" color="accent" icon="search"/></div>
          </div>
        </q-form>
      </div>
      <div class="col-12">
        <q-form @submit.prevent="generarsubitem">
          <div class="row">
            <div class="col-3"><q-input dense label="Fecha Inicio" type="date" outlined v-model="buscar.inicio" /></div>
            <div class="col-3"><q-input dense label="Fecha Fin" type="date" outlined v-model="buscar.fin" /></div>
            <div class="col-3"><q-select dense label="Unidad"  outlined :options="unidades"  v-model="unidad" /></div>
            <div class="col-3 flex flex-center"><q-btn type="submit" label="Resumen dia" color="warning" icon="search"/></div>
          </div>
        </q-form>
      </div>
      <div class="col-12 q-pa-xs">
        <q-form @submit.prevent="reportecaja">
          <div class="row">
            <div class="col-12 ">
              <div class="text-center bg-green text-white">REPORTE CAJEROS</div>
            </div>
            <div class="col-4">
              <q-input dense label="fecha de cobro" outlined type="date" v-model="fechacaja1"/>
            </div>
            <div class="col-4">
              <q-input dense label="fecha de cobro" outlined type="date" v-model="fechacaja2"/>
            </div>
            <div class="col-4 flex flex-center">
              <q-btn type="submit" color="info" icon="print" label="reporte caja" class="" />
            </div>
          </div>
        </q-form>
      </div>

    </div>
    <q-dialog full-width v-model="modalcomprobante">
      <q-card >
        <q-card-section>
          <div class="text-h6">Modificar comprobante</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form>
            <div class="row">
              <div class="col-4"><q-input type="date" label="Fecha" outlined dense v-model="fechainsertar"/></div>
              <div class="col-4"><q-select dense outlined label="Unidad" :options="unidades" v-model="unidad" /></div>
              <div class="col-4"><q-input label="nrocomprobante" outlined dense v-model="nrocomprobante"/></div>
            </div>
          </q-form>
          <q-table dense :columns="columnscomprobante" :rows-per-page-options="[12]" :data="detalle">
            <template v-slot:body-cell-coditem="props">
              <q-td auto-width :rops="props" >
                <q-input style="width: 15em" label="coditem" dense outlined v-model="props.row.coditem" @input="buscarcomprobante(props.row,props.pageIndex)"  />
              </q-td>
            </template>
            <template v-slot:body-cell-item="props">
              <q-td auto-width :rops="props" >
                {{props.row.item}}
              </q-td>
            </template>
            <template v-slot:body-cell-monto="props">
              <q-td auto-width :rops="props" align="right">
                <q-input style="width: 5em" label="monto" dense outlined v-model="props.row.monto"   />
              </q-td>
            </template>
            <template v-slot:bottom >
              <div class="full-width" style="text-align: right">
                <div class="text-h5">{{totalcomprobante}} Bs - {{totalcomprobantedetalle}} Bs</div>
              </div>
            </template>
          </q-table>
          <q-btn label="Modificar comprobante" @click="modificarcomprobante()"  icon="edit" color="positive" class="full-width" />
        </q-card-section>
        <q-card-actions align="right" >
          <q-btn flat label="cerrar" color="negative" icon="delete" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
import { jsPDF } from "jspdf";
import {date} from 'quasar'
const { addToDate } = date

export default {
  data() {
    return {
      resumenunidad:[],
      modalcomprobante:false,
      totalcomprobante:'',
      items:[],
      item:{},
      columnscomprobante:[
        {name:'coditem',field:'coditem',label:'coditem', align:'center'},
        {name:'item',field:'item',label:'item', align:'center'},
        {name:'monto',field:'monto',label:'monto', align:'right'},
      ],
      fechainsertar:'',
      nrocomprobante:'',
      filter:'',
      model:'',
      ci:'',
      paterno:'',
      materno:'',
      nombre:'',
      direccion:'',
      detalle:[],
      // fecha2:date.formatDate(Date.now(),'YYYY-MM-DD'),
      //
      // fecha:date.formatDate( addToDate(Date.now(),{days:-1}) ,'YYYY-MM-DD'),
      fechacaja1:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fechacaja2:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fecha2:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      buscar:{inicio:date.formatDate(Date.now(),'YYYY-MM-DD'),fin:date.formatDate(Date.now(),'YYYY-MM-DD')},
      options: [
        // 'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
      ],

      // columns:[
      //   {name:'codsubitem',label:'Codigo', align:'left',field:'codsubitem',sortable:true},
      //   {name:'referencia',label:'Referencia', align:'left',field:'detalle',sortable:true},
      //   {name:'precio',label:'Precio', align:'left',field:'precio',    format: val => `${val} Bs`,sortable:true},
      //   {name:'cantidad',label:'Cantidad', align:'left',field:'cantidad',sortable:true},
      //   {name:'subtotal',label:'Subtotal', align:'left',field:'subtotal',    format: val => `${val} Bs`,sortable:true},
      // ],
      pcolumns:[
        {name:'nrocomprobante',label:'N comprobante', align:'left',field:'nrocomprobante',sortable:true},
        {name:'unidad',label:'Unidad', align:'left',field:'unidad',sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'estado',label:'Estado', align:'left',field:'estado'},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero'},
        {name:'verificadosistema',label:'Verificar', align:'left',field:'verificadosistema'},
      ],
      comprobantes:[],
      comprobante:{},
      pagos:[],
      unidades:[],
      unidad:{},
      selectodos:false,
      pagos2:[],
    };
  },
  created() {

    // this.miscomprobante()
    // this.mispagos()
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      this.unidades=[{label:"todos",unid_id:0}]
      res.data.forEach(r=>{
        let d=r
        d.label=r.nombre
        this.unidades.push(d)
      })
      this.unidad=this.unidades[0]
      // console.log(res.data)
    })
    this.historial()
    this.$axios.get(process.env.URL+'/todoitems').then(res=>{
      this.items=res.data
      // console.log(this.unidades)
    }).catch(err=>{
      this.$q.notify({
        message:err.response.data.message,
        color:'red',
        icon:'error'
      })
    })
  },
  methods: {
    reportecaja(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/reportecaja', {fechainicio:this.fechacaja1,fechafin:this.fechacaja2}).then(res=>{
        this.$q.loading.hide()
        // console.log(res.data)
        // console.log(res.data)
        this.pagos2=[]
        res.data.forEach(r=>{
          let d=r
          d.cliente=r.paterno+' '+r.materno+' '+r.nombre
          this.pagos2.push(d)
          // this.pagos.push({
          //   nrotramite:r.nrotramite,
          //   unidad:r.unid.nombre,
          //   nrocomprobante:r.nrocomprobante,
          //   cliente:r.paterno+' '+r.materno+' '+r.nombre,
          //   cajero:r.cajero,
          //   estado:r.estado,
          //   ci:r.cliente.ci,
          //   id:r.id,
          //   total:r.total,
          //   cajero_id:r.cajero_id,
          // })
        })
        this.$q.loading.hide()
        let cm=this
        function header(unidad,fecha){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
          doc.text(5, 1.5,  'CAJAS  DE '+cm.fechacaja1+' AL '+cm.fechacaja2 )
          doc.text(1, 3, 'Nº COMPROBANTE')
          // doc.text(4, 3, 'Nº TRAMITE')
          doc.text(4, 3, 'CONTRIBUYENTE')
          doc.text(11.5, 3, 'CI/RUN')
          doc.text(13.5, 3, 'UNIDAD')
          doc.text(17, 3, 'MONTO BS.')
          doc.text(20, 3, 'CAJERO')
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        // console.log(dat);
        doc.setFont("courier");
        doc.setFontSize(9);
        // var x=0,y=
        header(this.$store.state.user.unid.nombre.toString(),this.fecha)
        // let xx=x
        // let yy=y
        let y=0
        let total=0
        this.pagos2.forEach(r=>{
          // xx+=0.5
          console.log(r)
          y+=0.5
          doc.text(1, y+3, r.nrocomprobante==undefined?'':r.nrocomprobante.substr(0,21))
          // doc.text(4, y+3, r.nrotramite==undefined?'):r.nrotramite
          doc.text(4, y+3, r.cliente==undefined?'':r.cliente.substr(0,33))
          doc.text(11.5, y+3, r.ci==undefined?'':r.ci)
          doc.text(13.5, y+3, r.unid==null?'':r.unid.nombre==undefined?'':r.unid.nombre.substr(0,21))
          doc.text(19, y+3, r.total==undefined?'':r.total,'right')
          doc.text(20, y+3, r.cajero ==undefined?'':r.cajero )
          total+=parseInt(r.total)
          if (y+3>25){
            doc.addPage();
            header(this.fecha)
            y=0
          }
        })
        doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
        doc.text(18, y+4, total+ ' Bs')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');

      })
    },
    sumar(d){
      let s=0
      d.forEach(r=>{
        s+= parseInt(r.subtotal)
      })
      return s
    },
    modificarcomprobante(){
      this.$q.loading.show()
      this.$axios.put(process.env.URL + '/modificarcomprobantesistemas/'+this.comprobante.id, {
        // total: this.totalcorto,
        fecha: this.fechainsertar,
        unid_id: this.unidad.id,
        nrocomprobante:this.nrocomprobante,
        detalles:this.detalle
      }).then((res) => {
        console.log(res.data)
        this.totalcorto='',
          this.$q.loading.hide()
        // return false
        this.historial()
        // this.detalle=[
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        //   {coditem:'',item:'',monto:''},
        // ]
        this.ci = ''
        this.paterno = ''
        this.materno = ''
        this.nombre = ''
        this.padron = ''
        this.expedido = ''
        this.direccion = ''
        this.numcasa = ''
        this.nrocomprobante=''
        this.modalcomprobante=false
        this.$q.notify({
          title: 'Modificado ',
          message:'Modificado correctamente',
          color: 'green',
          icon: 'check'
        })
        this.modalcomprobantemodificar=false
      }).catch(err => {
        this.$q.loading.hide()
        this.$q.notify({
          title: 'Error ',
          message: err.response.data.message,
          color: 'red',
          icon: 'error'
        })
      })
    },
    buscarcliente(){
      this.paterno=''
      this.materno=''
      this.nombre=''
      // this.padron=''
      // this.expedido=''
      this.direccion=''
      // this.numcasa=''
      if (this.ci!='')
        this.$axios.get(process.env.URL+'/cliente/'+this.ci).then(res=>{
          if (res.data.length>0){
            this.paterno=res.data[0].paterno
            this.materno=res.data[0].materno
            this.nombre=res.data[0].nombre
            // this.padron=res.data[0].padron
            // this.expedido=res.data[0].expedido
            this.direccion=res.data[0].direccion
            // this.numcasa=res.data[0].numcasa
          }
        })
    },
    generarsubitem(){
      if(this.buscar.inicio<=this.buscar.fin){
       this.$axios.post(process.env.URL+'/reportitem',{
         inicio:this.buscar.inicio,
         fin:this.buscar.fin,
         unid_id:this.unidad.id,
       }).then(res=>{
         // console.log(res.data)
         //return false
         this.item=res.data;
          // console.log(res.data);
          this.imprimiritem();
       })
      }
    },
    imprimiritem(){
      let mc=this
      function header(fecha1,fecha2,hoy){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.setFontSize(7);
        doc.text(2,1,'GOBIERNO AUTONOMO MUNICIPAL DE ORURO')
        doc.text(2.5,1.2,'DIRECCION DE INGRESOS')
        doc.setFontSize(9);
        doc.text(15,1,'Fecha de Consulta:'+hoy);
        doc.setFontSize(11);
        doc.text(6, 2, 'RESUMEN DE INGRESOS POR COMPROBANTE DE CAJA')
        if (mc.unidad.unid_id==0){
          doc.text(6.5, 2.5, 'DEL: '+fecha1+' AL '+fecha2)
        }else{
          doc.text(3.5, 2.5, 'UNIDAD: '+mc.unidad.label+' DEL: '+fecha1+' AL '+fecha2)
        }
        doc.text(0.5, 3.2, 'ITEM')
        doc.text(3, 3.2, 'DESCRIPCION')
        doc.text(16, 3.2, 'NRO TRAM')
        doc.text(19, 3.2, 'MONTO BS')
        doc.text(0.5, 3.2, '_________________________________________________________________________________________')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");

      // var x=0,y=
      header(this.buscar.inicio,this.buscar.fin,date.formatDate(Date.now(),'YYYY-MM-DD'))
      // let xx=x
      // let yy=y
      let y=0
      let cont=0
      let sum=0
      doc.setFontSize(10);
      this.item.forEach(item=>{
        cont++
        doc.text(0.5, y+3.6, item.cod);
        doc.text(3, y+3.6, item.nombre.substring(0,60));
        doc.text(16.5, y+3.6, ''+item.cantidad);
        doc.text(20, y+3.6, ''+item.monto,{align: 'right',});
        y+=0.4
        sum+=parseInt(item.monto)
        // if (cont==60){
        //   cont=0
        //   doc.addPage();
        //   header(this.buscar.inicio,this.buscar.fin,date.formatDate(Date.now(),'YYYY-MM-DD'))
        //    // doc.setFont(undefined,'bold')
        //   y=0;
        // }
      });
      doc.setFont(undefined,'bold')
      doc.text(3, y+3.3, '______________________________________________________________________________')
      doc.text(4, y+3.8, 'TOTAL RECAUDACION: ')
      doc.text(20.5, y+3.8, ''+new Intl.NumberFormat('es-MX').format(sum)+' BS',{align: 'right',})
      doc.setFont(undefined,'normal')
      doc.text(16.5, y+3.8, ''+this.tramite)
      window.open(doc.output('bloburl'), '_blank');
    },
    actualizar(comprobante){
      // console.log(comprobante)
      this.$axios.put(process.env.URL+'/sistema/'+comprobante.id,comprobante).then(res=>{
        // console.log(res.data)
      })
    },
    buscarcomprobante(i,index){
      // console.log(this.items)
      this.item=this.items.find(d=>d.codigo==i.coditem)
      if (this.item!=undefined){
        // console.log(this.item.nombre)
        this.detalle[index].item=this.item.nombre
      }
      // console.log(this.item)
      // this.$axios.post(process.env.URL+'/nombreitem',{coditem:i.coditem}).then(res=>{
      //
      //   if(res.data.length>0){
      //     console.log(this.detalle[index])
      //     this.detalle[index].item="asa"
      //     // this.detalle[index]={coditem:res.data[0].coditem,item:res.data[0].nombre};
      //   }
      //   else{
      //     this.detalle[index]={coditem:i.coditem,item:''};
      //   }
      // })
    },
    borrarcomprobante(comprobante){
      // console.log(comprobante)
      if (confirm('Seguro de eliminar!!!!')){
        this.$axios.delete(process.env.URL+'/sistema/'+comprobante.id).then(res=>{
          this.$q.loading.show()
          // console.log(res.data)
          this.historial()
        })
      }
    },
    frmmodificar(comprobante){
      this.comprobante=comprobante
      console.log(this.comprobante)
      this.unidad=this.comprobante.unid
      this.unidad.label=this.comprobante.unid.nombre
      this.fechainsertar=this.comprobante.fecha
      this.nrocomprobante=this.comprobante.nrocomprobante
      this.totalcomprobante=this.comprobante.total
      // this.ci=this.comprobante.ci
      // this.paterno=this.comprobante.paterno
      // this.materno=this.comprobante.materno
      // this.nombre=this.comprobante.nombre
      // this.direccion=this.comprobante.direccion
      this.detalle=[]
      this.comprobante.detalles.forEach(r=>{
        let d=r
        d.item=r.nombreitem
        d.coditem=r.coditem
        d.monto=r.subtotal
        this.detalle.push(d)
      })
      for (let i=0;i<=(12-this.detalle.length);i++){
        this.detalle.push({coditem:'',item:'',monto:''})
      }
      this.modalcomprobante=true
    },
    reportecomp(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/reportecomp',{inicio:this.fecha,fin:this.fecha2,}).then(res=>{
        function header(un,fec1,fec2,fec3){
          doc.setFont("courier");
          doc.setFontSize(10);

          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(3, 1, 'H. GOBIERNO MUNICIPAL DE ORURO')
          // doc.text(3, 1.5, '  JEFATURA DE RECAUDACIONES')
          doc.text(15, 1.5, 'Fecha de Proceso '+fec1)
          doc.text(8, 2.5, 'REGISTRO DE COMPROBANTES DE CAJA ')
          doc.text(5, 3, 'RESUMEN MENSUAL DE COMPROBANTES DEL ' + fec2 +' AL '+ fec3)
          // doc.setFontSize(10);
          // doc.text(.5, 4, 'FECHA DE PAGO')
          // doc.text(3, 4, 'Nº COMPROBANTE')
          // doc.text(5, 4, 'Nº TRAMITE')
          // doc.text(7, 4, 'CONTRIBUYENTE')
          // doc.text(15, 4, 'CI/RUN/RUC')
          // doc.text(17, 4, 'MONTO BS.')
          // doc.text(19, 4, 'USUARIO')
          // doc.text(20, 4, 'ESTADO')
          doc.setFont(undefined,'normal')
          // doc.setFontSize(10);
        }
        var doc = new jsPDF('p','cm','letter')
        // console.log(dat);

        // var x=0,y=
        header(this.$store.state.user.unid.nombre,date.formatDate(Date.now(),'YYYY-MM-DD'),this.fecha,this.fecha)
        // console.log(res.data)
        doc.setFontSize(10)
        let y=0
        let x=0
        let f='*'
        let a=0.5
        let cont=0;
        res.data.forEach(r=>{
          // xx+=0.5
          // console.log(r)
          cont++
          a=0
          if (f!=r.fecha){
            doc.setFont(undefined,'bold')
            f=r.fecha
            doc.text(x+1, y+3.5, r.fecha)
            doc.text(x+4.5, y+3.5, 'TALONARIOS' )
            a=0.30
            doc.setFont(undefined,'normal')
            cont++
          }
          doc.text(x+0.5, y+a+3.5, r.nombre.substring(0,20))
          doc.setFontSize(9)
          doc.text(x+4.8, y+a+3.5, r.menor+'-'+r.mayor)
          doc.setFontSize(10)
          // doc.text(x+6, y+a+3.5, r.mayor )
          if (a==0){
            y+=0.35
          }else{
            y=y+0.35+a
          }
          if (cont==66){
            // doc.addPage();
            // cont=0
            // header(this.$store.state.user.unid.nombre,this.ahora,this.fecha.inicio,this.fecha.fin)
            y=0
            x+=7
          }
          if (cont==(66*2)){
            y=0
            x+=7
          }
          if (cont==(66*3)){
            y=0
            x=0.5
            cont=0
            doc.addPage();
            header(this.$store.state.user.unid.nombre,date.formatDate(Date.now(),'YYYY-MM-DD'),this.fecha,this.fecha)
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
        this.$q.loading.show()

        this.$axios.post(process.env.URL+'/sistema',{
          datos:this.pagos
        }).then(res=>{
          // this.pagos=[]
          // this.$q.loading.hide()
          this.historial();
          // console.log(res.data)
          this.$q.notify({
            message:'Verificado exitoso',
            color:'green',
            icon:'check'
          })
        }).catch(err=>{
          this.$q.loading.hide()
          this.$q.notify({
            message:err.response.data.message,
            color:'red',
            icon:'error'
          })
        })
        // this.pagos.forEach(elemt=>{
        //   // if(elemt.verificadosistema)
        //    this.$axios.post(process.env.URL+'/verificadosistema',elemt);
        // });
        // this.$q.dialog({
        //   title:'Verificado Exitoso'
        // })
        // this.historial();
      },
    historial(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/historial3',{fecha:this.fecha,unid_id:this.unidad.id}).then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.pagos=[];
        let salto=0
        res.data.forEach(r => {
          // console.log(r)
          salto++
          // r.salto=salto+' '+parseInt(r.nrocomprobante)
          if (salto!=parseInt(r.nrocomprobante)){
            salto=parseInt(r.nrocomprobante)
            r.salto='S'
          }else{
            r.salto=''
          }

          if(r.verificadosistema==1){
            r.verificadocaja=true;
            r.verificadosistema=true;
          }else{
            r.verificadosistema=false;
          }
          this.pagos.push(r);
        });
        this.pagos=res.data;
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })

      this.$axios.post(process.env.URL+'/resumenporunidad',{fecha:this.fecha}).then(res=>{
        // console.log(res.data)
        this.resumenunidad=res.data
        this.$q.loading.hide()

      }).catch(err=>{
        this.$q.loading.hide()
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
      // console.log(this.pagos)
      let total=0
      this.pagos.forEach(r=>{
        if (r.verificadosistema){
          total+=parseFloat(r.total)
        }
      })
      return total
    },
    totalsinverificar() {
      // console.log(this.pagos)
      let total=0
      this.pagos.forEach(r=>{
          total+=parseFloat(r.total)
      })
      return total
    },
    totalcomprobantes() {
      // console.log(this.pagos)
      let total=0
      this.pagos.forEach(r=>{
        if (r.verificadosistema){
          total++;
        }

      })
      return total;
    },

    totalcomprobantedetalle(){
      let total=0
      this.detalle.forEach(r=>{
        if (r.monto!=''){
          total+=parseFloat(r.monto)
        }
      })
      return total.toFixed(2)
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
