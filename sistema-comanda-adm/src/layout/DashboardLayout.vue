<template>
  <div class="wrapper">
    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/admin/overview">
        <i class="nc-icon nc-chart-pie-35"></i>
        <p>Dashboard</p>
      </sidebar-link>
      <sidebar-link to="/admin/category">
        <i class="nc-icon nc-app"></i>
        <p>Categorias</p>
      </sidebar-link>
      <sidebar-link to="/admin/product">
        <i class="nc-icon nc-circle-09"></i>
        <p>Produtos</p>
      </sidebar-link>
      <sidebar-link to="/admin/payment">
        <i class="nc-icon nc-credit-card"></i>
        <p>Tipos de Pagamento</p>
      </sidebar-link>
      <sidebar-link to="/admin/command">
        <i class="nc-icon nc-notes"></i>
        <p>Comandas</p>
      </sidebar-link>
      <sidebar-link to="/admin/commands/all">
        <i class="nc-icon nc-notes"></i>
        <p>Todas as Comandas</p>
      </sidebar-link>
      <sidebar-link to="/admin/kitchen">
        <i class="nc-icon nc-notes"></i>
        <p>Cozinha</p>
      </sidebar-link>
      <sidebar-link to="/admin/table">
        <i class="nc-icon nc-notes"></i>
        <p>Mesas</p>
      </sidebar-link>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click="toggleSidebar">

      </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss">

</style>
<script>
  import TopNavbar from './TopNavbar.vue'
  import ContentFooter from './ContentFooter.vue'
  import DashboardContent from './Content.vue'
  import MobileMenu from './MobileMenu.vue'
  export default {
    components: {
      TopNavbar,
      ContentFooter,
      DashboardContent,
      MobileMenu
    },
    methods: {
      toggleSidebar () {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false)
        }
      },
    }
  }

</script>
