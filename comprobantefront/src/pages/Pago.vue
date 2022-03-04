<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12">
        <q-badge color="info">Ultimos 5 Nro comprobantes usados </q-badge>
        <q-btn label="Actualizar" @click="actualizar"  icon="send" color="info" size="xs" class="q-ma-xs" />
        <span v-for="(ultimo,index) in ultimos" :key="index">-{{ultimo.nrocomprobante}}-</span>
      </div>
      <div class="col-12 col-sm-6">
        <q-select
          outlined
          filled
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
      <div class="col-12 col-sm-5">
        <q-input
        outlined
        label="Nro Comprobante"
        v-model="nrocomprobante"
        type="number"
        lazy-rules
        @input="misrangos"
        :rules="[
          val=>val && val.length>0||'Porfavor llenar este campo',
          val => val >= min && val <= max || 'Tiene que estar en el rango de '+min+'-'+max
          ]"
        />
      </div>
      <div class="col-12 col-sm-1 ">
        <q-badge :color="color" class="full-width " text-color="white" :label="msg" />
      </div>
      <div class="col-12 col-sm-3">
        <q-input
          outlined
          label="Nombre completo"
          v-model="model.nombrecompleto"
          disable
        />
      </div>
      <div class="col-12 col-sm-3">
        <q-input
          outlined
          label="Padron"
          v-model="model.padron"
          disable
        />
      </div>
      <div class="col-12 col-sm-3">
        <q-input
          outlined
          label="Carnet de identidad"
          v-model="model.ci"
          disable
        />
      </div>
      <div class="col-12 col-sm-3">
        <q-input
          label-color="white"
          color="white"
          bg-color="red-5"
          outlined
          label="TOTAL"
          v-model="model.total"
          disable
        />
      </div>
      <div class="col-12">
        <q-table
        title="Detalle"
        dense
        :columns="columns"
        :data="model.detalles"
        />
        <q-btn @click="proforma" icon="add_circle" label="Proforma" color="warning" class="full-width"></q-btn>
        <q-btn @click="cancelar" icon="add_circle" label="Crear comprobante" color="positive" class="full-width"></q-btn>

      </div>
    </div>
    <div id="qr_code">
    </div>
  </q-page>
</template>

<script>
//const stringOptions = [
//'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
//]
import $ from 'jquery'
import { jsPDF } from "jspdf";


