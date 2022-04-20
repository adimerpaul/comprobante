<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-table dense :rows-per-page-options="[20,100,200,0]" title="Modificar Comprobantes" :data="miscomprobantes" :columns="columnscomprobantes" row-key="name" :filter="filter">
        <template v-slot:top-right>
          <q-input outlined dense  v-model="filter" placeholder="Buscar">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-opciones="props">
          <q-td :props="props">
            <q-btn  @click="modificar(props.row)" label="modificar" icon="edit" color="warning" size="xs"/>
          </q-td>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog v-model="dialogcomprobante" full-width>
    <q-card >
      <q-card-section class="bg-warning text-white">
        <div class="text-h6 "> <q-icon name="edit"/> MODIFICAR DE INGRESOS</div>
      </q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit="modificarcomprobante">
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
              <q-input color="red"  label-color="red" square label="Monto" dense outlined :value="subtotal" />
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
              <q-btn type="submit" class="full-width" icon="check_circle" color="warning" :label="'Modificar comprobante '+ total +' Bs'"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-actions align="right" class="bg-white text-teal">
        <q-btn icon="delete" color="negative" label="cancelar" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</q-page>
</template>
<script>
export default {
  data(){
    return {
      columnscomprobantes:[
        {name:'nrocomprobante',label:'nrocomprobante',field:'nrocomprobante',sortable:true},
        {name:'fecha',label:'fecha',field:'fecha',sortable:true},
        {name:'nrotramite',label:'nrotramite',field:'nrotramite',sortable:true},
        {name:'contribuyente',label:'contribuyente',field:'contribuyente',sortable:true},
        {name:'opciones',label:'opciones',field:'opciones'},
      ],
      miscomprobantes:[],
      micomprobante:{},
      filter:'',
      dialogcomprobante:false,
      ci:'',
      paterno:'',
      materno:'',
      nombre:'',
      padron:'',
      expedido:'',
      direccion:'',
      numcasa:'',
      nrotramite:'',
      items:[],
      item:'',
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
      detalle:'',
      subitems:[],
      subitem:{monto:0,cantidad:0,label:''},
    }
  },
  created() {
    this.miscomprobantesmercados()
    this.misitems()
  },
  methods:{
    quitardetalle(item){
      this.detalles.splice(item, 1)
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
    agregardetalle(){
      this.detalles.push({
        coditem:this.item.codigo,
        nombreitem:this.item.nombre.trim(),
        codsubitem:this.subitem.codigo,
        nombresubitem:this.subitem.nombre.trim(),
        detalle:this.subitem.nombre.trim(),
        precio:this.subitem.monto,
        cantidad:this.subitem.cantidad,
        monto:this.subitem.monto*this.subitem.cantidad
      })
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
    modificar(comprobante){
      this.subitem={monto:0,cantidad:0,label:''}
      this.micomprobante=comprobante
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
      this.dialogcomprobante=true
      this.ci = this.micomprobante.ci
      this.paterno = this.micomprobante.paterno
      this.materno = this.micomprobante.materno
      this.nombre = this.micomprobante.nombre
      this.padron = this.micomprobante.cliente.padron
      this.expedido = this.micomprobante.cliente.expedido
      this.direccion = this.micomprobante.cliente.direccion
      this.numcasa = this.micomprobante.cliente.numcasa
      this.nrotramite=this.micomprobante.nrotramite
      // console.log(this.micomprobante)
      // console.log('s');
    },
    modificarcomprobante(){
      this.$q.dialog({
        message:'Seguro de modificar?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=> {
        this.$q.loading.show()
        this.detalles.forEach(r => {
          r.subtotal = r.precio * r.cantidad
        })
        this.$axios.put(process.env.URL + '/mercado/1', {
          nrotramite: this.nrotramite,
          comprobante_id:this.micomprobante.id,
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
            title: 'modificado ',
            message:'modificado correctamente',
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
    miscomprobantesmercados() {
      this.$q.loading.show()
      this.$axios.get(process.env.URL + '/mercado').then(res=>{
        this.miscomprobantes=[]
        res.data.forEach(r=>{
          let d=r
          d.contribuyente=r.paterno+' '+r.materno+' '+r.nombre
          this.miscomprobantes.push(d)
        })
        this.$q.loading.hide()
      })
    }
  },
  computed:{
    subtotal(){
      return parseInt(this.subitem.monto)*parseInt(this.subitem.cantidad);
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

</style>
