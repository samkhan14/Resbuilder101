<template>
    <Head title="Platform Credentials" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Platform Credentials
                </h2>
                <p class="text-sm text-gray-600">
                    Manage your login credentials for automated resume syncing
                </p>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Success/Error Messages -->
                <div v-if="message" class="mb-6">
                    <div :class="messageType === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'"
                         class="px-4 py-3 rounded border">
                        {{ message }}
                    </div>
                </div>

                <!-- Platform Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="platform in Object.keys(supportedPlatforms)" :key="platform"
                         class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <!-- Platform Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ supportedPlatforms[platform].name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            {{ supportedPlatforms[platform].description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span v-if="getCredentialForPlatform(platform)"
                                          :class="getCredentialForPlatform(platform).is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                          class="px-2 py-1 text-xs font-medium rounded-full">
                                        {{ getCredentialForPlatform(platform).is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span v-else class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        Not Set
                                    </span>
                                </div>
                            </div>

                            <!-- Platform Features -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="feature in supportedPlatforms[platform].features" :key="feature"
                                          class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                        {{ feature.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button v-if="!getCredentialForPlatform(platform)"
                                        @click="openAddModal(platform)"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Add Credentials
                                </button>
                                <button v-else
                                        @click="openEditModal(platform)"
                                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Edit Credentials
                                </button>
                                <button v-if="getCredentialForPlatform(platform)"
                                        @click="toggleCredential(getCredentialForPlatform(platform))"
                                        :class="getCredentialForPlatform(platform).is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700'"
                                        class="px-3 py-2 text-white rounded-md text-sm font-medium transition-colors">
                                    {{ getCredentialForPlatform(platform).is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button v-if="getCredentialForPlatform(platform)"
                                        @click="deleteCredential(getCredentialForPlatform(platform))"
                                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Security Notice
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>
                                    Your credentials are encrypted and stored securely. They are only used for automated resume syncing
                                    and are never shared with third parties. You can delete your credentials at any time.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Credentials Modal -->
        <TransitionRoot as="template" :show="showModal">
            <Dialog as="div" class="relative z-50" @close="closeModal">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div>
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v-2.25H4.5v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                            {{ isEditing ? 'Edit' : 'Add' }} {{ selectedPlatform ? supportedPlatforms[selectedPlatform]?.name : '' }} Credentials
                                        </DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Enter your login credentials for automated resume syncing.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <form @submit.prevent="saveCredentials" class="mt-5 sm:mt-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" id="email" v-model="form.email" required
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" id="password" v-model="form.password" required
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="platform_user_id" class="block text-sm font-medium text-gray-700">
                                                Platform User ID (Optional)
                                            </label>
                                            <input type="text" id="platform_user_id" v-model="form.platform_user_id"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">
                                                Your username or ID on the platform (if different from email)
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <button type="submit" :disabled="saving"
                                                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 sm:col-start-2 disabled:opacity-50">
                                            {{ saving ? 'Saving...' : (isEditing ? 'Update' : 'Save') }}
                                        </button>
                                        <button type="button" @click="closeModal"
                                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const props = defineProps({
    credentials: Array,
    supportedPlatforms: Object,
})

const showModal = ref(false)
const isEditing = ref(false)
const selectedPlatform = ref(null)
const saving = ref(false)
const message = ref('')
const messageType = ref('success')

const form = ref({
    platform: '',
    email: '',
    password: '',
    platform_user_id: '',
})

const getCredentialForPlatform = (platform) => {
    return props.credentials.find(cred => cred.platform === platform)
}

const openAddModal = (platform) => {
    selectedPlatform.value = platform
    isEditing.value = false
    form.value = {
        platform: platform,
        email: '',
        password: '',
        platform_user_id: '',
    }
    showModal.value = true
}

const openEditModal = (platform) => {
    const credential = getCredentialForPlatform(platform)
    if (credential) {
        selectedPlatform.value = platform
        isEditing.value = true
        form.value = {
            platform: platform,
            email: credential.credentials.email,
            password: credential.credentials.password,
            platform_user_id: credential.platform_user_id || '',
        }
        showModal.value = true
    }
}

const closeModal = () => {
    showModal.value = false
    selectedPlatform.value = null
    isEditing.value = false
    form.value = {
        platform: '',
        email: '',
        password: '',
        platform_user_id: '',
    }
}

const saveCredentials = async () => {
    saving.value = true
    try {
        const url = isEditing.value
            ? `/credentials/${getCredentialForPlatform(selectedPlatform.value).id}`
            : '/credentials'

        const method = isEditing.value ? 'put' : 'post'

        const response = await fetch(url, {
            method: method.toUpperCase(),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(form.value),
        })

        const data = await response.json()

        if (data.success) {
            message.value = data.message
            messageType.value = 'success'
            closeModal()
            router.reload()
        } else {
            message.value = data.message
            messageType.value = 'error'
        }
    } catch (error) {
        message.value = 'An error occurred while saving credentials'
        messageType.value = 'error'
    } finally {
        saving.value = false
    }
}

const toggleCredential = async (credential) => {
    try {
        const response = await fetch(`/credentials/${credential.id}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })

        const data = await response.json()

        if (data.success) {
            message.value = data.message
            messageType.value = 'success'
            router.reload()
        } else {
            message.value = data.message
            messageType.value = 'error'
        }
    } catch (error) {
        message.value = 'An error occurred while updating credentials'
        messageType.value = 'error'
    }
}

const deleteCredential = async (credential) => {
    if (confirm(`Are you sure you want to delete your ${credential.platform} credentials?`)) {
        try {
            const response = await fetch(`/credentials/${credential.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })

            const data = await response.json()

            if (data.success) {
                message.value = data.message
                messageType.value = 'success'
                router.reload()
            } else {
                message.value = data.message
                messageType.value = 'error'
            }
        } catch (error) {
            message.value = 'An error occurred while deleting credentials'
            messageType.value = 'error'
        }
    }
}

// Clear message after 5 seconds
const clearMessage = () => {
    setTimeout(() => {
        message.value = ''
    }, 5000)
}

// Watch for message changes
import { watch } from 'vue'
watch(message, (newMessage) => {
    if (newMessage) {
        clearMessage()
    }
})
</script>
