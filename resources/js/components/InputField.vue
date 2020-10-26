<template>
    <div class="input-wrapper">
        <label :for="name">{{ label }}</label>
        <input :id="name" :type="type" :name="name" :placeholder="placeholder" v-model="value" @input="updateField" :class="errorClass()">
        <div class="error">
            <p v-text="errorMessage()">Error here</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InputField",
        props: [
            'name', 'label', 'placeholder', 'type', 'errors', 'initial_value', 'cat_number'
        ],
        data: function() {
            return {
                'value': ''
            }
        },
        created() {
            this.value = this.initial_value;
        },
        methods: {
            updateField: function() {
                this.clearError(name);
                if(this.type === "file") {
                    this.$emit('update:field', event.target.files[0]);

                } else {
                    this.$emit('update:field', this.value);
                }
            },
            errorMessage: function() {
                if(this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                    return this.errors[this.name][0];
                }
                if(this.name === 'categories') {
                    if(this.errors && this.errors[this.name + "." + this.cat_number] && this.errors[this.name + "." + this.cat_number].length > 0) {
                        this.errors[this.name + "." + this.cat_number][0] = "The category " + (this.cat_number + 1) + " is required.";
                        return this.errors[this.name + "." + this.cat_number][0];
                    }
                }
            },
            clearError: function() {
                if(this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                    this.errors[this.name] = null;
                }
                if(this.name === 'categories') {
                    if(this.errors && this.errors[this.name + "." + this.cat_number] && this.errors[this.name + "." + this.cat_number].length > 0) {
                        return this.errors[this.name + "." + this.cat_number] = null;
                    }
                }
            },
            errorClass : function() {
                //console.log(this.errors && this.errors[this.name] && this.errors[this.name].length > 0);
                //console.log(this.errors[this.name]);
                return {
                    'error-field' : this.errors && this.errors[this.name] && this.errors[this.name].length > 0
                };
            }
        }
    }
</script>

<style scoped>
    .input-wrapper {
        margin: 10px 0;
    }
    label {
        display: block;
        color: #00CEFF;
        font-weight: bold;
        font-size: 1.3em;
    }
    input {
        border: none;
        border-bottom: 2px solid #D3D3D3;
        outline: none;
        width: 100%;
        padding: 10px 0 5px 0;
        font-size: 1em;
        color: #707070;
        overflow-wrap: break-word;
    }
    input:focus {
        border-color: #00CEFF;
    }
    .error {
        color: red;
    }
    .error-field {
        border-color: red;
    }
</style>