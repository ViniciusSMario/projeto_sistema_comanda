import Vue from "vue";

import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cart: []
    },
    getters: {
        cartProducts(state) {
            return state
        },
        cartTotal: state => {
            return state.cart.reduce((acc, cartItem) => {
                return (cartItem.qtd * cartItem.preco) + acc;
            }, 0);
        },
    },
    actions: {
        addProductToCart(context, product) {
            const cartItem = context.state.cart.find(item => item.id === product.id)
            if (!cartItem) {
                context.commit('pushProductToCart', product)
            } else {
                context.commit('incrementItemQuantity', cartItem)
            }
        },
        removeProductFromCart(context, product) {
            const cartItem = context.state.cart.find(item => item.id === product.id)
            if (cartItem) {
                context.commit('removeProductToCart', product)
            }
        },
        removeAllItensFromCart(context) {
            const cart = context.state.cart
            if (cart) {
                context.commit('removeAllItensFromCart')
            }
        },
    },
    mutations: {
        pushProductToCart(state, product) {
            state.cart.push({
                id: product.id,
                nome: product.nome,
                preco: product.preco,
                qtd: 1
            })
        },
        incrementItemQuantity(state, cartItem) {
            cartItem.qtd++
        },
        removeProductToCart(state, product) {
            state.cart = state.cart.filter(function(cartItem) {
                return cartItem.id !== product.id
            })
        },
        removeAllItensFromCart(state) {
            state.cart = [];
        }
    }
});