<template>
  <div class="content">
    <div class="criar-produto">
      <b-container>
        <div>
          <b-card-group deck>
            <b-card class="panel-card">
              <b-row>
                <b-col md="12">
                  <h3 class="title-page">Adicionar Produto</h3>
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
                      @click="criarProduto()"
                      class="button"
                      variant="primary"
                      >Criar Produto</b-button
                    >
                    <b-button type="reset" class="button" variant="danger" @click="() => this.form.categorias_id = undefined"
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
  name: "NovoProduto",
  data() {
    return {
      form: {
        nome: "",
        descricao: "",
        preco: "",
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
    criarProduto() {
      if(this.checkForm()) {
        this.$swal("Formulário inválido", "", "warning")
      }else {
      var vm = this;
      api
        .post("produtos", vm.form)
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
  },
  mounted() {
    this.getCategorias();
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
