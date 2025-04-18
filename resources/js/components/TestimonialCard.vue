<template>
    <div class="bg-white p-6 rounded-lg shadow-sm">
      <p class="text-gray-600 mb-4">"{{ testimonial.text }}"</p>
      <div class="flex items-center">
        <img :src="testimonial.avatar" class="h-12 w-12 rounded-full mr-4" alt="">
        <div>
          <div class="font-semibold">{{ testimonial.name }}</div>
          <div class="text-gray-500 text-sm">{{ testimonial.role }}</div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  defineProps({
    testimonial: {
      type: Object,
      required: true
    }
  })
  </script>
