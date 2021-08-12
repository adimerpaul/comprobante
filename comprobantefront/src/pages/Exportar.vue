<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12">
        <q-form @submit.prevent="historial">
          <div class="row">
            <div class="col-4 q-pa-xs">
              <q-input label="fecha de cobro" outlined type="date" v-model="fecha"/>
            </div>
<!--            <div class="col-4 q-pa-xs">-->
<!--              &lt;!&ndash;        <q-input label="fecha de cobro" outlined type="date" v-model="fecha"/>&ndash;&gt;-->
<!--              <q-select v-model="unidad" outlined :options="unidades" option-label="nombre" option-value="id" required/>-->
<!--            </div>-->

            <div class="col-4 q-pa-xs">
              <q-btn color="primary" type="submit" icon="search"  label="Buscar" class="full-width full-height" />
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12 q-pt-md">
        <q-table
          title="Historial de cobros"
          :columns="columns"
          :data="pagos"
        >
          <template v-slot:top-right>
            <q-btn
              color="primary"
              icon-right="archive"
              label="Exportar comprobantes"
              no-caps
              @click="exportTable"
            />
          </template>
        </q-table>
      </div>
      <div class="col-12 q-pt-md">
<!--        <q-btn color="info" :label="'Total '+ total +'BS'" class="full-width text-red text-bold"/>-->
        <!--        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>-->
      </div>
    </div>
  </q-page>
</template>
<script>
import { jsPDF } from "jspdf"
import {date} from 'quasar'
import { exportFile } from 'quasar'

function wrapCsvValue (val, formatFn) {
  let formatted = formatFn !== void 0
    ? formatFn(val)
    : val

  formatted = formatted === void 0 || formatted === null
    ? ''
    : String(formatted)

  formatted = formatted.split('"').join('""')
  /**
   * Excel accepts \n and \r in strings, but some other CSV parsers do not
   * Uncomment the next two lines to escape new lines
   */
  // .split('\n').join('\\n')
  // .split('\r').join('\\r')

  return `"${formatted}"`
}

