<template>
    <div>
        <div v-if="loading">Loading...</div>

        <div class="posts-wrap flex" v-else>
            <div class="no-posts" v-if="this.posts.length === 0">
                <p>No posts avalaible right now</p>
            </div>
            <div class="post" v-for="post in this.posts" :key="post.id">
                <PostComponent :post="post" :postPath="'/posts/'" :user="user"></PostComponent>
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
            'user'
        ],
        mounted() {
            axios.get('/api/allPosts')
                .then(response => {
                    //console.log(response.data.data);
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
        }

    }
</script>

<style scoped>
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
    @media only screen and (max-width: 630px) {
        .post {
            flex: 0 100%;
            margin: 0;
        }
    }
</style>