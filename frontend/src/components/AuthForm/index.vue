<template>
  <div class="auth-form">
    <form @submit.prevent="submit">
      <h3>Для продолжения требуется авторизация:</h3>
      <div class="form-container">
        <div class="input-container">
          <label for="login">Логин:</label>
          <input v-model="user.login" id="login" type="text" name="login">
        </div>
        <div class="input-container">
          <label for="password">Пароль:</label>
          <input v-model="user.password" id="password" type="password" name="password">
        </div>
        <button type="submit" class="submit">Войти</button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import './style.scss';

export default {
  name: "AuthForm",
  data() {
    return {
      user: {
        login: '',
        password: '',
      }
    }
  },
  methods: {
    ...mapActions([
        'login'
    ]),
    submit() {
      this.login(this.user)
    }
  }
}
</script>

<style scoped>

</style>