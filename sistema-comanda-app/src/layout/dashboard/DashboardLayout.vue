<template>
  <div class="wrapper">
    <side-bar>
      <template slot="links">
        <sidebar-link to="/products" name="Produtos" icon="fa fa-shopping-bag"/>
        <sidebar-link to="/cart" name="Meu Pedido" icon="ti-shopping-cart"/>
        <sidebar-link to="/comand" name="Minha Comanda" icon="fa fa-list-alt"/>
      </template>

    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click.native="toggleSidebar">

      </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss">
</style>
<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "./MobileMenu";
export default {
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
    MobileMenu
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }
  }
};
</script>
