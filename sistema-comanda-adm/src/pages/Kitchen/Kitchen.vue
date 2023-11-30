<template>
  <div class="content">
    <div class="categorias">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="disponivel title-page text-center">
                    <b-icon icon="tags"></b-icon>
                    Cozinha  {{ vai_atualizar ? ': Atualizando pedidos' : '' }}
                  </h3>
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
                    <template #cell(finalizar)="row">
                      <button :disabled="vai_atualizar" class="btn btn-danger btn-sm" type="button" @click="finalizarPedidoCozinha(row.item)">
                        Finalizar
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
import api from '../../plugins/api';

export default {
  name: "Kitchen",
  data() {
    return {
      comandas: [],
      items: [],
      perPage: 5,
      currentPage: 1,
      filter: "",
      vai_atualizar: false,
    }
  },

  computed: {
    rows() {
      return this.items.length;
    },
  },

  mounted() {
    this.getItens();
    setInterval(this.getItens, 13000);
  },

  methods: {
    sleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    },

    finalizarPedidoCozinha(item) {
      console.log(item);

      api
        .put(`/itens_comandas/${item.id}`, item)
        .then(res => {
          this.$swal('Item finalizado', '', 'success');
          this.getItens();
        }).catch(err => {
            console.log(err)
        })

    },

    async getItens() {
      this.vai_atualizar = true;
      console.log("Vai atualizar");
      await this.sleep(3000)

      console.log("Atualizando Tabela");
      api
        .get('/comandas/mesa/itens')
        .then(res => {
          this.mapProdutoToTableLine(res.data);
        })
        .catch(err => {
          console.log(err);
        })
    },

    mapProdutoToTableLine(data) {

      let pedidos = [];

      console.log(data)

      data.forEach(c => {

        c.itens_comandas.forEach(i => {

          if(i.status == 'na_cozinha') {

          pedidos.push({

            id: i.id,
            comandas_id: i.comandas_id,
            mesa: c.mesas.nome,
            mesaId: c.mesas.id,
            nome: c.nome,

            produto: i.produtos.nome,
            produtos_id: i.produtos_id,
            quantidade: i.quantidade,

            status: 'na_cozinha' == i.status ? 'Na cozinha' : 'Finalizado',
            finalizar: ''

          })

        }

        })


      })
      this.items = pedidos;
      this.vai_atualizar = false;
      console.log("Tabela atualizada");
    }
  },
}
</script>
