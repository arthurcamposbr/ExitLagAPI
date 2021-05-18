<template>
  <div class="questoes">
      <div v-if="questoes" v-for="q in questoes" class="panel panel-primary" :key="q.id">
                <div class="panel-heading">
                    <h3 class="panel-title mb-4">
                        <span class="glyphicon glyphicon-circle-arrow-right"></span>{{q.pergunta}}</h3>
                </div>
                <div v-if="q.respostas" class="panel-body two-col mb-5">
                    <div class="row pb-4">
                        <div class="col-md-4" v-for="p in q.respostas" :key="p.id">
                            <div class="well well-sm">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="">
                                        {{p.resposta}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
            <div class="panel-footer pt-4">
                    <button type="button" class="btn btn-primary px-4 py-3">Avaliar</button>
                </div>
  </div>
</template>
<script>

export default {
  computed: {},
  data() {
      return {
          questoes: ''
      }
  },
  created(){
      fetch("http://localhost:8000/api/questoes")
      .then(response => response.json())
      .then(data => (this.questoes = data.data));
  }
};
</script>
