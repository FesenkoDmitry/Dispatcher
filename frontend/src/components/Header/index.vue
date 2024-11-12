<template>
  <div class="header">
    <div class="user-info" v-if="user">
      <h3 class="hello">Привет, {{ user.first_name }}</h3>
      <button v-if="user" @click="logout">Выйти</button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions} from 'vuex';
import './style.scss';

export default {
  name: "Header",
  computed: {
    ...mapGetters(['user']),
  },
  methods: {
    ...mapActions(['logout']),
  }
}
</script>

<style scoped>

</style>