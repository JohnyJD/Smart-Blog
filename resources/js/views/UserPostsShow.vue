<template>
    <div v-if="loading">
        <p>Loading...</p>
    </div>
    <div v-else>
        <div v-if="forbidden">
            <p>Server responded with status 403</p>
            <p>Forbidden action</p>
            <p>This post belongs to other user</p>
        </div>
        <div v-else>
            <div v-if="!post">
                <p>Post not found</p>
            </div>
            <div v-else>

                <div class="post-wrapper">
                    <div class="post-management flex">
                        <router-link :to="'/myPosts/' + post.post_id + '/edit'">
                            <button class="edit">Edit</button>
                        </router-link>
                        <div class="delete-wrapper">
                            <button class="delete" @click="modal = !modal">Delete</button>
                            <div class="delete-confirmation" v-if="modal">
                                <p>Are you sure to delete post?</p>
                                <div class="button-group flex">
                                    <button class="cancel" @click="modal = !modal">Cancel</button>
                                    <button class="delete" @click="deletePost">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-image">
                        <img :src="'/storage/' + post.slug_image" alt="Post image">
                    </div>

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

                    <form @submit.prevent="addComment()">
                        <TextareaComponent name="text"
                                           label="Comment"
                                           placeholder="Add comment"
                                           @update:field="form.text = $event"
                                           :errors="this.errors"/>
                        <button role="submit">Add comment</button>
                    </form>

                    <div v-if="this.comments.length === 0">
                        <p class="text-color-light-gray">No comments avalaible</p>
                    </div>

                    <div v-else>
                        <div class="comment" v-for="comment in comments">

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
    </div>
</template>

<script>
    import TextareaComponent from "../components/TextareaComponent";

    export default {
        name: "PostsShow",
        props: [
          'user'
        ],
        components: {
            TextareaComponent
        },
        mounted() {
            axios.get('/api/posts/' + this.$route.params.id)
                .then(response => {
                    this.post = response.data.data;
                    this.form.post_id = this.post.post_id;
                    this.comments = this.post.comments;
                    this.loading = false;
                })
                .catch(error => {
                    if(error.response.status === 403) {
                        this.forbidden = true;
                    }
                    this.loading = false;
                });
        },
        data: function() {
            return {
                'loading': true,
                'forbidden': false,
                'post': null,
                'comments' : '',
                'errors' : null,
                'modal': false,
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
            deletePost: function() {
                axios.delete('/api/posts/' + this.$route.params.id)
                    .then(response => {
                        console.log(response.data);
                        this.$router.push('/myPosts');
                    })
                    .catch(errors => {
                        console.log(errors);
                        alert('Internal error. Unable to delete post.')
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


    .post-management {
        justify-content: flex-end;
        margin: 10px 0;
    }
    button.delete, button.edit {
        border: none;
        outline: none;
        padding: 5px 15px;
        font-size: 1em;
        color: white;
        font-weight: bold;
        margin-left: 10px;
        cursor: pointer;
    }
    button.delete {
        background: rgba(255, 0, 0, 0.6);
        border: 2px solid rgba(255, 0, 0, 1);
        border-radius: 3px;
    }
    button.edit {
        background: rgba(0, 128, 0, 0.6);
        border: 2px solid rgba(0, 128, 0, 1);
        border-radius: 3px;
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
        cursor: pointer;
    }
    .delete-wrapper {
        position: relative;
    }
    .delete-confirmation {
        position: absolute;
        background: rgba(0, 206, 255, 0.95);
        width: 200px;
        border-radius: 3px;
        top: calc(100% + 5px);
        right: 0;
        padding: 10px 30px;
        color: white;
    }
    .delete-confirmation .button-group {
        justify-content: center;
    }
    .delete-confirmation button.delete {
        background: rgba(255, 0, 0, 1);
    }
    button.cancel {
        background: rgb(255, 255, 255);
        border: 2px solid rgb(255, 255, 255);
        border-radius: 3px;
        outline: none;
        padding: 5px 15px;
        font-size: 1em;
        color: black;
        font-weight: bold;
        margin-left: 10px;
        cursor: pointer;
    }
    .my_comment {
        color: #01a6ff;
    }
</style>