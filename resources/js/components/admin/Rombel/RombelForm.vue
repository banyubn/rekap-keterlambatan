<template>
    <h1 class="title mb-4">Master Rombel</h1>

    <v-form 
        ref="form"
        v-model="valid"
        :validate-on-submit="true"
        lazy-validation
        @submit.prevent="submit()"
        >
                <label 
                    for="rombel"
                    class="font-weight-bold"
                    >
                    Nama Rombel :
                </label>
                <v-text-field
                    v-model="rombel.rombel"
                    placeholder="Masukkan nama rombel"
                    id="rombel" 
                    :loading="loading"
                    :counter="12"
                    :rules="[rules.required, rules.rombel.min, rules.rombel.max]"
                    @input="uppercase()"
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
        rombelUri: String,
        indexUri: String,
        formUri: String,
    },
    data() {
        return {
            loading: false,
            valid: false,
            rombel: {
                id: '',
                rombel: '',
            },
            rules: {
                required: (value) => !!value || 'Required.',
                rombel: {
                    min: (v) => v.length >= 3 || 'Min 3 characters',
                    max: (v) => v.length <= 12 || 'Max 12 characters',
                }
            }
        };
    },
    methods: {
        getDataRombel() {
            this.loading = true;

            axios.get(this.rombelUri)
            .then((response) => {
                this.loading = false;
                this.rombel = response.data.data;

                this.rombel.rombel = response.data.data.rombel;
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
                if (this.rombelUri) {
                    axios.put(`${this.formUri}/${this.rombel.id}`, {
                        rombel: this.rombel.rombel,
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
                        rombel: this.rombel.rombel,
                    })
                    .then((response) => {
                        this.loading = false;
                        window.location.href = this.indexUri;
                    })
                    .catch((error) => {
                        this.loading = false;
                    })
                }
            } else {
                this.loading = false;
                console.log('Validation Fails');
            }
        },

        uppercase() {
            this.rombel.rombel = this.rombel.rombel.toUpperCase();
        }
    },
    mounted() {
        if (this.rombelUri) {
            this.getDataRombel();
        }
    }
};
</script>