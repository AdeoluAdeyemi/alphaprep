<template>
    <div class="flex items-center justify-center w-full">
        <label v-if="label" :for="id" class="flex flex-col items-center justify-center w-full h-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

            <div
                v-if="(fileDetails.name != null && fileDetails.size != null) || (model != null && model != '')"
                class="flex flex-col items-center justify-center pt-2 pb-2"
            >
            <div class="flex flex-row space-x-3 mb-2">
                <Button
                    size="md"
                    class="ml-2 rounded-md font-medium text-center bg-primary hover:bg-blue-800"
                    @click="clearField">
                    <svg class="w-[16px] h-[16px] text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                    </svg>

                    Change Image
                </Button>

                <!-- <Button
                    size="md"
                    id="redbtn"
                    @click="clearField"
                    class="ml-2 rounded-md font-medium text-center">
                    <svg class="w-[16px] h-[16px] text-red-600 hover:text-white mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                    </svg>
                    Remove Image
                </Button> -->
            </div>
                <p v-if="model == null" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">File name:</span> {{ fileDetails.name }}</p>
                <p v-if="model == null" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">File size:</span> {{ fileDetails.size }} bytes</p>
                <div class="flex w-full justify-center h-auto">
                    <img :src="url" class="h-auto w-96 rounded shadow-md" alt="image preview"/>
                </div>
            </div>
            <div
                v-else
                class="flex flex-col items-center justify-center pt-2 pb-2"
            >
                <svg class="w-8 h-8 mb-1 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <input
                :id
                type="file"
                accept="image/*"
                class="hidden"
                ref="photo"
                @change="previewImage"
            />
        </label>
    </div>
    <div v-if="error" :id="`${id}-error`" class="form-error">{{ error }}</div>
</template>

<script setup>
import { Button } from '@/components/ui/button';
import { defineProps, defineEmits, ref, defineModel, onMounted } from 'vue'
import { v4 as uuid } from 'uuid'
import { watch } from 'vue';

const props = defineProps({
    id: {
        type: String,
        default() {
            return `base-input-${uuid()}`
        },
    },
    label: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    error: String,
})

const model = defineModel()

const url = ref(null)
const photo = ref(null)

const fileDetails = ref({
    name: null,
    size: null
})

const requiredText = ref("<span class='text-red-600'>*</span>")

onMounted(() => {
    if (model.value)
    {
        console.log(model.value)
        url.value = `/images/${model.value}`
    }
})

// const photoClicked = () => {
//     // Dynamically call the .click() event on the hidden file input.
//     photo.value.click()
// }

const fetchFileDetails = () => {
    // Assign the file name to the model
    model.value = photo.value.files[0]
}

const previewImage = (e) => {
    const file = e.target.files[0]
    url.value = URL.createObjectURL(file)

    fileDetails.value.name = file.name
    fileDetails.value.size = file.size

    model.value = photo.value.files[0]

}

const showImage= () => {
    return "/storage/"
    //showImage()+imagepath
}

const clearField = () => {
    photo.value = null
    model.value = null
    fileDetails.value.name = null
    fileDetails.value.size = null
}

</script>

