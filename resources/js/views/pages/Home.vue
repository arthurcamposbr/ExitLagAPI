<template>
  <section class="home">
      <div class="hero">
          <div class="container">
              <div class="col-md-5 px-0">
                  <h1 class="text-primary text-uppercase display-4 mb-4">{{$t('titulo')}}</h1>
                  <div class="text-white h5 mb-4">
                      <p>{{$t('hero_texto')}}</p>
                  </div>
                  <a href="#teste" class="btn btn-primary text-uppercase px-4 py-3">{{$t('btn')}}</a>
              </div>
          </div>
      </div>
  </section>
</template>
<script>

export default {
  computed: {},
  data() {
      return {
          message:'Hello World'
      }
  }
};
</script>
