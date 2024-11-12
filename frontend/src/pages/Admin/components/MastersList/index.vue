<template>
  <div class="masters-list-container">
    <div class="table">
      <div class="tr">
        <div class="td">Имя</div>
        <div class="td">Статус</div>
        <div class="td">Координаты</div>
        <div class="td">Адрес</div>
      </div>
      <div class="tr" v-for="master in masters" :key="master.id">
        <div class="td">{{ master.first_name + ' ' + master.last_name }}</div>
        <div class="td">
          <select v-model="master.status_id" @change="saveUserStatus(master.id)">
            <option v-for="status in statuses" :value="status.id" :key="status.id">
              {{ status.label }}
            </option>
          </select>
        </div>
        <div class="td">{{
            master.coordinates ? master.coordinates.lat + ' ' + master.coordinates.lon : 'Неизвестно'
          }}
        </div>
        <div class="td">{{ master.address ? master.address : 'Неизвестно' }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import './style.scss';
import UserApi from '@a/user.js';

export default {
  name: "MastersList",
  emits: ['on-error'],
  data() {
    return {
      masters: [],
      errors: [],
      statuses: [],
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ])
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.loadMasters();
      this.loadStatuses();
    },
    loadMasters() {
      UserApi.getMasters(this.user.token)
          .then(response => this.masters = response);
    },
    loadStatuses() {
      UserApi.getStatuses(this.user.token)
          .then(response => this.statuses = response);
    },
    saveUserStatus(userId) {
      const user = this.masters.find(m => m.id === userId);
      const statusId = user.status_id;

      UserApi.setStatus(this.user.token, userId, statusId)
          .then(response => this.loadMasters());
    }
  },
  watch: {
    errors: {
      handler() {
        this.$emit('on-error', this.errors);
      }
    }
  }
}
</script>

<style scoped>

</style>