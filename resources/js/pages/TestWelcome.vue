<template>
    <div class="font-sans">
      <!-- Navigation -->
      <nav class="fixed w-full bg-white shadow-sm z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
          <div class="flex items-center">
            <img src="/logo.svg" alt="Logo" class="h-8">
          </div>

          <div class="hidden md:flex items-center space-x-8">
            <a href="#" class="text-gray-600 hover:text-blue-600">Why Paystack?</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Customers</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Pricing</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Learn</a>
          </div>

          <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
            Start Now
          </button>
        </div>
      </nav>

      <!-- Hero Section -->
      <div class="pt-24 pb-32 bg-gradient-to-br from-blue-900 to-blue-600">
        <div class="container mx-auto px-6 text-center">
          <h1 class="text-5xl font-bold text-white mb-8">
            Modern online and offline payments for Africa
          </h1>

          <p class="text-xl text-blue-100 mb-12 max-w-3xl mx-auto">
            Paystack helps businesses in Africa get paid by anyone, anywhere in the world
          </p>

          <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-6">
            <button class="bg-white text-blue-600 px-8 py-4 rounded-md text-lg font-semibold hover:bg-gray-100">
              Create a free account
            </button>
            <button class="text-white border-2 border-white px-8 py-4 rounded-md text-lg hover:bg-white hover:text-blue-600">
              Contact Sales
            </button>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-8 rounded-xl shadow-sm">
              <div class="text-3xl font-bold text-blue-600 mb-2">100k+</div>
              <div class="text-gray-600">Businesses powered</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm">
              <div class="text-3xl font-bold text-blue-600 mb-2">50%</div>
              <div class="text-gray-600">Of Fortune 500 companies</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm">
              <div class="text-3xl font-bold text-blue-600 mb-2">10m+</div>
              <div class="text-gray-600">Monthly transactions</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Features Section -->
      <div class="py-24">
        <div class="container mx-auto px-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
              <h2 class="text-4xl font-bold text-gray-800 mb-6">
                Trusted by global brands
              </h2>
              <p class="text-gray-600 text-lg mb-8">
                Thousands of organizations of all sizes trust Paystack to grow their business.
              </p>
              <div class="grid grid-cols-3 gap-8">
                <img v-for="brand in brands" :key="brand" :src="brand" alt="Brand" class="h-12 grayscale hover:grayscale-0">
              </div>
            </div>

            <div class="bg-gray-100 rounded-xl p-8">
              <img src="/dashboard-screenshot.png" alt="Dashboard" class="rounded-lg shadow-xl">
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  // Replace these with actual brand logos
  const brands = [
    '/brand1.svg',
    '/brand2.svg',
    '/brand3.svg',
    '/brand4.svg',
    '/brand5.svg',
    '/brand6.svg',
  ];
  </script>

  <style>
  /* Add any custom styles here */
  </style>
