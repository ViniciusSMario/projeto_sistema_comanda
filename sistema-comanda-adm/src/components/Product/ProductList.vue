<template>
  <b-card-group deck>
    <b-card class="panel-card">
      <b-row>
        <b-col md="12">
          <div class="d-flex justify-content-center">
            <button class="btn btn-info" v-on:click="$emit('back-list')">Voltar</button>
          </div>
          <h4 class="disponivel title-page text-center">
            <b-icon icon="tags"></b-icon>
            Novo pedido: {{ idComanda }}
          </h4>
          <h5>Itens adicionados: {{ getQuantidadeItens }}</h5>
          <h5>Total pedido: R$ {{ getPrecoTotalItens | toCurrency }}</h5>
          <h5>Pedido: {{ pedidoIsFechado }}</h5>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="4" sm="6" xs="3" v-for="produto in produtos" :key="produto.id" class="text-center">
          <div class="card p-3">
            <div class="card-body">
              <h4>{{ produto.nome }}</h4>
              <p>R$ {{ produto.preco | toCurrency }}</p>
              <p>{{ produto.descricao }}</p>
            </div>
            <button class="btn btn-success w-100" v-on:click="addProduto(produto)">
              Adicionar
            </button>
          </div>
        </b-col>
      </b-row>
    </b-card>
  </b-card-group>
</template>

<script>
import { mapGetters } from 'vuex';


export default {
  name: "ProductList",
  props: {
    produtos: [],
    idComanda: String
  },

  computed: {
    ...mapGetters([
      'getPrecoTotalItens',
      'getQuantidadeItens',
      'pedidoIsFechado'
    ])
  },

  methods: {
    addProduto(el) {
      this.$store.dispatch('addItemNoPedido', el);
      this.$swal('Produto adicionado', el.nome + ' adicionado com sucesso!', 'success');
    },

    redirect() {

    }
  },
}
</script>
