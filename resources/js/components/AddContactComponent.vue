<template>
    <div class="card">
        <div class="card-header"> Add Contact </div>
        <contact-form :user="this.user"  @childUpdated="updateParent"></contact-form>
    </div>
</template>

<script>
    import contactForm from "./ContactFormComponent"

    export default {
        
        mounted() {
            console.log('Component mounted.')
        },
        props: ['user'],
        data : function () {
            return {
                
            }
        },
        methods: {
            updateParent() {
                this.$emit('childUpdated')
            }
        },
        components: {
            contactForm,
        }
    }
</script>
