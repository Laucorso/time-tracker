<template>
    <div class="container mx-auto mt-4 md:mt-0 md:ml-4">
        <div class="flex items-center justify-center space-x-2 mb-6">
          <h2 class="text-3xl font-semibold text-center text-gray-800">Task Summary</h2>
        </div>
          <!-- filter -->
        <task-filter @search-task="handleSearch"></task-filter>

        <div v-if="tasks.length > 0" class="card overflow-x-auto bg-white shadow-md rounded-lg">

            <table class="table-auto w-full">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Task</th>
                        <th class="px-4 py-2 text-left">Today</th>
                        <th class="px-4 py-2 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks" :key="task.id" class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 text-left">{{ task.name }}</td>
                        <td class="px-4 py-2 text-left">{{ task.today_time }}</td>
                        <td class="px-4 py-2 text-left">{{ task.total_time }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- pagination buttons -->
            <pagination :pagination="pagination" @change-page="changePage"></pagination>

        </div>
    </div>
</template>


<script>
import TaskFilter from './TaskFilter.vue'; 
import Pagination from './Pagination.vue';
import axios from 'axios';

export default {
  name: 'Summary',
  components: {
    TaskFilter,
    Pagination,
  },
  data() {
    return {
      tasks: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 5,
        total: 0,
      }, 
      searchTask: ''   
    };
  },

  mounted() {
    this.changePage()
  },

  methods: {
    async fetchTasks(page = 1) {
      try {
        const params = { page };

        if (this.searchTask.trim() !== '') {
          params.filter = this.searchTask;
        }

        const response = await axios.get('/api/tasks/summary', {params});

        this.tasks = response.data.tasks;

        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total,
        };
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },

    async changePage(page = 1) {
        this.fetchTasks(page)
    },

    async handleSearch(searchTask) {
      this.searchTask = searchTask; 
      this.changePage(1);
    },
  }
};
</script>

