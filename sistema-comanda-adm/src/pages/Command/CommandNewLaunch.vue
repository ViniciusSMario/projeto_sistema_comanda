<template>
  <div class="content">
    <div class="categorias">

      <b-container>

        <div v-if="!mostrarProdutos">
          <CategoryList :categorias="categorias" :idComanda="idComanda" @get-category-id="getCategoryId" />
        </div>

        <div v-if="!mostrarProdutos" class="mt-4">
          <ProductTable :idComanda="idComanda"/>
        </div>

        <div v-if="mostrarProdutos">
          <ProductList :produtos="produtos" :idComanda="idComanda" @add-product="addProduct"
            @back-list="mostrarProdutos = false" />
        </div>

      </b-container>
    </div>
  </div>
</template>
<script>
import api from '../../plugins/api';

import CategoryList from '../../components/Category/CategoryList.vue';
import ProductList from '../../components/Product/ProductList.vue';
import ProductTable from '../../components/Product/ProductTable.vue';

export default {
  name: "CommandNewLaunch",
  data() {
    return {
      idComanda: '0',
      comandas: [],
      categorias: [],
      produtos: [],
      mostrarProdutos: false,
    };
  },
  mounted() {
    this.idComanda = this.$route.params.id;
    this.getCategorias();
  },
  computed: {
    rows() {
      return this.items.length;
    },
  },
  methods: {
    getCategoryId(el) {
      let vm = this;
      if (!!el) {
        vm.mostrarProdutos = true;
        vm.getProdutos(el);
      }
    },
    getProdutos(id) {
      let vm = this;
      api
        .get("produtos/categoria/" + id)
        .then((res) => {
          vm.produtos = res.data;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    getCategorias() {
      let vm = this;
      api
        .get("categorias")
        .then((res) => {
          vm.categorias = res.data;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    addProduct(el) { }
  },
  components: { CategoryList, ProductList, ProductTable }
}
</script>
