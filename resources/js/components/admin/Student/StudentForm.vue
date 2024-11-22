<template>
    <h1 class="title mb-4">Master Siswa</h1>

    <v-form 
        ref="form"
        v-model="valid"
        :validate-on-submit="true"
        lazy-validation
        @submit.prevent="submit()"
        >
        <v-row>
            <v-col cols="3">
                <label 
                    for="nis"
                    class="font-weight-bold"
                    >
                    NIS :
                </label>
                <v-text-field
                    v-model="student.nis"
                    placeholder="Masukkan NIS siswa"
                    type="number"
                    id="nis" 
                    :loading="loading"
                    :rules="[rules.required, rules.nis.min, rules.nis.max, rules.nis.numeric]"
                    required
                    >
                </v-text-field>
            </v-col>

            <v-col cols="9">
                <label 
                    for="name"
                    class="font-weight-bold"
                    >
                    Nama Siswa :
                </label>
                <v-text-field 
                    v-model="student.name"
                    placeholder="Masukkan nama siswa" 
                    id="name" 
                    :loading="loading"
                    :rules="[rules.required, rules.name.min, rules.name.max, rules.name.letter]"
                    required
                    >
                </v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="6">
                <label 
                    for="rombel_id"
                    class="font-weight-bold"
                    >
                    Rombel :
                </label>
                <v-autocomplete
                    v-model="student.rombel_id"
                    label="Pilih Rombel"
                    :rules="[rules.required]"
                    :loading="loading"
                    :items="rombels"
                    item-title="rombel"
                    item-value="id"
                    required
                    >
                </v-autocomplete>
            </v-col>
            <v-col cols="6">
                <label 
                    for="rayon_id"
                    class="font-weight-bold"
                    >
                    Rayon :
                </label>
                <v-autocomplete
                    v-model="student.rayon_id"
                    label="Pilih Rayon"
                    :rules="[rules.required]"
                    :loading="loading"
                    :items="rayons"
                    item-title="rayon"
                    item-value="id"
                    required
                    >
                </v-autocomplete>
            </v-col>
        </v-row>
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
        studentUri: String,
        formUri: String,
        indexUri: String,
        rombelUri: String,
        rayonUri: String
    },
    data() {
        return {
            loading: false,
            valid: false,
            student: {
                id: '',
                nis: '',
                name: '',
                rombel_id: '',
                rayon_id: '',
            },
            rombels: [],
            rayons: [],
            rules: {
                required: (value) => !!value || 'Required.',
                nis: {
                    min: (value) => value.length >= 8 || 'Must be at least 8 digits.',
                    max: (value) => value.length <= 10 || 'Max 10 digits.',
                    numeric: (value) => /^\d+$/.test(value) || 'Must be a number.',
                },
                name: {
                    min: (value) => value.length >= 3 || 'Min 3 characters.',
                    max: (value) => value.length <= 64 || 'Max 64 characters.',
                    letter: (value) => /^[a-zA-Z\s]+$/.test(value) || 'Must be a letter.',
                },
            }
        };
    },
    methods: {
        getDataRombel() {
            this.loading = true;

            axios.get(this.rombelUri)
            .then((response) => {
                this.loading = false;
                this.rombels = response.data.data;
            })
            .catch((error) => {
                this.loading = false;
                console.error(error);
            });
        },

        getDataRayon() {
            this.loading = true;

            axios.get(this.rayonUri)
            .then((response) => {
                this.loading = false;
                this.rayons = response.data.data;
            })
            .catch((error) => {
                this.loading = false;
                console.error(error);
            });
        },

        getDataStudent() {
            this.loading = true;

            axios.get(this.studentUri)
            .then((response) => {
                this.loading = false;
                this.student = response.data.data;
                console.log(this.student);

                this.student.nis = response.data.data.nis;
                this.student.name = response.data.data.name;
                this.student.rombel_id = response.data.data.rombel_id;
                this.student.rayon_id = response.data.data.rayon_id;
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
                if (this.studentUri) {
                    axios.put(`${this.formUri}/${this.student.id}`, {
                        nis: this.student.nis,
                        name: this.student.name,
                        rombel_id: this.student.rombel_id,
                        rayon_id: this.student.rayon_id
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
                        nis: this.student.nis,
                        name: this.student.name,
                        rombel_id: this.student.rombel_id,
                        rayon_id: this.student.rayon_id
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
        }
    },
    mounted() {
        this.getDataRombel();
        this.getDataRayon();

        if (this.studentUri) {
            this.getDataStudent();
        }
    }
};
</script>