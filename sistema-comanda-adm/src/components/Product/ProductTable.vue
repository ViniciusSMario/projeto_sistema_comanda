<template>
  <div>
    <b-card-group deck>
      <b-card class="panel-card">
        <b-row>
          <b-col md="12">
            <h3 class="disponivel title-page text-center">
              <b-icon icon="tags"></b-icon>
              Produtos adicionados
            </h3>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="9"></b-col>
          <b-col md="3">
            <div class="text-left justify-content-end">
              <button class="btn btn-danger btn-block" v-on:click="finalizarPedido()">Finalizar pedido</button>
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
            <b-table striped hover outlined responsive id="comandas_table" :filter="filter" :items="items"
              :per-page="perPage" :current-page="currentPage">
              <template #cell(remover)="row">
                <button class="btn btn-danger btn-sm" type="button" @click="remover(row.item)">
                  Remover
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
</template>

<script>

import { mapGetters } from 'vuex';
import api from '../../plugins/api';

export default {

  name: "ProductTable",

  props: {
    idComanda: String
  },

  mounted() {

  },

  computed: {
    ...mapGetters([
      'getPedido'
    ]),
    rows() {
      return this.items.length;
    },
    items() {
      return this.getPedido.items.map(item => {
        return {
          codigo: item.id,
          nome: item.nome,
          descricao: item.descricao,
          preco: item.preco,
          quantidade: item.qnt,
          remover: "",
        }
      });
    }
  },

  methods: {
    remover(el) {
      this.$store.dispatch('removeItemNoPedido', el);
    },
    finalizarPedido() {
      let vm = this;

      vm.getPedido.items.forEach(item => {

        const data = {
          comandas_id: vm.idComanda,
          produtos_id: item.id,
          quantidade: parseInt(item.qnt),
          valor: parseFloat(item.preco),
        }

        api
          .post("itens_comandas", data)
          .then((res) => {
            this.$store.dispatch('fecharPedido');
            this.$swal('Sucesso', 'Pedido enviado para cozinha', 'success');

          })
          .catch((error) => {
            console.log(error);
          });
      })

    }
  },

  data() {
    return {
      produtos: [],
      perPage: 5,
      currentPage: 1,
      filter: "",
    }
  },

}

</script>
