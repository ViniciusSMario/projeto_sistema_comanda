<template>
  <div class="content">
    <div class="categorias">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="disponivel title-page text-center">
                    <b-icon icon="tags"></b-icon>
                    Nova comanda
                  </h3>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="12">
                  <div class="form-group">
                    <input class="form-control" placeholder="Nome" v-model="nova_comanda.nome" />
                  </div>
                </b-col>
                <b-col md="12">
                  <div class="form-group">
                    <input class="form-control" v-mask="['(##) ####-####', '(##) #####-####']" placeholder="Celular" v-model="nova_comanda.celular" />
                  </div>
                </b-col>
                <b-col md="12">
                  <div class="form-group">
                    <select name="mesa" id="mesa" class="form-control" v-model="nova_comanda.mesas_id">
                      <option value="0">Selecione uma mesa</option>
                      <option v-for="mesa in mesas" :key="mesa.id" :value="mesa.id">{{ mesa.nome }}</option>
                    </select>
                  </div>
                </b-col>

                <b-col md="12">
                  <button class="btn btn-success btn-block" v-on:click="criarComanda()">Abrir comanda</button>
                </b-col>
              </b-row>
            </b-card>
          </b-card-group>
        </div>
      </b-container>
    </div>
  </div>
</template>
<script>
import api from '../../plugins/api';


export default {
  name: "CommandNew",
  data() {
    return {
      mesas: [],
      nova_comanda: {
        mesas_id: '0',
        nome: '',
        celular: ''
      },
    }
  },

  mounted() {
    this.getTables()
  },

  methods: {
    getTables() {

      var vm = this;

      api
        .get("/mesas/disponiveis")
        .then(res => {
          vm.mesas = res.data;
          console.log(res);
        })
        .catch(err => {
          console.log(err);
        })

    },

    criarComanda() {
      api
        .post("comandas", this.nova_comanda)
        .then(res => {
          this.$router.push(`/admin/command/launch/${res.data.comandas.id}`)
        })
        .catch(err => {
          console.log(err);
        })
    }
  }
}
</script>
