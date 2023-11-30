<template>
  <div class="content">
    <div class="new-category">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Adicionar Mesa</h3>
                  <b-form>
                    <b-form-input
                      id="nome"
                      v-model="form.nome"
                      placeholder="Nome da Mesa"
                      required
                    ></b-form-input>
                    <br />
                    <b-button
                      type="button"
                      @click="criarMesa()"
                      class="button"
                      variant="primary"
                      >Criar Mesa</b-button
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
  name: "NewTable",
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
    criarMesa() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .post("mesas", vm.form)
        .then((res) => {
          console.log(res);
          setTimeout(() => {
            this.$router.push("/admin/table");
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
