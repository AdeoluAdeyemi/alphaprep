<template>
    <div class="relative">
      <button
        @click="$emit('click')"
        class="p-2 text-gray-600 hover:text-blue-600 transition-colors"
        aria-label="Shopping cart"
      >
        <ShoppingCartIcon class="h-6 w-6" />
        <span
          v-if="count > 0"
          class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full h-5 w-5 text-xs flex items-center justify-center"
        >
          {{ count }}
        </span>
      </button>
    </div>
  </template>

  <script setup>
  import { ShoppingCartIcon } from '@heroicons/vue/24/outline'

  defineProps({
    count: {
      type: Number,
      default: 0
    }
  })

  defineEmits(['click'])
  </script>
