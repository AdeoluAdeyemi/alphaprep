<template>
    <QuillEditor :modules="modules" toolbar="full" />
</template>

<script setup>
    import { ref, defineComponent } from 'vue'
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css'
    import ImageUploader from 'quill-image-uploader';
    import axios from '../lib/axios';

const formData = new FormData();
formData.append("image", file);

axios.post('/upload-image', formData)
.then(res => {
    console.log(res)
    resolve(res.data.url);
})
.catch(err => {
    reject("Upload failed");
    console.error("Error:", err)
})
</script>
