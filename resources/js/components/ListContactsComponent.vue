<template>
    <div>
        <div v-for="contact in contacts" :key="contact.id" class="card mb-md-2">
            <div class="card-header text-primary"><h4>{{ contact.name }} </h4></div>

            <div class="card-body">
                <p class="card-text"><i class="fas fa-envelope-open mr-1"></i> {{ contact.email }} </p>
                <p class="card-text"><i class="fas fa-phone mr-1"></i>{{ contact.phone }}</p>

                <div class="d-flex align-items-start">
                        <div class="col-md-6">
                            <form action="" method="post">
                                <button type="submit" class="btn btn-primary col-12">Edit</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="post">
                                <button type="submit" class="btn btn-danger col-12">Delete</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'contacts'],
        data : function () {
            return {
                
            }
        },
        methods: {
            
        },
        mounted() {
            console.log('List Contact mounted.')
            console.log(this.contacts)
        },
    }
</script>