<template>
    <h1>Dashboard Admin</h1>
    <br>
    <br>
    <v-row>
        <v-col cols="6">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon>mdi-account-group-outline</v-icon>

                    Peserta Didik
                </v-card-title>
                <v-card-text class="text-h5 font-weight-bold">{{ student }}</v-card-text>
            </v-card>
        </v-col>

        <v-col cols="3">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon class="mr-1">mdi-account-circle-outline</v-icon>
                    Administrator</v-card-title
                >
                <v-card-text class="text-h5 font-weight-bold">{{ admin }}</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="3">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon class="mr-1">mdi-account-circle-outline</v-icon>
                    Pembimbing Siswa</v-card-title
                >
                <v-card-text class="text-h5 font-weight-bold">{{ ps }}</v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="6">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon class="mr-1">mdi-book-account-outline</v-icon>

                    Rombel</v-card-title
                >
                <v-card-text class="text-h5 font-weight-bold">{{ rombel }}</v-card-text>
            </v-card>
        </v-col>

        <v-col cols="6">
            <v-skeleton-loader type="list-item-two-line" v-if="loading">
            </v-skeleton-loader>
            <v-card :loading="loading" v-else>
                <v-card-title>
                    <v-icon class="mr-1">mdi-book-account-outline</v-icon>
                    Rayon</v-card-title
                >
                <v-card-text class="text-h5 font-weight-bold">{{ rayon }}</v-card-text>
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
        userUri: String,
    },
    data() {
        return {
            student: 0,
            rombel: 0,
            rayon: 0,
            ps: 0,
            admin: 0,
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            values: [40, 30, 20, 100, 20, 30, 50],
            loading: false,
        };
    },
    methods: {
        getDataStudent() {
            this.loading = true;
            axios
                .get(this.studentUri)
                .then((response) => {
                    this.loading = false;
                    this.student = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },
        getDataRombel() {
            this.loading = true;
            axios
                .get(this.rombelUri)
                .then((response) => {
                    this.loading = false;
                    this.rombel = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataRayon() {
            this.loading = true;
            axios
                .get(this.rayonUri)
                .then((response) => {
                    this.loading = false;
                    this.rayon = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },
        getDataAdmin(){
            this.loading = true;
            axios
                .get(this.userUri, {
                    params: {
                        role: "admin",
                    },
                })
                .then((response) => {
                    this.loading = false;
                    this.admin = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataPs(){
            this.loading = true;
            axios
                .get(this.userUri, {
                    params: {
                        role: "ps",
                    },
                })
                .then((response) => {
                    this.loading = false;
                    this.ps = response.data.data.length;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        }
    },

    mounted() {
        this.getDataStudent();
        this.getDataRombel();
        this.getDataRayon();
        this.getDataAdmin();
        this.getDataPs();
    },
};
</script>
