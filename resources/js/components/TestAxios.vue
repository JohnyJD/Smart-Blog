<template>
    <div>
        <input type="file" id="image">
        <button @click="fileUpload"></button>
    </div>

</template>

<script>
    export default {
        name: "TestAxios",
        data: function() {
            return {
                form: {
                    'image': ""
                }
            }
        },
        methods: {
            fileUpload: function() {
                this.form.image = document.getElementById("image").files[0];
                console.log(this.form.image);
                let formData = new FormData();
                formData.append('image', this.form.image);
                formData.append('id', 1);
                formData.append('hi', 100);
                //; boundary=---WebKitFormBoundary7MA4YWxkTrZu0gW
                let config = {headers: {'Content-Type' : 'multipart/form-data'}};
                axios.post('/otestuj', formData)
                    .then(success => {
                        console.log(success);
                    })
                    .catch(errors => {
                        console.log(errors.data);
                    });
            }
        }
    }
</script>

<style scoped>


</style>