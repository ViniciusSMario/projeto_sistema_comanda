<template>
  <b-card-group deck>
    <b-card class="panel-card">
      <b-row>
        <b-col md="12">
          <h3 class="disponivel title-page text-center">
            <b-icon icon="tags"></b-icon>
            Novo Lançamento: {{ idComanda }}
          </h3>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="4" sm="6" xs="3" v-for="categoria in categorias" :key="categoria.id" class="text-center">
          <button class="btn btn-info w-100 mb-2" v-on:click="$emit('get-category-id', categoria.id)">
            {{ categoria.nome }}
          </button>
        </b-col>
      </b-row>
    </b-card>
  </b-card-group>
</template>

<script>
export default {
  name: "CategoryList",
  props: {
    categorias: [],
    idComanda: String
  }
}
</script>
