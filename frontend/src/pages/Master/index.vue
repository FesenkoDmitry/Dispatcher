<template>
  <div class="master-page" v-if="user">
    <div class="status-container">
      <h2>Мой статус:</h2>
      <select v-model="status.id" @change="updateUserStatus">
        <option v-for="status in statuses" :value="status.id" :key="status.id">
          {{ status.label }}
        </option>
      </select>
    </div>
    <div class="page-title">
      <h2>Мои заказы:</h2>
    </div>
    <div v-if="orders.length > 0" class="order-list">
      <order-card
          v-for="order in orders"
          :key="order.id"
          :order="order"
          :can-control="!showHistoryOrders"
          @on-change-status="handleUpdateOrderStatus(order)"
          @on-cancel="handleCancelOrder(order, $event)"
      />
    </div>
    <div class="not-found" v-else>
      <h3>Заказы не найдены</h3>
    </div>
    <div class="order-history">
      <button @click="toggleShowHistoryOrders">{{ showHistoryOrdersBtnText }}</button>
    </div>
  </div>
  <div v-else>
    <auth-form/>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import AuthForm from '@c/AuthForm/index.vue';
import './style.scss';
import OrderApi from '@a/order.js';
import OrderCard from '@c/OrderCard/index.vue';
import constants from "./constants";
import UserApi from '@a/user.js';

export default {
  name: "MasterPage",
  components: {
    AuthForm,
    OrderCard,
  },
  data() {
    return {
      orders: [],
      cancelComment: null,
      status: {},
      statuses: [],
      showHistoryOrders: false,
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ]),
    showHistoryOrdersBtnText() {
      return this.showHistoryOrders ? 'Текущие заказы' : 'История заказов';
    }
  },
  mounted() {
    this.init();
  },
  watch: {
    showHistoryOrders(val) {
      if (val) {
        this.loadHistoryOrders();
      } else {
        this.loadOrders();
      }
    }
  },
  methods: {
    init() {
      this.loadOrders();
      this.loadStatuses();
      this.loadCurrentStatus();
    },
    loadOrders() {
      OrderApi.getForCurrentUser(this.user.token)
          .then(response => this.orders = response);
    },
    loadHistoryOrders() {
      OrderApi.getHistoryForCurrentUser(this.user.token)
          .then(response => this.orders = response);
    },
    loadStatuses() {
      UserApi.getStatuses(this.user.token)
          .then(response => this.statuses = response);
    },
    loadCurrentStatus() {
      UserApi.getStatus(this.user.token)
          .then(response => this.status = response);
    },
    updateUserStatus() {
      UserApi.setStatus(this.user.token, this.status.id)
          .then(response => this.loadCurrentStatus());
    },
    handleUpdateOrderStatus(order) {
      const newStatusPosition = constants.ORDER_STATUSES_PIPELINE
          .find(status => status.id === order.status.id).position + 1;
      const newStatusId = constants.ORDER_STATUSES_PIPELINE
          .find(status => status.position === newStatusPosition).id;

      if (newStatusId === constants.ORDER_STATUSES.IN_WORK) {
        this.status.id = constants.USER_STATUSES.WORKING
        this.updateUserStatus();
      }

      this.updateOrderStatus(newStatusId, order.id);
    },
    updateOrderStatus(statusId, orderId) {
      OrderApi.update(this.user.token, {
        statusId,
        id: orderId,
      })
          .then(response => this.loadOrders());
    },
    handleCancelOrder(order, text) {
      OrderApi.addComment(this.user.token, order.id, text)
          .then(response => {
            this.updateOrderStatus(constants.ORDER_STATUSES.CANCEL, order.id);
          });
    },
    toggleShowHistoryOrders() {
      this.showHistoryOrders = !this.showHistoryOrders;
    },
  },
}
</script>

<style scoped>

</style>