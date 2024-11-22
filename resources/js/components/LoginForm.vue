<!-- resources/js/components/LoginForm.vue -->
<template>
  <v-container fluid class="d-flex align-center justify-center" style="min-height: 100vh;">
    <v-card class="elevation-12 pa-10" max-width="400">
      <v-card-title class="text-h5 text-center font-weight-bold mb-10">Rekap Keterlambatan</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="submit">
          <v-text-field 
            v-model="email" 
            label="Email" 
            type="email" 
            required 
            variant="outlined"
            :loading="loading"
            :rules="[rules.required, rules.email]" class="mb-4">
          </v-text-field>
          <v-text-field 
            v-model="password" 
            label="Password" 
            type="password" 
            required 
            variant="outlined"
            :loading="loading"
            :rules="[rules.required]" class="mb-4">
          </v-text-field>
          <v-btn 
           :loading="loading" 
           color="primary"
           type="submit" 
           class="w-100 text-white" 
           size="large">
            Login
          </v-btn>
        </v-form>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-btn>Ada kesalahan? Hubungi Kami di sini</v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios';


export default {
  data() {
    return {
      loading: false,
      email: '',
      password: '',
      rules: {
        required: (value) => !!value || 'Required.',
        email: (value) => {
          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return emailPattern.test(value) || 'Invalid e-mail format.';
        },
      },
    };
  },
  methods: {
    async submit() {
      this.loading = true;
      try {
        const response = await axios.post('login/attempt', {
          email: this.email,
          password: this.password,
        }, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (response.status === 200 && response.data.redirect_url) {
          this.loading = false;
          window.location.href = response.data.redirect_url;
        }

      } catch (error) {
        this.loading = false;
        console.error(error);
      }
    },
  },
};
</script>