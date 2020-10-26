<template>
    
</template>

<script>
    export default {
        name: "Logout",
        mounted() {
            axios.post('/logout')
                .finally(err => {
                    window.location = '/';
                });
        }
    }
</script>

<style scoped>

</style>