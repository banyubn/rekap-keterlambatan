<template>
  <v-row>
    <v-col col="6">
      <v-text-field
        v-model="search"
        variant="underlined"
        label="Cari Rombel"
        prepend-inner-icon="mdi-magnify"
        @input="searchData()">
      </v-text-field>
    </v-col>
    <v-col col="6" align="right">
      <v-btn
        color="green"
        elevation="3"
        class="mr-2"
        :href="createUri">
        <v-icon color="white">
          mdi-plus
        </v-icon>
        <span style="color: white;">Tambah Data</span>
      </v-btn>
      <v-btn
        color="blue"
        :loading="loading"
        elevation="3"
        @click="getData()">
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
    @update:options="getData()"
    :loading="loading">
    <template v-for="f_header in headers" v-slot:[`header.${f_header.value}`]="{ column }">
      {{ column.text.toUpperCase() }}
    </template>
    <template v-slot:item.action="{ item }">
      <v-btn
        color="white"
        elevation="1"
        class="mr-2"
        :href="detailUri + '/' + item.student.id">
        Lihat
      </v-btn>
      
      <v-btn
        color="darkblue"
        v-if="item.count >= 3"
        elevation="1"
        class="mr-2"
        :href="printUri + '/' + item.student.id"
        >
        Cetak Surat Pernyataan
      </v-btn>
    </template>
  </v-data-table-server>
</template>

<script>
let call;
import axios from 'axios';

export default {
  props: {
    tableUri: String,
    detailUri: String,
    createUri: String,
    deleteUri: String,
    editUri: String,
    printUri: String,
  },
  data() {
    return {
      loading: false,
      headers: [
        { text: 'NIS', value: 'student.nis' },
        { text: 'Nama', value: 'student.name' },
        { text: 'Jumlah Keterlambatan', value: 'count' },
        { text: 'Action', value: 'action' },
      ],
      lates: [],
      search: '',
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

      console.log(Object.values(grouped).sort((a, b) => b.count - a.count));
      return Object.values(grouped).sort((a, b) => b.count - a.count);
    },
  },
  methods: {
    getData() {
      this.loading = true;

      if (this.abort) {
        this.abort.abort();
      }

      this.abort = new AbortController();
      const signal = this.abort.signal;

      axios.get(this.tableUri, {
        params: {
          page: this.pagination.page,
          per_page: this.pagination.rowsPerPage,
          search: this.search,
        },
        signal,
      })
        .then(response => {
          this.loading = false;
          this.lates = response.data.data.data;
          this.totalItems = response.data.data.total;
        })
        .catch(error => {
          this.loading = false;
          if (error.name === 'AbortError') {
            console.log('Request canceled:', error.message);
          } else {
            console.error(error);
          }
        });
    },

    searchData() {
      this.pagination.page = 1;

      setTimeout(() => {
        this.getData();
      }, 500);
    },

    deleteData(id) {
      axios.delete(`${this.deleteUri}/${id}`)
        .then(() => {
          this.getData();
        })
        .catch(error => {
          console.error(error);
        });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style scoped>
/* Tambahkan style jika diperlukan */
</style>
