<template>
  <Header />
  <div class="page-container">
    <router-view />
  </div>

</template>

<script>
import Header from '@c/Header/index.vue';

export default {
  name: "App",
  components: {
    Header,
  }
}
</script>

<style scoped>

</style>