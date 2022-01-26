<template>
<q-page class="q-pa-xs">
  <q-table dense title="Reimprimir comprobante" :data="reimprimir" :columns="columns" >
    <template v-slot:body-cell-opciones="props">
      <q-td :props="props">
        <q-btn @click="imprimir(props.row)" label="Reimprimir" size="xs" color="primary" icon="print" />
      </q-td>
    </template>
  </q-table>
  <div id="qr_code">
  </div>
</q-page>
</template>
<script>
import {jsPDF} from "jspdf";
import $ from "jquery";

export default {
  data(){
    return{
      reimprimir:[],
      columns:[
        {label:'fecha',field:'fecha',name:'fecha'},
        {label:'nrocomprobante',field:'nrocomprobante',name:'nrocomprobante'},
        {label:'Opciones',field:'opciones',name:'opciones'},
      ]
    }
  },
  created() {
    this.$q.loading.show()
    this.$axios.post(process.env.URL+'/reimprimir').then(res=>{
      // console.log(res.data)
      this.reimprimir=res.data
      this.$q.loading.hide()
    })
  },
  methods:{
    imprimir(comprobante){
      this.$axios.post(process.env.URL+'/imprimir',{id:comprobante.id}).then(res=>{
        // console.log(res.data)
        // this.reimprimir=res.data
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
      })
    }
  }
}
</script>
<style scoped>
#qr_code{
  display: none;
}
</style>
