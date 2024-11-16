<template>
    <div class="mb-4">
      <input
        v-model="searchTask"
        @input="handleSearch"
        type="text"
        placeholder="Search tasks by name"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
      />
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        searchTask: '',
        searchTimeout: null,
      };
    },
    methods: {
      handleSearch() {
        clearTimeout(this.searchTimeout)
  
        this.searchTimeout = setTimeout(() => {
          if (this.searchTask.length >= 3 || this.searchTask.length === 0) {
            this.$emit('search-task', this.searchTask)
          }
        }, 3000);
      },
    },
  }
  </script>
  