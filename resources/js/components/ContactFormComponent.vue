<template>
    <div class="card-body">
        
        <div v-if="success" class="alert alert-success" role="alert">
            Success
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-6">
                <input id="name" type="text" v-model="contact.name" class="form-control" name="name" required autocomplete="name" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-6">
                <input id="email" type="text" v-model="contact.email" class="form-control" name="email" required autocomplete="email" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Phone</label>
            <div class="col-md-6">
                <input id="phone" type="number" v-model="contact.phone" class="form-control" name="phone" required autocomplete="phone" autofocus>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-3">
                <button type="submit" class="btn btn-primary col-md-12" @click="addContact()">
                    Add Contact
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['user'],
        data : function () {
            return {
                contact: {
                    name : '',
                    email: '',
                    phone: ''
                },
                success: false,
            }
        },
        methods: {
            addContact() {
                axios.post('api/home/store', {
                    contact: this.contact,
                    user: this.user
                })
                .then(response => {
                    if ( response.status == 201 ){
                        this.success = true;
                        this.contact = {
                            name : '',
                            email: '',
                            phone: ''
                        };
                    } 
                    else 
                    {
                        this.success = false;
                    }
                    this.$emit('childUpdated')
                })
                .catch(error => {
                    this.success = false;
                });
            },
        },
        mounted() {
            console.log("Contact Form Mounted")
            console.log(this.user)
        }
    }
</script>