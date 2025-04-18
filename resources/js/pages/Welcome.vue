<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center space-x-4">
                        <img src="https://exampro.co/logo.svg" class="h-12 w-auto" alt="ExamPro AI Certification Prep">
                        <div class="hidden lg:flex space-x-8 ml-10">
                            <a href="#features" class="nav-link">Features</a>
                            <a href="#certifications" class="nav-link">Certifications</a>
                            <a href="#testimonials" class="nav-link">Success Stories</a>
                            <a href="#pricing" class="nav-link">Pricing</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <CartPreview :count="cartCount" @click="showCart = true" />
                        <button class="primary-button">Sign In</button>

                        <Link
                            href="/login"
                            class="primary-button"
                        >
                            Log in
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Master Professional Certifications with AI
                </h1>
                <p class="text-xl mb-12 max-w-3xl mx-auto leading-relaxed">
                    Join 850,000+ professionals who used our AI-powered platform to pass AWS, PMP, CFA, Cisco,
                    CompTIA, and other top certifications on their first attempt.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button class="hero-cta bg-white text-blue-900">
                        Start 7-Day Free Trial
                    </button>
                    <button class="hero-cta border-2 border-white">
                        Explore 50+ Certifications
                    </button>
                </div>
                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <!-- <img
              v-for="brand in trustedBrands"
              :key="brand"
              :src="`https://exampro.co/brands/${brand}.svg`"
              :alt="`${brand} certification`"
              class="h-12 opacity-80 hover:opacity-100 transition-opacity"
            > -->
                    <div
                        class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-8 xl:grid-cols-10 gap-x-6 sm:gap-x-6 lg:gap-x-10 xl:gap-x-36 gap-y-4 sm:gap-y-10 md:gap-y-12  mx-auto justify-items-center">
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/aws-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/aws-logo.svg" alt="AWS"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">AWS</p>
                            </a></div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/azure-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/azure-logo.svg" alt="Azure"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">Azure</p>
                            </a></div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/gcp-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/gcp-logo.svg" alt="GCP"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">GCP</p>
                            </a></div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/hashicorp-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/terraform-logo.svg"
                                    alt="Terraform"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">Terraform</p>
                            </a></div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/k8s-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/kubernetes-logo.svg"
                                    alt="Kubernetes"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">Kubernetes</p>
                            </a></div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/github-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/github-logo.svg"
                                    alt="GitHub"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">GitHub</p>
                            </a>
                        </div>
                        <div class="flex justify-center"><a
                                class="flex flex-col items-center justify-center w-[115px] h-[115px] [@media(max-width:359px)]:w-[100px] [@media(max-width:359px)]:h-[100px] sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white border border-gray-200 rounded-lg shadow-md transition-transform duration-200 hover:scale-110 hover:border-orange-500 hover:bg-orange-50"
                                href="/comptia-choose-an-exam"><img
                                    src="https://www.exampro.co/images/icons/platform-icons/comptia-logo.svg"
                                    alt="CompTIA"
                                    class="h-20 w-20 [@media(max-width:359px)]:h-16 [@media(max-width:359px)]:w-16 sm:h-16 sm:w-16 md:h-20 md:w-20 object-contain">
                                <p class="mt-2 text-sm sm:text-base md:text-base font-semibold text-center"
                                    style="color:rgb(0, 150, 162);">CompTIA</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Certifications Search & Grid -->
        <section id="certifications" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Prepare for Top Certifications</h2>
                <p class="text-gray-600 text-lg">
                    Access AI-powered practice tests for 50+ professional certifications across IT,
                    Project Management, Cloud, Cybersecurity, and Finance
                </p>
            </div>


            <!-- Enhanced Search -->
            <div class="max-w-3xl mx-auto mb-16">
                <div class="relative shadow-lg rounded-xl">
                    <input v-model="searchQuery" type="text"
                        placeholder="Search certifications (e.g., 'AWS', 'PMP', 'CISSP')"
                        class="w-full px-8 py-5 rounded-xl border-0 text-lg focus:ring-4 focus:ring-blue-200">
                    <MagnifyingGlassIcon class="h-6 w-6 text-gray-400 absolute right-6 top-5" />
                </div>
                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    <button v-for="category in categories" :key="category" @click="toggleCategory(category)" :class="selectedCategories.includes(category)
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors">
                        {{ category }}
                    </button>
                </div>
            </div>

            <!-- Certification Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <CertificationCard v-for="cert in filteredCertifications" :key="cert.id" :certification="cert"
                    @add-to-cart="addToCart" />
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="bg-gray-50 py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">Why Choose ExamPro?</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Cutting-edge features powered by artificial intelligence to optimize your exam preparation
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-16">
                    <div class="feature-card">
                        <img src="https://s3.us-east-1.amazonaws.com/website-v3-assets/assets/img/content/Collect-Payments-for-Multiple-Channels-1.1.gif" alt="Adaptive learning interface"
                            class="feature-image">
                        <div class="p-8">
                            <h3 class="feature-title">Smart Adaptive Learning</h3>
                            <p class="feature-description">
                                Our AI engine analyzes your performance in real-time, automatically adjusting
                                question difficulty and focusing on your weak areas. Get personalized study
                                recommendations and optimized learning paths.
                            </p>
                            <ul class="feature-list">
                                <li>Dynamic question bank with 10,000+ practice questions</li>
                                <li>Machine learning-powered difficulty adjustment</li>
                                <li>Personalized daily study plans</li>
                            </ul>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img src="https://s3.us-east-1.amazonaws.com/website-v3-assets/assets/img/content/_800x714_crop_center-center_82_line/Robust-Suite-of-APIs-Opt.png"
                            alt="Performance analytics dashboard" class="feature-image">
                        <div class="p-8">
                            <h3 class="feature-title">Advanced Analytics</h3>
                            <p class="feature-description">
                                Detailed performance tracking with comparative benchmarks. Visualize your progress
                                with interactive dashboards and predictive score estimates.
                            </p>
                            <ul class="feature-list">
                                <li>Real-time progress tracking</li>
                                <li>Peer performance benchmarking</li>
                                <li>Score prediction algorithm</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">Trusted by Professionals</h2>
                    <p class="text-gray-600 text-lg">
                        4.9/5 rating from 12,000+ verified users across 85 countries
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <TestimonialCard v-for="testimonial in testimonials" :key="testimonial.name"
                        :testimonial="testimonial" />
                </div>

                <div class="mt-16 text-center">
                    <button class="secondary-button">
                        Read 2,400+ Reviews
                    </button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-12">
            <!-- Footer content -->
        </footer>

        <!-- Cart Sidebar -->
        <!-- <CartSidebar :show="showCart" @close="showCart = false" /> -->
        <CartSidebar
            :show="showCart"
            :cart-items="cartItems"
            @close="showCart = false"
            @remove-item="removeCartItem"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
