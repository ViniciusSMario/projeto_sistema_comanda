<template>
  <div class="content">
    <div class="editar-produto">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Editar Produto</h3>
                  <b-form>
                    <label for="nome">Nome do Produto</label>
                    <b-form-input
                      id="nome"
                      v-model="form.nome"
                      placeholder="Nome do produto"
                      required
                    ></b-form-input>
                    <br />
                    <label for="descricao">Descrição</label>
                    <b-form-input
                      id="descricao"
                      v-model="form.descricao"
                      placeholder="Descrição do produto"
                      required
                    ></b-form-input>
                    <br />
                    <b-row>
                      <b-col md="6">
                        <label for="preco">Valor</label>
                        <b-form-input
                          type="number"
                          id="preco"
                          v-model="form.preco"
                          placeholder="Valor do produto"
                          required
                          min="0"
                        ></b-form-input>
                      </b-col>
                      <b-col md="6">
                        <label for="categorias_id">Categoria</label>
                        <b-form-select
                          id="categorias_id"
                          v-model="form.categorias_id"
                          :options="categorias"
                          required
                          class="form-control"
                        ></b-form-select>
                      </b-col>
                    </b-row>
                    <br />
                    <b-button
                      type="button"
                      @click="editarProduto()"
                      class="button"
                      variant="primary"
                      >Editar Produto</b-button
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
  name: "EditarProduto",
  data() {
    return {
      id_produto: 0,
      form: {
        nome: "",
        descricao: "",
        preco: 0,
        categorias_id: 0,
      },
      categorias: [],
    };
  },
  methods: {
    checkForm() {

      return this.form.nome == "" ||
             this.form.nome == null ||
             this.form.descricao == "" ||
             this.form.descricao == null ||
             this.form.preco == 0 ||
             this.form.preco == null ||
             this.form.categorias_id == 0 ||
             this.form.categorias_id == null

    },
    editarProduto() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      } else {
      var vm = this;
      api
        .put("produtos/" + vm.id_produto, vm.form)
        .then((res) => {
          console.log(res);
          setTimeout(() => {
            this.$router.push("/admin/product");
          }, 500);
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
      }
    },
    getCategorias() {
      var vm = this;

      api
        .get("categorias")
        .then((res) => {
          res.data.map(function (el) {
            console.log(el);
            vm.categorias.push({
              value: el.id,
              text: el.nome,
            });
          });
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
    getProduto(id_produto) {
      var vm = this;
      api
        .get("produtos/" + id_produto)
        .then((res) => {
          vm.form.nome = res.data.nome;
          vm.form.descricao = res.data.descricao;
          vm.form.preco = res.data.preco;
          vm.form.categorias_id = res.data.categorias_id;
        })
        .catch((error) => {
          console.log(error.response.data.mensagem);
        });
    },
  },
  mounted() {
    this.getCategorias();
    this.id_produto = this.$route.params.id;
    this.getProduto(this.id_produto);
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
