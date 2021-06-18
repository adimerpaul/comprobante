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
          Quasar App
        </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
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
          clickable
          to="/secure"
          exact
        >
          <q-item-section
            avatar
          >
            <q-icon name="article" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Comprobantes</q-item-label>
            <q-item-label caption>
              Actividades economicas
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          clickable
          to="/empresa"
          exact
        >
          <q-item-section
            avatar
          >
            <q-icon name="settings_overscan" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Empresa</q-item-label>
            <q-item-label caption>
              Registro de empresas
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
        this.$store.dispatch('logout')
          .then(() => {
            this.$router.push('/login')
          })
    }
  }
}
</script>
