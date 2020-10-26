<template>
    <div>
        <h2>My posts</h2>
        <div v-if="loading">Loading...</div>

        <div class="posts-wrap flex" v-else>
            <div class="no-posts" v-if="myPosts.length === 0">
                <p>No posts avalaible right now</p>
            </div>
            <div class="post" v-for="post in myPosts">
                <PostComponent :post="post" :postPath="'/myPosts/'"></PostComponent>
            </div>
        </div>
    </div>
</template>

<script>
    import PostComponent from "../components/PostComponent";

    export default {
        name: "UserPostsIndex",
        props: [
            'user'
        ],
        data: function () {
            return {
                'myPosts': null,
                'loading': true
            }
        },
        components: {
            PostComponent
        },
        mounted() {
            axios.get('/api/posts')
                .then(response => {
                   this.myPosts = response.data.data;
                   this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },
        /*created() {
            window.axios.interceptors.request.use(
                (config) => {
                    if(config.method === 'get') {
                        if(!config.url.includes('api_token')) {
                            config.url = config.url + '?api_token=' + this.user.api_token;
                        }
                    }
                    else {
                        console.log(config.data);
                        if(config.data.api_token === undefined) {
                            config.data = {
                                ...config.data,
                                api_token: this.user.api_token
                            }
                        }
                    }
                    return config;
                }
            )
        }*/

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
    @media only screen and (max-width: 630px) {
        .post {
            flex: 0 100%;
            margin: 0;
        }
    }
</style>