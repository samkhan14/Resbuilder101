<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link
                    :href="route('dashboard')"
                    class="text-gray-600 hover:text-gray-900"
                >
                    ← Back to Dashboard
                </Link>
                <div class="h-6 w-px bg-gray-300"></div>
                <h1 class="text-xl font-semibold text-gray-900">
                    {{ isEditing ? 'Edit Resume' : 'Create New Resume' }}
                </h1>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Template Selection (only show when creating new resume) -->
                <div v-if="!isEditing && !template" class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Choose a Template</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div
                            v-for="templateOption in availableTemplates"
                            :key="templateOption.id"
                            @click="selectTemplate(templateOption)"
                            class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-md transition-all"
                            :class="{ 'border-blue-500 bg-blue-50': selectedTemplateId === templateOption.id }"
                        >
                            <div class="text-center">
                                <!-- Template Preview Image -->
                                <div class="w-full h-40 bg-white rounded mb-3 flex items-center justify-center border border-gray-200 overflow-hidden">
                                    <div class="w-full h-full p-3">
                                        <!-- ATS Classic 1 Col Format Template -->
                                        <div v-if="templateOption.slug === 'ats-classic-1-col-format'" class="w-full h-full bg-white">
                                            <div class="text-center border-b-2 border-black pb-2 mb-3">
                                                <div class="text-lg font-bold text-black uppercase">John Doe</div>
                                                <div class="text-xs text-black space-y-1">
                                                    <div>john.doe@email.com</div>
                                                    <div>+1 (555) 123-4567</div>
                                                    <div>San Francisco, CA</div>
                                                </div>
                                            </div>
                                            <div class="text-left space-y-2">
                                                <div class="border-b border-black pb-1">
                                                    <div class="text-sm font-bold uppercase">Professional Summary</div>
                                                </div>
                                                <div class="border-b border-black pb-1">
                                                    <div class="text-sm font-bold uppercase">Experience</div>
                                                </div>
                                                <div class="border-b border-black pb-1">
                                                    <div class="text-sm font-bold uppercase">Education</div>
                                                </div>
                                                <div class="border-b border-black pb-1">
                                                    <div class="text-sm font-bold uppercase">Skills</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ATS Modern 1 Col Format Template -->
                                        <div v-else-if="templateOption.slug === 'ats-modern-1-col-format'" class="w-full h-full bg-white">
                                            <div class="text-center border-b-3 border-blue-600 pb-3 mb-3">
                                                <div class="text-xl font-bold text-blue-600 uppercase tracking-wide">John Doe</div>
                                                <div class="text-xs text-gray-600 space-y-1">
                                                    <div class="flex justify-center gap-6">
                                                        <span>john.doe@email.com</span>
                                                        <span>+1 (555) 123-4567</span>
                                                    </div>
                                                    <div class="flex justify-center gap-6">
                                                        <span>San Francisco, CA</span>
                                                        <span>linkedin.com/in/johndoe</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-left space-y-2">
                                                <div class="border-b-2 border-gray-200 pb-1">
                                                    <div class="text-sm font-bold text-blue-600 uppercase tracking-wide">Professional Summary</div>
                                                </div>
                                                <div class="border-b-2 border-gray-200 pb-1">
                                                    <div class="text-sm font-bold text-blue-600 uppercase tracking-wide">Experience</div>
                                                </div>
                                                <div class="border-b-2 border-gray-200 pb-1">
                                                    <div class="text-sm font-bold text-blue-600 uppercase tracking-wide">Education</div>
                                                </div>
                                                <div class="border-b-2 border-gray-200 pb-1">
                                                    <div class="text-sm font-bold text-blue-600 uppercase tracking-wide">Skills</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ATS Executive 1 Col Format Template -->
                                        <div v-else-if="templateOption.slug === 'ats-executive-1-col-format'" class="w-full h-full bg-white">
                                            <div class="text-center border-b-4 border-blue-800 pb-4 mb-3">
                                                <div class="text-2xl font-bold text-blue-800 uppercase tracking-widest">John Doe</div>
                                                <div class="text-xs text-gray-700 grid grid-cols-2 gap-2 mt-2">
                                                    <div class="text-left"><strong>Email:</strong> john.doe@email.com</div>
                                                    <div class="text-left"><strong>Phone:</strong> +1 (555) 123-4567</div>
                                                    <div class="text-left"><strong>Location:</strong> San Francisco, CA</div>
                                                    <div class="text-left"><strong>LinkedIn:</strong> linkedin.com/in/johndoe</div>
                                                </div>
                                            </div>
                                            <div class="text-left space-y-2">
                                                <div class="border-b-3 border-gray-200 pb-2">
                                                    <div class="text-sm font-bold text-blue-800 uppercase tracking-wide">Executive Summary</div>
                                                </div>
                                                <div class="border-b-3 border-gray-200 pb-2">
                                                    <div class="text-sm font-bold text-blue-800 uppercase tracking-wide">Experience</div>
                                                </div>
                                                <div class="border-b-3 border-gray-200 pb-2">
                                                    <div class="text-sm font-bold text-blue-800 uppercase tracking-wide">Education</div>
                                                </div>
                                                <div class="border-b-3 border-gray-200 pb-2">
                                                    <div class="text-sm font-bold text-blue-800 uppercase tracking-wide">Core Competencies</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ATS Minimal 1 Col Format Template -->
                                        <div v-else-if="templateOption.slug === 'ats-minimal-1-col-format'" class="w-full h-full bg-white">
                                            <div class="text-center border-b border-black pb-3 mb-3">
                                                <div class="text-lg font-bold text-black uppercase">John Doe</div>
                                                <div class="text-xs text-black">
                                                    <div>john.doe@email.com | +1 (555) 123-4567 | San Francisco, CA</div>
                                                </div>
                                            </div>
                                            <div class="text-left space-y-2">
                                                <div class="border-b border-gray-300 pb-1">
                                                    <div class="text-sm font-bold uppercase">Summary</div>
                                                </div>
                                                <div class="border-b border-gray-300 pb-1">
                                                    <div class="text-sm font-bold uppercase">Experience</div>
                                                </div>
                                                <div class="border-b border-gray-300 pb-1">
                                                    <div class="text-sm font-bold uppercase">Education</div>
                                                </div>
                                                <div class="border-b border-gray-300 pb-1">
                                                    <div class="text-sm font-bold uppercase">Skills</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Default Template Preview -->
                                        <div v-else class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                            <div class="text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div class="text-xs">Template Preview</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="font-medium text-gray-900">{{ templateOption.name }}</h4>
                                <p class="text-sm text-gray-600">{{ templateOption.description }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ATS-Friendly
                                    </span>
                                    <button
                                        @click.stop="openPreview(templateOption)"
                                        class="inline-flex items-center px-3 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors"
                                    >
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Info -->
                <div v-if="currentTemplate" class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-blue-900">Selected Template: {{ currentTemplate.name }}</h3>
                            <p class="text-sm text-blue-700">{{ currentTemplate.description }}</p>
                        </div>
                        <button
                            v-if="!isEditing"
                            @click="changeTemplate"
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium"
                        >
                            Change Template
                        </button>
                    </div>
                </div>

                <div class="flex justify-end mb-6">
                    <div class="flex items-center space-x-3">
                        <button
                            @click="saveDraft"
                            :disabled="saving || !isFormValid"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors disabled:opacity-50"
                        >
                            <span v-if="saving">Saving...</span>
                            <span v-else>Save Draft</span>
                        </button>
                        <button
                            @click="publishResume"
                            :disabled="saving || !isFormValid"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors disabled:opacity-50"
                        >
                            <span v-if="saving">Publishing...</span>
                            <span v-else>Publish Resume</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Form Section -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <div class="space-y-6">
                            <!-- Resume Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Resume Title *
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="e.g., Software Engineer Resume"
                                />
                                <p v-if="errors.title" class="mt-1 text-sm text-red-600">
                                    {{ errors.title }}
                                </p>
                            </div>

                            <!-- Personal Information -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name *
                                        </label>
                                        <input
                                            v-model="form.personal_info.first_name"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="John"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name *
                                        </label>
                                        <input
                                            v-model="form.personal_info.last_name"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Doe"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Job Title *
                                        </label>
                                        <input
                                            v-model="form.personal_info.title"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Web Developer"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Email *
                                        </label>
                                        <input
                                            v-model="form.personal_info.email"
                                            type="email"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="john.doe@email.com"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone
                                        </label>
                                        <input
                                            v-model="form.personal_info.phone"
                                            type="tel"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="+1 (555) 123-4567"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Location
                                        </label>
                                        <input
                                            v-model="form.personal_info.location"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="San Francisco, CA"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            LinkedIn / Portfolio
                                        </label>
                                        <input
                                            v-model="form.personal_info.website"
                                            type="url"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="https://linkedin.com/in/johndoe"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Summary -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Summary</h3>
                                <textarea
                                    v-model="form.summary"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Write a compelling summary of your professional background, key skills, and career objectives..."
                                ></textarea>
                            </div>

                            <!-- Work Experience -->
                            <div class="border-t pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Work Experience</h3>
                                    <button
                                        @click="addExperience"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                    >
                                        + Add Experience
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div
                                        v-for="(experience, index) in form.experience"
                                        :key="index"
                                        class="border border-gray-200 rounded-lg p-4"
                                    >
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="font-medium text-gray-900">Experience {{ index + 1 }}</h4>
                                            <button
                                                @click="removeExperience(index)"
                                                class="text-red-600 hover:text-red-700 text-sm"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Job Title *
                                                </label>
                                                <input
                                                    v-model="experience.job_title"
                                                    type="text"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Software Engineer"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Company *
                                                </label>
                                                <input
                                                    v-model="experience.company"
                                                    type="text"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Tech Company Inc."
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Start Date
                                                </label>
                                                <input
                                                    v-model="experience.start_date"
                                                    type="month"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    End Date
                                                </label>
                                                <input
                                                    v-model="experience.end_date"
                                                    type="month"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                />
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Description
                                                </label>
                                                <textarea
                                                    v-model="experience.description"
                                                    rows="3"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Describe your responsibilities and achievements..."
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="border-t pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Education</h3>
                                    <button
                                        @click="addEducation"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                    >
                                        + Add Education
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div
                                        v-for="(education, index) in form.education"
                                        :key="index"
                                        class="border border-gray-200 rounded-lg p-4"
                                    >
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="font-medium text-gray-900">Education {{ index + 1 }}</h4>
                                            <button
                                                @click="removeEducation(index)"
                                                class="text-red-600 hover:text-red-700 text-sm"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Degree *
                                                </label>
                                                <input
                                                    v-model="education.degree"
                                                    type="text"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Bachelor of Science"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Field of Study
                                                </label>
                                                <input
                                                    v-model="education.field_of_study"
                                                    type="text"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Computer Science"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Institution *
                                                </label>
                                                <input
                                                    v-model="education.institution"
                                                    type="text"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="University Name"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Graduation Year
                                                </label>
                                                <input
                                                    v-model="education.graduation_year"
                                                    type="number"
                                                    min="1900"
                                                    max="2030"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="2020"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Skills</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-2">
                                        <input
                                            v-model="newSkill"
                                            @keyup.enter="addSkill"
                                            type="text"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Add a skill (e.g., JavaScript, Project Management)"
                                        />
                                        <button
                                            @click="addSkill"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Add
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="(skill, index) in form.skills"
                                            :key="index"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800"
                                        >
                                            {{ skill }}
                                            <button
                                                @click="removeSkill(index)"
                                                class="ml-2 text-blue-600 hover:text-blue-800"
                                            >
                                                ×
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Live Preview</h3>
                            <div class="flex space-x-2">
                                <button
                                    @click="downloadPDF"
                                    :disabled="downloading"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors disabled:opacity-50"
                                >
                                    <span v-if="downloading">Generating...</span>
                                    <span v-else>Download PDF</span>
                                </button>
                                <button
                                    @click="downloadDOCX"
                                    :disabled="downloading"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors disabled:opacity-50"
                                >
                                    <span v-if="downloading">Generating...</span>
                                    <span v-else>Download DOCX</span>
                                </button>
                            </div>
                        </div>

                        <!-- Resume Preview with Template Styling -->
                        <div v-if="currentTemplate" class="resume-preview-container">
                            <div
                                class="resume-preview"
                                v-html="renderedResume"
                            ></div>
                        </div>

                        <!-- No Template Selected Message -->
                        <div v-else class="text-center py-12 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Select a Template</h3>
                            <p class="text-gray-600">Choose a template above to see your resume preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Template Preview Modal -->
        <TemplatePreviewModal
            :is-open="previewModalOpen"
            :template="previewTemplate"
            @close="closePreview"
            @select-template="selectTemplateFromPreview"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import TemplatePreviewModal from '@/Components/TemplatePreviewModal.vue'

const props = defineProps({
    resume: Object,
    template: Object,
    errors: Object,
    availableTemplates: Array,
})

const saving = ref(false)
const downloading = ref(false)
const newSkill = ref('')
const selectedTemplateId = ref(props.template?.id || null)
const currentTemplate = ref(props.template || null)
const previewModalOpen = ref(false)
const previewTemplate = ref(null)

const form = useForm({
    title: props.resume?.title || 'Untitled Resume',
    template_id: props.template?.id || null,
    personal_info: {
        first_name: props.resume?.personal_info?.first_name || 'John',
        last_name: props.resume?.personal_info?.last_name || 'Doe',
        title: props.resume?.personal_info?.title || 'Web Developer',
        email: props.resume?.personal_info?.email || 'john.doe@email.com',
        phone: props.resume?.personal_info?.phone || '+1 (555) 123-4567',
        location: props.resume?.personal_info?.location || 'San Francisco, CA',
        website: props.resume?.personal_info?.website || 'linkedin.com/in/johndoe',
    },
    summary: props.resume?.summary || 'Experienced web developer with expertise in modern web technologies including React, Vue.js, Laravel, and Node.js. Passionate about creating user-friendly applications and solving complex problems.',
    experience: props.resume?.experience || [
        {
            job_title: 'Senior Web Developer',
            company: 'Tech Company Inc.',
            start_date: 'Jan 2022',
            end_date: 'Present',
            description: 'Lead development of multiple web applications using React and Node.js. Mentored junior developers and implemented best practices.',
        }
    ],
    education: props.resume?.education || [
        {
            degree: 'Bachelor of Science',
            field_of_study: 'Computer Science',
            institution: 'University of Technology',
            graduation_year: '2020',
        }
    ],
    skills: props.resume?.skills || ['JavaScript', 'React', 'Vue.js', 'Laravel', 'Node.js', 'MySQL', 'Git', 'Docker'],
})

const isEditing = computed(() => !!props.resume)

const isFormValid = computed(() => {
    return form.title &&
           form.personal_info.first_name &&
           form.personal_info.last_name &&
           form.personal_info.email &&
           (isEditing.value || selectedTemplateId.value)
})

const renderedResume = computed(() => {
    if (!currentTemplate.value) return ''

    const css = currentTemplate.value.css_content

    // Debug: Log form data
    console.log('Form data for preview:', {
        personal_info: form.personal_info,
        summary: form.summary,
        experience: form.experience,
        education: form.education,
        skills: form.skills
    })

    // Generate HTML directly instead of trying to replace template variables
    let html = `
        <div class="resume-${currentTemplate.value.slug}">
            <div class="header">
                <h1 class="name">${form.personal_info.first_name || 'First Name'} ${form.personal_info.last_name || 'Last Name'}</h1>
                <p class="title">${form.personal_info.title || 'Job Title'}</p>
                <div class="contact-info">
                    <span>${form.personal_info.email || 'email@example.com'}</span>
                    <span>${form.personal_info.phone || 'Phone Number'}</span>
                    <span>${form.personal_info.location || 'Location'}</span>
                    ${form.personal_info.website ? `<span>${form.personal_info.website}</span>` : ''}
                </div>
            </div>

            ${form.summary ? `
                <div class="summary">
                    <h2>Professional Summary</h2>
                    <p>${form.summary}</p>
                </div>
            ` : ''}

            ${form.experience.length > 0 ? `
                <div class="experience">
                    <h2>Work Experience</h2>
                    ${form.experience.map(exp => `
                        <div class="exp-item">
                            <div class="exp-header">
                                <h3>${exp.job_title || 'Job Title'}</h3>
                                <span class="company">${exp.company || 'Company'}</span>
                                <span class="dates">${exp.start_date || 'Start Date'} - ${exp.end_date || 'Present'}</span>
                            </div>
                            ${exp.description ? `<p class="description">${exp.description}</p>` : ''}
                        </div>
                    `).join('')}
                </div>
            ` : ''}

            ${form.education.length > 0 ? `
                <div class="education">
                    <h2>Education</h2>
                    ${form.education.map(edu => `
                        <div class="edu-item">
                            <h3>${edu.degree || 'Degree'}</h3>
                            <p>${edu.institution || 'Institution'} - ${edu.graduation_year || 'Year'}</p>
                        </div>
                    `).join('')}
                </div>
            ` : ''}

            ${form.skills.length > 0 ? `
                <div class="skills">
                    <h2>Skills</h2>
                    <p>${form.skills.join(", ")}</p>
                </div>
            ` : ''}
        </div>
    `

    return `<style>${css}</style>${html}`
})

const openPreview = (template) => {
    previewTemplate.value = template
    previewModalOpen.value = true
}

const closePreview = () => {
    previewModalOpen.value = false
    previewTemplate.value = null
}

const selectTemplateFromPreview = (template) => {
    selectTemplate(template)
}

const selectTemplate = (template) => {
    selectedTemplateId.value = template.id
    form.template_id = template.id
    currentTemplate.value = template
}

const changeTemplate = () => {
    selectedTemplateId.value = null
    form.template_id = null
    currentTemplate.value = null
}

const addExperience = () => {
    form.experience.push({
        job_title: '',
        company: '',
        start_date: '',
        end_date: '',
        description: '',
    })
}

const removeExperience = (index) => {
    form.experience.splice(index, 1)
}

const addEducation = () => {
    form.education.push({
        degree: '',
        field_of_study: '',
        institution: '',
        graduation_year: '',
    })
}

const removeEducation = (index) => {
    form.education.splice(index, 1)
}

const addSkill = () => {
    if (newSkill.value.trim()) {
        form.skills.push(newSkill.value.trim())
        newSkill.value = ''
    }
}

const removeSkill = (index) => {
    form.skills.splice(index, 1)
}

const saveDraft = async () => {
    saving.value = true
    form.status = 'draft'

    if (isEditing.value) {
        await form.put(route('resumes.update', props.resume.id))
    } else {
        await form.post(route('resumes.store'))
    }

    saving.value = false
}

const publishResume = async () => {
    saving.value = true
    form.status = 'published'

    if (isEditing.value) {
        await form.put(route('resumes.update', props.resume.id))
    } else {
        await form.post(route('resumes.store'))
    }

    saving.value = false
}

const downloadPDF = async () => {
    downloading.value = true
    // Implement PDF download logic
    setTimeout(() => {
        downloading.value = false
    }, 2000)
}

const downloadDOCX = async () => {
    downloading.value = true
    // Implement DOCX download logic
    setTimeout(() => {
        downloading.value = false
    }, 2000)
}

onMounted(() => {
    // Auto-save draft every 30 seconds
    setInterval(() => {
        if (isFormValid.value && !saving.value) {
            saveDraft()
        }
    }, 30000)
})
</script>

<style scoped>
.resume-preview-container {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    overflow: hidden;
    background: white;
}

.resume-preview {
    min-height: 500px;
    padding: 1rem;
}

.resume-preview :deep(*) {
    font-family: inherit;
}
</style>
