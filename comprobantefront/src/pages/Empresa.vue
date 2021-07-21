<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Empresa"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Nueva Empresa</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <q-input
              filled
              v-model="dato.razonsocial"
              type="text"
              label="Nombre Empresa"
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.nit"
              type="number"
              label="Numero de Nit"
              hint="Ingresar NIT"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato.direccion"
              type="text"
              label="Direccion"
              hint="Ingresar la direccion"
            />
            <q-input
              filled
              v-model="dato.telefono"
              type="text"
              label="telefono"
              hint="Ingresar la telefono"
            />

            <q-input
              filled
              v-model="dato.padron"
              type="text"
              label="Padron"
              hint="Ingresar el padron"
                lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              v-model="cliente.ci"
              type="text"
              label="CI representante"
              hint="Ingresar Ci"
               lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              readonly
              v-model="cliente.nombre"
              type="text"
              label="Nombre Cliente"
            />

            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table title="Empresa" :data="data" :columns="columns" 
    row-key="name">
      <template v-slot:body-cell-opcion="props">
        <q-td :props="props">
            <q-btn
            dense
            round
            flat
            color="yellow"
            @click="editRow(props)"
            icon="edit"
          ></q-btn>
          <q-btn
            dense
            round
            flat
            color="red"
            @click="deleteRow(props)"
            icon="delete"
          ></q-btn>
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
              label="Codigo Item"
              readonly
            />

            <q-input
              filled
              v-model="dato2.nombre"
              type="text"
              label="Nombre del Item"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
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
      alert: false,
      dialog_mod: false,
      dialog_del: false,
      filter:'',
      dato: {},
      dato2: {},
      options: [],
      props: [],
      uni:{},
      
      columns: [
        {
          name: "nit",
          required: true,
          label: "nit",
          align: "left",
          field: (row) => row.nit,
          // format: val => `${val}`,
          sortable: true,
        },
        {
          name: "razonsocial",
          align: "left",
          label: "Razonsocial",
          field: "razonsocial",
          sortable: true,
        },

        { name: "opcion", label: "Opcion", field: "action", sortable: false },
      ],
     subcol: [
        {
          name: "codigo",
          required: true,
          label: "codigo",
          align: "left",
          field: (row) => row.codigo,
          // format: val => `${val}`,
          sortable: true,
        },
        {
          name: "nombre",
          align: "left",
          label: "nombre",
          field: "nombre",
          sortable: true,
        },
        {
          name: "monto",
          align: "left",
          label: "monto",
          field: "monto",
          sortable: true,
        },
      ],
      data: [],
      subitem: [],
    };
  },
  created() {
    this.unid();
    this.misdatos();
  },
  methods: {
    misdatos() {
      this.$q.loading.show();
      this.$axios.get(process.env.URL + "/item").then((res) => {
        // console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },
    unid(){
        this.unidades=[];
        this.$axios.get(process.env.URL + "/unid").then((res) => {
        console.log(res.data)
        res.data.forEach(und => {
            this.unidades.push({label:und.nombre,value:und.id});
        });

      });
      this.uni=this.unidades[0];
    },

    addRow(item) {
      this.dato2 = item.row;
      this.dialog_add = true;
    },

    verRow(item) {
      this.dato2 = item.row;
      this.$axios
        .get(process.env.URL + "/subitemlist/"+this.dato2.id)
        .then((res) => {
            this.subitem=res.data;
          });
      this.dialog_list = true;

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
      this.dato.unid_id=this.uni.value;
      this.$axios.post(process.env.URL + "/item", this.dato).then((res) => {
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
        .put(process.env.URL + "/item/" + this.dato2.id, this.dato2)
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
    onAdd() {
      this.$q.loading.show();
      this.$axios
        .post(process.env.URL + "/subitem",this.dato2)
        .then((res) => {
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Agregado subitem correctamente",
          });
          this.dialog_add = false;
          this.misdatos();
        });
    },

    onDel() {
      this.$q.loading.show();
      this.$axios.delete(process.env.URL + "/item/" + this.dato2.id).then((res) => {
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
      this.dato.codigo = null;
    },
    
  }
}

  </script>
