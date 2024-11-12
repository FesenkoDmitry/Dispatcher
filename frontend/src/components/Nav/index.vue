<template>
  <div class="nav-container">
    <div
        class="tab"
        v-for="(tab, index) in tabs"
        :key="index"
        :class="{ active: index === currentTabIndex }"
        @click="setCurrent(index)"
    >
      <div class="label">
        {{ tab.label }}
      </div>
    </div>
  </div>
</template>

<script>
import './style.scss';

export default {
  name: "NavBar",
  props: {
    tabs: {
      type: Array,
      required: true,
    }
  },
  emits: ['on-select-tab'],
  data() {
    return {
      currentTabIndex: null,
    }
  },
  methods: {
    setCurrent(index) {
      this.currentTabIndex = index;
    }
  },
  watch: {
    currentTabIndex: {
      handler() {
        this.$emit('on-select-tab', this.tabs[this.currentTabIndex]);
      }
    }
  }
}
</script>

<style scoped>

</style>