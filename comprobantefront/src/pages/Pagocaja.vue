<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12 col-sm-9">
        <q-select
          outlined
          dense
          v-model="model"
          use-input
          input-debounce="0"
          label="Selecionar comprobante"
          :options="options"
          @filter="filterFn"
        >
          <template v-slot:no-option>
            <q-item>
              <q-item-section class="text-grey">
                No results
              </q-item-section>
            </q-item>
          </template>
        </q-select>
      </div>
      <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
        <q-btn icon="refresh" label="Actualizar" color="primary" @click="loscomprobantes"/>
      </div>

<!--      <div class="col-12 col-sm-6">-->
<!--        <q-input-->
<!--        outlined-->
<!--        label="Nro Comprobante"-->
<!--        v-model="nrocomprobante"-->
<!--        type="number"-->
<!--        lazy-rules-->
<!--        :rules="[-->
<!--          val=>val && val.length>0||'Porfavor llenar este campo',-->
<!--          val => val >= $store.state.user.unid.inicio && val <= $store.state.user.unid.fin || 'Tiene que estar en el rango de '+$store.state.user.unid.inicio+'-'+$store.state.user.unid.fin-->
<!--          ]"-->
<!--        />-->
<!--      </div>-->
      <div class="col-12 col-sm-3">
        <q-input
          outlined
          dense
          label="Nombre completo"
          v-model="model.nombrecompleto"
          disable
        />
      </div>
      <div class="col-12 col-sm-3">
        <q-input
          outlined
          dense
          label="Padron"
          v-model="model.padron"
          disable
        />
      </div>
      <div class="col-12 col-sm-2">
        <q-input
          outlined
          dense
          label="Carnet de identidad"
          v-model="model.ci"
          disable
        />
      </div>
      <div class="col-12 col-sm-1">
<!--        <q-input-->
<!--          label-color="white"-->
<!--          color="white"-->
<!--          bg-color="red-5"-->
<!--          outlined-->
<!--          label="TOTAL"-->
<!--          v-model="model.total"-->
<!--          disable-->
<!--        />-->
        <q-badge class="full-width full-height text-subtitle2">
          <b>TOTAL: </b> {{ model.total }} BS
        </q-badge>

      </div>
      <div class="col-12 col-sm-3 flex flex-center">
        <q-btn  @click="cancelar" icon="add_circle" label="Cobrar comprobante" color="warning" />
      </div>
      <div class="col-12 q-mb-lg">
        <q-table
        title="Detalle"
        dense
        :columns="columns"
        :data="model.detalles"
        />
      </div>
      <div class="col-8">
        <q-input dense label="fecha de cobro" outlined type="date" v-model="fecha"/>
      </div>
      <div class="col-4 flex flex-center">
        <q-btn color="info" icon="search" @click="mispagos" label="Buscar" class="" />
      </div>
      <div class="col-12 q-pt-md">
        <q-table
          dense
          title="Historial de cobros"
          :columns="pcolumns"
          :data="pagos"
          :filter="filter"
          :rows-per-page-options="[10,50,100,0]"
        >
          <template v-slot:top-right>
            <q-btn label="Agregar " @click="crearcomprobante" icon="add_circle" color="positive"/>
            <q-input outlined dense v-model="filter" placeholder="Buscar">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>
        </q-table>
      </div>
      <div class="col-12 q-pt-md">
        <q-btn color="info" :label="'Total '+ total +'BS'" class="full-width text-red text-bold"/>
        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>
      </div>
    </div>
    <q-dialog full-width v-model="modalcomprobante">
      <q-card >
        <q-card-section>
          <div class="text-h6">Medium</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-card>
            <q-tabs
              v-model="tab"
              dense
              class="text-grey"
              active-color="primary"
              indicator-color="primary"
              align="justify"
              narrow-indicator
            >
              <q-tab name="simple" label="Simple" />
              <q-tab name="unidades" label="Unidades" />
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
              <q-tab-panel name="simple">
