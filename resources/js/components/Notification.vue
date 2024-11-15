<!-- components/Notification.vue -->
<template>
    <div 
      v-if="visible" 
      :class="[
        'fixed top-4 right-4 px-4 py-3 rounded-md shadow-lg transition-opacity duration-300',
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
      ]"
    >
      {{ message }}
    </div>
  </template>
  
  <script>
  export default {
    name: "Notification",
    props: {
      message: {
        type: String,
        required: true,
      },
      type: {
        type: String,
        default: "success",
      },
    },
    data() {
      return {
        visible: true,
      };
    },
    mounted() {
      setTimeout(() => {
        this.visible = false;
      }, 3000); 
    },
  };
  </script>
  
  