<template>
  <div class="orders-list-container">
    <div>
      <div class="filter-container">
        <a href="#" @click="toggleShowFilter">Фильтр</a>
        <div v-if="showFilter" class="filter">
          <div class="filter-input-container">
            <div class="filter-input-group">
              <label for="order-id">ID заказа:</label>
              <input v-model="filter.id" id="order-id" type="number">
            </div>
            <div class="filter-input-group">
              <label for="status">Статус:</label>
              <select id="status" v-model="filter.statusId">
                <option v-for="status in statuses" :key="status.id" :value="status.id">
                  {{ status.label }}
                </option>
              </select>
            </div>
            <div class="filter-input-group">
              <label for="user">Мастер:</label>
              <select id="user" v-model="filter.userId">
                <option v-for="master in masters" :key="master.id" :value="master.id">
                  {{ `${master.first_name} ${master.last_name}` }}
                </option>
              </select>
            </div>
            <div class="filter-input-group">
              <label for="priority">Приоритет:</label>
              <select id="priority" v-model="filter.orderPriorityId">
                <option v-for="priority in priorities" :key="priority.id" :value="priority.id">
                  {{ priority.label }}
                </option>
              </select>
            </div>
            <div class="filter-input-group">
              <label for="deadline-from">Срок c:</label>
              <vue-date-picker
                  v-model="filter.deadlineFrom"
                  model-type="timestamp"
                  id="deadline-from"
                  locale="ru"
                  cancelText="Отменить"
                  selectText="Выбрать"
                  uid="deadline-from"
                  :enable-time-picker="false"
              />
            </div>
            <div class="filter-input-group">
              <label for="deadline-to">Срок до:</label>
              <vue-date-picker
                  v-model="filter.deadlineFrom"
                  model-type="timestamp"
                  id="deadline-to"
                  locale="ru"
                  cancelText="Отменить"
                  selectText="Выбрать"
                  uid="deadline-to"
                  :enable-time-picker="false"
              />
            </div>
            <div class="filter-input-group">
              <label for="created-from">Дата создания c:</label>
              <vue-date-picker
                  v-model="filter.createdFrom"
                  model-type="timestamp"
                  id="created-from"
                  locale="ru"
                  cancelText="Отменить"
                  selectText="Выбрать"
                  uid="created-from"
                  :enable-time-picker="false"
              />
            </div>
            <div class="filter-input-group">
              <label for="created-to">Дата создания до:</label>
              <vue-date-picker
                  v-model="filter.createdTo"
                  model-type="timestamp"
                  id="created-to"
                  locale="ru"
                  cancelText="Отменить"
                  selectText="Выбрать"
                  uid="created-to"
                  :enable-time-picker="false"
              />
            </div>
          </div>
          <div class="filter-controls">
            <button @click="loadOrders">Применить</button>
            <button @click="clearFilter">Сбросить</button>
          </div>
        </div>
      </div>
      <div class="table">
        <div class="tr th">
          <div class="td">ID</div>
          <div class="td">Статус</div>
          <div class="td">Приоритет</div>
          <div class="td">Мастер</div>
          <div class="td">Клиент</div>
          <div class="td">Адрес</div>
          <div class="td">Срок</div>
          <div class="td">Дата создания</div>
        </div>
        <div class="tr" v-for="order in orders" :key="order.id">
          <div class="td">{{ order.id }}</div>
          <div class="td">
            <select v-model="order.status.id" @change="setStatus(order.status.id, order.id)">
              <option v-for="status in statuses" :value="status.id" :key="status.id">
                {{ status.label }}
              </option>
            </select>
          </div>
          <div class="td">
            {{ order.priority.label }}
          </div>
          <div class="td">
            <select v-model="order.user.id" @change="setUser(order.user.id, order.id)">
              <option v-for="master in masters" :value="master.id" :key="master.id">
                {{ master.first_name + ' ' + master.last_name }}
              </option>
            </select>
          </div>
          <div class="td">
            {{ order.client.name }}
          </div>
          <div class="td">{{ order.address }}</div>
          <div class="td">{{ order.deadline }}</div>
          <div class="td">{{ order.created_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import './style.scss';
import {mapGetters} from "vuex";
import VueDatePicker from '@vuepic/vue-datepicker';
import OrderApi from '@a/order.js';
import UserApi from '@a/user.js';

export default {
  name: "OrdersList",
  components: {
    VueDatePicker,
  },
  data() {
    return {
      orders: [],
      showFilter: false,
      filter: {
        id: null,
        statusId: null,
        userId: null,
        orderPriorityId: null,
        deadlineTo: null,
        deadlineFrom: null,
        createdTo: null,
        createdFrom: null,
        limit: 100,
        offset: 0,
      },
      statuses: [],
      masters: [],
    }
  },
  computed: {
    ...mapGetters([
      'user',
    ]),
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.loadStatuses();
      this.loadMasters();
      this.loadOrders();
    },
    loadStatuses() {
      OrderApi.getStatuses(this.user.token)
          .then(response => {
            this.statuses = response;
          });
    },
    loadMasters() {
      UserApi.getMasters(this.user.token)
          .then(response => {
            this.masters = response;
          });
    },
    loadOrders() {
      OrderApi.getOrders(this.user.token, this.filter)
          .then(response => {
            this.orders = response;
          })
    },
    toggleShowFilter() {
      this.showFilter = !this.showFilter;
    },
    clearFilter() {
      this.filter.id = null;
      this.filter.userId = null;
      this.filter.statusId = null;
      this.filter.orderPriorityId = null;
      this.filter.deadlineFrom = null;
      this.filter.deadlineTo = null;
      this.filter.createdFrom = null;
      this.filter.createdTo = null;
    },
    setStatus(statusId, id) {
      OrderApi.update(this.user.token, {
        id,
        statusId,
      }).then(response => this.loadOrders());
    },
    setUser(userId, id) {
      OrderApi.update(this.user.token, {
        id,
        userId,
      }).then(response => this.loadOrders());
    }
  }
}
</script>

<style scoped>

</style>