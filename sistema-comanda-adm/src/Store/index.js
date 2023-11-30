import Vue from "vue";

import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({

  state: {
    pedido: {
      aberto: true,
      items: []
    }
  },

  mutations: {

    addItemNoPedido(state, produto) {

      const pedido = state.pedido;

      let item = pedido.items.find(item => item.id == produto.id);

      if (item != null) {
        item.qnt = item.qnt + 1;
        state.pedido = {...pedido }
      }

      if (item == null) {
        produto.qnt = 1;
        state.pedido.items.push(produto);
      }

    },

    removeItemNoPedido(state, produto) {

      let produtosState = { ...state.pedido };

      const index = produtosState.items.findIndex(item => item.id == produto.codigo)

      if (index > -1) {

        let targetProduto = state.pedido.items[index];

        if (targetProduto.qnt == undefined || targetProduto.qnt == 0) {
          removeItem(state, index);
        }

        if (targetProduto.qnt > 0) {
          targetProduto.qnt = targetProduto.qnt - 1;
          state.pedido = { ...produtosState }

          if (targetProduto.qnt == 0) {
            removeItem(state, index)
          }
        }
      }
    },

    fecharPedido(state) {
      state.pedido = {
        aberto: true,
        items: []
      }
    }

  },

  actions: {
    addItemNoPedido({ commit }, produto) {
      commit('addItemNoPedido', produto)
    },

    removeItemNoPedido({ commit }, produto) {
      commit('removeItemNoPedido', produto)
    },

    fecharPedido({ commit }) {
      commit('fecharPedido')
    }
  },

  getters: {

    pedidoIsFechado(state) {
      return (!state.pedido.aberto == false) ? 'Aberto' : 'Fechado'
    },

    getItemsPedido(state) {
      return state.pedido.items;
    },

    getQuantidadeItens(state) {
      return state.pedido.items
        .filter(item => item.qnt != undefined)
        .map(item => parseInt(item.qnt))
        .reduce((qnt, nextQnt) => qnt + nextQnt, 0)
    },

    getPrecoTotalItens(state) {
      return state.pedido.items.map(item => parseFloat(item.preco) * item.qnt)
        .reduce((preco, nextPreco) => preco + nextPreco, 0).toFixed(2);
    },

    getPedido(state) {
      return state.pedido;
    }

  }

})

export const removeItem = (state, index) => {
  const produtos = state.pedido.items;
  const itens = [...produtos.slice(0, index), ...produtos.slice(index + 1)]

  state.pedido.items = [];
  state.pedido.items = itens;
}
