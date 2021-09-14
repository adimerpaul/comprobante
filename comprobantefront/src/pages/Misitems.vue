<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Item"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Nuevo Item</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <q-input
              filled
              v-model="dato.codigo"
              type="number"
              label="Numero codigo"
              hint="Ingresar codigo"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato.nombre"
              type="text"
              label="Nombre de Item"
              hint="Ingresar Nombre item"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
<!--            <q-select-->
<!--            v-model="uni"-->
<!--            :options="unidades"-->
<!--            label="unidad"-->
<!--            hint="Seleccionar"-->
<!--            lazy-rules-->
<!--              :rules="[(val) => val!='' && val!=null || 'Por favor ingresa datos']"-->
<!--            />-->

            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table
      title="Items "
      :data="data"
      :columns="columns"
      :rows-per-page-options="[50,30,50,0 ]"
    :filter="filter"
    :grid="$q.screen.xs"
    row-key="name">
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="codigo" :props="props">
            {{ props.row.codigo }}
          </q-td>
          <q-td key="nombre" :props="props">
            {{ props.row.nombre }}
          </q-td>
<!--          <q-td key="unid" :props="props">-->
<!--            {{ props.row.unid.nombre }}-->
<!--          </q-td>-->
          <q-td key="estado" :props="props">
            <q-badge @click="cambio(props.row)" v-if="props.row.estado=='ACTIVO'" color="positive">
              {{ props.row.estado }}
            </q-badge>
            <q-badge @click="cambio(props.row)" v-else color="negative">
              {{ props.row.estado }}
            </q-badge>
          </q-td>
          <q-td key="subitems" :props="props">
<!--            {{ props.row.subitems}}-->
            <ul>
              <span v-for="(subitem,index) in props.row.subitems" :key="index">
                  <li >
                    {{subitem.codigo}} {{subitem.nombre}}
                    <q-badge @click="cambiosubitem(subitem)"  v-if="subitem.estado=='ACTIVO'" color="positive">
                      {{ subitem.estado }}
                    </q-badge>
                    <q-badge @click="cambiosubitem(subitem)"  v-else color="negative">
                      {{ subitem.estado }}
                    </q-badge>
                    {{subitem.monto}} Bs.
                  </li>
              </span>

            </ul>

          </q-td>
          <q-td key="opcion" :props="props">
                      <q-btn
                        dense
                        round
                        flat
                        color="green"
                        @click="addRow(props)"
                        icon="playlist_add"
                      ></q-btn>
                        <q-btn
                        dense
                        round
                        flat
                        color="green"
                        @click="verRow(props)"
                        icon="list"
                      ></q-btn>
                    <q-btn
                        dense
                        round
                        flat
                        color="yellow"
                        @click="editRow(props)"
                        icon="edit"
                      ></q-btn>
<!--                      <q-btn-->
<!--                        dense-->
<!--                        round-->
<!--                        flat-->
<!--                        color="red"-->
<!--                        @click="deleteRow(props)"-->
<!--                        icon="delete"-->
<!--                      ></q-btn>-->
          </q-td>
        </q-tr>
      </template>
<!--      <template v-slot:body-cell-opcion="props">-->
<!--        <q-td :props="props">-->
<!--          <q-btn-->
<!--            dense-->
<!--            round-->
<!--            flat-->
<!--            color="green"-->
<!--            @click="addRow(props)"-->
<!--            icon="playlist_add"-->
<!--          ></q-btn>-->
<!--            <q-btn-->
<!--            dense-->
<!--            round-->
<!--            flat-->
<!--            color="green"-->
<!--            @click="verRow(props)"-->
<!--            icon="list"-->
<!--          ></q-btn>-->
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
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
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
<!--            <q-select-->
<!--            v-model="uni2"-->
<!--            :options="unidades"-->
<!--            label="unidad"-->
<!--            hint="Seleccionar"-->
<!--            lazy-rules-->
<!--              :rules="[(val) => val!='' && val!=null || 'Por favor ingresa datos']"-->
<!--            />-->

            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

