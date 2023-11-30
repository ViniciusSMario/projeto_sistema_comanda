<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-4 col-md-6">
          <stats-card class="comandas-hoje">
            <div slot="header" class="icon-warning">
              <i class="nc-icon nc-notes text-warning"></i>
            </div>
            <div slot="content">
              <p class="card-category">Comandas Abertas</p>
              <h4 class="card-title">{{ dados_gerais.aberta.hoje.qtde }}</h4>
            </div>
          </stats-card>
        </div>

        <div class="col-xl-4 col-md-6">
          <stats-card>
            <div slot="header" class="icon-success">
              <i class="nc-icon nc-check-2 text-success"></i>
            </div>
            <div slot="content">
              <p class="card-category"> Comandas Fechadas</p>
              <h5>Hoje</h5>
              <h5>Comandas: {{ dados_gerais.fechada.hoje.qtde }}</h5>
              <h5>{{ dados_gerais.fechada.hoje.valor_total | toCurrency }}</h5>
              <hr />
              <h5>Total:</h5>
              <h5>Comandas: {{ dados_gerais.fechada.geral.qtde }}</h5>
              <h5>{{ dados_gerais.fechada.geral.valor_total | toCurrency}}</h5>
            </div>
          </stats-card>
        </div>

        <div class="col-xl-4 col-md-6">
          <stats-card>
            <div slot="header" class="icon-danger">
              <i class="nc-icon nc-notes text-success"></i>
            </div>
            <div slot="content">
              <p class="card-category">Total de comandas</p>
                <h5>Hoje</h5>
                <h5>Comandas: {{ dados_gerais.total_comandas.hoje.qtde }}</h5>
                <h5>{{ dados_gerais.total_comandas.hoje.valor_total | toCurrency }}</h5>
                <hr />
                <h5>Total:</h5>
                <h5>
                  Comandas: {{ dados_gerais.total_comandas.geral.qtde }}
                </h5>
                <h5>
                  {{ dados_gerais.total_comandas.geral.valor_total | toCurrency}}
                </h5>
            </div>
          </stats-card>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-3 col-md-6">
          <stats-card>
            <div slot="header" class="icon-warning">
              <i class="nc-icon nc-app text-warning"></i>
            </div>
            <div slot="content">
              <p class="card-category">Categorias</p>
              <h4 class="card-title">{{ dados_gerais.categorias }}</h4>
            </div>
          </stats-card>
        </div>
        <div class="col-xl-3 col-md-6">
          <stats-card>
            <div slot="header" class="icon-warning">
              <i class="nc-icon nc-chart text-warning"></i>
            </div>
            <div slot="content">
              <p class="card-category">Produtos</p>
              <h4 class="card-title">{{ dados_gerais.produtos }}</h4>
            </div>
          </stats-card>
        </div>
        <div class="col-xl-3 col-md-6">
          <stats-card>
            <div slot="header" class="icon-warning">
              <i class="nc-icon nc-grid-45 text-warning"></i>
            </div>
            <div slot="content">
              <p class="card-category">Mesas</p>
              <h4 class="card-title">{{ dados_gerais.mesas }}</h4>
            </div>
          </stats-card>
        </div>
        <div class="col-xl-3 col-md-6">
          <stats-card>
            <div slot="header" class="icon-warning">
              <i class="nc-icon nc-credit-card text-warning"></i>
            </div>
            <div slot="content">
              <p class="card-category">Tipos de Pagamentos</p>
              <h4 class="card-title">{{ dados_gerais.pagamentos }}</h4>
            </div>
          </stats-card>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">Notificações</h2>
          <div v-if="notificacoes.length == 0">
            <h5 class="text-center">Nenhuma nova notificação</h5>
          </div>
          <div v-else v-for="notificacao in notificacoes" :key="notificacao.id">
            <b-alert show dismissible variant="warning">
                <strong>Atenção: </strong>A comanda Nº {{notificacao.id}} - Mesa {{notificacao.mesas.nome}} foi finalizada pelo cliente {{notificacao.nome}}
            </b-alert>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import api from "../plugins/api"
  import ChartCard from 'src/components/Cards/ChartCard.vue'
  import StatsCard from 'src/components/Cards/StatsCard.vue'
  import LTable from 'src/components/Table.vue'

  export default {
    components: {
      LTable,
      ChartCard,
      StatsCard
    },
    data () {
      return {
        dados_gerais: [],
        notificacoes: [],
        editTooltip: 'Edit Task',
        deleteTooltip: 'Remove',
        pieChart: {
          data: {
            labels: ['40%', '20%', '40%'],
            series: [40, 20, 40]
          }
        },
        lineChart: {
          data: {
            labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
            series: [
              [287, 385, 490, 492, 554, 586, 698, 695],
              [67, 152, 143, 240, 287, 335, 435, 437],
              [23, 113, 67, 108, 190, 239, 307, 308]
            ]
          },
          options: {
            low: 0,
            high: 800,
            showArea: false,
            height: '245px',
            axisX: {
              showGrid: false
            },
            lineSmooth: true,
            showLine: true,
            showPoint: true,
            fullWidth: true,
            chartPadding: {
              right: 50
            }
          },
          responsiveOptions: [
            ['screen and (max-width: 640px)', {
              axisX: {
                labelInterpolationFnc (value) {
                  return value[0]
                }
              }
            }]
          ]
        },
        barChart: {
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [
              [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
              [412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
            ]
          },
          options: {
            seriesBarDistance: 10,
            axisX: {
              showGrid: false
            },
            height: '245px'
          },
          responsiveOptions: [
            ['screen and (max-width: 640px)', {
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc (value) {
                  return value[0]
                }
              }
            }]
          ]
        },
        tableData: {
          data: [
            {title: 'Sign contract for "What are conference organizers afraid of?"', checked: false},
            {title: 'Lines From Great Russian Literature? Or E-mails From My Boss?', checked: true},
            {
              title: 'Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit',
              checked: true
            },
            {title: 'Create 4 Invisible User Experiences you Never Knew About', checked: false},
            {title: 'Read "Following makes Medium better"', checked: false},
            {title: 'Unfollow 5 enemies from twitter', checked: false}
          ]
        }
      }
    },
    mounted() {
      this.getDadosGerais();
      this.getNotificacoes();
      setInterval(this.getNotificacoes, 60000);
    },
    methods: {
      sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      },
      getDadosGerais() {
        api
          .get("/administrativo")
          .then((res) => {
            this.dados_gerais = res.data;
          })
          .catch((err) => {
            console.log(err.response.data.mensagem);
          });
      },
      async getNotificacoes() {
        console.log('chamou')
        await this.sleep(3000)

        api
          .get("/comandas/mesa/notificacoes")
          .then((res) => {
            this.notificacoes = res.data;
            return;
          })
          .catch((err) => {
            console.log(err.response.data.mensagem);
            return;
          });
      },
    },
  }
</script>
<style scoped>
.comandas-hoje{
  min-height: 261px;
}
</style>
