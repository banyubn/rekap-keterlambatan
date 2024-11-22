<template>
    <h1 class="title mb-4">Master Rayon</h1>

    <v-form
        ref="form"
        v-model="valid"
        :validate-on-submit="true"
        lazy-validation
        @submit.prevent="submit()"
    >
        <label for="rayon" class="font-weight-bold"> Nama Rayon : </label>
        <v-text-field
            v-model="rayon.rayon"
            placeholder="Masukkan nama rayon"
            id="rayon"
            :loading="loading"
            :counter="12"
            :rules="[rules.required, rules.rayon.min, rules.rayon.max]"
            required
        >
        </v-text-field>
        <label for="user_id" class="font-weight-bold">
            Pembimbing Rayon :
        </label>
        <v-autocomplete
            v-model="rayon.user_id"
            label="Pilih PJ Rayon"
            :rules="[rules.required]"
            :loading="loading"
            :items="users"
            item-title="name"
            item-value="id"
            required
        >
        </v-autocomplete>
        <v-btn
            color="secondary"
            elevation="3"
            class="mt-4 mr-2"
            prepend-icon="mdi-arrow-left"
            :href="indexUri"
        >
            <span style="color: white">Kembali</span>
        </v-btn>
        <div
            style="display: inline-block"
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
                <span style="color: white">Submit</span>
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
import axios from "axios";
import { stringifyQuery } from "vue-router";

export default {
    props: {
        rayonUri: String,
        userUri: String,
        indexUri: String,
        formUri: String,
    },
    data() {
        return {
            loading: false,
            valid: false,
            rayon: {
                id: "",
                rayon: "",
                user_id: "",
            },
            users: [],
            rules: {
                required: (value) => !!value || "Required.",
                rayon: {
                    min: (v) => v.length >= 3 || "Min 3 characters",
                    max: (v) => v.length <= 12 || "Max 12 characters",
                },
            },
        };
    },
    methods: {
        getDataRayon() {
            this.loading = true;

            axios
                .get(this.rayonUri)
                .then((response) => {
                    this.loading = false;

                    this.rayon.rayon = response.data.data.rayon;
                    this.rayon.user_id = response.data.data.user_id;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataUser() {
            this.loading = true;

            axios
                .get(this.userUri, {
                    params: {
                        role: "ps",
                    },
                })
                .then((response) => {
                    this.loading = false;

                    console.log(response);
                    this.users = response.data.data;
                })
                .catch((error) => {
                    this.loading = false;
                });
        },

        submit() {
            this.loading = true;
            this.$refs.form.validate();

            if (this.valid) {
                if (this.rayonUri) {
                    axios
                        .put(`${this.formUri}/${this.rayon.id}`, {
                            rayon: this.rayon.rayon,
                            user_id: this.rayon.user_id,
                        })
                        .then((response) => {
                            this.loading = false;
                            console.log(response);

                            window.location.href = this.indexUri;
                        })
                        .catch((error) => {
                            console.error(error);
                            this.loading = false;
                        });
                } else {
                    axios
                        .post(this.formUri, {
                            rayon: this.rayon.rayon,
                            user_id: this.rayon.user_id,
                        })
                        .then((response) => {
                            this.loading = false;
                            console.log(response);

                            window.location.href = this.indexUri;
                        })
                        .catch((error) => {
                            this.loading = false;
                            console.error(error);
                        });
                }
            } else {
                this.loading = false;
                console.log("Validation Fails");
            }
        },
    },
    mounted() {
        this.getDataUser();

        if (this.rayonUri) {
            this.getDataRayon();
        }
    },
};
</script>
