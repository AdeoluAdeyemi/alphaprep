<template>
    <div class="font-sans">
      <!-- Navigation -->
      <nav class="fixed w-full bg-white shadow-sm z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
          <div class="flex items-center">
            <img src="/logo.svg" alt="Logo" class="h-8">
          </div>

          <div class="hidden md:flex items-center space-x-8">
            <a href="#" class="text-gray-600 hover:text-[#0065ff] transition-colors">Why Paystack?</a>
            <a href="#" class="text-gray-600 hover:text-[#0065ff] transition-colors">Customers</a>
            <a href="#" class="text-gray-600 hover:text-[#0065ff] transition-colors">Pricing</a>
            <a href="#" class="text-gray-600 hover:text-[#0065ff] transition-colors">Learn</a>
            <button class="bg-[#0065ff] text-white px-6 py-2 rounded-md hover:bg-[#0052cc] transition-colors">
              Start Now
            </button>
          </div>

          <!-- Mobile Menu Button -->
          <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
          </button>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="md:hidden absolute w-full bg-white shadow-lg">
          <div class="px-6 py-4 space-y-4">
            <a href="#" class="block text-gray-600 hover:text-[#0065ff]">Why Paystack?</a>
            <a href="#" class="block text-gray-600 hover:text-[#0065ff]">Customers</a>
            <a href="#" class="block text-gray-600 hover:text-[#0065ff]">Pricing</a>
            <a href="#" class="block text-gray-600 hover:text-[#0065ff]">Learn</a>
            <button class="w-full bg-[#0065ff] text-white px-6 py-2 rounded-md hover:bg-[#0052cc]">
              Start Now
            </button>
          </div>
        </div>
      </nav>

      <!-- Hero Section -->
      <section class="pt-32 pb-24 bg-gradient-to-br from-[#001e4d] to-[#0065ff]">
        <div class="container mx-auto px-6 text-center">
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-8 leading-tight">
            Modern online and offline<br class="hidden md:block"> payments for Africa
          </h1>

          <p class="text-lg md:text-xl text-blue-100 mb-12 max-w-3xl mx-auto">
            Paystack helps businesses in Africa get paid by anyone, anywhere in the world
          </p>

          <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <button class="bg-white text-[#0065ff] px-8 py-4 rounded-md text-lg font-semibold hover:bg-gray-50 transition-colors shadow-lg">
              Create a free account
            </button>
            <button class="text-white border-2 border-white px-8 py-4 rounded-md text-lg hover:bg-white hover:text-[#0065ff] transition-colors">
              Contact Sales
            </button>
          </div>

          <!-- Trusted By -->
          <div class="mt-20">
            <p class="text-blue-100 mb-6">Trusted by over 100,000 businesses</p>
            <div class="flex flex-wrap justify-center items-center gap-8 opacity-80">
              <img v-for="brand in trustedBrands" :key="brand" :src="brand" class="h-8 grayscale hover:grayscale-0 transition-all">
            </div>
          </div>
        </div>
      </section>

      <!-- Stats Section -->
      <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
          <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
              <div class="text-3xl font-bold text-[#0065ff] mb-2">100k+</div>
              <div class="text-gray-600">Businesses powered</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
              <div class="text-3xl font-bold text-[#0065ff] mb-2">100k+</div>
              <div class="text-gray-600">Businesses powered</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
              <div class="text-3xl font-bold text-[#0065ff] mb-2">100k+</div>
              <div class="text-gray-600">Businesses powered</div>
            </div>
            <!-- Repeat similar blocks for other stats -->
          </div>
        </div>
      </section>

      <!-- Features Grid -->
      <section class="py-20">
        <div class="container mx-auto px-6">
          <h2 class="text-3xl md:text-4xl font-bold text-center mb-16">Powering growth for amazing businesses</h2>
          <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature Cards -->
            <div v-for="feature in features" :key="feature.title" class="p-8 rounded-xl hover:bg-gray-50 transition-colors">
              <img :src="feature.icon" class="h-16 w-16 mb-6">
              <h3 class="text-xl font-semibold mb-4">{{ feature.title }}</h3>
              <p class="text-gray-600">{{ feature.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-20 bg-[#001e4d] text-white">
        <div class="container mx-auto px-6 text-center">
          <h2 class="text-3xl md:text-4xl font-bold mb-8">Get started with Paystack</h2>
          <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <button class="bg-white text-[#0065ff] px-8 py-4 rounded-md text-lg font-semibold hover:bg-gray-50 transition-colors">
              Create a free account
            </button>
            <button class="border-2 border-white px-8 py-4 rounded-md text-lg hover:bg-white hover:text-[#0065ff] transition-colors">
              Contact Sales
            </button>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <footer class="bg-[#0a1830] text-white py-16">
        <div class="container mx-auto px-6">
          <div class="grid md:grid-cols-5 gap-8">
            <div class="md:col-span-2">
              <img src="/logo-white.svg" class="h-8 mb-6">
              <p class="text-gray-400">© 2023 Paystack. All rights reserved.</p>
            </div>
            <!-- Footer Columns -->
            <div v-for="column in footerLinks" :key="column.title">
              <h4 class="font-semibold mb-4">{{ column.title }}</h4>
              <ul class="space-y-3 text-gray-400">
                <li v-for="link in column.links" :key="link">
                  <a href="#" class="hover:text-white transition-colors">{{ link }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const isMobileMenuOpen = ref(false);

  // Replace with actual image paths
  const trustedBrands = [
    '/brands/dangote.svg',
    '/brands/dominos.svg',
    '/brands/uber.svg',
    '/brands/mtn.svg',
  ];

  const features = [
    {
      icon: '/icons/easy-integration.svg',
      title: 'Easy Integration',
      description: 'Get set up and start accepting payments in minutes.'
    },
    {
      icon: '/icons/easy-integration.svg',
      title: 'Easy Integration',
      description: 'Get set up and start accepting payments in minutes.'
    },
    {
      icon: '/icons/easy-integration.svg',
      title: 'Easy Integration',
      description: 'Get set up and start accepting payments in minutes.'
    },
    // Add more features
  ];

  const footerLinks = [
    {
      title: 'Products',
      links: ['Payment Gateway', 'Commerce Tools', 'Paystack Terminal']
    },
    // Add more footer columns
  ];
  </script>

  <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  body {
    font-family: 'Inter', sans-serif;
  }

  /* Custom Animations */
  .fade-in {
    animation: fadeIn 0.5s ease-in;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .hover-scale {
    transition: transform 0.3s ease;
  }

  .hover-scale:hover {
    transform: translateY(-5px);
  }

  /* Custom Gradient */
  .bg-brand-gradient {
    background: linear-gradient(135deg, #001E4D 0%, #0065FF 100%);
  }
  </style>
