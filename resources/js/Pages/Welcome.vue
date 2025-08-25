<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: 'admin@admin.com',
    password: 'admin@123',
})

const login = () => {
    form.post(route('login'))
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

        <!-- Main Content -->
        <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <!-- Header -->
                <div class="text-center">
                    <div class="mx-auto h-20 w-20 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl mb-6">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">
                        Resume Builder
                    </h1>
                    <p class="text-xl text-gray-600">
                        Create professional, ATS-friendly resumes
                    </p>
                </div>

                <!-- Login Form -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8">
                    <form @submit.prevent="login" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                placeholder="Enter your email"
                            />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                v-model="form.password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                placeholder="Enter your password"
                            />
                        </div>

                        <div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:transform-none"
                            >
                                <span v-if="form.processing" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Signing in...
                                </span>
                                <span v-else>Sign In</span>
                            </button>
                        </div>
                    </form>

                    <!-- Demo Credentials -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500 mb-3">Demo Account</p>
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 border border-blue-100">
                                <div class="text-sm text-gray-700 space-y-1">
                                    <p><span class="font-semibold">Email:</span> <span class="font-mono text-blue-600">admin@admin.com</span></p>
                                    <p><span class="font-semibold">Password:</span> <span class="font-mono text-purple-600">admin@123</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-grid-pattern {
    background-image:
        linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
    background-size: 20px 20px;
}
</style>
