<template>
  <div class="order-card">
    <div class="content">
      <div class="order-title">
        <h4>Заказ №{{ order.id }}</h4>
      </div>
      <div class="order-row">
        <div>Статус:</div>
        <div class="attr-value">{{ order.status.label}}</div>
      </div>
      <div class="order-row">
        <div>Адрес:</div>
        <div class="attr-value">{{ order.address }}</div>
      </div>
      <div class="order-row">
        <div>Клиент:</div>
        <div class="attr-value">{{ order.client.name }}</div>
      </div>
      <div class="order-row">
        <div>Контакты:</div>
        <div class="attr-value">{{ contact }}</div>
      </div>
    </div>
    <div v-if="canControl" class="controls">
      <button class="change-status" @click="$emit('on-change-status')">{{ changeStatusBtnText }}</button>
      <button class="change-status" @click="isShowCancelReason = true">Отменить</button>
      <div v-if="isShowCancelReason" class="cancel-reason">
        <span class="close" @click="isShowCancelReason = false">x</span>
        <h5>Укажите причину отмены:</h5>
        <textarea v-model="cancelReason" />
        <button class="cancel" :disabled="!canCancel" @click="$emit('on-cancel', cancelReason)">Сохранить</button>
      </div>
    </div>
  </div>
</template>

<script>
import './style.scss';

export default {
  name: "OrderCard",
  props: {
    order: {
      type: Object,
      required: true,
    },
    canControl: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isShowCancelReason: false,
      cancelReason: null,
    }
  },
  emits: ['on-change-status', 'on-cancel'],
  computed: {
    contact() {
      return this.order.client?.contacts.find(contact => contact.type === 'phone')?.value;
    },
    changeStatusBtnText() {
      switch (this.order.status.id) {
        case 6: return 'Принять';
        case 2: return 'В работу';
        case 3: return 'Завершить';
      }
    },
    canCancel() {
      return this.cancelReason && this.cancelReason.length > 10;
    }
  },
}
</script>

<style scoped>

</style>