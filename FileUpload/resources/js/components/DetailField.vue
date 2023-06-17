<template>
    <PanelItem :index="index" :field="field" />

    <slot>{{ field.value }}</slot>

    <div class="grid gap-2 grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="(image, index) in images" :key="index" class="relative flex-shrink-0">
            <img :src="getImageUrl(image)" class="w-full h-full object-cover" alt="tour image" />
        </div>
    </div>

    <div class="mb-5 flex flex-wrap space-x-2 space-y-2">
        <div class="relative flex-shrink-0" v-for="(image, index) in imagePreviewUrls" :key="index" style="width:170px; height: 180px;">
            <img :src="image" class="w-full h-full object-cover" alt="tour image"/>
        </div>
    </div>
</template>

<script>

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    data() {
        return {
            images: []
        }
    },

    mounted(){
        console.log('foo')
        this.fetchImages()
    },

    methods: {
        fetchImages() {
            Nova.request`/nova-api/mizormor/file-upload/uploads/${this.resourceName}/${this.resourceId}`
                // this is the line that is causing the error
                .then(response => {
                    this.images = response
                })
                .catch(error => {
                    console.error(error)
                })
        },

        getImageUrl(image) {
            return `/nova-api/mizormor/file-upload/uploads/${resourceName}/${resourceId}/${image}`
        }
    }
}
</script>
