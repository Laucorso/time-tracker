<template>
    <div>
        <div class="flex items-center justify-center space-x-2 mb-6">
            <span class="material-symbols-outlined">
            timer
            </span>
            <h2 class="text-3xl font-semibold text-center text-gray-800">Task Time Tracker</h2>
        </div>
        <div class="task-tracker">
            <div class="input-container">
                <input type="text" v-model="taskName" :disabled="isTracking" placeholder="Enter task name" class="task-input" />
                <button v-if="!isTracking" @click="startTask" class="ml-2 start-button">Start</button>
                <button v-if="isTracking" @click="stopTask" class="ml-2 stop-button">Stop</button>
            </div>

            <br><br>
            <p v-if="isTracking" class="tracking-text">Tracking task: <span class="text-blue-900 uppercase">{{ trackingTaskName }}</span></p>

            <p v-if="showTime" class="time-tracked">{{ formattedTimeTracked }}</p>

            <Notification v-if="notification.message" :message="notification.message" :type="notification.type" />

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Notification from "./Notification.vue";

export default {
    name: 'TaskTracker',
    components: {
        Notification,
    },
    emits: ['task-stopped'],
    data() {
        return {
            taskName: '',
            trackingTaskName: '',
            isTracking: false,
            showTime: false,
            timeTracked: 0,
            intervalId: null,
            notification: {
                message: "",
                type: "success",
            },
        };
    },
    computed: {
        formattedTimeTracked() {
            const hours = Math.floor(this.timeTracked / 3600); 
            const minutes = Math.floor((this.timeTracked % 3600) / 60);
            const seconds = this.timeTracked % 60;

            return `${hours} hour${hours !== 1 ? 's' : ''} ${minutes} minute${minutes !== 1 ? 's' : ''} ${seconds} second${seconds !== 1 ? 's' : ''}`;
        }
    },
    methods: {
        async startTask() {
            if (this.taskName) {
                try {
                    const response = await axios.post(`/api/tasks/${this.taskName}/start`);
                    this.isTracking = true;
                    this.showTime = true;  // Show time when tracking starts
                    this.startCounter();
                    this.taskName = ''
                    this.showNotification("Task started successfully!", "success");
                } catch (error) {
                    console.error('Error starting task:', error);
                }
            }
        },
        async stopTask() {
            try {
                const response = await axios.put(`/api/tasks/${this.trackingTaskName}/stop`, {
                    duration: this.timeTracked
                })
                this.isTracking = false;
                clearInterval(this.intervalId); // Stop the counter
                this.intervalId = null;
                this.showTime = false;
                this.timeTracked = 0;
                this.$emit('task-stopped', this.formattedTimeTracked);
                this.showNotification("Task stopped successfully!", "success");
            } catch (error) {
                this.showNotification("Error stopping task. Please try again.", "error");
            }
        },
        startCounter() {
            this.trackingTaskName = this.taskName;
            this.intervalId = setInterval(() => {
                this.timeTracked += 1; 
            }, 1000)
        },
        showNotification(message, type) {
            this.notification.message = message;
            this.notification.type = type;

            setTimeout(() => {
                this.notification.message = "";
            }, 4000);
        },
    },
};
</script>

<style scoped>
.task-tracker {
    @apply font-sans text-center max-w-4xl min-w-[450px] mx-auto p-6 bg-blue-200 rounded-lg shadow-md flex flex-col justify-center items-center;
}

.input-container {
    @apply flex justify-center items-center w-full mt-auto mb-auto;
}

.task-input {
    @apply w-3/4 p-3 text-lg border-2 border-gray-300 rounded-md transition-colors focus:border-indigo-600 focus:outline-none;
}

.start-button,
.stop-button {
    @apply px-6 py-2 text-lg border-none rounded-md cursor-pointer transition-all;
}

.start-button {
    @apply bg-blue-500 text-white hover:bg-blue-700;
}

.stop-button {
    @apply bg-red-500 text-white hover:bg-red-600;
}

.tracking-text,
.time-tracked {
    @apply text-xl text-gray-700 mt-4;
}
.material-symbols-outlined-time {
  font-variation-settings:
  'FILL' 0,
  'wght' 600,
  'GRAD' 0,
  'opsz' 40
}
</style>