export default {
  data() {
    return {
      model:'',
      unidad:'',
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      options: [
        // 'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
      ],
      nrocomprobante:'',
      // columns:[
      //   {name:'codsubitem',label:'Codigo', align:'left',field:'codsubitem',sortable:true},
      //   {name:'referencia',label:'Referencia', align:'left',field:'detalle',sortable:true},
      //   {name:'precio',label:'Precio', align:'left',field:'precio',    format: val => `${val} Bs`,sortable:true},
      //   {name:'cantidad',label:'Cantidad', align:'left',field:'cantidad',sortable:true},
      //   {name:'subtotal',label:'Subtotal', align:'left',field:'subtotal',    format: val => `${val} Bs`,sortable:true},
      // ],
      columns:[
        {name:'nrotramite',label:'nrotramite', align:'left',field:'nrotramite'},
        {name:'nrocomprobante',label:'nrocomprobante', align:'left',field:'nrocomprobante'},
        {name:'fecha',label:'fecha', align:'left',field:'fecha'},
        {name:'fechalimite',label:'fechalimite', align:'left',field:'fechalimite'},
        {name:'fechapago',label:'fechapago', align:'left',field:'fechapago'},
        {name:'fechaimpreso',label:'fechaimpreso', align:'left',field:'fechaimpreso'},
        {name:'tipo',label:'tipo', align:'left',field:'tipo'},
        {name:'item',label:'item', align:'left',field:'item'},
        {name:'padron',label:'padron', align:'left',field:'padron'},
        {name:'varios',label:'varios', align:'left',field:'varios'},
        {name:'total',label:'total', align:'left',field:'total'},
        {name:'literal',label:'literal', align:'left',field:'literal'},
        {name:'controlinterno',label:'controlinterno', align:'left',field:'controlinterno'},
        {name:'estado',label:'estado', align:'left',field:'estado'},
        {name:'cajero',label:'cajero', align:'left',field:'cajero'},
        {name:'usuarioimp',label:'usuarioimp', align:'left',field:'usuarioimp'},
        {name:'porcaja',label:'porcaja', align:'left',field:'porcaja'},

        {name:'uname',label:'uname', align:'left',field:'uname'},
        {name:'ucodigo',label:'ucodigo', align:'left',field:'ucodigo'},
        {name:'uemail',label:'uemail', align:'left',field:'uemail'},

        {name:'cname',label:'cname', align:'left',field:'cname'},
        {name:'ccodigo',label:'ccodigo', align:'left',field:'ccodigo'},
        {name:'cemail',label:'cemail', align:'left',field:'cemail'},

        {name:'iname',label:'iname', align:'left',field:'iname'},
        {name:'icodigo',label:'icodigo', align:'left',field:'icodigo'},
        {name:'iemail',label:'iemail', align:'left',field:'iemail'},

        {name:'cci',label:'cci', align:'left',field:'cci'},
        {name:'cexpedido',label:'cexpedido', align:'left',field:'cexpedido'},
        {name:'cpaterno',label:'cpaterno', align:'left',field:'cpaterno'},
        {name:'cmaterno',label:'cmaterno', align:'left',field:'cmaterno'},
        {name:'cpadron',label:'cpadron', align:'left',field:'cpadron'},
        {name:'cnombre',label:'cnombre', align:'left',field:'cnombre'},
        {name:'cdireccion',label:'cdireccion', align:'left',field:'cdireccion'},
        {name:'cnumcasa',label:'cnumcasa', align:'left',field:'cnumcasa'},
        {name:'ctelefono',label:'ctelefono', align:'left',field:'ctelefono'},

        {name:'unid_id',label:'unid_id', align:'left',field:'unid_id'},
        {name:'coditem',label:'coditem', align:'left',field:'coditem'},
        {name:'nombreitem',label:'nombreitem', align:'left',field:'nombreitem'},
        {name:'codsubitem',label:'codsubitem', align:'left',field:'codsubitem'},
        {name:'nombresubitem',label:'nombresubitem', align:'left',field:'nombresubitem'},
        {name:'detalle',label:'detalle', align:'left',field:'detalle'},
        {name:'precio',label:'precio', align:'left',field:'precio'},
        {name:'cantidad',label:'cantidad', align:'left',field:'cantidad'},
        {name:'subtotal',label:'subtotal', align:'left',field:'subtotal'},



      //   {name:'unidad',label:'Unidad', align:'left',field:'unidad',sortable:true},
      //   {name:'cliente',label:'Contribuyente', align:'left',field:'cliente', sortable:true},
      //   {name:'ci',label:'Carnet identidad', align:'left',field:'ci',sortable:true},
      //   {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
      //   {name:'cajero',label:'Cajero', align:'left',field:'cajero',sortable:true},
      ],
      comprobantes:[],
      pagos:[],
      unidades:[]
    };
  },
  created() {
    this.historial();
    // console.log(this.$store.state.user)
  },
  methods: {
    exportTable() {
      // console.log('a')
      // naive encoding to csv format
      const content = [ this.columns.map(col => wrapCsvValue(col.label)) ].concat(
        this.pagos.map(row => this.columns.map(col => wrapCsvValue(
          typeof col.field === 'function'
            ? col.field(row)
            : row[col.field === void 0 ? col.name : col.field],
          col.format
        )).join(','))
      ).join('\r\n')

      const status = exportFile(
        this.$store.state.user.unid.nombre+''+this.fecha+'.csv',
        content,
        'text/csv'
      )

      if (status !== true) {
        this.$q.notify({
          message: 'Browser denied file download...',
          color: 'negative',
          icon: 'warning'
        })
      }
    },
    historial(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/exportar',{fecha:this.fecha}).then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.pagos=[]
        res.data.forEach(r=>{
          this.pagos.push({
            nrotramite:r.nrotramite,
            nrocomprobante:r.nrocomprobante,
            fecha:r.fecha,
            fechalimite:r.fechalimite,
            fechapago:r.fechapago,
            fechaimpreso:r.fechaimpreso,
            tipo:r.tipo,
            item:r.item,
            padron:r.padron,
            varios:r.varios,
            total:r.total,
            literal:r.literal,
            controlinterno:r.controlinterno,
            estado:r.estado,
            cajero:r.cajero.codigo,
            usuarioimp:r.usuarioimp,
            porcaja:r.porcaja,
            uname:r.user.name,
            ucodigo:r.user.codigo,
            uemail:r.user.email,

            cname:r.cajero.name,
            ccodigo:r.cajero.codigo,
            cemail:r.cajero.email,

            iname:r.impreso.name,
            icodigo:r.impreso.codigo,
            iemail:r.impreso.email,

            cci:r.cliente.ci,
            cexpedido:r.cliente.expedido,
            cpaterno:r.cliente.paterno,
            cmaterno:r.cliente.materno,
            cpadron:r.cliente.padron,
            cnombre:r.cliente.nombre,
            cdireccion:r.cliente.direccion,
            cnumcasa:r.cliente.numcasa,
            ctelefono:r.cliente.telefono,

            unid_id:r.unid_id,
            coditem:r.coditem,
            nombreitem:r.nombreitem,
            codsubitem:r.codsubitem,
            nombresubitem:r.nombresubitem,
            detalle:r.detalle,
            precio:r.precio,
            cantidad:r.cantidad,
            subtotal:r.subtotal,

          })
        })
      }).catch(err=>{
        console.log(err)
        // this.$q.notify({
        //   message:err.response.data.message,
        //   color:'red',
        //   icon:'error'
        // })
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
