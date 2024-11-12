<template>
  <div class="client-form">
    <div v-if="isSubmitted" class="submission-result">
      <h1>Ваша заявка принята!</h1>
      <h3>Мастер свяжется в ближайшее время.</h3>
    </div>
    <div v-else-if="submissionError" class="submission-result">
      <h1>Произошла ошибка</h1>
      <h3>Попробуйте отправить заявку повторно.</h3>
      <button @click="clearErrors">Вернуться</button>
    </div>
    <form v-else @submit.prevent="createOrder">
      <div class="form-title-container">
        <h1 class="form-title">Оставить заявку</h1>
      </div>
      <div class="form-container">
        <div class="input-container">
          <label for="name">Имя:</label>
          <input v-model="order.name" id="name" type="text" name="name" class="client-form-input">
        </div>
        <div class="input-container">
          <label for="phone">Телефон:</label>
          <div class="phone-container">
            <input disabled :placeholder="phoneCode" class="phone-code">
            <input v-model="phone" id="phone" type="text" name="phone" minlength="10" maxlength="10"
                   class="client-form-input">
          </div>
        </div>
        <AddressSuggestionsInput
            class="input-container"
            @on-select="setCoords"
        />
        <div class="input-container">
          <label for="issue">Проблема:</label>
          <select id="issue" v-model="order.issueId" class="client-form-input">
            <option v-for="(issue, index) in issues" :key="index" :value="issue.id">{{ issue.name }}</option>
          </select>
        </div>
        <div v-if="!order.isUrgent" class="input-container-date">
          <label for="date">Дата:</label>
          <vue-date-picker
              v-model="order.dateTime"
              model-type="timestamp"
              id="date"
              locale="ru"
              cancelText="Отменить"
              selectText="Выбрать"
              uid="dp"
              time-picker-inline
              :min-date="new Date()"
              :start-time="timePickerConfig"
          />
        </div>
        <div class="input-container urgent">
          <label for="is-urgent">Срочно</label>
          <input v-model="order.isUrgent" id="is-urgent" type="checkbox" name="urgent">
        </div>
        <button class="submit" :disabled="!canSubmit">Оставить заявку</button>
        <h4>Минимальная стоимость выезда мастера: 500 рублей</h4>
      </div>
    </form>
  </div>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import AddressSuggestionsInput from "@c/AddressSuggestionsInput/index.vue";
import './style.scss';
import OrderApi from '@a/order.js';
import IssueApi from '@a/issue.js';

export default {
  name: "ClientForm",
  components: {
    VueDatePicker,
    AddressSuggestionsInput,
  },
  data() {
    return {
      order: {
        name: '',
        phone: '',
        coords: '',
        issueId: '',
        dateTime: 0,
        isUrgent: false,
        address: '',
      },
      phoneCode: '+7',
      phone: '',
      issues: {},
      timePickerConfig: {
        hours: (new Date()).getHours(),
        minutes: (new Date()).getMinutes(),
      },
      isSubmitted: false,
      submissionError: false,
    }
  },
  computed: {
    canSubmit() {
      return !!this.order.name && !!this.order.phone && !!this.order.coords && !!this.order.issueId && (!!this.order.dateTime || !!this.order.isUrgent);
    },
  },
  methods: {
    init() {
      this.loadIssues();
    },
    loadIssues() {
      IssueApi.getList()
          .then(response => this.issues = response);
    },
    createOrder() {
      OrderApi.create(this.order)
          .then(response => this.isSubmitted = response);
    },
    setCoords(data) {
      this.order.coords = {
        lat: data.data.geo_lat,
        lon: data.data.geo_lon,
      };
      this.order.address = data.value;
    },
    clearErrors() {
      this.submissionError = false;
    }
  },
  mounted() {
    this.init();
  },
  watch: {
    phone: {
      handler(val, oldVal) {
        this.phone = val.replace(/[^\d.-]+/g, '')
        this.order.phone = this.phoneCode + this.phone;
      },
    }
  },
}
</script>

<style scoped>

</style>