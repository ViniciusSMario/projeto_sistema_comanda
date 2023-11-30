<template>
  <div class="inicio gradient-custom vh-100">
    <div class="container">
      <div class="row d-flex justify-content-end align-items-end h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div
            class="card text-white mt-3"
            style="border-radius: 1rem; background-color: #051937"
          >
            <div class="card-body">
              <div class="mt-md-2 pb-2">
                <h2 class="fw-bold mb-2 text-uppercase text-center">
                  Seja bem-vindo
                </h2>
                <h3 class="text-center">
                  Para fazer seu pedido, informe os dados abaixo
                </h3>

                <div class="form-group">
                  <label for="nome" class="font-weight-bold text-white"
                    >Nome:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    name="nome"
                    id="nome"
                    v-model="nova_comanda.nome"
                    placeholder="Nome Completo"
                  />
                </div>

                <div class="form-group">
                  <label for="cliente" class="font-weight-bold text-white"
                    >Telefone/Celular:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    name="celular"
                    id="celular"
                    placeholder="(19)9 9999-9999"
                    v-model="nova_comanda.celular"
                    v-mask="['(##) ####-####', '(##) #####-####']"
                  />
                </div>

                <div class="form-group">
                  <label for="cliente" class="font-weight-bold text-white"
                    >Mesa:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    name="mesa"
                    id="mesa"
                    v-model="nova_comanda.mesas_id"
                    placeholder="Código da mesa"
                  />
                </div>

                <div
                  class="d-flex justify-content-center align-items-center text-center"
                >
                  <button
                    class="btn btn-outline-success btn-lg px-5 mt-3"
                    type="button"
                    @click="criarComanda()"
                  >
                    Começar
                  </button>
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
import api from '../plugins/api'

export default {
  data() {
    return {
      nova_comanda: {
        mesas_id: '',
        nome: '',
        celular: ''
      },
      mensagem: ''
    };
  },
  methods: {
     criarComanda(){
       api
        .post("comandas", this.nova_comanda)
        .then((res) => {
          localStorage.comandas_id = res.data.comandas.id;
          localStorage.nome = this.nova_comanda.nome;
          localStorage.mesas_id = this.nova_comanda.mesas_id;
          localStorage.celular = this.nova_comanda.celular;

          this.$router.push('/products/');
        })
        .catch((error) => {
          this.mensagem = error.response.data.mensagem;
          this.$swal('Ops!!!', this.mensagem, 'error');

        });
    },
  }
};
</script>
<style>
.gradient-custom {
  background-image: url("../../public/images/background-login.jpg");
  background-size: cover;
}
</style>
