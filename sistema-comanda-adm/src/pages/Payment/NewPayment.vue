<template>
  <div class="content">
    <div class="new-payment">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Adicionar Tipo de Pagamento</h3>
                  <b-form @submit="checkForm">
                    <b-form-input
                      id="nome"
                      v-model="form.nome"
                      placeholder="Tipo de pagamento"
                      required
                    ></b-form-input>
                    <br />
                    <b-button
                      type="button"
                      @click="criarTipoPagamento()"
                      class="button"
                      variant="primary"
                      >Criar Tipo de Pagamento</b-button
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
  name: "NewPayment",
  data() {
    return {
      form: {
        nome: "",
      },
    };
  },
  methods: {
    checkForm() {
        return this.form.nome == "" || this.form.nome == null;
    },
    criarTipoPagamento() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .post("tipo_pagamentos", vm.form)
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