<!--                <div class="text-h6">Crear comprobante</div>-->
                <q-form>
                  <div class="row">
                    <div class="col-3"><q-input type="date" label="Fecha" outlined dense v-model="fechainsertar"/></div>
                    <div class="col-3"><q-select dense outlined label="Unidad" :options="unidades" v-model="unidad" /></div>
                    <div class="col-3"><q-input label="nrocomprobante" outlined dense v-model="nrocomprobante"/></div>
                    <div class="col-3"><q-input label="ci" @input="buscarcliente" outlined dense v-model="ci"/></div>
                    <div class="col-3"><q-input label="paterno" outlined dense v-model="paterno"/></div>
                    <div class="col-3"><q-input label="materno" outlined dense v-model="materno"/></div>
                    <div class="col-3"><q-input label="nombre" outlined dense v-model="nombre"/></div>
                    <div class="col-3"><q-input label="direccion" outlined dense v-model="direccion"/></div>
                  </div>
                </q-form>
                <q-table dense :columns="columnscomprobante" :rows-per-page-options="[12]" :data="detalle">
                  <template v-slot:body-cell-coditem="props">
                    <q-td auto-width :rops="props" >
                      <q-input style="width: 15em" label="coditem" dense outlined v-model="props.row.coditem" @input="buscar(props.row,props.pageIndex)"  />
                    </q-td>
                  </template>
                  <template v-slot:body-cell-item="props">
                    <q-td auto-width :rops="props" >
                      {{props.row.item}}
                    </q-td>
                  </template>
                  <template v-slot:body-cell-monto="props">
                    <q-td auto-width :rops="props" align="right">
                      <q-input style="width: 5em" label="monto" dense outlined v-model="props.row.monto" @input="buscar(props.row,props.pageIndex)"  />
                    </q-td>
                  </template>
                  <template v-slot:bottom >
                    <div class="full-width" style="text-align: right">
                      <div class="text-h5">{{totalcomprobante}} Bs</div>
                    </div>
                  </template>
                </q-table>
                <q-btn label="Crear comprobante" @click="insertcomprobante" icon="add_circle" color="positive" class="full-width" />
              </q-tab-panel>
              <q-tab-panel name="unidades">
                <div class="text-h6">Alarms</div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
              </q-tab-panel>

            </q-tab-panels>
          </q-card>

        </q-card-section>

        <q-card-actions align="right" >
          <q-btn flat label="cerrar" color="negative" icon="delete" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
