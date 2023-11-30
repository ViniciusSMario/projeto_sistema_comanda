<template>
  <div class="content">
    <div class="editar-categoria">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Editar Mesa</h3>
                  <b-form>
                    <input
                      type="hidden"
                      name="id"
                      class="form-control"
                      v-model="idMesa"
                    />
                    <b-form-input
                      id="nome"
                      v-model="form.nome"
                      placeholder="Nome da Categoria"
                      required
                    ></b-form-input>
                    <br />
                    <b-button
                      type="button"
                      @click="editarMesas()"
                      class="button"
                      variant="primary"
                      >Editar Mesa</b-button
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
  name: "EditTable",
  data() {
    return {
      idMesa: "",
      form: {
        nome: "",
      },
    };
  },
  mounted() {
    this.idMesa = this.$route.params.id;
    this.getMesa(this.idMesa);
  },
  methods: {
    checkForm() {
        return this.form.nome == "" || this.form.nome == null;
    },
    editarMesas() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .put("mesas/" + vm.idMesa, vm.form)
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
    getMesa(idMesa) {
      var vm = this;
      api
        .get("mesas/" + idMesa)
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
