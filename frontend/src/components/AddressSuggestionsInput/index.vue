<template>
  <div class="address-container">
    <label for="address">Адрес:</label>
    <input v-if="!selectedSuggestion" v-model="query" id="address" name="address" placeholder="Начните вводить адрес" class="client-form-input">
    <div v-if="selectedSuggestion" class="selected-suggestion" @click="clearSelectedSuggestion">
      <span>{{ selectedSuggestion }}</span>
    </div>
    <div v-if="suggestions.length > 0 && query" class="suggestions-container">
      <div v-for="(suggestion, index) in suggestions" :key="index" class="suggestion" @click="selectSuggestion(suggestion.value)">{{ suggestion.value }}</div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import './style.scss';

export default {
  name: "AddressSuggestionsInput",
  emits: [
    'on-select',
  ],
  data() {
    return {
      query: '',
      suggestions: [],
      selectedSuggestion: '',
      selectedSuggestionDetails: {},
      searchInputTimer: null,
    }
  },
  methods: {
    getSuggestions(query, count = 10){
      axios.get('/dadata/suggestions', {
        params: {
          query,
          count,
        },
      }).then(response => {
        if (Array.isArray(response?.data) && response?.data.length > 0) {
          if (response.data.length > 1) {
            this.suggestions = response.data;
          } else {
            this.$emit('on-select', response.data[0]);
            this.suggestions = [];
            this.selectedSuggestion = response.data[0].value;
            this.query = response.data[0].value;
          }
        }
      }).then(error => console.log(error));
    },
    selectSuggestion(suggestion) {
      this.getSuggestions(suggestion, 1);
    },
    clearSelectedSuggestion() {
      this.selectedSuggestion = '';
    }
  },
  watch: {
    query: {
      handler(val, oldVal) {
        clearTimeout(this.searchInputTimer);
        if (val.length > 2) {
          this.searchInputTimer = setTimeout(() => {
            this.getSuggestions(val);
          }, 1000);
        }
      }
    },
  }
}
</script>

<style scoped>

</style>