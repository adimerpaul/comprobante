<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Unidad"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Nueva Unidad</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <q-input
              filled
              v-model="dato.codigo"
              type="text"
              label="Codigo de unidad"
              hint="Codigo de la unidad"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato.nombre"
              type="text"
              label="Nombre de Unidad"
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.inicio"
              type="number"
              label="Inicio de Comp"
              hint="Numero de Comp I"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.fin"
              type="number"
              label="Fin de Comp"
              hint="Numero de Comp F"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />


            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table dense title="Unidades" :data="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100,0]" :filter="filter">
      <template v-slot:top-right>
        <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar..">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-opcion="props">
        <q-td :props="props">
        <q-btn
            dense
            round
            flat
            color="yellow"
            @click="editRow(props)"
            icon="edit"
          />
          <q-btn
            dense
            round
            flat
            @click="comprobante(props)"
            color="secondary"
            icon="add_circle"
          />
          <q-btn
            dense
            round
            flat
            color="red"
            @click="deleteRow(props)"
            icon="delete"
          />
        </q-td>
      </template>
    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Modificar</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onMod" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.codigo"
              type="text"
              label="Codigo del Unidad"
              hint="Ingresar codigo"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.nombre"
              type="text"
              label="Nombre del Unidad"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.inicio"
              type="number"
              label="Numero Comp I"
              hint="Ingresar numero"
            />
            <q-input
              filled
              v-model="dato2.fin"
              type="number"
              label="Numero Comp F"
              hint="Ingresar numero"
            />
            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>


   <q-dialog v-model="dialog_del">
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel" />
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter:'',
      alert: false,
      dialog_mod: false,
      dialog_del: false,
      dato: {},
      dato2: {},
      options: [],
      props: [],
      unidades:[],
      uni:{},
      columns: [
        {name:"codigo",align: "right",label:"Codigo",field: "codigo",sortable: true},
        {name: "nombre", align: "left", label: "nombre", field: "nombre", sortable: true,},
        {name: "inicio", align: "left", label: "Inicio", field: "inicio", sortable: true,},
        {name: "fin", align: "left", label: "Fin", field: "fin", sortable: true,},
        { name: "opcion", label: "Opcion", field: "action", sortable: false },
      ],
      data: [],
    };
  },
  created() {
    this.misdatos();
  },
  methods: {
    comprobante(item){
      // this.dato2 = item.row;
      this.$q.dialog({
        title:'Numero de comprobante',
        prompt:{
          model:'',
          type:'number'
        },
        cancel:true,
        persistent:true
      }).onOk(data=>{
        // console.log(data);
        this.$q.loading.show()
        this.$axios.put(process.env.URL+'/unid/'+item.row.id,{inicio:data,fin: parseInt(data)+99}).then(res=>{
          this.$q.notify({
            message:'Modificado correctamente',
            icon:'cloud_done',
            color:'green-4'
          })
          this.misdatos()
        }).catch(err=>{
          this.$q.loading.hide()
          this.$q.notify({
            message:err.response.data.message,
            color:'red',
            icon:'error'
          })
        })
      })
    },
    misdatos() {
      this.$q.loading.show();
      this.$axios.get(process.env.URL + "/unid").then((res) => {
        // console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },

    editRow(item) {
      this.dato2 = item.row;
      this.dialog_mod = true;
    },
    deleteRow(item) {
      this.dato2 = item.row;
      this.dialog_del = true;
    },

    onSubmit() {
      this.$q.loading.show();
      this.$axios.post(process.env.URL + "/unid", this.dato).then((res) => {
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Creado correctamente",
        });
        this.alert = false;
        this.misdatos();
      });
    },
    onMod() {
      this.$q.loading.show();
      this.$axios
        .put(process.env.URL + "/unid/" + this.dato2.id, this.dato2)
        .then((res) => {
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Modificado correctamente",
          });
          this.dialog_mod = false;
          this.misdatos();
        });
    },

    onDel() {
      this.$q.loading.show();
      this.$axios.delete(process.env.URL + "/unid/" + this.dato2.id).then((res) => {
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Eliminado correctamente",
        });
        this.dialog_del = false;
        this.misdatos();
      });
    },

    onReset() {
      this.dato.nombre = null;
      this.dato.inicio = 0;
      this.dato.fin = 0;
    },
  },
};
</script>
