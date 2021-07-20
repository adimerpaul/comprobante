<template>
  <div id="q-app">
    <router-view />
  </div>
</template>
<script>
export default {
  name: 'App',
  mounted() {
    window.onunload  = function (e) {
      var storage = window.localStorage
      storage.clear()
      e.preventDefault()
      return false
    }
  },
  // beforeDestroy: function () {
  //   // alert('saliste')
  //   this.$q.loading.show()
  //   this.$store.dispatch('logout')
  //     .then(() => {
  //       this.$q.loading.hide()
  //       this.$router.push('/login')
  //     })
  //   // this.choicesSelect.destroy()
  // }
}
</script>
