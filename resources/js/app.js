import { createApp } from 'vue';
import TaskTracker from './components/TaskTracker.vue';
import Summary from './components/SummaryTasks.vue';

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

import './bootstrap';

