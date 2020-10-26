<template>
    <div class="post-create">
        <h2>Adding post</h2>
        <form @submit.prevent="addPost" action="/api/posts" method="POST" enctype="multipart/form-data">
            <InputField name="title" label="Title" placeholder="Add title" type="text" @update:field="form.title = $event" :errors="this.errors" initial_value=""/>
            <TextareaComponent name="slug" label="Slug text" placeholder="Add slug text" @update:field="form.slug = $event" :errors="this.errors" initial_value=""/>
            <InputField name="slug_image" label="Slug image" placeholder="" type="file" @update:field="form.slug_image = $event" :errors="this.errors" initial_value=""/>
            <div v-for="category in this.categories_count">
                <InputField  name="categories" :label="'Category ' + category" :cat_number="(category-1)" placeholder="Add category" type="text" @update:field="form.categories[category-1] = $event" :errors="errors" initial_value=""/>
            </div>
            <div class="add-category-button" @click="addCategoryField">Add category</div>
            <label for="text">Text</label>
            <vue-ckeditor
                    id="text"
                    name="text"
                    v-model="form.text"
                    :config="config"
            />
            <div class="error">
                <p v-text="errorMessage()">Error here</p>
            </div>
            <button role="submit">Add post</button>
        </form>
    </div>
</template>

<script>

    import VueCkeditor from 'vue-ckeditor2';
    import InputField from "../components/InputField";
    import TextareaComponent from "../components/TextareaComponent";
    export default {
        name: "UserPostsCreate",
        props: [
            'user'
        ],
        components: { VueCkeditor, InputField, TextareaComponent },
        data: function() {
            return {
                form: {
                    'title': '',
                    'slug' : '',
                    'slug_image' : null,
                    'text' : '',
                    'categories' : [''],
                },
                'errors': null,
                'categories_count' : 1,
                config: {
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
        methods: {
            addPost: function() {
                let formData = new FormData();
                formData.append('title', this.form.title);
                formData.append('slug', this.form.slug);
                formData.append('slug_image', this.form.slug_image);
                formData.append('text', this.form.text);
                console.log(this.form.categories);
                this.form.categories.forEach(category => formData.append('categories[]', category));
                formData.append('api_token', this.user.api_token);
                axios({
                    method : 'post',
                    url: '/api/posts',
                    data: formData,
                    headers: {'Content-Type' : 'multipart/form-data'}
                })
                   .then(response => {
                        if(response.status === 201) {
                            this.$router.push("/myPosts");
                        }
                        console.log(response);
                   })
                   .catch(errors => {
                       console.log(errors.response);
                        this.errors = errors.response.data.errors;
                   });
            },
            addCategoryField: function(e) {
                e.preventDefault();
                this.categories_count++;
                this.form.categories[this.categories_count-1] = '';
            },
            errorMessage: function() {

                if(this.errors && this.errors['text'] && this.errors['text'].length > 0) {
                    return this.errors['text'][0];
                }
            },
            clearError: function() {
                if(this.errors && this.errors['text'] && this.errors['text'].length > 0) {
                    this.errors['text'] = null;
                }
            },
        },
        watch : {
            form : function(newForm, oldForm) {
                console.log("dsdjfôaklsdf saf dslk fkasdf askldf jasldôkf lkj2803219093120%93%123 ");
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
    button:hover,.add-category-button:hover {
        background: #0081ff;
    }
    .error {
        color: red;
    }
</style>