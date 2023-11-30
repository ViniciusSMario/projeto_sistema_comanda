<template>
  <div class="cart">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10">

        <div class="d-flex justify-content-center align-items-center mb-1">
          <h3 class="fw-normal mb-0 text-black">Meu pedido - Mesa {{mesa}} | Comanda:  {{comandas_id}}</h3>
        </div>

        <div class="row" v-show="cartProduct.length > 0">
          <div class="col-md-6">
            <button type="button"
                  @click="removeAllItensFromCart()"
                  class="btn btn-danger btn-sm m-0 d-flex justify-content-start align-items-center mb-3">Remover todos os itens</button>
          </div>
          <div class="col-md-6">
            <p class="mb-0 text-black font-weight-bold d-flex justify-content-end align-items-center mb-3">Sub-total: {{ cartTotal | toCurrency}}</p>
          </div>
        </div>

        <div v-if="cartProduct.length <=0" class="row">
            <div class="col-md-12 text-center">
              <h5 class="font-weight-bold mb-0">
                Você não tem itens adicionados ao seu pedido
              </h5>
            </div>
            <div class="col-md-12 text-center mt-4">
              <router-link to="/products" class="btn btn-info btn-sm">
                <i class="fa fa-shopping-bag fa-2x"></i>
                &nbsp; Adicionar produtos
              </router-link>
            </div>
        </div>
        <div v-else>
            <div class="card rounded-3 mb-4" v-for="item in cartProduct" :key="item.id">
            <div class="card-body p-4">
              <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-3 col-lg-3">
                  <p class="lead fw-normal mb-2">{{item.nome}}</p>
                  <p class="fw-normal mb-2">Unidade: {{parseFloat(item.preco) | toCurrency }}</p>
                </div>
                <div class="col-md-2 col-lg-2 d-flex">
                  <button class="btn btn-link px-2"
                    @click="removeQtdItem(item)">
                    <i class="fa fa-minus"></i>
                  </button>

                  <p class="mt-3">{{item.qtd}}</p>

                  <button class="btn btn-link px-2"
                    @click="addQtdItem(item)">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                  <h5 class="mb-0">{{calcularValorProduto(item.preco,item.qtd) | toCurrency}}</h5>
                </div>
                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                  <button type="button" @click="removeItemFromCart(item)" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-lg"></i></button>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <button type="button"
                @click="realizarPedido()"
                class="btn btn-warning btn-block btn-lg">Realizar Pedido</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import api from '../plugins/api'
import { mapGetters, mapActions } from "vuex";
export default {
  name: 'Cart',
  mounted(){
    this.cartProduct = this.$store.state.cart
  },
  computed: {
    ...mapGetters(["cartTotal"]),
  },
  data(){
    return {
      cartProduct: [],
      valorTotalPedido: 0,
      mesa: localStorage.getItem('mesas_id'),
      comandas_id: localStorage.getItem('comandas_id')
    }
  },
  methods: {
    calcularValorProduto(valor, qtd){
      return (valor * qtd);
    },
    removeQtdItem(item){
      this.cartProduct.map(function (produto){
        if(item.id == produto.id){
          if(produto.qtd > 1) {
            return produto.qtd--;
          }
          return
        }
      })
    },
    addQtdItem(item){
       this.cartProduct.map(function (produto){
        if(item.id == produto.id){
          return produto.qtd++;
        }
      })
    },
    removeItemFromCart(item){
      this.$store.dispatch('removeProductFromCart', item);

      this.cartProduct = this.cartProduct.filter(function (cartItem){
        return cartItem.id !== item.id
      });
    },
    removeAllItensFromCart(){
      this.$store.dispatch('removeAllItensFromCart');

      this.cartProduct = [];
    },
    realizarPedido(){
      this.cartProduct.map(function (cartItem){
         api
          .post("itens_comandas", {
            comandas_id: localStorage.getItem('comandas_id'),
            produtos_id: cartItem.id,
            quantidade: parseInt(cartItem.qtd),
            valor: parseFloat(cartItem.preco),
          })
          .then((res) => {
            console.log(res);
          })
          .catch((error) => {
            console.log(error.response.data.mensagem);
          });
      });
      this.$swal('Pedido realizado', 'O seu pedido foi realizado e logo estará pronto!', 'success');
      this.removeAllItensFromCart();
      this.$router.push('/products/');
    }
  }
}
</script>
