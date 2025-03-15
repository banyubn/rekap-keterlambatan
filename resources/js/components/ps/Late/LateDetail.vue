<template>
    <v-btn
        color="secondary"
        elevation="1"
        class="mb-3"
        prepend-icon="mdi-arrow-left"
        text="Kembali"
        :href="recapUri"
    >
    </v-btn>
    <div class="mt-5">
        <span class="text-h4">
            {{ student.name }}
        </span>
        <span class="text-h6"> | {{ student.nis }} </span>
        <span class="text-h6"> | {{ student.rombel.rombel }} </span>
        <span class="text-h6"> | {{ student.rayon.rayon }} </span>
    </div>
    <v-row class="mt-4">
        <v-col
            cols="4"
            md="4"
            sm="6"
            lg="3"
            v-for="(late, index) in lates"
            :key="late.id"
        >
            <v-card :loading="loading" class="mx-auto" max-width="344">
                <v-img
                    height="200px"
                    :src="late.bukti ? bannerSrc + '/' + late.bukti : defaultBannerSrc"
                    cover
                ></v-img>

                <v-card-title> </v-card-title>

                <v-card-subtitle>
                    Keterlambatan ke-{{ index + 1 }}
                </v-card-subtitle>

                <v-card-actions>
                    <v-btn
                        color="black"
                        text="Alasan"
                        :append-icon="
                            show[late.id]
                                ? 'mdi-chevron-up'
                                : 'mdi-chevron-down'
                        "
                        @click="show[late.id] = !show[late.id]"
                    >
                    </v-btn>

                    <v-spacer></v-spacer>
                </v-card-actions>

                <v-expand-transition>
                    <div v-show="show[late.id]">
                        <v-divider></v-divider>

                        <v-card-text>
                            {{ late.information }}
                        </v-card-text>
                    </div>
                </v-expand-transition>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import axios from "axios";

export default {
    props: {
        lateUri: String,
        studentUri: String,
        recapUri: String,
        bannerSrc: String,
        defaultBannerSrc: String,
    },

    data: () => ({
        loading: false,
        show: false,
        lates: [],
        student: [],
        show: {},
    }),

    methods: {
        getDataStudent() {
            this.loading = true;

            axios
                .get(this.studentUri)
                .then((response) => {
                    this.loading = false;
                    console.log(response.data.data);
                    this.student = response.data.data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },

        getDataLate() {
            this.loading = true;

            axios
                .get(this.lateUri)
                .then((response) => {
                    this.loading = false;
                    console.log(response);
                    this.lates = response.data.data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.error(error);
                });
        },
    },

    mounted() {
        this.getDataLate();
        this.getDataStudent();
    },
};
</script>
