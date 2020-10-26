<template>
    <div v-if="loading">
        <p>Loading ...</p>
    </div>
    <div class="post-edit" v-else>
        <h2>Editing post</h2>
        <form @submit.prevent="editPost">
            <InputField name="title" label="Title" placeholder="Add title" type="text" @update:field="form.title = $event" :errors="this.errors" :initial_value="post.title"/>
            <TextareaComponent name="slug" label="Slug text" placeholder="Add slug text" @update:field="form.slug = $event" :errors="this.errors" :initial_value="post.slug"/>
            <InputField name="slug_image" label="Slug image" placeholder="" type="file" @update:field="form.slug_image = $event" :errors="this.errors" initial_value=""/>
            <div v-for="category in this.categories_count">
                <InputField  name="categories[]" :label="'Category' + category" placeholder="Add category" type="text" @update:field="form.categories[category-1] = $event" :errors="errors" :initial_value="appendCategoryName(category-1)"/>
            </div>
            <div class="add-category-button" @click="addCategoryField">Add category</div>
            <label for="text">Text</label>
            <vue-ckeditor
                    id="text"
                    name="text"
                    :config="config"
                    :value="post.text"
                    v-model="form.text"
            />
            <button role="submit">Edit post</button>
        </form>
    </div>
</template>

<script>
    import VueCkeditor from 'vue-ckeditor2';
    import InputField from "../components/InputField";
    import TextareaComponent from "../components/TextareaComponent";

    export default {
        name: "UserPostsEdit",
        components: { VueCkeditor, InputField, TextareaComponent },
        props: [
            'user'
        ],
        data: function() {
            return {
                form: {
                    'title': '',
                    'slug' : '',
                    'slug_image' : '',
                    'text' : '',
                    'categories' : [],
                },
                'post' : null,
                'loading' : true,
                'errors' : null,
                'categories_count' : ''
                ,config: {
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },

                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                        { name: 'about', items: [ 'About' ] }
                    ],
                    height: 300
                }
            }
        },
        mounted() {
            axios.get('/api/posts/' + this.$route.params.id )
                .then(response => {
                    this.post = response.data.data;
                    this.categories_count = this.post.categories.length;

                    this.form.title = this.post.title;
                    this.form.slug = this.post.slug;
                    this.form.text = this.post.text;
                    for(let i = 0; i < this.post.categories.length; i++) {
                        this.form.categories[i] = this.post.categories[i].name;
                    }

                    this.loading = false;
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                    this.loading = false;
                });
        },
        methods: {
            addCategoryField: function(e) {
                e.preventDefault();
                this.categories_count++;
                this.form.categories[this.categories_count-1] = '';
            },
            appendCategoryName: function(id) {
                if(this.post.categories[id] === undefined) {
                    return '';
                }
                return this.post.categories[id].name;
            },
            editPost: function() {
                let formData = new FormData();
                formData.append('title', this.form.title);
                formData.append('slug', this.form.slug);
                formData.append('slug_image', this.form.slug_image);
                formData.append('text', this.form.text);
                console.log(this.form.categories);
                this.form.categories.forEach(category => formData.append('categories[]', category));
                formData.append('api_token', this.user.api_token);
                formData.append('_method', 'patch');
                console.log(this.form);
                axios({
                    method : 'post',
                    url: '/api/posts/' + this.post.post_id,
                    data: formData,
                    headers: {'Content-Type' : 'multipart/form-data'}
                })
                    .then(response => {
                        if(response.status === 200) {
                            this.$router.push("/myPosts");
                        }
                        console.log(response);
                    })
                    .catch(errors => {
                        console.log(errors.response);
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>
    h2 {
        font-size: 2.5em;
        color: #00CEFF;
        margin-top: 0;
    }
    label {
        display: block;
        color: #00CEFF;
        font-weight: bold;
        font-size: 1.3em;
    }
    button,.add-category-button {
        background: #00CEFF;
        color: white;
        font-weight: bold;
        font-size: 1em;
        width: fit-content;
        padding: 5px 10px;
        margin: 5px 0;
        cursor: pointer;

        -webkit-transition: background .3s;
        -moz-transition: background .3s;
        -ms-transition: background .3s;
        -o-transition: background .3s;
        transition: background .3s;
        border: none;
        font-family: Nunito;
    }
    button:hover, .add-category-button:hover {
        background: #0081ff;
    }
</style>