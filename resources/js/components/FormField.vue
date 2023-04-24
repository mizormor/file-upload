<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
     <div class="relative">
         <img v-if="imagePreviewUrl" :src="imagePreviewUrl" alt="tour image" class="mb-5" width="200" height="auto">
         <input
             :id="field.attribute"
             type="file"
             ref="fileInput"
             class="opacity-0 w-0 h-0"
             :class="errorClasses"
             :placeholder="field.name"
             @change="previewImage"
         />
         <button v-if="imagePreviewUrl" @click="clearImage" class="absolute top-0 left-0 m-2 p-2 text-white bg-red-500 rounded-full focus:outline-none">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
                 <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
             </svg>
         </button>
         <button @click="$refs.fileInput.click()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
             Choose Image
         </button>
     </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            imagePreviewUrl: null
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
          const file = event.target.files[0];
          const reader = new FileReader();

          reader.onload = () => {
              this.imagePreviewUrl = reader.result;
          };

          if (file) {
              reader.readAsDataURL(file);
          }
      },

      async uploadImage() {
          // Send `this.imageFile` to your remote server here
      },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
      clearImage() {
          this.imagePreviewUrl = null;
          this.$refs.fileInput.value = '';
      }
  },
}
</script>
