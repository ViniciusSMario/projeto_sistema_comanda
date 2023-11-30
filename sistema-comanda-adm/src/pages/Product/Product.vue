<template>
  <div class="content">
    <div class="produtos">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="text-center disponivel title-page">
                    <b-icon icon="clipboard-minus"></b-icon>
                    Produtos
                  </h3>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="9"></b-col>
                <b-col md="3">
                  <div class="text-left justify-content-end">
                    <router-link :to="'product/newProduct'">
                      <button class="btn btn-success btn-block">Novo Produto</button>
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
                        aria-controls="produtos_table"
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
                    :items="items"
                    id="produtos_table"
                    :filter="filter"
                    :per-page="perPage"
                    :current-page="currentPage"
                  >
                    <template #cell(editar)="row">
                      <router-link :to="'product/edit/' + row.item.id">
                        <button class="btn btn-info btn-sm" type="button">
                          Editar
                        </button>
                      </router-link>
                    </template>
                    <template #cell(excluir)="row">
                      <button
                        class="btn btn-danger btn-sm"
                        type="button"
                        @click="excluirProduto(row.item.id)"
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
  data() {
    return {
      produtos: [],
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
    this.getProdutos();
  },
  methods: {
    getProdutos() {
      var vm = this;

      api
        .get("produtos")
        .then((res) => {
          vm.produtos = res.data;
          vm.produtos.map(function (el) {
            vm.items.push({
              id: el.id,
              nome: el.nome,
              descricao: el.descricao,
              preco: el.preco,
              editar: "",
              excluir: "",
            });
          });
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    excluirProduto(id_produto) {
      var resultado = confirm("Deseja excluir o produto?");
      if (resultado) {
        api
          .delete("produtos/" + id_produto)
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
