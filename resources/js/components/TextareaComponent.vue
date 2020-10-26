<template>
    <div class="input-wrapper">
        <label :for="name">{{ label }}</label>
        <textarea :name="name" :id="name" :placeholder="placeholder" rows="2" v-model="value" @input="updateField()" :class="errorClass()">{{initial_value}}</textarea>
        <div class="error">
            <p v-text="errorMessage()">Error here</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TextareaComponent",
        props : [
            'name', 'placeholder', 'label', 'errors', 'initial_value'
        ],
        data: function() {
            return {
                'value' : ''
            }
        },
        created() {
            this.value = this.initial_value;
        },
        methods: {
            updateField : function () {
                this.clearError(name);
                this.$emit('update:field', this.value);
            },
            errorMessage: function() {

                if(this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                    return this.errors[this.name][0];
                }
            },
            clearError: function() {
                if(this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                    this.errors[this.name] = null;
                }
            },
            errorClass : function() {
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
    textarea {
        border: none;
        border-bottom: 2px solid #D3D3D3;
        outline: none;
        width: 100%;
        padding: 10px 0 5px 0;
        font-size: 1em;
        overflow-wrap: break-word;
        color: #707070;
    }
    textarea:focus {
        border-color: #00CEFF;
    }
    .error {
        color: red;
    }
    .error-field {
        border-color: red;
    }
</style>