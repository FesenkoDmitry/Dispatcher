<template>
  <div v-if="isError">
    <h2>Произошла непредвиденная ошибка</h2>
  </div>
  <div v-else class="admin-page">
    <h1 class="title">Администрирование</h1>
    <div v-if="!user">
      <auth-form />
    </div>
    <div v-else>
      <nav-bar
          :tabs="tabsConfig"
          @on-select-tab="selectedComponent = $event.component" />
      <component
          class="list-container"
          v-if="selectedComponent"
          :is="selectedComponent"
      />
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import AuthForm from '@c/AuthForm/index.vue';
import './style.scss';
import MastersList from './components/MastersList/index.vue';
import NavBar from '@c/Nav/index.vue';
import TabsConfig from './constants';
import OrdersList from './components/OrdersList/index.vue';

export default {
  name: "AdminPage",
  components: {
    AuthForm,
    MastersList,
    NavBar,
    OrdersList,
  },
  data() {
    return {
      isError: false,
      tabsConfig: TabsConfig,
      selectedComponent: null,
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ]),
  },
  methods: {
    ...mapActions([
      'logout'
    ]),
  }
}
</script>

<style scoped>

</style>