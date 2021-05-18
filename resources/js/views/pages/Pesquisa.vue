<template>
  <section class="pesquisa">
      <div class="cont_pesquisa">
          <div class="container text-center">
              <h1 class="text-primary display-4 mb-4"><b>{{$t('tit_pesquisa')}}</b></h1>
              <div class="col-md-6 mx-auto px-0">
                  <div class="intro mb-4 text-secondary">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque magna, commodo a nisi ut, semper sodales nibh. Vivamus eget turpis suscipit, volutpat mi eu, faucibus tellus. Donec at venenatis diam. Duis blandit diam ac velit congue venenatis. Donec facilisis turpis a venenatis tincidunt. Integer pharetra augue et erat auctor, quis ornare neque vestibulum. </p>
                  </div>
                  <questoes />
              </div>
          </div>
      </div>
  </section>
</template>
<script>
import Questoes from "../../components/Questoes.vue"

export default {

  computed: {},
  data() {
      return {
      }
  },
  components: {
        Questoes
    },
};
</script>
