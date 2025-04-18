<template>
    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
      <div class="aspect-video bg-gray-100 rounded-lg mb-4"></div>
      <h3 class="text-xl font-semibold mb-2">{{ certification.title }}</h3>
      <div class="flex justify-between items-center mb-4">
        <span class="text-blue-600 font-semibold">${{ certification.price }}</span>
        <div class="flex items-center">
          <StarIcon class="h-5 w-5 text-yellow-400" />
          <span class="ml-1 text-gray-600">{{ certification.popularity }}</span>
        </div>
      </div>
      <button
        @click="$emit('add-to-cart')"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
      >
        Add to Cart
      </button>
    </div>
  </template>

  <script setup>
  import { StarIcon } from '@heroicons/vue/24/solid'

  defineProps({
    certification: {
      type: Object,
      required: true
    }
  })
  </script>
