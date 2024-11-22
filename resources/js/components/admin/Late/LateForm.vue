<template>
    <h1 class="title mb-4">Master Late</h1>

    <v-form 
        ref="form"
        v-model="valid"
        :validate-on-submit="true"
        lazy-validation
        @submit.prevent="submit()"
        >
                <label 
                    for="siswa"
                    class="font-weight-bold"
                    >
                    Siswa :
                </label>
                <v-autocomplete
                    class="mb-4"
                    v-model="late.student_id"
                    id="siswa"
                    label="Pilih siswa"
                    :rules="[rules.required]"
                    :loading="loading"
                    :items="students"
                    item-title="name"
                    item-value="id"
                >
                </v-autocomplete>
        
                <label 
                    for="tanggal"
                    class="font-weight-bold"
                    >
                    Tanggal :
                </label>
                <v-text-field
                    class="mb-4"
                    v-model="late.date_time_late"
                    placeholder="Masukkan nama late"
                    id="tanggal" 
                    :loading="loading"
                    :counter="12"
                    :rules="[rules.required]"
                    type="datetime-local"
                    required
                    >
                </v-text-field>
        
                
            <label 
                for="keterangan"
                class="font-weight-bold"
                >
                Keterangan Keterlambatan :
            </label>
            <v-textarea
            class="mb-4"
            v-model="late.information"
            placeholder="Masukkan keterangan"
            id="keterangan" 
            :loading="loading"
            maxlength="255"
            :counter="255"
            :rules="[rules.required]"
            required
            >
        </v-textarea>

        <label 
            for="bukti"
            class="font-weight-bold"
            >
            Bukti :
        </label>
        <v-text-field
            class="mb-4"
            v-model="late.bukti"
            id="bukti" 
            type="file"
            :loading="loading"
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
        lateUri: String,
        studentUri: String,
        indexUri: String,
        formUri: String,
    },
    data() {
        return {
            loading: false,
            valid: false,
            late: {
                id: '',
                date_time_late: new Date().toISOString().substr(0, 16),
                information: '',
                bukti: '',
                student_id: '',
            },
            students: [],
            rules: {
                required: (value) => !!value || 'Required.',
            }
        };
    },
    methods: {
        getDataLate() {
            this.loading = true;

            axios.get(this.lateUri)
            .then((response) => {
                this.loading = false;

                this.late = response.data.data;

                this.late.student_id = response.data.data.student_id;
                this.late.date_time_late = response.data.data.date_time_late;
                this.late.information = response.data.data.information;
                this.late.bukti = response.data.data.bukti;
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

                this.students = response.data.data;
                console.log(this.students);
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
                if (this.lateUri) {
                    axios.put(this.formUri, {
                        late: this.late.late,
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
                        student_id: this.late.student_id,
                        date_time_late: this.late.date_time_late,
                        information: this.late.information,
                        bukti: this.late.bukti
                    })
                    .then((response) => {
                        this.loading = false;
                        console.log(response);
                        window.location.href = this.indexUri;
                    })
                    .catch((error) => {
                        this.loading = false;
                        console.error(error);
                    })
                }
            } else {
                this.loading = false;
                console.log('Validation Fails');
            }
        },
    },
    mounted() {
        this.getDataStudent();

        if (this.lateUri) {
            this.getDataLate();
        }
    }
};
</script>