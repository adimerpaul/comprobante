<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Usuario"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6"><q-icon name="add_circle" /> Nuevo Usuario</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <q-input
              filled
              v-model="dato.name"
              type="text"
              label="Nombre "
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato.codigo"
              type="text"
              label="Codigo "
              hint="Ingresar codigo"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.email"
              type="email"
              label="Email"
              hint="Correo electronico"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.password"
              type="password"
              label="Contraseña"
              hint="Contraseña"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-select
              filled
              label="Unidad"
              v-model="dato.unid_id"
              :options="unidades"
              option-label="nombre"
              option-value="id"
            />
            <q-input
              filled
            label="Fecha limite"
            type="date"
            v-model="dato.fechalimite"
            />
            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table :filter="filter" title="Unidades" :data="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="name" :props="props">
            {{props.row.name}}
          </q-td>
          <q-td key="unid" :props="props">
            {{props.row.unid.nombre}}
          </q-td>
          <q-td key="codigo" :props="props">
            {{props.row.codigo}}
          </q-td>
          <q-td key="email" :props="props">
            {{props.row.email}}
          </q-td>
          <q-td key="fechalimite" :props="props">
            {{props.row.fechalimite}}
          </q-td>
          <q-td key="opcion" :props="props">
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
            color="positive"
            @click="prompt"
            icon="password"
            />
            <q-btn
              dense
              round
              flat
              color="red"
              @click="deleteRow(props)"
              icon="delete"
            ></q-btn>
          </q-td>

<!--          <q-td key="opcion" :props="props">-->
<!--            <q-btn-->
<!--              dense-->
<!--              round-->
<!--              flat-->
<!--              color="green"-->
<!--              @click="addRow(props)"-->
<!--              icon="playlist_add"-->
<!--            ></q-btn>-->
<!--            <q-btn-->
<!--              dense-->
<!--              round-->
<!--              flat-->
<!--              color="green"-->
<!--              @click="verRow(props)"-->
<!--              icon="list"-->
<!--            ></q-btn>-->
<!--            <q-btn-->
<!--              dense-->
<!--              round-->
<!--              flat-->
<!--              color="yellow"-->
<!--              @click="editRow(props)"-->
<!--              icon="edit"-->
<!--            ></q-btn>-->
<!--            <q-btn-->
<!--              dense-->
<!--              round-->
<!--              flat-->
<!--              color="red"-->
<!--              @click="deleteRow(props)"-->
<!--              icon="delete"-->
<!--            ></q-btn>-->
<!--          </q-td>-->
        </q-tr>
      </template>
<!--      <template v-slot:body-cell-opcion="props">-->
<!--        <q-td :props="props">-->
<!--        <q-btn-->
<!--            dense-->
<!--            round-->
<!--            flat-->
<!--            color="yellow"-->
<!--            @click="editRow(props)"-->
<!--            icon="edit"-->
<!--          ></q-btn>-->
<!--          <q-btn-->
<!--            dense-->
<!--            round-->
<!--            flat-->
<!--            color="red"-->
<!--            @click="deleteRow(props)"-->
<!--            icon="delete"-->
<!--          ></q-btn>-->
<!--        </q-td>-->
<!--      </template>-->
    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-warning text-white">
          <div class="text-h6"> <q-icon name="edit"/> Modificar</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onMod" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.name"
              type="text"
              label="Nombre "
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.codigo"
              type="text"
              label="Codigo "
              hint="Ingresar codigo"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato2.email"
              type="email"
              label="Email"
              hint="Correo electronico"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-select
              filled
              label="Unidad"
              v-model="dato2.unid_id"
              :options="unidades"
              option-label="nombre"
              option-value="id"
            />
            <q-input
              filled
              label="Fecha limite"
              type="date"
              v-model="dato2.fechalimite"
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
import { date } from 'quasar'

export default {
  data() {
    return {
      alert: false,
      dialog_mod: false,
      dialog_del: false,
      filter:'',
      dato: {
        fechalimite:date.formatDate(Date.now(), 'YYYY-MM-DD')
      },
      dato2: {},
      options: [],
      props: [],
      unidades:[],
      uni:{},
      columns: [
        {name: "name", align: "left", label: "Nombre ", field: "name", sortable: true,},
        {name: "unid", align: "left", label: "Unidad", field: "unid", sortable: true,},
        {name: "codigo", align: "left", label: "Codigo", field: "codigo", sortable: true,},
        {name: "email", align: "left", label: "Email", field: "email", sortable: true,},
        {name: "fechalimite", align: "left", label: "Fecha limite", field: "fechalimite", sortable: true,
        },

        { name: "opcion", label: "Opcion", field: "action", sortable: false },
      ],
      data: [],
    };
  },
  created() {
    this.misdatos();
    this.$axios.get(process.env.URL+'/unid').then(res=>{
      // console.log(res.data)
      this.unidades=res.data
    })
  },
  methods: {
    misdatos() {
      this.$q.loading.show();
      this.$axios.get(process.env.URL + "/user").then((res) => {
        console.log(res.data)
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
      // this.dato.unid_id=this.dato.unid_id.id;
      this.$axios.post(process.env.URL + "/user", {
        name:this.dato.name,
        password:this.dato.password,
        email:this.dato.email,
        unid_id:this.dato.unid_id.id,
        fechalimite:this.dato.fechalimite,
        codigo:this.dato.codigo,
      }).then((res) => {
        // console.log(res.data)
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Creado correctamente",
        });
        this.dato={fechalimite:date.formatDate(Date.now(), 'YYYY-MM-DD')}
        this.alert = false;
        this.misdatos();
      });
    },
    onMod() {
      this.$q.loading.show();
      this.$axios
        .put(process.env.URL + "/user/" + this.dato2.id, this.dato2)
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
      this.$axios.delete(process.env.URL + "/user/" + this.dato2.id).then((res) => {
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
    prompt () {
      this.$q.dialog({
        title: 'Prompt',
        message: 'What is your name?',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }
  },
};
</script>
