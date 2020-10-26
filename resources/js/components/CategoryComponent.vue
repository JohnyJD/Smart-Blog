<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div class="category-wrapper" v-for="category in categories" v-else>
            <div class="category flex">
                <router-link :to="'/category/' + category.name">
                    <h3 :id="'cat-' + category.name" @click="getCategorizedPosts(category.name)">{{ category.name }}</h3>
                </router-link>
                <p>{{category.posts_count}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CategoryComponent",
        mounted() {
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        data : function () {
            return {
                'loading' : true,
                'categories' : null,
                'posts' : null,
                'lastShowing' : null
            }
        },
        methods: {
            getCategorizedPosts : function(catName) {
                let target = event.target;
                axios.get('/api/allPosts/category/' + catName)
                    .then(response => {
                        console.log(response.data);
                        this.posts = response.data.data;
                        this.emitNewData();
                        this.toggleClass(target);
                    })
                    .catch(errors => {
                        console.log(errors.data);
                    })
            },
            emitNewData: function() {
                this.$emit("posts:category" , this.posts);
            },
            toggleClass: function(target) {
                if(this.lastShowing != null) {
                    this.lastShowing.classList.remove("isShowing");
                }
                target.classList.add("isShowing");
                this.lastShowing = target;
            }
        }
    }
</script>

<style scoped>
    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .category-wrapper {
        border-top: 1px solid rgba(112, 112, 112, 0.51);
    }
    .category-wrapper:first-child {
        border-top: none;
    }
    .category h3 {
        color: #717171;
        font-weight: normal;
        cursor: pointer;
        -webkit-transition: color .3s;
        -moz-transition: color .3s;
        -ms-transition: color .3s;
        -o-transition: color .3s;
        transition: color .3s;
    }
    .category h3:hover {
        color: #00CEFF;
    }
    .category p {
        background: #00CEFF;
        padding: 2px 15px;
        border-radius: 20px;
        color: white;
    }
    h3.isShowing {
        color: #00CEFF !important;
    }
</style>