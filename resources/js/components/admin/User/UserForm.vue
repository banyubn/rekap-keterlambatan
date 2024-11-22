<template>
    <h1 class="title mb-4">Master User</h1>

    <v-form 
        ref="form"
        v-model="valid"
        :validate-on-submit="true"
        lazy-validation
        @submit.prevent="submit()"
        >
        <label 
            for="name"
            class="font-weight-bold"
            >
            Nama :
        </label>
        <v-text-field 
            v-model="user.name"
            placeholder="Masukkan nama user" 
            id="name" 
            :counter="64"
            :loading="loading"
            :rules="[rules.required, rules.name.min, rules.name.max]"
            required
            >
        </v-text-field>

        <label 
            for="email"
            class="font-weight-bold"
            >
            Email :
        </label>
        <v-text-field 
            v-model="user.email"
            placeholder="Masukkan email user" 
            id="email" 
            :loading="loading"
            :rules="[rules.required, rules.email]"
            required
            >
        </v-text-field>
        
        <label 
            for="role"
            class="font-weight-bold"
            >
            Role :
        </label>
        <v-select
            v-model="user.role"
            :items="['admin', 'ps']"
            id="role"
            :loading="loading"
            :rules="[rules.required]"
            label="Pilih Role"
        >

        </v-select>

        <label 
            for="password"
            class="font-weight-bold"
            >
            Password :
        </label>
        <v-text-field 
            v-model="user.password"
            placeholder="Masukkan password user" 
            id="password" 
            :loading="loading"
            :rules="[rules.required]"
            required
            >
        </v-text-field>

        <v-btn
            color="secondary"
            elevation="3"
            class="mt-4 mr-2"
            prepend-icon="mdi-arrow-left"
            :href="indexUri"
            >
            
            <span style="color: white;">Kembali</span>
        </v-btn>
            <div
                style="display: inline-block;"
                @mouseover="showTooltip = true"
                @mouseout="showTooltip = false"
            >
                <v-btn
                    color="primary"
                    elevation="3"
                    type="submit"
                    class="mt-4"
                    :disabled="!valid || loading"
                    :loading="loading"
                >
                    <span style="color: white;">Submit</span>
                </v-btn>
                <v-tooltip
                    v-if="!valid"
                    content-class="bg-red"
                    activator="parent"
                    location="bottom end"
                    manual
                    :value="showTooltip"
                >
                    Tolong isi kolom - kolom di atas dengan benar sebelum submit!
                </v-tooltip>
            </div>
    </v-form>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        formUri: String,
        userUri: String,
        indexUri: String,
    },
    data() {
        return {
            loading: false,
            valid: false,
            user: {
                id: '',
                name: '',
                email: '',
                role: '',
                password: '',
            },
            rombels: [],
            rayons: [],
            rules: {
                required: (value) => !!value || 'Required.',
                email: (value) => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return pattern.test(value) || 'Invalid e-mail.';
                },
                name: {
                    min: (v) => v.length >= 3 || 'Min 3 characters',
                    max: (v) => v.length <= 64 || 'Max 64 characters',
                }
            }
        };
    },
    methods: {
        getDataUser() {
            this.loading = true;

            axios.get(this.userUri)
            .then((response) => {
                this.loading = false;
                this.user = response.data.data;
                console.log(this.user);

                this.user.name = response.data.data.name;
                this.user.email = response.data.data.email;
                this.user.role = response.data.data.role;
                this.user.password = response.data.data.password;
            })
            .catch((error) => {
                this.loading = false;
                console.error(error);
            });
        },

        submit() {
            this.loading = true;
            this.$refs.form.validate();
      
            if (this.valid) {
                if (this.userUri) {
                    axios.put(`${this.formUri}`, {
                        name: this.user.name,
                        email: this.user.email,
                        role: this.user.role,
                        password: this.user.password
                    })
                    .then((response) => {   
                        this.loading = false;
                        window.location.href = this.indexUri;
                    })
                    .catch((error) => {
                        console.error(error);
                        this.loading = false;
                    })
                } else {
                    axios.post(this.formUri, {
                        name: this.user.name,
                        email: this.user.email,
                        role: this.user.role,
                        password: this.user.password
                    })
                    .then((response) => {
                        this.loading = false;
                        window.location.href = this.indexUri
                    })
                    .catch((error) => {
                        this.loading = false;
                    })
                }
            } else {
                this.loading = false;
                console.log('Validation Fails');
            }
        }
    },
    mounted() {
        if (this.userUri) {
            this.getDataUser();
        }
    }
};
</script>