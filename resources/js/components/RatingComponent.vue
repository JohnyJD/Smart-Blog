<template>
    <div id="rating">
        <div class="rating-wrap">
            <h2>Rating</h2>
            <button v-if="this.user" :class="{ 'disabled' : this.typeOfRating === 1}" @click="changeRating(true)">+</button>
            <p class="rating-number" :class="{ 'bad-rating' : this.rating < 0}">{{ this.rating }}</p>
            <button v-if="this.user" :class="{ 'disabled' : this.typeOfRating === -1}" @click="changeRating(false)">-</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Rating component',
    props: [
        'user',
        'post'
    ],
    data: function() {
        return {
            'typeOfRating': null,
            'rating' : 0
        }
    },
    mounted: function() {
        if(this.user) {
            this.getRating();
        }   
        this.rating = this.post.rating;
        console.log(this.post);
        
    },
    methods: {
        changeRating(rateUp) {
            let rating = rateUp ? 1 : -1;
            let formData = new FormData();
            formData.append('post_id', this.post.post_id);
            formData.append('rating', rating);
            formData.append('api_token', this.user.api_token);
            axios.post('/api/user/post/rating' , formData)
                .then(response => {
                    console.log(response.data);
                    this.rating = response.data.rating;
                    this.typeOfRating += rating;
                    console.log('User changed rating of a post');
                })
                .catch(err => {
                    console.log(err);
                });

        },
        getRating() {
            axios.get('/api/user/' + this.user.id + '/post/'+ this.post.post_id +'/rating')
                .then(response => {
                    console.log(response.data);
                    this.typeOfRating = response.data;
                })
                .catch(errors => {
                        this.errors = errors.response.data.errors;
                });
        }
    }
}
</script>

<style scoped>
.rating-wrap {
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-end;
}
.rating-wrap h2 {
    font-size: 0.8em;
    padding: 0;
    margin-right: 15px;
    
}
.rating-wrap button {
    width: 20px;
    font-size: 1.5em;
    background: none;
    outline: none;
    color: black;
    padding: 0 !important;
    border: none;
    cursor: pointer;
}
.rating-wrap button.disabled {
    color: rgb(199, 199, 199);
    cursor: default;
}
.rating-number {
    font-size: 1.5em;
    font-weight: bold;
    padding: 0 10px;
    color: green;
    margin: 0;
}
.rating-number.bad-rating {
    color: red;
}

</style>