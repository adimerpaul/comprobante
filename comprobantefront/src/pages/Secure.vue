<template>
  <q-page class="q-pt-md q-pl-lg">
    <div class="row">
      <div class="col-12 col-sm-6">
        <q-select
          filled
          v-model="model"
          use-input
          input-debounce="0"
          label="Simple filter"
          :options="options"
          @filter="filterFn"
          style="width: 250px"
        >
          <template v-slot:no-option>
            <q-item>
              <q-item-section class="text-grey">
                No results
              </q-item-section>
            </q-item>
          </template>
        </q-select>
      </div>
      <div class="col-12 col-sm-6"></div>
    </div>

  </q-page>
</template>

<script>
const stringOptions = [
  'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
]

export default {
  data () {
    return {
      model: null,
      options: stringOptions
    }
  },
  created() {
    
  },
  methods: {
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          //this.options = stringOptions
          this.$axios.get(process.env.URL+'/lista/1').then(res=>{
                //console.log(res.data)
                console
          });
          // with Quasar v1.7.4+
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.options = stringOptions.filter(v => v.toLowerCase().indexOf(needle) > -1)
      })
    }
  }
}
</script>

<style scoped>

</style>