<!--    <div class="col-12 col-sm-3 q-pa-xs flex flex-center">-->
<!--      <q-btn icon="add_circle" label="Actualizar" color="positive" />-->
<!--    </div>-->

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
      items:[],
      item:{},
      detalle:[
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
        {coditem:'',item:'',monto:''},
      ],
      columnscomprobante:[
        {name:'coditem',field:'coditem',label:'coditem', align:'center'},
        {name:'item',field:'item',label:'item', align:'center'},
        {name:'monto',field:'monto',label:'monto', align:'right'},
      ],
      tab:'simple',
      ci:'',
      paterno:'',
      materno:'',
      nombre:'',
      direccion:'',
      filter:'',
      model:'',
      modalcomprobante:false,
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fechainsertar:date.formatDate(Date.now(),'YYYY-MM-DD'),
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
        {name:'ci',label:'Carnet identidad', align:'left',field:'ci',sortable:true},
        {name:'cliente',label:'Contribuyente', align:'left',field:'cliente', sortable:true},
        {name:'unidad',label:'Unidad', align:'left',field:'unidad',sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero',sortable:true},
      ],
      comprobantes:[],
      pagos:[],
      unidades:[],
      unidad:''
    };
  },
  created() {
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      this.unidades=[]
      res.data.forEach(r=>{
        let d=r
        d.label=r.nombre
        this.unidades.push(d)
        this.unidad=this.unidades[0]
      })
      // this.unidades=res.data
      // console.log(this.unidades)
    }).catch(err=>{
      this.$q.notify({
        message:err.response.data.message,
        color:'red',
        icon:'error'
      })
    })
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
    // this.miscomprobante()
    this.mispagos()
    // this.loscomprobantes()
  },
  mounted() {
    // console.log(this.$store.state.user.unid.nombre)
    this.loscomprobantes();
  },
  methods: {
    insertcomprobante(){
      // this.detalle.forEach(r => {
      //   r.subtotal = r.precio * r.cantidad
      // })
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/caja', {
        total: this.totalcomprobante,
        ci: this.ci,
        fecha: this.fechainsertar,
        paterno: this.paterno,
        materno: this.materno,
        nombre: this.nombre,
        direccion: this.direccion,
        data: this.detalle,
        unid_id: this.unidad.id,
        nrocomprobante:this.nrocomprobante,
      }).then((res) => {
        console.log(res.data)
        this.$q.loading.hide()
        // return false
        this.mispagos()

        this.detalle = ''
        this.ci = ''
        this.paterno = ''
        this.materno = ''
        this.nombre = ''
        this.padron = ''
        this.expedido = ''
        this.direccion = ''
        this.numcasa = ''
        this.nrocomprobante=''
        this.$q.notify({
          title: 'Creado ',
          message:'Creado correctamente',
          color: 'green',
          icon: 'check'
        })
        this.modalcomprobante=false
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
    buscar(i,index){
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
    crearcomprobante(){
      this.modalcomprobante=true
    },
    loscomprobantes(){
      this.model=''
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/loscomprobantes').then(res=>{
        // console.log(res.data)
        this.comprobantes=[]
        this.$q.loading.hide()
        res.data.forEach(r=>{
          this.comprobantes.push({
            label:r.nrocomprobante+' '+r.paterno+' '+r.materno+' '+r.nombre+' ',
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
    imprimir(){
      function header(unidad,fecha){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
        doc.text(5, 1.5, unidad +' DE '+fecha)
        doc.text(1, 3, 'Nº COMPROBANTE')
        doc.text(4, 3, 'Nº TRAMITE')
        doc.text(6.5, 3, 'CONTRIBUYENTE')
        doc.text(11.5, 3, 'CI/RUN')
        doc.text(13.5, 3, 'UNIDAD')
        doc.text(17, 3, 'MONTO BS.')
        doc.text(19, 3, 'CAJERO')
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
      this.pagos.forEach(r=>{
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.nrocomprobante)
        doc.text(4, y+3, r.nrotramite)
        doc.text(6.5, y+3, r.cliente)
        doc.text(11.5, y+3, r.ci)
        doc.text(13.5, y+3, r.unidad)
        doc.text(18, y+3, r.total)
        doc.text(19, y+3, r.cajero )
        if (y+3>25){
          doc.addPage();
          header(this.fecha)
          y=0
        }
      })
      doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4, this.total+'Bs')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    // miscomprobante(){
    //   this.$axios.post(process.env.URL+'/buscarimpreso').then(res=>{
    //     this.comprobantes=[]
    //     res.data.forEach(r=>{
    //       this.comprobantes.push({
    //         label:'padron:'+r.varios+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre+' nro:'+r.nrocomprobante,
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
      this.$axios.post(process.env.URL+'/mispagoscaja',{'fecha':this.fecha}).then(res=>{
        // console.log(res.data)

        this.$q.loading.hide()
        this.pagos=[]
        res.data.forEach(r=>{
          this.pagos.push({
            nrotramite:r.nrotramite,
            unidad:r.unid.nombre,
            nrocomprobante:r.nrocomprobante,
            cliente:r.paterno+' '+r.materno+' '+r.nombre,
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
      // if ( parseInt(this.nrocomprobante)< parseInt(this.$store.state.user.unid.inicio) || parseInt(this.nrocomprobante)> parseInt(this.$store.state.user.unid.fin)){
      //   this.$q.dialog({
      //     title:'Rango de comprobantes no permitidos'
      //   })
      //   return false;
      // }
      // return  false;
      this.$q.loading.show()
      this.$axios.put(process.env.URL+'/pagocaja/'+this.model.id)
        .then(res=>{
          this.loscomprobantes()
        // console.log(res.data)
        this.$q.loading.hide()
        this.model=''
        this.$q.dialog({
          title:'Cobro exitoso'
        })
        // this.miscomprobante()
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
      })
        .catch(err=>{
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
        total+=parseFloat(r.total)
      })
      return total.toFixed(2);
    },
    totalcomprobante(){
      let total=0
      this.detalle.forEach(r=>{
        if (r.monto!=''){
          total+=parseFloat(r.monto)
        }
      })
      return total.toFixed(2)
    }
  }
};
</script>

