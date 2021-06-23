<template>
  <q-page class="q-pt-md q-pl-lg">
    <div class="row">
      <div class="col-12 col-sm-6">
        <q-input
          type="text"
          v-model="dato.ci"
          @keydown.enter.prevent="llenar"
          :error="!valido"
          label="Cedula Identidad"
        />
        <template v-if="valor">
          <q-form @submit.prevent="onSubmit" class="q-gutter-md">
            <q-select
              v-model="dato.expedido"
              :options="['LP', 'OR', 'CH', 'CB', 'PT', 'TJ', 'SC', 'BE', 'PD']"
              label="Expedido"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.nombre"
              label="Nombre"
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => val.length > 0 || 'Ingrese nombre']"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.paterno"
              label="Paterno"
              hint="Ingresar apellido"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.materno"
              label="Materno"
              hint="Ingresar materno"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.casada"
              label="Ap Casada"
              hint="Ingresar Ap Casada"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.direccion"
              label="Direccion"
              hint="ingresa la direccion"
              lazy-rules
              :rules="[(val) => val.length > 0 || 'Debe ingresar direccion']"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.numcasa"
              label="Numero Casa"
              hint="Numero del domicilio"
              lazy-rules
              :rules="[(val) => val.length > 0 || 'Debe ingresar numero']"
            />

            <q-input
              Filled
              type="text"
              v-model="dato.telefono"
              label="Telefono"
              hint="Ingrese numero telefonico"
            />
            <div>
              <q-btn
                label="Crear Modificar"
                type="submit"
                color="positive"
                icon="add_circle"
              />
            </div>
          </q-form>
        </template>
      </div>
      <div class="col-12 col-sm-6"></div>
    </div>
  </q-page>
</template>

<script>
//const stringOptions = [
//'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
//]

export default {
  data() {
    return {
      model: null,
      options: [],
      cadena: [],
      dato: [],
      valido: false,
      aux: "",
      valor: false,
    };
  },
  created() {},
  methods: {
    onSubmit() {
      console.log(this.dato);
      this.$q.loading.show();
      if (this.dato.paterno == null) this.dato.paterno = "";
      if (this.dato.materno == null) this.dato.materno = "";
      if (this.dato.casada == null) this.dato.casada = "";
      if (this.dato.id == "" || this.dato.id == null) {
        this.$axios.post(process.env.URL + "/cliente", this.dato).then((res) => {
          console.log(res.data);
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Creado correctamente",
          });
        });
      } else {
        this.$axios
          .put(process.env.URL + "/cliente/" + this.dato.id, this.dato)
          .then((res) => {
            console.log(res.data);
            this.$q.notify({
              color: "green-4",
              textColor: "white",
              icon: "cloud_done",
              message: "Modificado correctamente",
            });
          });
      }

      this.$q.loading.hide();
    },
    llenar() {
      this.datoscliente(this.cl);
      this.valor = true;
    },
    datoscliente() {
      this.cadena = [];

      this.$axios.get(process.env.URL + "/lista/" + this.dato.ci).then((res) => {
        console.log(res.data);
        if (res.data.length == 1) {
          this.valido = true;
          this.dato = res.data[0];
        } else {
          this.valido = false;
          this.aux = this.dato.ci;
          this.dato = {};
          this.dato.ci = this.aux;
        }
        res.data.forEach((row) => {
          this.cadena.push(row.ci);
        });
        this.options = this.cadena;
      });
    },
  },
};
</script>

<style scoped></style>
