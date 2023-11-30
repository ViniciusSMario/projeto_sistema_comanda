<template>
  <div class="comanda">
    <div class="container py-1 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-8 col-xl-6">
          <div class="card border-top border-bottom border-3" style="border-color: #f37a27 !important">
            <div class="card-body p-4">
              <p class="lead fw-bold mb-5 font-weight-bold text-center" style="color: #f37a27">
                Meus Pedidos Realizados
              </p>

              <div class="row">
                <div class="col mb-3">
                  <p class="small text-muted mb-1">Data</p>
                  <p>{{ comanda.created_at | formatDate }}</p>
                </div>
                <div class="col mb-3">
                  <p class="small text-muted mb-1">Comanda</p>
                  <p>Nº {{ this.$route.params.id }}</p>
                </div>
              </div>
              <div class="mx-n3 px-3 py-4">
                <div class="row">
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center font-weight-bold">
                    <p>Produto</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center font-weight-bold">
                    <p>Qtd</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center font-weight-bold">
                    <p>Valor</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row" v-for="item in items" :key="item.id" style="background-color: #FFF">
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p>{{ item.produto }}</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p>{{ item.quantidade }}</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p>{{ calcularValorProduto(item.preco, item.quantidade) | toCurrency }}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p class="fw-bold mb-0 font-weight-bold" style="color: #f37a27">Total</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p class="fw-bold mb-0 font-weight-bold" style="color: #f37a27">{{ qtd_total }}</p>
                  </div>
                  <div class="col col-md-4 col-sm-4 col-lg-4 text-center">
                    <p class="fw-bold mb-0 font-weight-bold" style="color: #f37a27">{{ valor_total | toCurrency }}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 mt-3 d-flex justify-content-center align-items-center">
                  <button class="btn btn-info btn-block" @click="() => {
                    statusMetodoPagamento = !statusMetodoPagamento
                  }">Selecionar método de pagamento</button>
                </div>
                <div v-if="statusMetodoPagamento == true"
                  class="col-md-12 col-sm-12 col-lg-12 mt-3 d-flex justify-content-center align-items-center">
                  <div class="col-md-6 col-sm-6 col-lg-6">
                    <select name="tipo_pagamento" id="tipo_pagamento" class="form-control" v-model="tipo_pagamento">
                      <option value="">Selecione</option>
                      <option v-for="tp in tipo_pagamentos" :key="tp.id" :value="tp.id">{{ tp.nome }}</option>
                    </select>
                  </div>
                  <div class="col-md-6 col-sm-6 col-lg-6">
                    <button class="btn btn-success btn-block" @click="fecharComanda()">Fechar Comanda</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../plugins/api';


export default {
  name: "Comanda",

  mounted() {
  },

  data() {
    return {
      comanda: [],
      valor_total: 0,
      qtd_total: 0,
      items: [],
      tipo_pagamentos: [],
      statusMetodoPagamento: false,
      tipo_pagamento: ''
    }
  },
  mounted() {
    this.getComandaWithItens(this.$route.params.id);
    this.getTiposPagamento();
  },
  methods: {
    fecharComanda() {

      let vm = this;

      const data = {
        comandas_id: vm.$route.params.id,
        valor_total: vm.valor_total,
        tipo_pagamentos_id: vm.tipo_pagamento
      }

      api.post("/fechamentos", data).then(res => {
        console.log(res);
        vm.$router.push('/admin/command')
      }).catch(err => {
        console.log(err);
      })
    },

    calcularValorProduto(valor, qtd) {
      return (valor * qtd);
    },

    getComandaWithItens(id_comanda) {
      var vm = this;
      api
        .get("comandas/itens/" + id_comanda)
        .then((res) => {
          vm.comanda = res.data.comanda[0];
          vm.comanda.itens_comandas.map(function (el) {
            var produtoEncontrado = vm.items.find(item => item.produto == el.produtos.nome);

            if (!produtoEncontrado) {
              vm.items.push({
                id: el.id,
                produto: el.produtos.nome,
                preco: el.produtos.preco,
                quantidade: el.quantidade
              })
            } else {
              produtoEncontrado.quantidade = parseInt(produtoEncontrado.quantidade) + parseInt(el.quantidade);
            }
            vm.valor_total += el.quantidade * el.produtos.preco
            vm.qtd_total += el.quantidade;
          })
        })
        .catch(function (error) {
          console.log(error)
          // this.$swal('Ops!!!', error.response.data.mensagem, 'error');
        });
    },
    getTiposPagamento() {
      var vm = this;
      api
        .get("tipo_pagamentos")
        .then((res) => {
          vm.tipo_pagamentos = res.data
        })
        .catch(function (error) {
          console.log(error)
          // this.$swal('Ops!!!', error.response.data.mensagem, 'error');
        });
    }
  }
};
</script>
