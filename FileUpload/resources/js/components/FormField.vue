<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div>
                <div>
                    <div class="mb-5 flex flex-wrap space-x-2 space-y-2">
                        <div class="relative flex-shrink-0" v-for="(image, index) in imagePreviewUrls" :key="index" style="width:170px; height: 180px;">
                            <img :src="image" class="w-full h-full object-cover" alt="tour image"/>
                            <button @click="clearImage(index)"
                                    class="absolute top-0 right-0 m-1 p-1 text-white bg-red-500 rounded-full focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-2 h-2 fill-current">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <input type="file"
                           @change="previewImage"
                           ref="fileInput"
                           class="opacity-0 w-0 h-0 hidden"
                           :class="errorClasses"
                           :placeholder="field.name"
                    multiple/>
                    <button class="bg-primary-500 text-white py-2 px-4 rounded text-sm font-bold" @click="chooseFile">Choose File</button>

                </div>
            </div>
            <p v-if="errorMessage" class="my-2 text-danger">
                {{ errorMessage }}
            </p>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            imagePreviewUrls: [],
            imageFiles: [],
            errorMessage: null
        };
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },
        previewImage(event) {
            const files = event.target.files;

            Array.from(files).forEach((file) => {
                console.log(this.maxFileSize);
                console.log(file.size);
                if (this.maxFileSize && file.size / 1024 > this.maxFileSize) {
                    this.errorMessage = `File size must be less than ${this.maxFileSize} KB`;
                    return;
                }

                const imageUrl = URL.createObjectURL(file);
                this.imagePreviewUrls.push(imageUrl);
                this.imageFiles.push(file);
            })
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {

            this.imageFiles.forEach((file, index) => {
                formData.append(`${this.field.attribute}[${index}]`, file)
            })
        },
        clearImage(index) {
            this.imagePreviewUrls.splice(index, 1);
            this.imageFiles.splice(index, 1)
        },
        chooseFile() {
            this.$refs.fileInput.click();
        },
    },
}
</script>
