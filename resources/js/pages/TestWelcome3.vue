<template>
    <div class="font-sans">
      <!-- Navigation -->
      <nav class="fixed w-full bg-white shadow-sm z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
          <div class="flex items-center">
            <img src="https://www.paystack.com/assets/website/images/logo.svg" alt="Paystack Logo" class="h-8">
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

          <!-- Mobile Menu -->
          <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
          </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div v-if="isMobileMenuOpen" class="md:hidden bg-white shadow-lg">
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
            Paystack helps businesses in Africa get paid by anyone, anywhere in the world. Powerful tools to grow your business.
          </p>

          <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <button class="bg-white text-[#0065ff] px-8 py-4 rounded-md text-lg font-semibold hover:bg-gray-50 transition-colors shadow-lg">
              Create a free account
            </button>
            <button class="text-white border-2 border-white px-8 py-4 rounded-md text-lg hover:bg-white hover:text-[#0065ff] transition-colors">
              Contact Sales
            </button>
          </div>

          <!-- Trusted By Section -->
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
              <div class="text-gray-600">Businesses Using Paystack</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
              <div class="text-3xl font-bold text-[#0065ff] mb-2">20+</div>
              <div class="text-gray-600">Countries Across Africa</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
              <div class="text-3xl font-bold text-[#0065ff] mb-2">250+</div>
              <div class="text-gray-600">Payment Methods Supported</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-20">
        <div class="container mx-auto px-6">
          <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Everything you need to get paid</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">From online stores to physical retail, recurring billing to split payments - we've got you covered</p>
          </div>

          <div class="grid md:grid-cols-3 gap-8">
            <div class="p-8 rounded-xl hover:bg-gray-50 transition-colors">
              <img src="https://img.icons8.com/color/96/online-payment.png" class="h-16 w-16 mb-6" alt="Online Payments">
              <h3 class="text-xl font-semibold mb-4">Online Payments</h3>
              <p class="text-gray-600">Accept payments from anywhere in the world with cards, bank transfers, and mobile money</p>
            </div>
            <div class="p-8 rounded-xl hover:bg-gray-50 transition-colors">
              <img src="https://img.icons8.com/color/96/recurring-payment.png" class="h-16 w-16 mb-6" alt="Recurring Billing">
              <h3 class="text-xl font-semibold mb-4">Recurring Billing</h3>
              <p class="text-gray-600">Set up subscription payments for your SaaS, membership sites, and other recurring revenue models</p>
            </div>
            <div class="p-8 rounded-xl hover:bg-gray-50 transition-colors">
              <img src="https://img.icons8.com/color/96/pos-terminal.png" class="h-16 w-16 mb-6" alt="POS Payments">
              <h3 class="text-xl font-semibold mb-4">POS Payments</h3>
              <p class="text-gray-600">Take payments in-person with our mobile POS solution that works with any Android device</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Integration Section -->
      <section class="py-20 bg-[#f8f9fa]">
        <div class="container mx-auto px-6">
          <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Integrates with the tools you love</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Connect Paystack to your favorite business tools and automate your workflow</p>
          </div>

          <div class="flex flex-wrap justify-center items-center gap-8">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/WordPress_blue_logo.svg" class="h-12" alt="WordPress">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Shopify_logo_2018.svg" class="h-12" alt="Shopify">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" class="h-12" alt="React">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" class="h-12" alt="Laravel">
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Slack_icon_2019.svg" class="h-12" alt="Slack">
          </div>
        </div>
      </section>

      <!-- Testimonials -->
      <section class="py-20">
        <div class="container mx-auto px-6">
          <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Loved by businesses worldwide</h2>
          </div>

          <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm">
              <div class="flex items-center mb-6">
                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="h-12 w-12 rounded-full" alt="User">
                <div class="ml-4">
                  <div class="font-semibold">John Adekunle</div>
                  <div class="text-gray-600">CEO, Nguvu Logistics</div>
                </div>
              </div>
              <p class="text-gray-600">"Paystack has transformed how we collect payments across Africa. The multiple currency support and easy integration made our expansion seamless."</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm">
              <div class="flex items-center mb-6">
                <img src="https://randomuser.me/api/portraits/women/45.jpg" class="h-12 w-12 rounded-full" alt="User">
                <div class="ml-4">
                  <div class="font-semibold">Amina Mohammed</div>
                  <div class="text-gray-600">Founder, Urban Fashion</div>
                </div>
              </div>
              <p class="text-gray-600">"The dashboard analytics helped us understand our customers better. Payment success rates improved by 40% after switching to Paystack."</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Final CTA -->
      <section class="py-20 bg-[#001e4d] text-white">
        <div class="container mx-auto px-6 text-center">
          <h2 class="text-3xl md:text-4xl font-bold mb-8">Start accepting payments in minutes</h2>
          <p class="text-xl text-blue-100 mb-12 max-w-2xl mx-auto">Join thousands of businesses growing with Paystack</p>
          <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <button class="bg-white text-[#0065ff] px-8 py-4 rounded-md text-lg font-semibold hover:bg-gray-50 transition-colors">
              Create Free Account
            </button>
            <button class="border-2 border-white px-8 py-4 rounded-md text-lg hover:bg-white hover:text-[#0065ff] transition-colors">
              Schedule Demo
            </button>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <footer class="bg-[#0a1830] text-white py-16">
        <div class="container mx-auto px-6">
          <div class="grid md:grid-cols-5 gap-8">
            <div class="md:col-span-2">
              <img src="https://www.paystack.com/assets/website/images/logo-white.svg" class="h-8 mb-6" alt="Paystack">
              <p class="text-gray-400">© 2023 Paystack. All rights reserved.</p>
            </div>

            <div>
              <h4 class="font-semibold mb-4">Products</h4>
              <ul class="space-y-3 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">Payment Gateway</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Commerce Tools</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Terminal</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Payouts</a></li>
              </ul>
            </div>

            <div>
              <h4 class="font-semibold mb-4">Developers</h4>
              <ul class="space-y-3 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                <li><a href="#" class="hover:text-white transition-colors">API Reference</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Status Page</a></li>
                <li><a href="#" class="hover:text-white transition-colors">SDKs</a></li>
              </ul>
            </div>

            <div>
              <h4 class="font-semibold mb-4">Company</h4>
              <ul class="space-y-3 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
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

  const trustedBrands = [
    'https://assets.paystack.com/assets/img/logos/merchants/Dominos-Plain.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/mtn-group-grayscale.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/Bolt-Stack-Blue_200304_153027.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/Axa-mansard-_-Plain.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/_300xAUTO_crop_center-center_none/Piggyvest-Stack-Blue_200304_153734.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/_300xAUTO_crop_center-center_none/GIGM-Plain_180827_172142.svg',
    'https://assets.paystack.com/assets/img/logos/merchants/_300xAUTO_crop_center-center_none/carbon-dark.svg',
  ];
  </script>

  <style>
  /* Custom CSS */
  body {
    font-family: 'Inter', sans-serif;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
  }
  </style>