import CertificationCard from '@/components/CertificationCard.vue'
import TestimonialCard from '@/components/TestimonialCard.vue'
  import CartPreview from '@/components/CartPreview.vue'
  import CartSidebar from '@/components/CartSidebar.vue'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const cartItems = ref([])

const addToCart = (cert) => {
  cartItems.value.push({
    id: cert.id,
    title: cert.title,
    price: cert.price,
    provider: cert.provider,
    image: cert.image
  })

  cartCount.value++

}

const removeCartItem = (id) => {
  cartItems.value = cartItems.value.filter(item => item.id !== id)
}

// Sample data for 10 certifications (expand to 50)
const certifications = ref([
    {
        id: 1,
        title: 'AWS Certified Solutions Architect',
        price: 149,
        category: 'Cloud Computing',
        provider: 'Amazon Web Services',
        rating: 4.9,
        image: 'https://exampro.co/certs/aws-saa.png',
        features: ['1000+ practice questions', '5 full-length exams', 'Video explanations']
    },
    {
        id: 2,
        title: 'PMP Certification',
        price: 199,
        category: 'Project Management',
        provider: 'PMI',
        rating: 4.8,
        image: 'https://exampro.co/certs/pmp.png',
        features: ['PMBOK 7th Ed aligned', 'Agile practice tests', 'Flashcards']
    },
    // Add 48 more certifications...
])

const trustedBrands = ['aws', 'pmi', 'cisco', 'comptia', 'microsoft', 'google-cloud', 'isc2', 'salesforce']

//const features = ref([...]) // Expanded features data

const testimonials = ref([
    {
        name: 'Sarah Johnson',
        role: 'Senior Cloud Architect',
        certification: 'AWS Certified Solutions Architect',
        text: 'The AI practice tests were incredibly accurate - I saw several very similar questions in the actual exam. The performance analytics helped me focus my studies exactly where needed.',
        avatar: 'https://randomuser.me/api/portraits/women/85.jpg',
        company: 'TechCorp Solutions'
    },
    {
        name: 'Sarah Johnson',
        role: 'Senior Cloud Architect',
        certification: 'AWS Certified Solutions Architect',
        text: 'The AI practice tests were incredibly accurate - I saw several very similar questions in the actual exam. The performance analytics helped me focus my studies exactly where needed.',
        avatar: 'https://randomuser.me/api/portraits/women/85.jpg',
        company: 'TechCorp Solutions'
    },
    {
        name: 'Sarah Johnson',
        role: 'Senior Cloud Architect',
        certification: 'AWS Certified Solutions Architect',
        text: 'The AI practice tests were incredibly accurate - I saw several very similar questions in the actual exam. The performance analytics helped me focus my studies exactly where needed.',
        avatar: 'https://randomuser.me/api/portraits/women/85.jpg',
        company: 'TechCorp Solutions'
    },
    // Add more testimonials...
])

// Search and filter logic
const searchQuery = ref('')
const selectedCategories = ref([])
const categories = ['Cloud', 'Cybersecurity', 'Project Management', 'Finance', 'IT', 'Agile']

const filteredCertifications = computed(() => {
    return certifications.value.filter(cert => {
        const matchesSearch = cert.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            cert.provider.toLowerCase().includes(searchQuery.value.toLowerCase())
        const matchesCategory = selectedCategories.value.length === 0 ||
            selectedCategories.value.some(cat => cert.category.toLowerCase().includes(cat.toLowerCase()))
        return matchesSearch && matchesCategory
    })
})

// Cart functionality
const cartCount = ref(0)
const showCart = ref(false)

// const addToCart = (cert) => {
//     cartCount.value++
//     // Implement actual cart logic
// }
</script>

<style>
.nav-link {
    @apply text-gray-700 hover:text-blue-600 transition-colors font-medium text-lg;
}

.primary-button {
    @apply bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors;
}

.secondary-button {
    @apply border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors;
}

.hero-cta {
    @apply px-8 py-4 rounded-xl text-lg font-semibold transition-transform hover:scale-105;
}

.feature-card {
    @apply bg-white rounded-xl shadow-lg overflow-hidden;
}

.feature-image {
    @apply w-full h-64 object-cover;
}

.feature-title {
    @apply text-2xl font-bold mb-4 text-gray-900;
}

.feature-description {
    @apply text-gray-600 mb-4 leading-relaxed;
}

.feature-list {
    @apply list-disc pl-5 space-y-2 text-gray-600;
}
</style>
