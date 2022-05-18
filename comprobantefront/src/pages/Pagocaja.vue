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
            <q-btn size="xs" label="Agregar corto" @click="crearcomprobantecorto" icon="warning" color="warning"/>
<!--            <q-btn size="xs" label="Agregar largo" @click="crearcomprobante" icon="add_circle" color="positive"/>-->
            <q-btn size="xs" label="Agregar de unidad" @click="crearcomprobanteunidad" icon="add_circle" color="positive"/>
            <q-input outlined dense v-model="filter" placeholder="Buscar">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>
          <template v-slot:body-cell-estado="props">
            <q-td :props="props">
              <q-badge :color="props.row.estado=='ANULADO'?'negative':'info'">{{props.row.estado}}</q-badge>
            </q-td>
          </template>
          <template v-slot:body-cell-opciones="props">
            <q-td :props="props">
              <q-btn v-if="esfechaigual(props.row.fecha,hoy) && props.row.cliente_id==2" @click="modificar(props.row)"  size="xs" color="warning" label="modificar" icon="edit"></q-btn>
              <q-btn v-if="esfechaigual(props.row.fecha,hoy) && props.row.cliente_id==2 && props.row.estado!='ANULADO'" @click="anular(props)"  size="xs" color="negative" label="Anular" icon="warning"></q-btn>
            </q-td>
          </template>
        </q-table>
      </div>
      <div class="col-12 q-pa-xs">
<!--        <q-btn color="info" :label="'Total '+ total +'BS'" class="full-width text-red text-bold"/>-->
<!--        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos"/>-->
        <div class="full-width text-center bg-red text-bold" > TOTAL {{total}} BS</div>
      </div>
      <div class="col-4 q-pa-xs">
        <q-btn class="full-width" @click="imprimir" color="secondary"  icon="print" label="Imprimir pagos usuario"/>
      </div>
      <div class="col-4 q-pa-xs">
<!--        <q-select :options="cajeros" label="cajero" outlined dense v-model="cajero"/>-->
        <q-btn class="full-width" @click="imprimircajatotales" color="info"  icon="print" label="Imprimir pagos todos"/>
      </div>
      <div class="col-4 q-pa-xs">
<!--        <q-btn class="full-width" @click="imprimirusuario" color="warning"  icon="print" label="Imprimir usuario"/>-->
      </div>
    </div>
    <q-dialog full-width v-model="modalcomprobante">
      <q-card >
        <q-card-section>
          <div class="text-h6">Insertar comprobante detallado</div>
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
                    <div class="col-3"><q-input @input="buscarcomprobante" label="nrocomprobante" outlined dense v-model="nrocomprobante"/></div>
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
                      <q-input style="width: 5em" label="monto" dense outlined v-model="props.row.monto"  />
                    </q-td>
                  </template>
                  <template v-slot:bottom >
                    <div class="full-width" style="text-align: right">
                      <div class="text-h5">{{totalcomprobante}} Bs</div>
                    </div>
                  </template>
                </q-table>
                <q-btn :disable="boolcrearcomprobante"  label="Crear comprobante" @click="insertcomprobante" icon="add_circle" color="positive" class="full-width" />
                <div style="width: 100%;" :class="boolcrearcomprobante?'bg-red':'bg-green'" class="text-white rounded-borders row flex-center "> {{boolcrearcomprobante?'COMPROBANTE YA INSERTADO':'COPROBANTE LIBRE'}}</div>

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
    <q-dialog full-width full-height v-model="modalcomprobantecorto">
      <q-card >
        <q-card-section>
          <div class="text-h6">Agregar comprobantes</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form @submit="insertcomprobantecorto">
            <div class="row">
              <div class="col-6"><q-input type="date" label="Fecha" outlined dense v-model="fechainsertar"/></div>
              <div class="col-6"><q-select dense outlined label="Unidad" :options="unidades" v-model="unidad" /></div>
              <template v-for="(c,i) in comprobantecorto" >
                <div :key="i" class="col-1 flex flex-center"><div class="text-h6">{{i+1}}</div></div>
                <div :key="i+1000" class="col-4"><q-input type="number" required @input="buscarcomprobante" label="nrocomprobante" outlined dense v-model="c.nrocomprobante"/></div>
                <div :key="i+2000" class="col-3"><q-input type="number" required label="Total" outlined dense v-model="c.total"/></div>
                <div :key="i+3000" class="col-2 flex flex-center"> <q-checkbox size="xs" keep-color color="red" label="Anulado?" v-model="c.anulado"/> </div>
                <div :key="i+4000" class="col-1 flex flex-center"><q-btn @click="agregarcomprobante" v-if="i==0" icon="add_circle" color="positive"/></div>
                <div :key="i+5000" class="col-1 flex flex-center"><q-btn @click="quitarcomprobante(i)" v-if="i!=0" icon="remove_circle" color="negative"/></div>
              </template>
              <div class="col-12">
                <div class="text-h4 q-pr-lg text-right">{{totalcomprobantecorto}} Bs</div>
              </div>
              <div class="col-12">
                <q-btn  type="submit" label="Registrar comprobantes"  icon="add_circle" color="positive" class="full-width" />
