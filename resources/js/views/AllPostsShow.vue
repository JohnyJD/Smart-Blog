<template>
    <div v-if="loading">
        <p>Loading...</p>
    </div>
    <div v-else>
        <div v-if="!post">
            <p>Post not found</p>
        </div>
        <div v-else>
            <div class="post-wrapper">
                <div class="main-image">
                    <img :src="'/storage/' + post.slug_image" alt="Post image">
                </div>
                <RatingComponent :user="this.user" :post="this.post" />
                <div class="post-title">
                    <h2>{{ post.title }}</h2>
                </div>
                
                <div class="post-info flex">
                    <div class="info-1 flex blue-color">
                        <p>by {{ post.user.name }}</p>
                        <p>{{ post.created_at }}</p>
                    </div>
                    <div class="info-2 flex text-color-light-gray">
                        <p v-for="category in post.categories">{{ category.name }}</p>
                    </div>
                </div>
                

                <div class="main-text text-color-light-gray">
                    <p v-html="post.text"></p>
                </div>
            </div>

            

            <div class="comments-wrapper">

                <div class="comments-count blue-color">
                    <p v-if="this.comments.length === 0 || this.comments.length > 1">{{ this.comments.length }} comments</p>
                    <p v-else>{{ this.comments.length }} comment</p>
                </div>

                <div v-if="this.user">
                    <form @submit.prevent="addComment()">
                        <TextareaComponent name="text"
                                           label="Comment"
                                           placeholder="Add comment"
                                           @update:field="form.text = $event"
                                           :errors="this.errors"/>
                        <button role="submit">Add comment</button>
                    </form>
                </div>

                <div class="no-comments" v-if="this.comments.length === 0">
                    <p class="text-color-light-gray">No comments avalaible</p>
                </div>

                <div v-else>
                    <div class="comment" v-for="comment in this.comments">

                        <div class="comment-info flex">
                            <p class="text-color-light-gray" :class="myComment(comment.user.name)">{{ showUsersName(comment.user.name) }}</p>
                            <p class="blue-color">{{ comment.created_at }}</p>
                        </div>

                        <div class="comment-text text-color-light-gray">
                            {{ comment.text }}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import TextareaComponent from "../components/TextareaComponent";
    import RatingComponent from "../components/RatingComponent";

    export default {
        name: "AllPostsShow",
        components: {
            TextareaComponent, RatingComponent
        },
        props: [
            'user'
        ],
        mounted() {
            axios.get('/api/allPosts/' + this.$route.params.id)
                .then(response => {
                    this.post = response.data.data;
                    this.form.post_id = this.post.post_id;
                    this.comments = this.post.comments;
                    this.loading = false;
                })
                .catch(error => {
                   this.loading = false;
                });
        },
        data: function() {
            return {
                'loading' : true,
                'post' : null,
                'comments' : '',
                'errors' : null,
                form : {
                    'text': '',
                    'post_id': 0,
                }
            }
        },
        methods: {
            addComment : function () {
                let formData = new FormData();
                formData.append('text', this.form.text);
                formData.append('post_id', this.form.post_id);
                formData.append('api_token', this.user.api_token);
                axios.post('/api/comments' , formData)
                    .then(response => {
                        axios.get('/api/posts/comments/' + this.post.post_id)
                            .then(response => {
                                this.comments = response.data;
                            })
                            .catch(errors => {
                               console.log(errors);
                            });
                        console.log(response);
                    })
                    .catch(errors => {
                         this.errors = errors.response.data.errors;
                    });
            },
            showUsersName(name) {
                if(this.user != null && this.user.name === name) {
                  return name + " (Me)";
                }
                return name;
            },
            myComment(name) {
                return {
                    'my_comment' : this.user != null && this.user.name === name
                }
            },
            addRating(rating) {
                //console.log(this.user);
                let formData = new FormData();
                formData.append('rating', rating);
                formData.append('api_token', this.user.api_token);
                axios.get('/api/user/' + this.user.id + '/post/'+ this.post.post_id +'/rating' , formData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(errors => {
                         this.errors = errors.response.data.errors;
                    });
            }

        }
    }
</script>

<style scoped>
    .flex {
        display: flex;
    }
    .blue-color {
        color: #00CEFF;
    }
    .text-color-light-gray {
        color: #707070;
    }

    .post-wrapper, .comments-wrapper {
        width: 90%;
        margin: auto;
    }
    .main-image img {
        width: 100%;
        height: auto;
    }
    .post-title h2 {
        color: #464646;
        margin: 30px 0px 0px 0;
        font-size: 2.2em;
    }
    .post-info {
        justify-content: space-between;
        border-bottom: 2px solid #D3D3D3;
    }
    .post-info p {
        padding-top: 20px;
        padding-bottom: 10px;
        margin:0;
        font-size: 0.9em;
    }
    .info-1 p {
        padding-right: 20px;
    }
    .info-2 p {
        padding-left: 20px;
    }

    .comments-wrapper {
        margin-top: 30px;
    }
    .comments-count {
        border-bottom: 2px solid #D3D3D3;
        padding: 10px 0;
    }
    .comments-count p {
        font-weight: bold;
        font-size: 1.5em;
        margin: 0;
    }
    .comment-info {
        align-items: center;
    }
    .comment-info p {
        padding-right: 20px;
        margin: 5px 0 5px 0;
        font-size: 0.9em;
    }
    .comment-info p:first-of-type {
        font-weight: bold;
        font-size: 1.3em;
    }

    .comment {
        border-top: 1px solid #D8D8D8;
        padding: 20px 0;
    }
    .comment:first-child {
        border-top: none;
        padding: 20px 0;
    }

    form {
        margin: 10px 0;
    }

    form button {
        background: #00CEFF;
        color: white;
        font-weight: bold;
        border: none;
        outline: none;
        padding: 5px 15px;
        font-size: 1em;
    }
    .my_comment {
        color: #01a6ff;
    }
    .no-comments {
        text-align: center;
        font-size: 1.1em;
        margin: 50px 0;
    }

</style>