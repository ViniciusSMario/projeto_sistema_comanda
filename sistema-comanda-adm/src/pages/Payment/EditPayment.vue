<template>
  <div class="content">
    <div class="editar-payment">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Editar Tipo de Pagamento</h3>
                  <b-form>
                    <input
                      type="hidden"
                      name="id"
                      class="form-control"
                      v-model="id_tipo_pagamento"
                    />
                    <b-form-input
                      id="nome"
                      v-model="form.nome"
                      placeholder="Tipo de Pagamento"
                      required
                    ></b-form-input>
                    <br />
                    <b-button
                      type="button"
                      @click="editarTipoPagamento()"
                      class="button"
                      variant="primary"
                      >Editar Categoria</b-button
                    >
                    <b-button type="reset" class="button" variant="danger"
                      >Limpar</b-button
                    >
                  </b-form>
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
import api from "../../plugins/api";
export default {
  name: "EditarTipoPagamento",
  data() {
    return {
      id_tipo_pagamento: "",
      form: {
        nome: "",
      },
    };
  },
  mounted() {
    this.id_tipo_pagamento = this.$route.params.id;
    this.getTipoPagamento(this.id_tipo_pagamento);
  },
  methods: {
    checkForm() {
        return this.form.nome == "" || this.form.nome == null;
    },
    editarTipoPagamento() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .put("tipo_pagamentos/" + vm.id_tipo_pagamento, vm.form)
        .then((res) => {
          console.log(res);
          setTimeout(() => {
            this.$router.push("/admin/payment");
          }, 500);
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
      }
    },
    getTipoPagamento(id_tipo_pagamento) {
      var vm = this;
      api
        .get("tipo_pagamentos/" + id_tipo_pagamento)
        .then((res) => {
          vm.form.nome = res.data.nome;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
  },
};
</script>

<style scoped>
.data {
  text-align: right;
  font-weight: bold;
  font-size: 16px;
}

.button {
  margin: 10px;
}
</style>
