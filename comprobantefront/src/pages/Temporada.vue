<template>
<q-page class="q-pa-xs">
<div class="row">
  <div class="col-12">
    <q-form @submit="crearcomprobante" >
      <div class="row">
        <div class="col-3">
          <q-select @input="misregistros" dense outlined :options="temporadas" v-model="temporada" />
        </div>
        <div class="col-8">
          <q-select @input="pagotemporada" dense outlined :options="registros" v-model="registro" @filter="filterFn" use-input >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
        <div class="col-1 flex flex-center">
          <q-btn class="full-width" @click="dialogcrearregistro=true" icon="add_circle" color="positive"/>
        </div>
        <div class="col-2">
          <q-input dense outlined label="paterno" v-model="clientecobro.paterno"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="materno" v-model="clientecobro.materno"  />
        </div>
        <div class="col-3">
          <q-input dense outlined label="nombre" v-model="clientecobro.nombre"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="esposo" v-model="clientecobro.esposo"  />
        </div>
        <div class="col-3">
          <q-input dense outlined label="direccion" v-model="clientecobro.direccion"  />
        </div>
        <div class="col-12"></div>
        <div class="col-6">
          <q-input dense outlined label="categoria" v-model="rubrocobro.categoria"  />
        </div>
        <div class="col-6">
<!--          <q-input dense outlined label="nombre" v-model="rubrocobro.nombre"  />-->
          <q-select dense outlined :options="rubros" v-model="rubrocobro" @filter="filterFn2" use-input >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
<!--          <pre>{{rubrocobro}}</pre>-->
        </div>
        <div class="col-4">
          <q-input dense outlined label="temporada" v-model="rubrocobro.temporada"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="largo" v-model="registrocobro.largo"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="ancho" v-model="registrocobro.ancho"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="monto" v-model="rubrocobro.monto"  />
        </div>
        <div class="col-2">
          <q-input dense outlined label="monto + formualrio " :value="rubrocobro.monto+2"  />
        </div>
        <div class="col-12">
          <q-input dense outlined label="nrocomprobante" v-model="nrocomprobante" required />
        </div>
        <div class="col-12">
          <!--    <q-input dense outlined label="temporada" v-model="rubrocobro.temporada"  />-->
          <q-btn type="submit" class="full-width" :label="'Liquidar comprobante '+temporada.nombre" color="positive" icon="add_circle"  />
        </div>
      </div>
    </q-form>
  </div>
</div>
  <div class="row">
    <div class="col-12">
      <q-card>
        <q-card-section class="text-center text-bold q-pa-xs q-ma-xs bg-green">Reporte por tempotadas</q-card-section>
        <q-separator/>
        <q-card-section>
          <q-form @submit.prevent="reportecomprobantestotales">
            <div class="row">
              <div class="col-6">
                <q-select :options="temporadas"  dense outlined label="Temporada" v-model="reportetemporada"/>
              </div>
              <div class="col-6 flex flex-center">
                <q-btn class="full-width" label="reporte" icon="print" color="positive" type="submit" />
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </div>
  <q-dialog full-width full-height v-model="dialogcrearregistro">
    <q-card>
      <q-form @submit="createRegistro">
        <q-card-section class="text-h5 text-center">Registro a <small class="q-pa-xs text-white  bg-red-9">{{temporada.nombre}}</small></q-card-section>
      <q-separator/>
      <q-card-section>
          <div class="row">
            <div class="col-4"><q-input @input="buscarcliente" label="ci" v-model="ci" dense outlined /></div>
            <div class="col-4"><q-select :options="['','CH','LP','CB','OR','PT','TJ','SC','BE','PD','OTROS']" outlined dense square label="Expedido" v-model="cliente.expedido"/></div>
            <div class="col-4"><q-input label="paterno" v-model="cliente.paterno" dense outlined /></div>
            <div class="col-4"><q-input label="materno" v-model="cliente.materno" dense outlined /></div>
            <div class="col-4"><q-input label="nombre" v-model="cliente.nombre" dense outlined /></div>
            <div class="col-4"><q-input label="casada" v-model="cliente.casada" dense outlined /></div>
            <div class="col-4"><q-input label="direccion" v-model="cliente.direccion" dense outlined /></div>
            <div class="col-4"><q-input label="numcasa" v-model="cliente.numcasa" dense outlined /></div>
            <div class="col-4"><q-input label="telefono" v-model="cliente.telefono" dense outlined /></div>
          </div>
      </q-card-section>
      <q-card-section class="text-center text-subtitle2 q-pa-none">Datos Actividad</q-card-section>
      <q-separator/>
      <q-card-section>
        <div class="row">
          <div class="col-12">
            <q-select dense outlined :options="rubros" v-model="rubro" @filter="filterFn2" use-input >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <div class="col-3">
            <q-input dense outlined label="largo" v-model="largo" required/>
          </div>
          <div class="col-3">
            <q-input dense outlined label="ancho" v-model="ancho" required/>
          </div>
          <div class="col-6">
            <q-input dense outlined label="ubicacion" v-model="ubicacion" required/>
          </div>
          <div class="col-12">
            <q-btn type="submit" class="full-width" color="positive" icon="add_circle" :label="'registro de contribuyente a '+temporada.nombre" />
          </div>
        </div>
      </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
