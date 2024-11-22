<template>
    <h1>
        Data Keterlambatan
        <span v-for="rayon in rayons">
            {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
        </span>
    </h1>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-btn v-bind="props" elevation="3" class="d-inline cursor-pointer"
                >All
                <v-icon class="ml-1 text-h5" icon="mdi-menu-down"></v-icon>
            </v-btn>
        </template>
        <v-list>
            <v-list-item
                :href="tableRecapUri"
                class="text-capitalize"
            >
                Recapitulation
            </v-list-item>
        </v-list>
    </v-menu>
    <br />
    <br />
    <v-row>
        <v-col col="6">
            <v-text-field
                v-model="search"
                variant="underlined"
                label="Cari Data Keterlambatan"
                prepend-inner-icon="mdi-magnify"
                @input="searchData()"
            >
            </v-text-field>
        </v-col>
        <v-col col="6" align="right">
            <v-btn
                color="blue"
                :loading="loading"
                elevation="3"
                @click="getDataLate()"
            >
                <v-icon color="white"> mdi-refresh </v-icon>
            </v-btn>
        </v-col>
    </v-row>
    <v-data-table-server
        v-model:items-per-page="pagination.rowsPerPage"
        v-model:page="pagination.page"
        :headers="headers"
        :items="lates"
        :items-length="totalItems"
        :item-value="name"
        @update:options="getDataLate()"
        :loading="loading"
    >
        <template
            v-for="f_header in headers"
            v-slot:[`header.${f_header.value}`]="{ column }"
        >
            {{ column.text.toUpperCase() }}
        </template>
        <template v-slot:item.action="{ item }">
            <v-btn
                color="primary"
                elevation="1"
                class="mr-2"
                :href="editUri + '/' + item.id"
            >
                <v-icon color="white"> mdi-pencil </v-icon>
            </v-btn>
            <v-btn
                color="red"
                elevation="1"
                class="mr-2"
                @click="deleteData(item.id)"
            >
                <v-icon color="white"> mdi-delete </v-icon>
            </v-btn>
        </template>
    </v-data-table-server>
</template>
<script>
let call;
import axios from "axios";

export default {
    props: {
        tableUri: String,
        tableRecapUri: String,
        rayonUri: String,
        authId: String,
    },
    data() {
        return {
            loading: false,
            headers: [
                { text: "Nama", value: "student.name" },
                { text: "Tanggal", value: "date_time_late" },
                { text: "Informasi", value: "information" },
            ],
            lates: [],
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
        getDataLate() {
            this.loading = true;

            if (this.abort) {
                this.abort.abort();
            }

            this.abort = new AbortController();
            const signal = this.abort.signal;

            axios
                .get(this.tableUri, {
                    params: {
                        student_rayon_user_id: this.authId,
                        page: this.pagination.page,
                        per_page: this.pagination.rowsPerPage,
                        search: this.search,
                    },
                    signal,
                })
                .then((response) => {
                    console.log(response.data.data.data);
                    this.loading = false;
                    this.lates = response.data.data.data;
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
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        searchData() {
            this.pagination.page = 1;

            setTimeout(this.getDataLate(), 5000);
        },

        deleteData(id) {
            axios
                .delete(`${this.deleteUri}/${id}`)
                .then((response) => {
                    this.getDataLate();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.getDataLate();
        this.getDataRayon();
    },
};
</script>
