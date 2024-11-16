<template>
    <div v-if="pagination.total > 0" class="mt-4 flex justify-center space-x-2 mb-2">
      <button
        :disabled="pagination.current_page <= 1"
        @click.prevent="changePage(pagination.current_page - 1)"
        :class="{
          'px-4 py-2 text-blue-500 cursor-not-allowed': pagination.current_page <= 1,
          'px-4 py-2 text-blue-500': pagination.current_page > 1
        }"
      >
        Previous
      </button>
  
      <span v-for="page in pagination.last_page" :key="page">
        <button
          @click.prevent="changePage(page)"
          :class="{
            'px-4 py-2 text-blue-700 font-semibold': pagination.current_page === page,
            'px-4 py-2 text-blue-700 hover:bg-blue-100': pagination.current_page !== page
          }"
        >
          {{ page }}
        </button>
      </span>
  
      <button
        :disabled="pagination.current_page >= pagination.last_page"
        @click.prevent="changePage(pagination.current_page + 1)"
        :class="{
          'px-4 py-2 text-blue-500 cursor-not-allowed': pagination.current_page >= pagination.last_page,
          'px-4 py-2 text-blue-500': pagination.current_page < pagination.last_page
        }"
      >
        Next
      </button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      pagination: Object, 
    },
    methods: {
      changePage(page) {
        this.$emit('change-page', page);
      }
    }
  }
  </script>
  