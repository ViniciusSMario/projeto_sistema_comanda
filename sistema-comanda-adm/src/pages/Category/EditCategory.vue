<template>
  <div class="content">
    <div class="editar-categoria">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Editar Categoria</h3>
                  <b-form>
                    <input
                      type="hidden"
                      name="id"
                      class="form-control"
                      v-model="id_categoria"
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
                      @click="editarCategoria()"
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
  name: "EditarCategorias",
  data() {
    return {
      id_categoria: "",
      form: {
        nome: "",
      },
    };
  },
  mounted() {
    this.id_categoria = this.$route.params.id;
    this.getCategoria(this.id_categoria);
  },
  methods: {
    checkForm() {
        return this.form.nome == "" || this.form.nome == null;
    },
    editarCategoria() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .put("categorias/" + vm.id_categoria, vm.form)
        .then((res) => {
          console.log(res);
          setTimeout(() => {
            this.$router.push("/admin/category");
          }, 500);
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
      }
    },
    getCategoria(id_categoria) {
      var vm = this;
      api
        .get("categorias/" + id_categoria)
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
