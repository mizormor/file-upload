<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
        <div>
            <div class="relative">
                <img v-if="imagePreviewUrl" :src="imagePreviewUrl" class="w-400 mb-5" width="200"  alt="tour image"/>
                <input type="file"
                       @change="previewImage"
                       ref="fileInput"
                       class="opacity-0 w-0 h-0"
                       :class="errorClasses"
                       :placeholder="field.name" />
                <button v-if="imagePreviewUrl" @click="clearImage" class="absolute top-0 left-0 m-2 p-2 text-white bg-red-500 rounded-full focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    </svg>
                </button>
            </div>
        </div>
        <p v-if="hasError" class="my-2 text-danger">
            {{ firstError }}
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
            imagePreviewUrl: null,
            imageFile: null,
        };
    },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

      // previewImage(event) {
      //     const file = event.target.files[0];
      //     const reader = new FileReader();
      //
      //     reader.onload = () => {
      //         this.imagePreviewUrl = reader.result;
      //     };
      //
      //     if (file) {
      //         reader.readAsDataURL(file);
      //     }
      // },
      previewImage(event) {
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.onload = (e) => {
              this.imagePreviewUrl = e.target.result;
              this.$emit('input', file);
              this.imageFile = file
              this.errorMessage = null;
              // console.log(this.imageFile);
          };
          if (this.maxFileSize && file.size / 1024 > this.maxFileSize) {
              this.errorMessage = `File size must be less than ${this.maxFileSize} KB`;
              this.imagePreviewUrl = null;
          } else {
              reader.readAsDataURL(file);
          }
      },

      uploadImage() {
          // Replace the URL with your own server endpoint
          const url = 'https://example.com/upload';

          // Create a new FormData object and append the image file to it
          const formData = new FormData();
          formData.append('tour_image', this.$refs.fileInput.files[0]);
          console.log(this.$refs.fileInput)

          // Make a POST request to the server with the form data
          fetch(url, {
              method: 'POST',
              body: formData
          })
              .then(response => {
                  // Handle the response from the server
                  console.log('Response:', response);
              })
              .catch(error => {
                  // Handle any errors that occur during the request
                  console.error('Error:', error);
              });
      },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.imageFile)
        console.log(formData.get('tour_image'))
    },
      clearImage() {
          this.imagePreviewUrl = null;
          this.$refs.fileInput.value = '';
      }
  },
}
</script>