<q-dialog v-model="dialog_modsub">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Modificar Subitem</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onModsub" class="q-gutter-md">


            <q-input
              filled
              v-model="dato3.nombre"
              type="text"
              label="Nombre del SubItem"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato3.monto"
              type="number"
              step="0.01"
              label="Monto SubItem"
              hint="Ingresar monto"
              lazy-rules
              :rules="[(val) => (val && val >= 0) || 'Por favor ingresa datos']"
            />



            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_add">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Agregar Subitem</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onAdd" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.subnombre"
              type="text"
              label="Nombre del SubItem"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato2.submonto"
              type="number"
              step="0.01"
              label="Monto"
              hint="Ingresar monto"
              lazy-rules
              :rules="[(val) => (val>=0 && val.length > 0) || 'Por favor ingresa datos']"
            />


            <div>
              <q-btn label="Agregar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_list">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Lista de Subitem</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
                <q-table
                    title="Subitems"
                    :data="subitem"
                    :columns="subcol"
                    >
      <template v-slot:body="props">
          <q-tr :props="props">
          <q-td key="codigo" :props="props">
            {{ props.row.codigo }}
          </q-td>
            <q-td key="nombre" :props="props">
            {{ props.row.nombre }}
          </q-td>
          <q-td key="estado" :props="props">
            <q-badge @click="cambio(props.row)" v-if="props.row.estado=='ACTIVO'" color="positive">
              {{ props.row.estado }}
            </q-badge>
            <q-badge @click="cambio(props.row)" v-else color="negative">
              {{ props.row.estado }}
            </q-badge>
          </q-td>
                    <q-td key="monto" :props="props">
            {{ props.row.monto }}
          </q-td>
          <q-td>
            <q-btn
                        dense
                        round
                        flat
                        color="yellow"
                        @click="editsub(props)"
                        icon="edit"
                      ></q-btn>
                      <q-btn
                        dense
                        round
                        flat
                        color="red"
                        @click="deletesub(props)"
                        icon="delete"
                      ></q-btn>
          </q-td>
          </q-tr>
          </template>
                </q-table>
            <div>
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
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

    <q-dialog v-model="dialog_delsub">
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDelsub" />
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
      dialog_modsub: false,
      dialog_add: false,
      dialog_del: false,
      dialog_delsub: false,
      dialog_list: false,
      filter:'',
      dato: {},
      dato2: {},
      dato3: {},
      options: [],
      props: [],
      unidades:[],
      uni:{},
      uni2:{},
      unidad2:{},

      columns: [
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
          name: "nombre", align: "left", label: "nombre", field: "nombre", sortable: true,
        },
        // {name: "unid", align: "left", label: "Unidad", field: "unid", sortable: true,},
        {name: "estado", align: "left", label: "Estado", field: "estado", sortable: true,},
        {name: "subitems", align: "left", label: "Sub Items", field: "subitems", sortable: true,},
        { name: 'opcion', label: 'Opcion', field:'action',  sortable: false },

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
          name: "estado",
          align: "left",
          label: "estado",
          field: "estado",
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
    cambiosubitem(i){
      console.log(i);
      this.$q.loading.show();
      this.$axios.get(process.env.URL + "/cambiosubitem/"+i.id).then((res) => {
        // console.log(res.data)
        if (i.estado=='ACTIVO'){
          i.estado='INACTIVO'
        }else{
          i.estado='ACTIVO'
        }
        this.$q.loading.hide();
      });
    },
    cambio(i){
      this.$q.loading.show();
      this.$axios.get(process.env.URL + "/cambio/"+i.id).then((res) => {
        // console.log(res.data)
        if (i.estado=='ACTIVO'){
          i.estado='INACTIVO'
        }else{
          i.estado='ACTIVO'
        }
        this.$q.loading.hide();
      });
    },
    misdatos() {
      this.$q.loading.show();
      this.$axios.post(process.env.URL + "/misitems").then((res) => {
        console.log(res.data)
        this.$q.loading.hide()
        // return false
        // return false
        this.data = res.data

      });
    },
    unid(){
        this.unidades=[];
        this.$axios.get(process.env.URL + "/unid").then((res) => {
        // console.log(res.data)
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
      // this.uni2={value:item.row.unid.id,label:item.row.unid.nombre}
      this.dialog_mod = true;
    },
    editsub(item) {
      this.dato3 = item.row;
      this.dialog_modsub = true;
    },
    deleteRow(item) {
      this.dato2 = item.row;
      this.dialog_del = true;
    },
    deletesub(item) {
      this.dato3 = item.row;
      this.dialog_delsub = true;
    },

    onSubmit() {
      this.$q.loading.show();
      // this.dato.unid_id=this.uni.value;
      this.$axios.post(process.env.URL + "/misitemcrear", this.dato).then((res) => {
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
      this.dato2.unid_id=this.uni2.value;
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

      onModsub() {
      this.$q.loading.show();
      this.$axios
        .put(process.env.URL + "/subitem/" + this.dato3.id, this.dato3)
        .then((res) => {
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Modificado correctamente",
          });
          this.dialog_modsub = false;
          this.misdatos();
        });
    },
    onAdd() {
      this.$q.loading.show();
      this.$axios
        .post(process.env.URL + "/subitem",this.dato2)
        .then((res) => {
          console.log(res.data)
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

        onDelsub() {
      this.$q.loading.show();
      this.$axios.delete(process.env.URL + "/subitem/" + this.dato3.id).then((res) => {
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Eliminado correctamente",
        });
        this.dialog_delsub = false;
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
