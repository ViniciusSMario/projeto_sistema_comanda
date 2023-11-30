<template>
  <div class="content">
    <div class="payments">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="disponivel title-page text-center">
                    <b-icon icon="tags"></b-icon>
                    Tipos de Pagamentos
                  </h3>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="9"></b-col>
                <b-col md="3">
                  <div class="text-left justify-content-end">
                    <router-link :to="'payment/newPayment'">
                      <button class="btn btn-success btn-block">Novo Tipo de Pagamento</button>
                    </router-link>
                  </div>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="12" class="mt-2">
                  <b-row class="mb-2 justify-content-end">
                    <b-col md="9">
                      <b-pagination
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        size="sm"
                        pills
                        prev-text="Anterior"
                        next-text="Próxima"
                        aria-controls="categoria_table"
                      ></b-pagination>
                    </b-col>
                    <b-col md="3">
                      <b-input-group>
                        <b-input-group-prepend>
                          <b-input-group-text class="icon-prepend">
                            <b-icon icon="search"></b-icon>
                          </b-input-group-text>
                        </b-input-group-prepend>
                        <b-form-input
                          type="text"
                          placeholder="Procurar"
                          v-model="filter"
                        ></b-form-input>
                      </b-input-group>
                    </b-col>
                  </b-row>
                  <b-table
                    striped
                    hover
                    outlined
                    responsive
                    id="tipo_pagamento_table"
                    :filter="filter"
                    :items="items"
                    :per-page="perPage"
                    :current-page="currentPage"
                  >
                    <template #cell(editar)="row">
                      <router-link :to="'payment/edit/' + row.item.id">
                        <button class="btn btn-info btn-sm" type="button">
                          Editar
                        </button>
                      </router-link>
                    </template>
                    <template #cell(excluir)="row">
                      <button
                        class="btn btn-danger btn-sm"
                        type="button"
                        @click="excluirTipoPagamento(row.item.id)"
                      >
                        Excluir
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
import api from "../../plugins/api";
export default {
  name: "TipoPagamento",
  data() {
    return {
      tipo_pagamento: [],
      items: [],
      perPage: 5,
      currentPage: 1,
      filter: "",
    };
  },
  computed: {
    rows() {
      return this.items.length;
    },
  },
  mounted() {
    this.getTipoPagamento();
  },
  methods: {
    getTipoPagamento() {
      var vm = this;

      api
        .get("tipo_pagamentos")
        .then((res) => {
          vm.tipo_pagamento = res.data;
          vm.items.pop();
          vm.tipo_pagamento.map(function (el) {
            vm.items.push({
              id: el.id,
              nome: el.nome,
              editar: "",
              excluir: "",
            });
          });
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    excluirTipoPagamento(id_tipo_pagamento) {
      var resultado = confirm("Deseja excluir o tipo de pagamento?");
      if (resultado) {
        api
          .delete("tipo_pagamentos/" + id_tipo_pagamento)
          .then((res) => {
            setTimeout(() => {
              console.log(res);
              window.location.reload();
            }, 500);
          })
          .catch((error) => {
            console.log(error.response.data.mensagem);
          });
      }
    },
  },
};
</script>

<style scoped>
.data {
  text-align: right;
  font-weight: bold;
  font-size: 16px;
}

.icon-prepend {
  padding: 0.5rem 0.75rem;
}
</style>
