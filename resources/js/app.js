import { createApp } from 'vue';
import TaskTracker from './components/TaskTracker.vue';
import Summary from './components/SummaryTasks.vue';
import { TailwindPagination } from 'laravel-vue-pagination';

/*en una estructura ideal con un componente padre, la lógica de gestión de eventos, 
como handleTaskStopped, estaría en ese componente padre en lugar de directamente en el archivo principal de javascript*/

const app = createApp({
    methods: {
        handleTaskStopped() {
            const summaryTasksComponent = this.$refs.summaryTasks;
            if (summaryTasksComponent) {
                summaryTasksComponent.fetchTasks();
            }
        }
    }
});
app.component('task-tracker', TaskTracker);
app.component('summary-tasks', Summary);
app.mount('#app');

app.component('pagination', TailwindPagination);
import './bootstrap';

