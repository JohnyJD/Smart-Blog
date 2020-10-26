<template>
    <div>
        <h2>{{this.$route.params.name}}</h2>
        <div v-if="loading">Loading...</div>

        <div class="posts-wrap flex" v-else>
            <div class="no-posts" v-if="this.posts.length === 0">
                <p>No posts avalaible right now</p>
            </div>
            <div class="post" v-for="post in this.posts" :key="post.id">
                <PostComponent :post="post" :postPath="'/posts/'"></PostComponent>
            </div>
        </div>
    </div>
</template>

<script>
    import PostComponent from '../components/PostComponent';
    export default {
        name: "AllPostsIndex",
        components: {
            PostComponent
        },
        props: [
            'postsUpdate'
        ],
        mounted() {
            axios.get('/api/allPosts/category/' + this.$route.params.name)
                .then(response => {
                    console.log(response.data.data);
                    this.posts = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;
                });
        },
        data: function() {
            return {
                loading: true,
                posts: null
            }
        },
        watch: {
            postsUpdate: function($val) {
                this.posts = $val;
            }
        }

    }
</script>

<style scoped>
    h2 {
        color: #00CEFF;
        font-size: 2em;
        margin-top: 0;
    }
    .flex {
        display: flex;
    }
    .posts-wrap {
        flex-wrap: wrap;
    }
    .post {
        flex: 0 48%;
        margin: 0 1%;
    }
    .no-posts {
        width: 100%;
        padding: 40px 0;
    }
    .no-posts p {
        text-align: center;
        font-size: 1.5em;
        color: #717171;
    }
</style>