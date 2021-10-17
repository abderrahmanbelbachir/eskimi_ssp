<template>
    <b-table
            :narrowed="true"
            paginated
            :loading="loading"
            :data="rows"
            backend-filtering
            backend-pagination
            :total="total"
            :per-page="perPage"
            @page-change="onPageChange"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
            backend-sorting
            :default-sort-direction="defaultSortOrder"
            :default-sort="[sortField, sortOrder]"
            @sort="onSort"
            custom-row-key="id"
    >

        <b-table-column field="id" label="ID" width="40" numeric sortable v-slot="props">
            {{ props.row.id }}
        </b-table-column>

        <b-table-column field="name" label="Name" width="40" sortable v-slot="props">
            {{ props.row.name }}
        </b-table-column>

        <b-table-column field="from" label="From" width="40" sortable v-slot="props">
            {{ props.row.from }}
        </b-table-column>

        <b-table-column field="to" label="To" width="40" sortable v-slot="props">
            {{ props.row.to }}
        </b-table-column>

        <b-table-column field="daily_budget" label="Daily budget" width="40" sortable v-slot="props">
            {{ props.row.daily_budget }}
        </b-table-column>

        <b-table-column field="total_budget" label="Total Budget" width="40" sortable v-slot="props">
            {{ props.row.total_budget }}
        </b-table-column>

        <b-table-column label="Creative upload" width="40" v-slot="props">
            <open-uploads :uploads="JSON.parse(props.row.uploads)"></open-uploads>
        </b-table-column>
        <b-table-column label="Action" width="40" v-slot="props">
            <a v-bind:href="`/compaign/${props.row.id}/edit`">
                <b-button :loading="loading" size="is-small" type="is-primary">
                    Edit
                </b-button>
            </a>
        </b-table-column>

    </b-table>
</template>

<script>
    export default {
        name: "CompaignList",
        mounted() {

            this.loadAsyncData()

        },
        data() {
          return {
              sortField: 'created_at',
              sortOrder: 'desc',
              defaultSortOrder: 'desc',
              loading: false,
              rows: [],
              total: 0,
              page: 1,
              perPage: 5,
          }
        },
        methods: {
            onPageChange(page) {
                this.page = page
                this.loadAsyncData()
            },
            onSort(field, order) {
                this.sortField = field
                this.sortOrder = order
                this.loadAsyncData()
            },
            loadAsyncData() {
                this.loading = true
                axios({
                    method: 'post',
                    url: `compaigns/filter?page=${this.page}&sort_by=${this.sortField}.${this.sortOrder}`,
                }).then(({data}) => {
                    this.rows = data.data;
                    this.total = data.total;
                    this.loading = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>