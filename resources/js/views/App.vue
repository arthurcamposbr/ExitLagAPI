<template>
  <main>
    <header id="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-md-0 mb-4">
                    <router-link to="/">
                        <img src="img/exitlag.png" alt="ExitLag">
                    </router-link>
                </div>
                <div class="col-md">
                    <ul class="nav justify-content-md-end justify-content-center">
                        <router-link to="/" tag="li" class="nav-item">
                            <span class="nav-link">{{$t('nav.home')}}</span>
                        </router-link>
                        <router-link to="pesquisa" tag="li" class="nav-item">
                            <span class="nav-link">{{$t('nav.pesquisa')}}</span>
                        </router-link>
                    </ul>
                </div>
                <div class="col-md-auto">
                    <div class="idiomas">
                        <select v-model="$i18n.locale">
                            <option v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang">{{ lang }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <router-view></router-view>
  </main>
</template>
<script>

export default {
  computed: {},
  data() {
      return {
          langs: ['br', 'en']
      }
  }
};
</script>
