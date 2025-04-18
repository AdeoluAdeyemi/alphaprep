<template>
    <div>
      <!-- Overlay -->
      <transition
        enter-active-class="transition-opacity ease-linear duration-300"
        leave-active-class="transition-opacity ease-linear duration-300"
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
      >
        <div
          v-if="show"
          class="fixed inset-0 bg-black/50 z-50"
          @click="$emit('close')"
        ></div>
      </transition>

      <!-- Sidebar -->
      <transition
        enter-active-class="transition-transform ease-in-out duration-300"
        leave-active-class="transition-transform ease-in-out duration-300"
        enter-from-class="translate-x-full"
        leave-to-class="translate-x-full"
      >
        <div
          v-if="show"
          class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-xl z-50 flex flex-col"
        >
          <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-xl font-semibold">Your Cart</h2>
            <button
              @click="$emit('close')"
              class="text-gray-500 hover:text-gray-700"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>

          <!-- Cart Items -->
          <div class="flex-1 overflow-y-auto p-6">
            <div v-if="cartItems.length === 0" class="text-center text-gray-500 py-12">
              Your cart is empty
            </div>

            <div v-for="item in cartItems" :key="item.id" class="flex gap-4 py-4 border-b">
              <img
                :src="item.image"
                :alt="item.title"
                class="h-20 w-20 object-contain bg-gray-100 rounded-lg"
              >
              <div class="flex-1">
                <h3 class="font-medium">{{ item.title }}</h3>
                <p class="text-gray-500 text-sm">{{ item.provider }}</p>
                <div class="flex items-center justify-between mt-2">
                  <span class="text-blue-600 font-semibold">${{ item.price }}</span>
                  <button
                    @click="removeItem(item.id)"
                    class="text-red-500 hover:text-red-700 text-sm"
                  >
                    Remove
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Cart Summary -->
          <div class="p-6 border-t">
            <div class="flex justify-between text-lg font-semibold mb-4">
              <span>Total:</span>
              <span>${{ cartTotal }}</span>
            </div>
            <button
              class="w-full primary-button"
              :disabled="cartItems.length === 0"
            >
              Proceed to Checkout
            </button>
          </div>
        </div>
      </transition>
    </div>
  </template>

  <script setup>
  import { XMarkIcon } from '@heroicons/vue/24/outline'
  import { computed } from 'vue'

  const props = defineProps({
    show: Boolean,
    cartItems: {
      type: Array,
      default: () => []
    }
  })

  const emit = defineEmits(['close', 'remove-item'])

  const cartTotal = computed(() => {
    return props.cartItems.reduce((sum, item) => sum + item.price, 0).toFixed(2)
  })

  const removeItem = (id) => {
    emit('remove-item', id)
  }
  </script>