<!--                <div style="width: 100%;" :class="boolcrearcomprobante?'bg-red':'bg-green'" class="text-white rounded-borders row flex-center "> {{boolcrearcomprobante?'COMPROBANTE YA INSERTADO':'COPROBANTE LIBRE'}}</div>-->
              </div>
            </div>
          </q-form>
        </q-card-section>

        <q-card-actions align="right" >
          <q-btn flat label="cerrar" color="negative" icon="delete" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog full-width v-model="modalcomprobantemodificar">
      <q-card >
        <q-card-section>
          <div class="text-h6">Modificar comprobante</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-form>
            <div class="row">
              <div class="col-3"><q-input type="date" label="Fecha" outlined dense v-model="fechainsertar"/></div>
              <div class="col-3"><q-select dense outlined label="Unidad" :options="unidades" v-model="unidad" /></div>
              <div class="col-3"><q-input label="nrocomprobante" outlined dense v-model="nrocomprobante"/></div>
              <div class="col-3"><q-input label="Total" outlined dense v-model="totalcorto"/></div>
            </div>
          </q-form>
          <q-btn label="Modificar comprobante" @click="modificarcomprobantecorto" icon="add_circle" color="warning" class="full-width" />

        </q-card-section>

        <q-card-actions align="right" >
          <q-btn flat label="cerrar" color="negative" icon="delete" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-dialog full-width full-height v-model="modalcomprobantecorto">
      <q-card >
        <q-card-section>
          <div class="text-h6">Agregar comprobantes</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form @submit="insertcomprobantecorto">
            <div class="row">
              <div class="col-6"><q-input type="date" label="Fecha" outlined dense v-model="fechainsertar"/></div>
              <div class="col-6"><q-select dense outlined label="Unidad" :options="unidades" v-model="unidad" /></div>
              <template v-for="(c,i) in comprobantecorto" >
                <div :key="i" class="col-1 flex flex-center"><div class="text-h6">{{i+1}}</div></div>
                <div :key="i+1000" class="col-4"><q-input type="number" required @input="buscarcomprobante" label="nrocomprobante" outlined dense v-model="c.nrocomprobante"/></div>
                <div :key="i+2000" class="col-3"><q-input type="number" required label="Total" outlined dense v-model="c.total"/></div>
                <div :key="i+3000" class="col-2 flex flex-center"> <q-checkbox size="xs" keep-color color="red" label="Anulado?" v-model="c.anulado"/> </div>
                <div :key="i+4000" class="col-1 flex flex-center"><q-btn @click="agregarcomprobante" v-if="i==0" icon="add_circle" color="positive"/></div>
                <div :key="i+5000" class="col-1 flex flex-center"><q-btn @click="quitarcomprobante(i)" v-if="i!=0" icon="remove_circle" color="negative"/></div>
              </template>
              <div class="col-12">
                <div class="text-h4 q-pr-lg text-right">{{totalcomprobantecorto}} Bs</div>
              </div>
              <div class="col-12">
                <q-btn  type="submit" label="Registrar comprobantes"  icon="add_circle" color="positive" class="full-width" />
                <!--                <div style="width: 100%;" :class="boolcrearcomprobante?'bg-red':'bg-green'" class="text-white rounded-borders row flex-center "> {{boolcrearcomprobante?'COMPROBANTE YA INSERTADO':'COPROBANTE LIBRE'}}</div>-->
              </div>
            </div>
          </q-form>
        </q-card-section>

        <q-card-actions align="right" >
          <q-btn flat label="cerrar" color="negative" icon="delete" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog full-width full-height v-model="modalcomprobanteunidad">
      <q-card >
        <q-card-section>
          <div class="text-h6">Insertar comprobante por unidad</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-form>
            <div class="row">
              <div class="col-12">
                <q-form @submit.prevent="buscarcomprobantesdirecto">
                  <div class="row">
                    <div class="col-4"><q-input type="date" label="Fecha" outlined dense v-model="fechacomprobanteunidad"/></div>
                    <div class="col-4"><q-select dense outlined label="Unidad" :options="unidadesdirectos" v-model="unidaddirecto" /></div>
                    <div class="col-4"><q-btn type="submit" class="full-height full-width" color="info" icon="search" label="consultar" /></div>
                  </div>
                </q-form>
              </div>
              <div class="col-12">
                <q-table dense :columns="columnscomprobanteunidades" :data="comprobantesunidades" :filter="filtercomprobanteunidades">
                  <template v-slot:top-right>
                    <q-checkbox v-model="cobrartodo" @input="cambiocobrar"  color="red" label="Marcar todo" class="qq-pr-md"/>
                    <q-input outlined dense v-model="filtercomprobanteunidades" placeholder="Buscar comprobante">
                      <template v-slot:append>
                        <q-icon name="search" />
                      </template>
                    </q-input>
                  </template>
                  <template v-slot:body-cell-num="props">
                    <q-td :props="props">
                      <div class="text-subtitle2">{{props.pageIndex+1}}</div>
                    </q-td>
                  </template>
                  <template v-slot:body-cell-estado="props">
                    <q-td :props="props">
                      <q-badge v-if="props.row.estado=='ANULADO'" color="red" label="ANULADO"/>
                    </q-td>
                  </template>
                  <template v-slot:body-cell-cobrar="props">
                    <q-td :props="props">
                      <q-checkbox v-model="props.row.cobrar"  color="red" label="Cobrar"/>
                    </q-td>
                  </template>
                </q-table>
              </div>
              <div class="col-12 text-right text-h5">
                Total: {{totalcomprobantesunidades}} Bs - {{totalcomprobantesunidadesmarcado}} Bs
              </div>
            </div>
          </q-form>
          <q-btn @click="cobrarcomprobantedirecto" label="Cobrar comprobantes"  icon="add_circle" color="positive" class="full-width" />
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


