<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    userResumes: Array,
    stats: Object,
});

const selectTemplate = (template) => {
    router.visit(route('resumes.create', { template: template.id }));
};

const duplicateResume = (resumeId) => {
    router.post(route('resumes.duplicate', resumeId));
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Resume Builder Dashboard
                </h2>
                <Link
                    :href="route('resumes.create')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                >
                    Create New Resume
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Total Resumes</div>
                            <div class="text-3xl font-bold text-blue-600">{{ props.stats.totalResumes }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Published</div>
                            <div class="text-3xl font-bold text-green-600">{{ props.stats.publishedResumes }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Drafts</div>
                            <div class="text-3xl font-bold text-yellow-600">{{ props.stats.draftResumes }}</div>
                        </div>
                    </div>
                </div>

                <!-- User Resumes Section -->
                <div v-if="props.userResumes.length > 0" class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Your Resumes</h3>
                        <Link
                            :href="route('resumes.index')"
                            class="text-blue-600 hover:text-blue-700 font-medium"
                        >
                            View All →
                        </Link>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="resume in props.userResumes.slice(0, 6)"
                            :key="resume.id"
                            class="bg-white rounded-lg shadow-sm border p-6 hover:shadow-md transition-shadow"
                        >
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ resume.title }}</h4>
                                <span
                                    :class="{
                                        'bg-green-100 text-green-800': resume.status === 'published',
                                        'bg-yellow-100 text-yellow-800': resume.status === 'draft',
                                        'bg-gray-100 text-gray-800': resume.status === 'archived'
                                    }"
                                    class="px-2 py-1 text-xs font-medium rounded-full"
                                >
                                    {{ resume.status }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">{{ resume.template.name }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Updated {{ formatDate(resume.updated_at) }}</span>
                                <div class="flex space-x-2">
                                    <Link
                                        :href="route('resumes.edit', resume.id)"
                                        class="text-blue-600 hover:text-blue-700"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        @click="duplicateResume(resume.id)"
                                        class="text-green-600 hover:text-green-700"
                                    >
                                        Duplicate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Categories Section -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Choose a Template</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div
                            v-for="category in props.categories"
                            :key="category.id"
                            class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition-shadow"
                        >
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <span class="text-2xl">{{ category.icon || '📄' }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-semibold text-gray-900">{{ category.name }}</h4>
                                        <p class="text-gray-600 text-sm">{{ category.description }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    <div
                                        v-for="template in category.templates.slice(0, 4)"
                                        :key="template.id"
                                        class="relative group cursor-pointer"
                                        @click="selectTemplate(template)"
                                    >
                                        <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden border-2 border-transparent group-hover:border-blue-300 transition-colors">
                                            <img
                                                v-if="template.thumbnail"
                                                :src="template.thumbnail_url"
                                                :alt="template.name"
                                                class="w-full h-full object-cover"
                                            />
                                            <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                                                <span class="text-4xl">📄</span>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg flex items-center justify-center">
                                            <span class="text-white font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                                Use Template
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">
                                        {{ category.templates.length }} templates available
                                    </span>
                                    <Link
                                        :href="route('templates.index', { category: category.slug })"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                    >
                                        View All →
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
