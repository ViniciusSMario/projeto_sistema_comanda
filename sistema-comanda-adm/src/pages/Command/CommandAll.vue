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
                    Comandas
                  </h3>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="9"></b-col>
                <b-col md="3">
                  <div class="text-left justify-content-end">
                    <router-link :to="'/admin/command/new'">
                      <button class="btn btn-success btn-block">Nova Comanda</button>
                    </router-link>
                  </div>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="12" class="mt-2">
                  <b-row class="mb-2 justify-content-end">
                    <b-col md="9">
                      <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" size="sm" pills
                        prev-text="Anterior" next-text="Próxima" aria-controls="comandas_table"></b-pagination>
                    </b-col>
                    <b-col md="3">
                      <b-input-group>
                        <b-input-group-prepend>
                          <b-input-group-text class="icon-prepend">
                            <b-icon icon="search"></b-icon>
                          </b-input-group-text>
                        </b-input-group-prepend>
                        <b-form-input type="text" placeholder="Procurar" v-model="filter"></b-form-input>
                      </b-input-group>
                    </b-col>
                  </b-row>
                  <b-table striped hover outlined responsive id="comandas_all_table" :filter="filter" :items="items"
                    :per-page="perPage" :current-page="currentPage">
                    <template #cell(fechar)="row">
                      <button class="btn btn-danger btn-sm" type="button" @click="() => {
                        $router.push(`/admin/command/launch/${row.item.id}/done`);
                      }">
                        Fechar
                      </button>
                    </template>
                  </b-table>
                  <p class="mt-3 text-md-end">
                    Página atual: {{ currentPage }}
                  </p>
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
  name: "CommandAll",
  data() {
    return {
      comandas: [],
      items: [],
      perPage: 5,
      currentPage: 1,
      filter: "",
    }
  },

  mounted() {
    this.getCommands();
  },

  computed: {
    rows() {
      return this.items.length;
    },
  },

  methods: {
    getCommands() {

      var vm = this;

      api
        .get("/comandas/with/mesas")
        .then(res => {
          if (res.data) {
            vm.items.pop();
            res.data.map(cmd => {
              vm.items.push({
                id: cmd.id,
                nome: cmd.nome,
                status: cmd.status.toUpperCase(),
                telefone: cmd.celular,
                mesaTipo: cmd.mesas.nome,
                fechar: "",
              })
            })
          }

          if (!res.data) {
            vm.items.pop();
            vm.comandas = []
          }
        })
        .catch(err => {
          console.log(err);
        })
    },
  }
}
</script>
