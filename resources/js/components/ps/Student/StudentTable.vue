<template>
    <h1>
        Data Siswa
        <span v-for="rayon in rayons">
            {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
        </span>
    </h1>

    <v-row>
        <v-col col="6">
            <v-text-field
                v-model="search"
                variant="underlined"
                label="Cari Siswa"
                prepend-inner-icon="mdi-magnify"
                @input="searchData()"
            >
            </v-text-field>
        </v-col>
        <v-col col="6" align="right">
            <v-btn
                color="green"
                elevation="3"
                class="mr-2"
                href="/admin/student/create"
            >
                <v-icon color="white"> mdi-plus </v-icon>
                <span style="color: white"> Tambah Data </span>
            </v-btn>
            <v-btn
                color="blue"
                :loading="loading"
                elevation="3"
                @click="getDataStudent()"
            >
                <v-icon color="white"> mdi-refresh </v-icon>
            </v-btn>
        </v-col>
    </v-row>
    <v-data-table-server
        v-model:items-per-page="pagination.rowsPerPage"
        v-model:page="pagination.page"
        :headers="headers"
        :items="students"
        :items-length="totalItems"
        :item-value="name"
        @update:options="getDataStudent()"
        :loading="loading"
    >
        <template
            v-for="f_header in headers"
            v-slot:[`header.${f_header.value}`]="{ column }"
        >
            {{ column.text.toUpperCase() }}
        </template>
        <template v-slot:item.rombel="{ item }">
            {{ item.rombel ? item.rombel.rombel : "N/A" }}
        </template>
        <template v-slot:item.rayon="{ item }">
            {{ item.rayon ? item.rayon.rayon : "N/A" }}
        </template>
    </v-data-table-server>
</template>
<script>
let call;
import axios from "axios";

export default {
    props: {
        tableUri: String,
        rayonUri: String,
        authId: String,
    },
    data() {
        return {
            loading: false,
            headers: [
                { text: "Nis", value: "nis" },
                { text: "Nama", value: "name" },
                { text: "Rombel", value: "rombel" },
                { text: "Rayon", value: "rayon" },
            ],
            students: [],
            rayons: [],
            search: "",
            pagination: {
                page: 1,
                rowsPerPage: 10,
            },
            totalItems: 0,
            abort: null,
        };
    },
    methods: {
        getDataStudent() {
            this.loading = true;

            if (this.abort) {
                this.abort.abort();
            }

            this.abort = new AbortController();
            const signal = this.abort.signal;

            axios
                .get(this.tableUri, {
                    params: {
                        rayon_user_id: this.authId,
                        page: this.pagination.page,
                        per_page: this.pagination.rowsPerPage,
                        search: this.search,
                    },
                    signal,
                })
                .then((response) => {
                    console.log(response.data.data.data);
                    this.loading = false;
                    this.students = response.data.data.data;
                    this.totalItems = response.data.data.total;
                })
                .catch((error) => {
                    this.loading = false;
                    if (error.name === "AbortError") {
                        console.log("Request canceled:", error.message);
                    } else {
                        console.error(error);
                    }
                });
        },

        getDataRayon() {
            axios
                .get(this.rayonUri, {
                    params: {
                        user_id: this.authId,
                    },
                })
                .then((response) => {
                    this.rayons = response.data.data;
                    console.log(this.rayons);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        searchData() {
            this.pagination.page = 1;

            setTimeout(this.getDataStudent(), 5000);
        },

        deleteData(id) {
            axios
                .delete(`${this.deleteUri}/${id}`)
                .then((response) => {
                    this.getDataStudent();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.getDataStudent();
        this.getDataRayon();
    },
};
</script>
