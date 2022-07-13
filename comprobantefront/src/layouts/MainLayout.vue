<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />
        <q-toolbar-title>
          <div v-if="!$store.getters.isLoggedIn" style="text-align:center"><b style="font-size:16px; ;">SIRCU</b> <span style="font-size:14px"> Sistema de Informacion de Registro de Comprobantes de Unidades</span></div>
          {{$store.state.user.name}}
        </q-toolbar-title>
        <div v-if="Object.keys($store.state.user).length>0">Uni: {{$store.state.user.unid.nombre}} </div>
        <q-btn size="xs" icon="logout" @click="logout" v-if="$store.getters.isLoggedIn" label="salir" color="black" />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-1"
    >
      <q-list>
        <q-item-label
          header
          class="text-grey-8"
        >
          Opciones
        </q-item-label>


        <q-item clickable to="/" exact><q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Home</q-item-label>
            <q-item-label caption>
              Ingreso al sistema
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          v-if="!$store.getters.isLoggedIn"
          clickable
          exact
          to="/login"
        >
          <q-item-section avatar>
            <q-icon name="login" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Login</q-item-label>
            <q-item-label caption>
              Ingreso al sistema
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/cliente" exact v-if="$store.state.boolcontribuyente">
          <q-item-section avatar>
            <q-icon name="person" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Contribuyente</q-item-label>
            <q-item-label caption>
              Datos Contribuyente
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/user" exact v-if="$store.state.boolusuario">
          <q-item-section avatar>
            <q-icon name="person" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Usuarios</q-item-label>
            <q-item-label caption>
              Permisos de usuario
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/item" exact v-if="$store.state.boolitem">
          <q-item-section avatar>
            <q-icon name="category" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Item</q-item-label>
            <q-item-label caption>
              Configuracion de items
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/unid" exact v-if="$store.state.boolunidad">
          <q-item-section avatar>
            <q-icon name="meeting_room" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Unidades</q-item-label>
            <q-item-label caption>
              Lista de Unidades
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/secure" exact v-if="$store.state.boolcomprobante">
          <q-item-section avatar>
            <q-icon name="article" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Crear comprobantes</q-item-label>
            <q-item-label caption>
              01 Crear comprobante
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/pagomercado" exact v-if="$store.state.boolcomprobantemercado">
          <q-item-section avatar>
            <q-icon name="article" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Crear comprobantes</q-item-label>
            <q-item-label caption>
              01 Pago mercado
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/pagocatastrovehiculos" exact v-if="$store.state.boolcomprobantecatastro">
          <q-item-section avatar>
            <q-icon name="drive_eta" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Compro Vehiculo</q-item-label>
            <q-item-label caption>
              01 Compro Vehiculo
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/pagocatastro" exact v-if="$store.state.boolcomprobantecatastro">
          <q-item-section avatar>
            <q-icon name="real_estate_agent" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Compro Tributario</q-item-label>
            <q-item-label caption>
              01 Compro Tributario
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/pagocatastronombres" exact v-if="$store.state.boolcomprobantecatastro">
          <q-item-section avatar>
            <q-icon name="microwave" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Compro Tributario Largo </q-item-label>
            <q-item-label caption>
              01 Compro Tributario Largo
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/pagourbano" exact v-if="$store.state.boolcomprobanteurbano">
          <q-item-section avatar>
            <q-icon name="article" />
          </q-item-section>
          <q-item-section>
            <q-item-label>01 Crear comprobantes</q-item-label>
            <q-item-label caption>
              01 Pago urbano
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/temporada" exact v-if="$store.state.booltemporada">
          <q-item-section avatar>
            <q-icon name="sensor_window" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Pago temporada</q-item-label>
            <q-item-label caption>
              Pago temporada
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/modificarcomprobante" exact v-if="$store.state.boolmodificarcomprobante">
          <q-item-section avatar>
            <q-icon name="edit" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Modificar comprobante</q-item-label>
            <q-item-label caption>
              Modificar comprobante
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/pago" exact v-if="$store.state.boolimprimir">
          <q-item-section avatar>
            <q-icon name="picture_as_pdf" />
          </q-item-section>

          <q-item-section>
            <q-item-label>02 Imprimir Comprobantes</q-item-label>
            <q-item-label caption>
              02 Imprimir comprobante
            </q-item-label>
          </q-item-section>
        </q-item>




        <q-item clickable to="/cancelar" exact v-if="$store.state.boolpagounidad">
          <q-item-section avatar>
            <q-icon name="paid" />
          </q-item-section>

          <q-item-section>
            <q-item-label>03 Pagos Comprobantes</q-item-label>
            <q-item-label caption>
              03 Pagos Comprobantes
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/reimprimir" exact v-if="$store.state.boolcomprobante">
          <q-item-section avatar>
            <q-icon name="print" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Reimprimir (opcional)</q-item-label>
            <q-item-label caption>
              Reimprimir (opcional)
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/anular" exact v-if="$store.state.boolanular">
          <q-item-section avatar>
            <q-icon name="running_with_errors" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Anular Comprobantes</q-item-label>
            <q-item-label caption>
              Imprimir de comprobante
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/pagocaja" exact v-if="$store.state.boolpagocaja">
          <q-item-section avatar>
            <q-icon name="paid" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Pagos por Caja</q-item-label>
            <q-item-label caption>
              Pagos por caja
            </q-item-label>
          </q-item-section>
        </q-item>

       <q-item
          clickable
          to="/resumen"
          exact
          v-if="$store.state.boolresumencaja"
        >
          <q-item-section avatar>
            <q-icon name="list" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Resumen Caja</q-item-label>
            <q-item-label caption>
              Resumen de Pagos del cajero
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/empresa" exact v-if="$store.state.boolempresa">
          <q-item-section avatar>
            <q-icon name="settings_overscan" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Empresa</q-item-label>
            <q-item-label caption>
              Registro de empresas
            </q-item-label>
          </q-item-section>

        </q-item>
        <q-item clickable to="/exportar" exact v-if="$store.state.boolexportar">
          <q-item-section avatar>
            <q-icon name="file_download" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Exportar pagos</q-item-label>
            <q-item-label caption>
              Exportar de pagos
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/importar" exact v-if="$store.state.boolimportar">
          <q-item-section avatar>
            <q-icon name="file_upload" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Importar pagos</q-item-label>
            <q-item-label caption>
              Importar de pagos
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/verificar" exact v-if="$store.state.boolverificar">
          <q-item-section avatar>
            <q-icon name="history" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Verificar pagos</q-item-label>
            <q-item-label caption>
              Historial de pagos
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/verificarcaja" exact v-if="$store.state.boolverificarcaja">
          <q-item-section avatar>
            <q-icon name="history" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Verificar caja</q-item-label>
            <q-item-label caption>
              Historial de pagos
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/verificarsistema" exact v-if="$store.state.boolverificarsistema">
          <q-item-section avatar>
            <q-icon name="history" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Verificar sistemas</q-item-label>
            <q-item-label caption>
              Historial de pagos
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/verificarconsulta" exact v-if="$store.state.boolverificarconsulta">
          <q-item-section avatar>
            <q-icon name="manage_search" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Verificar consulta</q-item-label>
            <q-item-label caption>
              Historial de pagos
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/misitems" exact v-if="$store.state.boolmisitems">
          <q-item-section avatar>
            <q-icon name="code" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Mis items</q-item-label>
            <q-item-label caption>
              Historial de pagos
            </q-item-label>
          </q-item-section>
        </q-item>


        <q-item clickable to="/actualizarcomprobante" exact v-if="$store.state.boolactualizarcomprobante">
          <q-item-section avatar>
            <q-icon name="map" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Actualizar comprobante</q-item-label>
            <q-item-label caption>
              Actualizar comprobante
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/buscarcomprobante" exact v-if="$store.state.boolbuscarcomprobante">
          <q-item-section avatar>
            <q-icon name="search" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Buscar comprobante</q-item-label>
            <q-item-label caption>
              Buscar Comprobante
            </q-item-label>
          </q-item-section>
        </q-item>


        <q-item
          v-if="$store.getters.isLoggedIn"
          clickable
          @click="logout"
        >
          <q-item-section avatar>
            <q-icon name="logout" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Salir</q-item-label>
            <q-item-label caption>
              Salir del sistema
            </q-item-label>
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>


export default {
  name: 'MainLayout',
  data () {
    return {
      leftDrawerOpen: false,
    }
  },
  methods:{
    logout(){
      this.$q.loading.show()
        this.$store.dispatch('logout')
          .then(() => {
            this.$q.loading.hide()
            this.$router.push('/login')
          })
    }
  }
}
</script>
