<template>
    <v-app class="bg-secondary">
        <div class="container">
            <data-table></data-table>
        </div>
    </v-app>
</template>

<script>
    import dataTable from "./DataTable"

    export default {
        components: {
            dataTable
        },
    }
</script>