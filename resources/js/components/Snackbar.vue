<template>
    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      :color="color"
      location="bottom right"
      >
      {{ message }}

      <template v-slot:actions> 
        <v-btn
          color="white"
          variant="text"
          @click="snackbar = false"
          >
        &#x2715;
        </v-btn>
      </template>
    </v-snackbar>
  </template>
  
  <script>
  export default {
    props: {
      message: {
        type: String,
        default: ''
      },
      timeout: {
        type: Number,
        default: 3000
      },
      color: {
        type: String,
        default: 'success'
      },
      status: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        snackbar: this.status
      };
    },
  };
  </script>