export default {
  data() {
    return {
      min:0,
      max:0,
      model:'',
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
      comprobantes:[],
      color:'',
      msg:'',
      ultimos:[]
    };
  },
  created() {
    this.miscomprobante()
    this.ultimoscomprobante()
    this.misrangos()
  },
  mounted() {

  },
  methods: {
    actualizar(){
      this.ultimoscomprobante()
      this.miscomprobante()
      this.misrangos()
    },
    ultimoscomprobante(){
      this.$axios.post(process.env.URL+'/ultimoscomprobante').then(res=>{
        // console.log(res.data)
        this.ultimos=res.data
      });
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
    miscomprobante(){
      this.$q.loading.show()
      this.$axios.get(process.env.URL+'/comprobante').then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.comprobantes=[]
        res.data.forEach(r=>{
          this.comprobantes.push({
            label:r.padron+' '+r.cliente.paterno+' '+r.cliente.materno+' '+r.cliente.nombre+' tram:'+r.nrotramite,
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

    cancelar(){
      if (this.nrocomprobante==''){
        this.$q.dialog({
          title:'Falta numero comprobante'
        })
        return false
      }
      if (this.model==''){
        this.$q.dialog({
          title:'Seleccione comprobante'
        })
        return false
      }
      // console.log(      parseInt(this.nrocomprobante)+'---'+this.$store.state.user.unid.fin)
      if ( parseInt(this.nrocomprobante)>parseInt(this.max) || parseInt(this.nrocomprobante)< parseInt(this.min)){
        this.$q.dialog({
          title:'Rango de comprobantes no permitidos!'
        })
        return false
      }
      // return  false
      this.$q.loading.show()
      this.$axios.put(process.env.URL+'/comprobante/'+this.model.id,{nrocomprobante:this.nrocomprobante}).then(
        async res=>{
        // console.log(res.data)
        this.nrocomprobante=''
        this.$q.loading.hide()
        this.model=''
        this.$q.dialog({
          title:'Creado exitoso'
        })
        this.miscomprobante()
        this.ultimoscomprobante()
          let dat=res.data[0];
          var doc = new jsPDF('p','cm','letter')
          // console.log(dat);
          doc.setFont("courier",'bold');
          doc.setFontSize(11);
          var x=0,y=-2;
          doc.text(x+14.5, y+5.1, 'TRAMITE N '+dat.nrotramite.toString());
          doc.text(x+9.5, y+7.5, dat.cliente.paterno.toString()+' '+dat.cliente.materno.toString()+' '+dat.cliente.nombre.toString());
          doc.text(x+9.5, y+9, dat.cliente.direccion.toString());
          doc.text(x+14, y+9, dat.cliente.numcasa.toString());
          doc.text(x+15.6, y+2, dat.cliente.ci.toString()+' '+dat.cliente.expedido.toString());
          doc.text(x+18, y+9, dat.cliente.telefono.toString());
          doc.text(x+3, y+9.5, dat.varios.toString());
          doc.text(x+9.5, y+10.5, 'OR '+ dat.fecha.toString());
          let xx=x+1.2
          let yy=x+9.7
          let lin=yy
          let cont=0
          let fin=50
          doc.setFontSize(8);
          dat.detalles.forEach(r=>{
            doc.text(xx, yy, r.coditem.toString());
            doc.text(xx+2.5, yy, r.nombreitem.toString());
            // doc.text(xx, yy, r.codsubitem.toString());
            doc.text(xx+14.5, yy, r.subtotal.toString()+' Bs');
            //count=r.detalle.toString().length
            if(r.detalle.toString().length<50)
              doc.text(xx+2.5, yy+0.3, r.detalle.toString());
            else{
              while (r.detalle.toString().length>=cont){
                doc.text(xx+2.5, yy+0.3, r.detalle.substring(cont,fin));
                //console.log(r.detalle.substring(cont,fin));
                //console.log(cont+ ' '+ fin)
                cont+=50;
                fin+=50
                yy+=0.3;
              }}
            yy+=0.6
            // console.log(r)
          })

          doc.text(x+15.5, y+15.5, dat.total.toString()+' Bs');
          doc.text(x+2, y+17.5, dat.literal.toString()+' 00/100Bs');
          doc.setFontSize(11);
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
            }, 250);
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


      }).catch(err=>{
        console.error(err);
        //this.$q.notify({
        //  message:err.response.data.res,
       //   icon:'error',
       //   color:'red'
       // })
        this.$q.loading.hide()
      })
    },

    proforma(){
      if (this.model==''){
        this.$q.dialog({
          title:'Seleccione comprobante'
        })
        return false;
      }
      this.$axios.post(process.env.URL+'/proforma/'+this.model.id).then(
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
        let yy=y+0.7
        dat2.detalles.forEach(r=>{
          doc.text(xx, yy, r.codsubitem.toString());
          doc.text(xx+2.5, yy, r.nombreitem.toString());
          // doc.text(xx, yy, r.codsubitem.toString());
          doc.text(xx+14.5, yy, r.subtotal.toString());
          doc.text(xx+2.5, yy+0.5, r.detalle.toString());
          yy++
          // console.log(r)
        })

        doc.text(xx+5.5, yy+1, 'TOTAL A PAGAR POR SERVICIOS TECNICOS: '+dat2.total.toString()+' Bs');

          // succesMessage es lo que sea que pasamos en la función resolve(...) de arriba.
          // No tiene por qué ser un string, pero si solo es un mensaje de éxito, probablemente lo sea.
          // console.log("¡Sí! " + successMessage);


          window.open(doc.output('bloburl'), '_blank');


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
      }
  },
};
</script>

<style scoped>
#qr_code{
  display: none;
}
</style>
