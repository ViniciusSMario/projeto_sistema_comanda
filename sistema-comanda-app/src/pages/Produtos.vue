<template>
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12">
        <form ref="formFilter" id="formFilter">
          <div class="row">
            <div class="col-md-4">
              <label for="termo">Filtro</label>
              <input
                type="text"
                name="termo"
                id="termo"
                v-model="filtro.termo"
                placeholder="Nome do produto"
                class="form-control"
              />
            </div>
            <div class="col-md-4">
              <label for="id_categoria">Categoria</label>
              <select
                name="id_categoria"
                v-model="filtro.id_categoria"
                class="form-control"
              >
                <option value="">Selecione</option>
                <option
                  v-for="categoria in categorias"
                  :key="categoria.id"
                  :value="categoria.id"
                >
                  {{ categoria.nome }}
                </option>
              </select>
            </div>
            <div class="col-md-4">
              <button
                type="button"
                @click.prevent="getProdutosByFiltro()"
                class="btn btn-info btn-block mt-4"
              >
                Filtrar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <card>
          <div class="list-product" v-if="produtos.length > 0">
            <div class="row">
              <div class="col-md-3" v-for="item in produtos" :key="item.id">
                <div class="card text-left">
                  <div class="card-body">
                    <h4 class="card-title">{{ item.nome }}</h4>
                    <p class="card-text mt-2">{{ item.descricao }}</p>
                    <p class="card-text text-right">R$ {{ item.preco }}</p>
                    <div class="row">
                      <div class="col-md-12 mt-3 btn-adicionar text-center">
                        <button
                          class="btn btn-success"
                          @click="addProductToCart(item)"
                        >
                          Adicionar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-product" v-else>
            <h3 class="text-center">{{message}}</h3>
          </div>
        </card>
      </div>
    </div>
  </div>
</template>
<script>
import Button from "../components/Button.vue";

import api from "../plugins/api";
import { mapState } from "vuex";

export default {
  components: { Button },
  data() {
    return {
      produtos: [],
      categorias: [],
      items: [],
      cartProduct: [],
      filtro: {
        termo: "",
        id_categoria: "",
      },
      message: ""
    };
  },
  mounted() {
    this.getAllProducts();
    this.getAllCategorias();
  },
  computed: {
    Total() {
      let total = 0;
      this.items.forEach((item) => {
        total += item.price * item.qtd;
      });
      return total;
    },
    ...mapState({
      cart: (state) => state.cart,
    }),
  },
  methods: {
    getAllProducts() {
      var vm = this;

      api
        .get("produtos")
        .then((res) => {
          vm.produtos = res.data;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    getAllCategorias() {
      var vm = this;

      api
        .get("categorias")
        .then((res) => {
          vm.categorias = res.data;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    getProdutosByFiltro() {
      var vm = this;
      var data = vm.filtro;
      console.log(vm.filtro)
      api
        .post("produtos/filtro", data)
        .then((res) => {
          if (res.sucesso == false){
            vm.message = error.response.data.mensagem;
            return
          }
          vm.produtos = res.data;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
          vm.message = error.response.data.mensagem;
        });

    },
    addProductToCart(product) {
      this.$store.dispatch("addProductToCart", product);
      this.$swal(
        "Produto adicionado",
        product.nome + " adicionado com sucesso!",
        "success"
      );
    },
  },
};
</script>
<style>
.list-product .card {
  min-height: 270px;
}

.list-product .btn-adicionar {
  position: absolute;
  bottom: 10px;
}
</style>
