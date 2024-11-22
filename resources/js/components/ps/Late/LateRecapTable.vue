<template>
    <h1>
        Data Keterlambatan
        <span v-for="rayon in rayons">
            {{ rayon.rayon }}{{ rayons.length > 1 ? ", " : "" }}
        </span>
    </h1>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-btn v-bind="props" class="d-inline cursor-pointer" elevation="3"
                >Recapitulation
                <v-icon class="ml-1 text-h5" icon="mdi-menu-down"></v-icon>
            </v-btn>
        </template>
        <v-list>
            <v-list-item :href="tableAllUri" class="text-capitalize">
                All
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
                label="Cari Rombel"
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
                <v-icon color="white">mdi-refresh</v-icon>
            </v-btn>
        </v-col>
    </v-row>

    <v-data-table-server
        v-model:items-per-page="pagination.rowsPerPage"
        v-model:page="pagination.page"
        :headers="headers"
        :items="groupedLates"
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
                color="white"
                elevation="1"
                class="mr-2"
                :href="detailUri + '/' + item.student.id"
            >
                Lihat
            </v-btn>

            <v-btn
                color="darkblue"
                v-if="item.count >= 3"
                elevation="1"
                class="mr-2"
            >
                Cetak Surat Pernyataan
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
        tableAllUri: String,
        detailUri: String,
        rayonUri: String,
        authId: String,
        editUri: String,
    },
    data() {
        return {
            loading: false,
            headers: [
                { text: "NIS", value: "student.nis" },
                { text: "Nama", value: "student.name" },
                { text: "Jumlah Keterlambatan", value: "count" },
                { text: "Action", value: "action" },
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
    computed: {
        groupedLates() {
            const grouped = this.lates.reduce((acc, curr) => {
                const student = curr.student;
                if (!acc[curr.student_id]) {
                    acc[curr.student_id] = { student, count: 0 };
                }
                acc[curr.student_id].count += 1;
                return acc;
            }, {});

            console.log(
                Object.values(grouped).sort((a, b) => b.count - a.count)
            );
            return Object.values(grouped).sort((a, b) => b.count - a.count);
        },
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

            setTimeout(() => {
                this.getDataLate();
            }, 500);
        },

        deleteData(id) {
            axios
                .delete(`${this.deleteUri}/${id}`)
                .then(() => {
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

<style scoped>
/* Tambahkan style jika diperlukan */
</style>
