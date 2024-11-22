<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      :pagination.sync="pagination"
      :total-items="totalItems"
      :loading="loading"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-text-field
            v-model="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-toolbar>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        {
          text: 'Column 1',
          align: 'start',
          sortable: false,
          value: 'column1',
        },
        { text: 'Column 2', value: 'column2' },
        { text: 'Column 3', value: 'column3' },
      ],
      items: [],
      search: '',
      pagination: {
        sortBy: 'column1',
        descending: false,
        page: 1,
        rowsPerPage: 10,
      },
      totalItems: 0,
      loading: true,
    }
  },
  mounted() {
    this.fetchData()
  },
  watch: {
    pagination: {
      handler() {
        this.fetchData()
      },
      deep: true,
    },
    search: {
      handler() {
        this.fetchData()
      },
    },
  },
  methods: {
    fetchData() {
      this.loading = true
      const { sortBy, descending, page, rowsPerPage } = this.pagination
      const search = this.search
      const url = `api/rombel/table?sort=${sortBy}&direction=${descending ? 'desc' : 'asc'}&page=${page}&per_page=${rowsPerPage}&search=${search}`
      this.$axios.get(url)
        .then(response => {
          this.items = response.data.data
          this.totalItems = response.data.total
          this.loading = false
        })
        .catch(error => {
          console.error(error)
          this.loading = false
        })
    },
  },
}
</script>