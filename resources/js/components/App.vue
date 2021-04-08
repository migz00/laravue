<template>
    <v-app>
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
        props: ['user'],
        data : function () {
            return {
                contacts: []
            }
        },
        methods: {
            getContact() {
                // axios.get('api/home/'+this.user.id)
                // .then(response => {
                //     this.contacts = response.data
                //     console.log(this.contacts)
                // })
                // .catch(error => {
                // });
            },
            updateParent() {
                this.getContact()
            }
        },
        created() {
            this.getContact()
        }
    }
</script>