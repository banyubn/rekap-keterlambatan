<template>
    <h1>
        Dashboard PS (
        <span v-for="rayon in rayons">
            {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
        </span>
        )
    </h1>
    <br />
    <br />
    <v-row>
        <v-col cols="6">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon>mdi-account-group-outline</v-icon>

                    Peserta Didik Rayon
                    <span v-for="rayon in rayons">
                        {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
                    </span>
                </v-card-title>
                <v-card-text class="text-h5 font-weight-bold">{{
                    student
                }}</v-card-text>
            </v-card>
        </v-col>

        <v-col cols="6">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon class="mr-1">mdi-account-circle-outline</v-icon>
                    Keterlambatan Rayon
                    <span v-for="rayon in rayons">
                        {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
                    </span>
                </v-card-title>
                <v-card-text class="text-h5 font-weight-bold">
                    {{ late }}
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <v-row class="mt-4">
        <v-col cols="12">
            <v-skeleton-loader type="card" v-if="loading">
            </v-skeleton-loader>
            <v-card
                v-else
                class="mx-auto text-center"
                color="primary"
                :loading="loading"
            >
                <v-card-title>
                    <div class="text-white text-start">
                        Keterlambatan 7 Hari Terakhir
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-sheet color="rgba(0, 0, 0, .12)">
                        <v-sparkline
                            :labels="labels"
                            :model-value="values"
                            line-width="1"
                            :padding="8"
                            :smooth="false"
                            color="rgba(255, 255, 255, .7)"
                            height="40"
                            padding="24"
                            stroke-linecap="round"
                            smooth
                        >
                            <template v-slot:label="item">
                                {{ item.value }}
                            </template>
                        </v-sparkline>
                    </v-sheet>
                </v-card-text>

                <v-divider></v-divider>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import axios from "axios";

export default {
    props: {
        studentUri: String,
        rombelUri: String,
        rayonUri: String,
        lateUri: String,
        userUri: String,
        authId: String,
    },
    data() {
        return {
            student: 0,
            late: 0,
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            rayons: [],
            values: [40, 30, 20, 100, 20, 30, 50],
            loading: false,
        };
    },
    methods: {
        getDataStudent() {
            this.loading = true;
            axios
                .get(this.studentUri, {
                    params: {
                        rayon_user_id: this.authId,
                    },
                })
                .then((response) => {
                    this.loading = false;
                    console.log(response);
                    this.student = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataRayon() {
            this.loading = true;
            axios
                .get(this.rayonUri, {
                    params: {
                        user_id: this.authId,
                    },
                })
                .then((response) => {
                    this.loading = false;
                    this.rayons = response.data.data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataLate() {
            this.loading = true;
            axios
                .get(this.lateUri, {
                    params: {
                        student_rayon_user_id: this.authId,
                    },
                })
                .then((response) => {
                    this.loading = false;
                    this.late = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },
    },

    mounted() {
        this.getDataStudent();
        this.getDataRayon();
        this.getDataLate();
    },
};
</script>
