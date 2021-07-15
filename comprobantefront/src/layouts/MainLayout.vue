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
          {{$store.state.user.name}}
        </q-toolbar-title>

        <div v-if="Object.keys($store.state.user).length>0">Uni: {{$store.state.user.unid.nombre}} </div>
        <q-btn @click="logout" v-if="$store.getters.isLoggedIn" label="salir" color="black" />
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
          Essential Links
        </q-item-label>


        <q-item
          clickable
          to="/"
          exact
        >
          <q-item-section
            avatar
          >
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
          <q-item-section
            avatar
          >
            <q-icon name="login" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Login</q-item-label>
            <q-item-label caption>
              Ingreso al sistema
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          to="/cliente"
          exact
          v-if="$store.state.boolcontribuyente"
        >
          <q-item-section
            avatar
          >
            <q-icon name="person" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Contribuyente</q-item-label>
            <q-item-label caption>
              Datos Contribuyente
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          clickable
          to="/user"
          exact
          v-if="$store.state.boolusuario"
        >
          <q-item-section
            avatar
          >
            <q-icon name="person" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Usuarios</q-item-label>
            <q-item-label caption>
              Permisos de usuario
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          to="/item"
          exact
          v-if="$store.state.boolitem"
        >
          <q-item-section
            avatar
          >
            <q-icon name="category" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Item</q-item-label>
            <q-item-label caption>
              Configuracion de items
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          to="/unid"
          exact
          v-if="$store.state.boolunidad"
        >
          <q-item-section
            avatar
          >
            <q-icon name="meeting_room" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Unidades</q-item-label>
            <q-item-label caption>
              Lista de Unidades
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          to="/secure"
          exact
          v-if="$store.state.boolcomprobante"
        >
          <q-item-section
            avatar
          >
            <q-icon name="article" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Comprobantes</q-item-label>
            <q-item-label caption>
              Crear comprobante
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          clickable
          to="/pago"
          exact
          v-if="$store.state.boolpagocomprobante"
        >
          <q-item-section
            avatar
          >
            <q-icon name="picture_as_pdf" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Imprimir Comprobantes</q-item-label>
            <q-item-label caption>
              Imprimir de comprobante
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          clickable
          to="/cancelar"
          exact
          v-if="$store.state.boolcancelarcomprobante"
        >
          <q-item-section
            avatar
          >
            <q-icon name="paid" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Pagos Comprobantes</q-item-label>
            <q-item-label caption>
              Pagos de comprobante
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
        <q-item clickable to="/verificar" exact v-if="$store.state.boolempresa">
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

        <q-item
          v-if="$store.getters.isLoggedIn"
          clickable
          @click="logout"
        >
          <q-item-section
            avatar
          >
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
