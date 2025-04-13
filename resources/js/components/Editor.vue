<template>
    <ckeditor
        v-model="data"
        :editor="ClassicEditor"
        :config="config"
    />
</template>

<script setup>
import { ref, computed } from 'vue';
import { ClassicEditor, Essentials, Paragraph, Bold, Italic } from 'ckeditor5';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { FormatPainter } from 'ckeditor5-premium-features';

import 'ckeditor5/ckeditor5.css';
import 'ckeditor5-premium-features/ckeditor5-premium-features.css';

const data = ref( '<p>Type a text</p>' );

const config = computed( () => {
    return {
        licenseKey: import.meta.env.VITE_CKEDITOR_API_KEY, // Or 'GPL'.
        plugins: [ Essentials, Paragraph, Bold, Italic, FormatPainter ],
        toolbar: [ 'undo', 'redo', '|', 'bold', 'italic', '|', 'formatPainter', 'underline', '|','superscript', 'subscript', 'code', 'block quote']
    };
} );
</script>
