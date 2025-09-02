<template>
    <Head title="Activity & Sync Logs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Activity & Sync Logs
                </h2>
                <p class="text-sm text-gray-600">
                    Monitor your resume sync activities and system logs
                </p>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Sync Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Syncs</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ syncStats.total_syncs }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Successful</p>
                                    <p class="text-2xl font-semibold text-green-600">{{ syncStats.successful_syncs }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Failed</p>
                                    <p class="text-2xl font-semibold text-red-600">{{ syncStats.failed_syncs }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Pending</p>
                                    <p class="text-2xl font-semibold text-yellow-600">{{ syncStats.pending_syncs }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Processing</p>
                                    <p class="text-2xl font-semibold text-blue-600">{{ syncStats.processing_syncs }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button @click="activeTab = 'sync'"
                                    :class="activeTab === 'sync' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Sync Logs
                            </button>
                            <button @click="activeTab = 'activity'"
                                    :class="activeTab === 'activity' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Activity Logs
                            </button>
                        </nav>
                    </div>

                    <div class="p-6">
                        <!-- Sync Logs Tab -->
                        <div v-if="activeTab === 'sync'" class="space-y-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Recent Sync Operations</h3>
                                <div class="flex space-x-2">
                                    <select v-model="syncFilter.platform" @change="filterSyncLogs"
                                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">All Platforms</option>
                                        <option value="linkedin">LinkedIn</option>
                                        <option value="naukri">Naukri</option>
                                        <option value="gulftalent">GulfTalent</option>
                                        <option value="indeed">Indeed</option>
                                    </select>
                                    <select v-model="syncFilter.status" @change="filterSyncLogs"
                                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">All Status</option>
                                        <option value="success">Success</option>
                                        <option value="failed">Failed</option>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                    </select>
                                </div>
                            </div>

                            <div v-if="filteredSyncLogs.length > 0" class="space-y-3">
                                <div v-for="log in filteredSyncLogs" :key="log.id"
                                     class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <span :class="getStatusColor(log.status)"
                                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                    {{ log.status }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ log.resume?.title || 'Unknown Resume' }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ log.platform }} • {{ formatDate(log.created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">
                                                {{ log.sync_method || 'automation' }}
                                            </p>
                                            <p v-if="log.execution_time" class="text-xs text-gray-400">
                                                {{ log.execution_time }}s
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="log.error_message" class="mt-2 p-2 bg-red-50 border border-red-200 rounded text-sm text-red-700">
                                        {{ log.error_message }}
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-8 text-gray-500">
                                No sync logs found
                            </div>
                        </div>

                        <!-- Activity Logs Tab -->
                        <div v-if="activeTab === 'activity'" class="space-y-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Recent Activities</h3>
                            </div>

                            <div v-if="activityLogs.length > 0" class="space-y-3">
                                <div v-for="log in activityLogs" :key="log.id"
                                     class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ log.description }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ formatDate(log.created_at) }}
                                            </p>
                                            <div v-if="log.event" class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ log.event }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-8 text-gray-500">
                                No activity logs found
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    activityLogs: Array,
    syncLogs: Array,
    syncStats: Object,
})

const activeTab = ref('sync')
const syncFilter = ref({
    platform: '',
    status: '',
})

const filteredSyncLogs = computed(() => {
    let logs = props.syncLogs || []

    if (syncFilter.value.platform) {
        logs = logs.filter(log => log.platform === syncFilter.value.platform)
    }

    if (syncFilter.value.status) {
        logs = logs.filter(log => log.status === syncFilter.value.status)
    }

    return logs
})

const getStatusColor = (status) => {
    const colors = {
        success: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        manual_required: 'bg-gray-100 text-gray-800',
    }
    return colors[status] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
    if (!dateString) return 'Unknown'
    const date = new Date(dateString)
    return date.toLocaleString()
}

const filterSyncLogs = () => {
    // The computed property will automatically update
}
</script>