import { jsPDF } from "jspdf"
import {date} from 'quasar'
import unid from "pages/Unid";

export default {
  data() {
    return {
      cobrartodo:false,
      filtercomprobanteunidades:'',
      modalcomprobanteunidad:false,
      fechacomprobanteunidad:date.formatDate(Date.now(),'YYYY-MM-DD'),
      boolcrearcomprobante:true,
      modalcomprobantemodificar:false,
      totalcorto:'',
      items:[],
      item:{},
      cajeros:[],
      cajero:{},
      comprobantecorto:[
        {nrocomprobante:'',anulado:false,total:0},
        {nrocomprobante:'',anulado:false,total:0},
        {nrocomprobante:'',anulado:false,total:0},
        {nrocomprobante:'',anulado:false,total:0},
        {nrocomprobante:'',anulado:false,total:0},
      ],
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
      columnscomprobanteunidades:[
        {name:'num',field:'num',label:'num', align:'center'},
        {name:'nrocomprobante',field:'nrocomprobante',label:'nrocomprobante', align:'left'},
        {name:'estado',field:'estado',label:'estado', align:'left'},
        {name:'total',field:'total',label:'total', align:'right'},
        {name:'cobrar',field:'cobrar',label:'cobrar', align:'left'},
      ],
      tab:'simple',
      comprobantesunidades:[],
      ci:'',
      paterno:'',
      materno:'',
      nombre:'',
      direccion:'',
      filter:'',
      model:'',
      modalcomprobante:false,
      modalcomprobantecorto:false,
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
      hoy:date.formatDate(Date.now(),'YYYY-MM-DD'),
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
        {name:'estado',label:'estado', align:'left',field:'estado',sortable:true},
        // {name:'nrotramite',label:'Numero tramite', align:'left',field:'nrotramite',sortable:true},
        // {name:'ci',label:'Carnet identidad', align:'left',field:'ci',sortable:true},
        {name:'cliente',label:'Contribuyente', align:'left',field:'cliente', sortable:true},
        // {name:'unidad',label:'Unidad', align:'left',field:'unidad',sortable:true},
        {name:'total',label:'Monto', align:'left',field:'total',    format: val => `${val} Bs`,sortable:true},
        {name:'cajero',label:'Cajero', align:'left',field:'cajero',sortable:true},
        {name:'opciones',label:'opciones', align:'left',field:'opciones',sortable:true},
      ],
      comprobantes:[],
      pagos:[],
      pagos2:[],
      unidades:[],
      unidad:'',
      unidadesdirectos:[],
      unidaddirecto:'',
      comprobante:''
    };
  },
  created() {
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      this.unidades=[{label:''}]
      // this.unidadesdirectos=[{label:''}]
      res.data.forEach(r=>{
        r.label=r.nombre
        if (r.id==9||r.id==10||r.id==7){
          this.unidades.push(r)
        }
        // if (r.id==1||r.id==2||r.id==3||r.id==4||r.id==5||r.id==6||r.id==7){
          this.unidadesdirectos.push(r)
        // }
      })
      this.unidad=this.unidades[0]
      this.unidaddirecto=this.unidadesdirectos[0]
      // this.unidades=res.data
      // console.log(this.unidades)
    }).catch(err=>{
      this.$q.notify({
        message:err.response.data.message,
        color:'red',
        icon:'error'
      })
    })
    this.$axios.get(process.env.URL+'/caja').then(res=>{
      this.cajeros=[]
      res.data.forEach(r=>{
        let d=r
        d.label=r.name
        this.cajeros.push(d)
        this.cajero=this.cajeros[0]
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
    cobrarcomprobantedirecto(){
      if (confirm("seguro de cobrar?")){
        this.$q.loading.show()
        this.$axios.post(process.env.URL+'/cobrarcomprobantedirecto',{datos:this.comprobantesunidades}).then(res=>{
          this.$q.loading.hide()
          this.mispagos()
          this.comprobantesunidades=[]
          this.modalcomprobanteunidad=false
          // console.log(res.data)
          // this.comprobantesunidades=[]
          // res.data.forEach(r=>{
          //   r.cobrar=false
          //   this.comprobantesunidades.push(r)
          // })
          // this.mispagos()
          // this.misanulados()
        })
      }
    },
    cambiocobrar(){
      // console.log(this.cobrartodo)
      this.comprobantesunidades.forEach(r=>{
        r.cobrar=this.cobrartodo
      })
    },
    buscarcomprobantesdirecto(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/buscarcomprobantesdirecto',{unid_id:this.unidaddirecto.id,fecha:this.fechacomprobanteunidad}).then(res=>{
        this.$q.loading.hide()
        console.log(res.data)
        this.comprobantesunidades=[]
        res.data.forEach(r=>{
          r.cobrar=false
          this.comprobantesunidades.push(r)
        })
        // this.mispagos()
        // this.misanulados()
      })
    },
    modificar(i){
      this.comprobante=i
      this.modalcomprobantemodificar=true
      this.fechainsertar=this.comprobante.fecha
      // console.log(this.comprobante)
      this.unidad=this.comprobante.unid
      this.unidad.label=this.comprobante.unid.nombre
      this.nrocomprobante=this.comprobante.nrocomprobante
      this.totalcorto=this.comprobante.total

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
          console.log(res.data)
          this.mispagos()
          // this.misanulados()
        })
      })
    },
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

        this.detalle=[
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
        ]
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
    modificarcomprobantecorto(){
      // console.log(this.comprobante)
      // return false
      this.$q.loading.show()
      this.$axios.put(process.env.URL + '/caja/'+this.comprobante.id, {
        total: this.totalcorto,
        fecha: this.fechainsertar,
        unid_id: this.unidad.id,
        nrocomprobante:this.nrocomprobante,
      }).then((res) => {
        console.log(res.data)
        this.totalcorto='',
          this.$q.loading.hide()
        // return false
        this.mispagos()
        this.detalle=[
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
        ]
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
    buscarcomprobante(){
      if (this.nrocomprobante!=''){
        this.$axios.get(process.env.URL + '/caja/'+this.nrocomprobante+'/edit').then(res=>{
          // console.log(res.data)
          if (res.data==0){
            this.boolcrearcomprobante=false
          }else {
            this.boolcrearcomprobante=true
          }
        })
      }
    },
    boolagregar(num1,num2){
      // console.log(num1+'   '+num2)
      if (parseInt(num1)==parseInt(num2)){
        return true
      }else{
        return  false
      }
    },
    agregarcomprobante(){
      this.comprobantecorto.push({nrocomprobante:'',anulado:false,total:0},)
    },
    quitarcomprobante(i){
      this.comprobantecorto.splice(i, 1)
    },
    insertcomprobantecorto(){
      // this.detalle.forEach(r => {
      //   r.subtotal = r.precio * r.cantidad
      // })
      if (!confirm("seguro de insertar?")){
        return false
      }
      if (this.unidad.id==undefined){
        this.$q.notify({
          title: 'Error',
          message: 'Debes selecionar la unidad',
          color: 'red',
          icon: 'error'
        })
        return false
      }
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/insertarcorto', {
        total: this.totalcorto,
        fecha: this.fechainsertar,
        datos:this.comprobantecorto,
        unid_id: this.unidad.id,
        // nrocomprobante:this.nrocomprobante,
      }).then((res) => {
        // console.log(res.data)
        this.unidad={label:''}
        this.comprobantecorto=[
          {nrocomprobante:'',anulado:false,total:0},
          {nrocomprobante:'',anulado:false,total:0},
          {nrocomprobante:'',anulado:false,total:0},
          {nrocomprobante:'',anulado:false,total:0},
          {nrocomprobante:'',anulado:false,total:0},
        ]
        this.totalcorto='',
        this.$q.loading.hide()
        // return false
        this.mispagos()
        this.detalle=[
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
        ]
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
          title: 'Insertado ',
          message:'Insertado correctamente!',
          color: 'green',
          icon: 'check'
        })
        this.modalcomprobantecorto=false
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
    esfechaigual(f1,f2){
      if (f1==f2){
        return true
      }else{
        return false
      }
    },
    crearcomprobante(){
      this.modalcomprobante=true
      // this.fechainsertar=date.formatDate(Date.now(),'YYYY-MM-DD')
      this.nrocomprobante=''
      this.totalcorto=''
    },
    crearcomprobantecorto(){
      this.modalcomprobantecorto=true
      // this.fechainsertar=date.formatDate(Date.now(),'YYYY-MM-DD')
      this.nrocomprobante=''
      this.totalcorto=''
    },
    crearcomprobanteunidad(){
      this.modalcomprobanteunidad=true
    },
    loscomprobantes(){
      this.model=''
      this.$q.loading.show()
      this.$axios.post(process.env.URL+'/loscomprobantes').then(res=>{
        // console.log(res.data)
        this.comprobantes=[]
        this.$q.loading.hide()

        res.data.forEach(r=>{
          let d=r
          d.label=r.nrocomprobante+' '+r.paterno+' '+r.materno+' '+r.nombre+' '
          d.nombrecompleto=r.paterno+' '+r.materno+' '+r.nombre
          this.comprobantes.push(d)
          // this.comprobantes.push({
          //   label:r.nrocomprobante+' '+r.paterno+' '+r.materno+' '+r.nombre+' ',
          //   id:r.id,
          //   detalles:r.detalles,
          //   nombrecompleto:r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre,
          //   padron:r.padron,
          //   ci:r.ci,
          //   total:r.total,
          // })
        })
      })
    },
    imprimirusuario(){
      // console.log(this.$store.state.user.id)
      function header(unidad,fecha){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
        doc.text(5, 1.5, unidad +' DE '+fecha)
        doc.text(1, 3, 'Nº COMPROBANTE')
        // doc.text(4, 3, 'Nº TRAMITE')
        doc.text(4, 3, 'CONTRIBUYENTE')
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
      let su=0
      this.pagos.forEach(r=>{
        // console.log(r.cajero_id)
        if (this.cajero.id==r.cajero_id){
          y+=0.5
          doc.text(1, y+3, r.nrocomprobante==undefined?'':r.nrocomprobante)
          // doc.text(4, y+3, r.nrotramite==undefined?'':r.nrotramite)
          doc.text(4, y+3, r.cliente==undefined?'':r.cliente)
          doc.text(11.5, y+3, r.ci==undefined?'':r.ci)
          doc.text(13.5, y+3, r.unid.nombre==undefined?'':r.unid.nombre)
          doc.text(18, y+3, r.total==undefined?'':r.total)
          doc.text(19, y+3, r.cajero ==undefined?'':r.cajero )
          su=su+parseInt(r.total)
          if (y+3>25){
            doc.addPage();
            header(this.fecha)
            y=0
          }
        }
      })
      doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4, su+' Bs')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    imprimircajatotales(){
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/caja/'+this.fecha).then(res=>{
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
        function header(unidad,fecha,contador){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
          doc.text(5, 1.5, unidad +' DE '+fecha +' USUARIO: '+cm.$store.state.user.name)
          doc.setFontSize(8);
          doc.text(15,1,'Fecha de Consulta:'+cm.hoy);
          doc.setFontSize(9);
          doc.text(1, 3, 'Nº COMPROBANTE')
          // doc.text(4, 3, 'Nº TRAMITE')
          doc.text(4, 3, 'CONTRIBUYENTE')
          doc.text(11.5, 3, 'CI/RUN')
          doc.text(13.5, 3, 'UNIDAD')
          doc.text(17, 3, 'MONTO BS.')
          doc.text(19, 3, 'CAJERO')
          doc.text('----- Pag ' +contador+' -----',10,26,'center');
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        // console.log(dat);
        doc.setFont("courier");
        doc.setFontSize(9);
        // var x=0,y=
        let contador=1
        header(this.$store.state.user.unid.nombre.toString(),this.fecha,contador)
        // let xx=x
        // let yy=y
        let y=0
        let total=0
        this.pagos2.forEach(r=>{
          // xx+=0.5

          // console.log(r)
          y+=0.5
          doc.text(1, y+3, r.nrocomprobante==undefined?'':r.nrocomprobante.substr(0,21))
          // doc.text(4, y+3, r.nrotramite==undefined?'):r.nrotramite
          doc.text(4, y+3, r.cliente==undefined?'':r.cliente.substr(0,33))
          doc.text(11.5, y+3, r.ci==undefined?'':r.ci)
          doc.text(13.5, y+3, r.unid.nombre==undefined?'':r.unid.nombre.substr(0,21))
          doc.text(18, y+3, r.total==undefined?'':r.total)
          doc.text(19, y+3, r.cajero ==undefined?'':r.cajero )
          total+=parseInt(r.total)
          if (y+3>25){
            doc.addPage();
            contador++
            header(this.$store.state.user.unid.nombre.toString(),this.fecha,contador)
            y=0
          }
        })
        doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
        doc.text(18, y+4, total+ ' Bs')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');

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
      let cm=this
      function header(unidad,fecha,contador){
        var img = new Image()
        img.src = 'logo.jpg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
        doc.text(5, 1.5, unidad +' DE '+fecha +' USUARIO: '+cm.$store.state.user.name)
        doc.setFontSize(8);
        doc.text(15,1,'Fecha de Consulta:'+cm.hoy);
        doc.setFontSize(9);
        doc.text(1, 3, 'Nº COMPROBANTE')
        // doc.text(4, 3, 'Nº TRAMITE')
        doc.text(4, 3, 'CONTRIBUYENTE')
        doc.text(11.5, 3, 'CI/RUN')
        doc.text(13.5, 3, 'UNIDAD')
        doc.text(17, 3, 'MONTO BS.')
        doc.text(19, 3, 'CAJERO')
        doc.text('----- Pag ' +contador+' -----',10,26,'center');
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      let contador=1
      header(this.$store.state.user.unid.nombre.toString(),this.fecha,contador)
      // let xx=x
      // let yy=y
      let y=0
      this.pagos.forEach(r=>{
        // xx+=0.5
        console.log(r)
        y+=0.5
        doc.text(1, y+3, r.nrocomprobante==undefined?'':r.nrocomprobante)
        // doc.text(4, y+3, r.nrotramite==undefined?'):r.nrotramite
        doc.text(4, y+3, r.cliente==undefined?'':r.cliente.substr(0,33))
        doc.text(11.5, y+3, r.ci==undefined?'':r.ci)
        doc.text(13.5, y+3, r.unid.nombre==undefined?'':r.unid.nombre.substr(0,21))
        doc.text(18, y+3, r.total==undefined?'':r.total)
        doc.text(19, y+3, r.cajero ==undefined?'':r.cajero )
        if (y+3>25){
          doc.addPage();
          contador++
          header(this.$store.state.user.unid.nombre.toString(),this.fecha,contador)
          y=0
        }
      })
      doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      doc.text(18, y+4, this.total+ ' Bs')
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
          let d=r
          d.cliente=r.paterno+' '+r.materno+' '+r.nombre
          this.pagos.push(d)
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
    },
    totalcomprobantecorto(){
      let total=0
      this.comprobantecorto.forEach(r=>{
        if (r.total!=''){
          total+=parseFloat(r.total)
        }
      })
      return total.toFixed(2)
    },
    totalcomprobantesunidades(){
      let total=0
      this.comprobantesunidades.forEach(r=>{
        if (r.total!=''){
          total+=parseFloat(r.total)
        }
      })
      return total.toFixed(2)
    },
    totalcomprobantesunidadesmarcado(){
      let total=0
      this.comprobantesunidades.forEach(r=>{
        if (r.total!=''&& r.cobrar){
          total+=parseFloat(r.total)
        }
      })
      return total.toFixed(2)
    },
  }
};
</script>