<!--  <q-dialog full-width full-height v-model="dialogcomprobante">-->
<!--    <q-card >-->
<!--      <q-card-section class="text-center text-bold">Ingresar numero de comprobante</q-card-section>-->
<!--      <q-separator/>-->
<!--      <q-card-section>-->
<!--        <q-form>-->
<!--        <div class="row">-->
<!--          <div class="col-12">-->
<!--            <q-input dense outlined label="nro comprobante" />-->
<!--          </div>-->
<!--          <div class="col-12">-->
<!--            <q-btn type="submit" class="full-width" color="positive" icon="add_circle" :label="'liquidar comprobante '+temporada.nombre" />-->
<!--          </div>-->
<!--        </div>-->
<!--        </q-form>-->
<!--      </q-card-section>-->
<!--    </q-card>-->
<!--  </q-dialog>-->
  <div id="qr_code">
  </div>
</q-page>
</template>

<script>
import {jsPDF} from "jspdf";
import $ from "jquery";
import {date} from "quasar";
import conversor from "conversor-numero-a-letras-es-ar";

export default {
  name: `Temporada`,
  data(){
    return{
      dialogcomprobante:false,
      nrocomprobante:'',
      ci:'',
      largo:'',
      ancho:'',
      ubicacion:'',
      cliente:{expedido:''},
      dialogcrearregistro:false,
      temporadas:[
        {label:"FERIA NORTE",nombre:"FERIA NORTE",coditem:"1534011",nombreitem:"Patentes por Temporadas (mercados)",codsubitem:"153401101",nombresubitem:"Patentes por Temporadas",detalle:"Patentes por Temporadas (mercados)"},
        {label:"FERIA SUD",nombre:"FERIA SUD",coditem:"1534011",nombreitem:"Patentes por Temporadas (mercados)",codsubitem:"153401101",nombresubitem:"Patentes por Temporadas",detalle:"Patentes por Temporadas (mercados)"},
        {label:"FERIA VINTO",nombre:"FERIA VINTO",coditem:"1534011",nombreitem:"Patentes por Temporadas (mercados)",codsubitem:"153401101",nombresubitem:"Patentes por Temporadas",detalle:"Patentes por Temporadas (mercados)"},
      ],
      reportetemporada:{label:"FERIA NORTE",nombre:"FERIA NORTE",coditem:"1534011",nombreitem:"Patentes por Temporadas (mercados)",codsubitem:"153401101",nombresubitem:"Patentes por Temporadas",detalle:"Patentes por Temporadas (mercados)"},
      temporada:{},
      registros:[],
      registros2:[],
      registro:{},
      rubros:[],
      rubros2:[],
      rubro:{},
      clientecobro:{},
      rubrocobro:{},
      registrocobro:{},
      nrotramite:'',
    }
  },
  created() {
    this.numcomprobante()
    this.temporada=this.temporadas[0]
    this.misregistros(this.temporada)
  },
  methods:{
    reportecomprobantestotales(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/reportemes',{inicio:'2022-03-31',fin:'2022-06-31'}).then(res=>{
        this.miscomprobantestotales=res.data
        let cm=this;
        function header(fecha){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
          doc.text(5, 1.5, cm.$store.state.user.unid.nombre+' '+cm.reportetemporada.label)
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
          // console.log(this.reportetemporada.label+' '+r.nrocomprobante.temporada)
          if (r.nrocomprobante!='' && r.nrocomprobante!=null && r.temporada==this.reportetemporada.label){
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
        doc.text(12, y+3.5, 'TOTAL RECAUDADCION: ')
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
    liquidarcomprobante(){

    },
    crearcomprobante(){
      this.$q.dialog({
        message:'Seguro de crear?',
        title:'Confirmar?',
        cancel:true,
      }).onOk(()=> {
        this.$q.loading.show()
        // this.detalles.forEach(r => {
        //   r.subtotal = r.precio * r.cantidad
        // })
        let detalles=[
          {
            coditem:'1220007',
            nombreitem:'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES',
            codsubitem:'122000701',
            nombresubitem:'Venta y reposición de formulario',
            detalle:'Venta y reposicion de formulario',
            precio:2,
            cantidad:1,
            monto:2
          },
          {
          'coditem':'1534011',
          'nombreitem':' Patentes por Temporadas (mercados)',
          'codsubitem':'153401101',
          'nombresubitem':'Patentes por Temporadas',
          'detalle':'Suma que ingresa por licencia y derecho de puesto eventual para funcionamiento de: ' + this.rubrocobro.nombre+' '+this.registrocobro.largo+'X'+ this.registrocobro.ancho+', '+this.registrocobro.ubicacion ,
          'precio':parseInt( this.rubrocobro.monto),
          'cantidad':1,
          'monto':parseInt( this.rubrocobro.monto),
          }
        ]
        this.$axios.post(process.env.URL + '/temporada', {
          nrotramite: this.nrotramite,
          // padron: this.padron,
          total: parseInt(this.rubrocobro.monto)+2,
          ci: this.clientecobro.ci,
          paterno: this.clientecobro.paterno,
          materno: this.clientecobro.materno,
          nombre: this.clientecobro.nombre,
          largo: this.registrocobro.largo,
          ancho: this.registrocobro.ancho,
          registro_id:this.registrocobro.id,
          rubro_id:this.rubrocobro.id,
          data:detalles,
          nrocomprobante:this.nrocomprobante,
        }).then((res) => {
          console.log(res.data)
          let dat=res.data[0]
          // return false
          this.clientecobro={}
          this.rubrocobro={}
          this.registrocobro={}
          this.nrocomprobante=''
          this.reporte(dat)

          // return false
          this.misregistros(this.temporada)
          this.$q.loading.hide()
          this.numcomprobante()
          // this.item = ''
          // this.subitem = ''
          // this.detalle = ''
          // this.ci = ''
          // this.paterno = ''
          // this.materno = ''
          // this.nombre = ''
          // this.padron = ''
          // this.expedido = ''
          // this.direccion = ''
          // this.numcasa = ''
          this.$q.notify({
            title: 'Creado ',
            message:'Creado correctamente',
            color: 'green',
            icon: 'check'
          })
          this.dialogcomprobante=false
        })
        .catch(err => {
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
    pagotemporada(registro){
      this.clientecobro=registro.cliente
      this.registrocobro=registro
      this.rubrocobro=registro.rubro
      this.rubrocobro.label=registro.rubro.nombre
      // console.log(this.registro)
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
      doc.text(x+3, y+10.5, this.temporada.nombre +' ' + date.formatDate(new Date(),'YYYY'));
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
      doc.setFontSize(10);
      doc.text('Segun Resolucion Administrativa Nº 10/2022 de 18/04/2022',x+2.5, y+14.5);
      doc.text('Segun Memorandum Nº 303/2022 de  22/04/2022',x+2.5, y+14.8);
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
    createRegistro(){
      this.$q.loading.show()
      // this.$q.loading.hide()
      this.$axios.get(process.env.URL+'/cliente/'+this.ci).then(res=>{
        this.dialogcrearregistro=false
        // console.log(res.data)
        if (res.data.length==0){
          this.$axios.post(process.env.URL+'/cliente',{
            ci:this.ci,
            expedido:this.cliente.expedido,
            paterno:this.cliente.paterno,
            materno:this.cliente.materno,
            nombre:this.cliente.nombre,
            casada:this.cliente.casada,
            direccion:this.cliente.direccion,
            numcasa:this.cliente.numcasa,
            telefono:this.cliente.telefono,
          }).then(res=>{
            let cliente_id=res.data.id
            this.$axios.post(process.env.URL+'/registro',{
              "temporada":this.temporada.nombre,
              "ubicacion":this.ubicacion,
              "coditem":'1534011',
              // "nombreitem":'Patentes por Temporadas (mercados)',
              "coditemsubitem":'153401101',
              // "nombresubitem":'Patentes por Temporadas',
              "detalle":'Suma que ingresa por licencia y derecho de puesto eventual para funcionamiento de:',
              "largo":this.largo==undefined?'':this.largo,
              "ancho":this.ancho==undefined?'':this.ancho,
              "cliente_id":cliente_id,
              "rubro_id":this.rubro.id,
            }).then(res=>{
              console.log(res.data)
              this.$q.loading.hide()
              this.misregistros(this.temporada)
            })

            // console.log(res.data)
          })
          return false
        }else{
          let clienteid=res.data[0].id
          this.$axios.post(process.env.URL+'/registro',{
            "temporada":this.temporada.nombre,
            "ubicacion":this.ubicacion,
            "coditem":'1534011',
            // "nombreitem":'Patentes por Temporadas (mercados)',
            "coditemsubitem":'153401101',
            // "nombresubitem":'Patentes por Temporadas',
            "detalle":'Suma que ingresa por licencia y derecho de puesto eventual para funcionamiento de:',
            "largo":this.largo==undefined?'':this.largo,
            "ancho":this.ancho==undefined?'':this.ancho,
            "cliente_id":clienteid,
            "rubro_id":this.rubro.id,
          }).then(res=>{
            console.log(res.data)
            this.$q.loading.hide()
            this.misregistros(this.temporada)
          })
        }
        return false
        // this.$q.loading.hide()
      })
      // this.$axios.post(process.env.URL+'/registro',{
      //   "temporada":this.temporada.nombre,
      //   "ubicacion":this.ubicacion,
      //   "coditem":'1534011',
      //   // "nombreitem":'Patentes por Temporadas (mercados)',
      //   "coditemsubitem":'153401101',
      //   // "nombresubitem":'Patentes por Temporadas',
      //   "detalle":'Suma que ingresa por licencia y derecho de puesto eventual para funcionamiento de:',
      //   "largo":this.largo,
      //   "ancho":this.ancho,
      //   "cliente_id":this.cliente.id,
      //   "rubro_id":this.rubro.id,
      // }).then(res=>{
      //   this.misregistros(this.temporada)
      // })
    },
    numcomprobante(){
      // this.$q.loading.show()
      this.$axios.get(process.env.URL+'/comprobante/1').then(res=>{
        this.nrotramite=this.$store.state.user.codigo+this.zfill(parseInt(res.data)+1,4);
        // this.$q.loading.hide()
      })
    },
    buscarcliente(ci){

      // this.$q.loading.show()
      this.cliente={expedido:''}
      if (ci!=''){
        this.$axios.get(process.env.URL+'/cliente/'+ci).then(res=>{
          // console.log(res.data)
          if (res.data.length==0){
            this.cliente={expedido:''}
          }else{
            this.cliente=res.data[0]
          }
        })
      }
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
    misregistros(temporada){
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/registro/'+temporada.nombre).then(res=>{
        this.registros=[]
        res.data.forEach(r=>{
          r.label=r.cliente.ci+' '+r.cliente.nombre+' '+r.cliente.paterno+' '+r.cliente.materno
          this.registros.push(r)
        })
        this.registro=this.registros[0]
        this.registros2=this.registros
        this.$q.loading.hide()
      })
      this.$axios.get(process.env.URL+'/rubro/'+temporada.nombre).then(res=>{
        this.rubros=[]
        res.data.forEach(r=>{
          r.label=r.nombre+' '+r.monto+'Bs'
          this.rubros.push(r)
        })
        this.rubro=this.rubros[0]
        this.rubros2=this.rubros
        // this.$q.loading.hide()
      })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.registros = this.registros2

          // with Quasar v1.7.4+
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.registros = this.registros2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    filterFn2 (val, update) {
      if (val === '') {
        update(() => {
          this.rubros = this.rubros2

          // with Quasar v1.7.4+
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.rubros = this.rubros2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
  }
}
</script>

<style scoped>
#qr_code{
  display: none;
}
</style>

