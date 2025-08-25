<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!-- Background overlay -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>

      <!-- Modal panel -->
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
        <!-- Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">
              Template Preview: {{ template?.name }}
            </h3>
            <button
              @click="closeModal"
              class="text-gray-400 hover:text-gray-600 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <p class="text-sm text-gray-600 mt-1">{{ template?.description }}</p>
        </div>

        <!-- Content -->
        <div class="px-6 py-4">
          <div class="template-preview-container">
            <div
              class="template-preview"
              v-html="previewHtml"
            ></div>
          </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex justify-end space-x-3">
            <button
              @click="closeModal"
              class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors"
            >
              Close
            </button>
            <button
              @click="selectTemplate"
              class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
            >
              Use This Template
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  isOpen: Boolean,
  template: Object,
})

const emit = defineEmits(['close', 'select-template'])

const closeModal = () => {
  emit('close')
}

const selectTemplate = () => {
  emit('select-template', props.template)
  closeModal()
}

const previewHtml = computed(() => {
  if (!props.template) return ''

  const css = props.template.css_content
  const sampleData = {
    name: 'John Doe',
    title: 'Web Developer',
    email: 'john.doe@email.com',
    phone: '+1 (555) 123-4567',
    location: 'San Francisco, CA',
    website: 'linkedin.com/in/johndoe',
    summary: 'Experienced web developer with expertise in modern web technologies including React, Vue.js, Laravel, and Node.js. Passionate about creating user-friendly applications and solving complex problems.',
    experience: [
      {
        job_title: 'Senior Web Developer',
        company: 'Tech Company Inc.',
        start_date: 'Jan 2022',
        end_date: 'Present',
        description: 'Lead development of multiple web applications using React and Node.js. Mentored junior developers and implemented best practices.'
      },
      {
        job_title: 'Web Developer',
        company: 'Startup XYZ',
        start_date: 'Mar 2020',
        end_date: 'Dec 2021',
        description: 'Developed responsive web applications using Vue.js and Laravel. Collaborated with design team to implement user interfaces.'
      }
    ],
    education: [
      {
        degree: 'Bachelor of Science',
        field_of_study: 'Computer Science',
        institution: 'University of Technology',
        graduation_year: '2020'
      }
    ],
    skills: ['JavaScript', 'React', 'Vue.js', 'Laravel', 'Node.js', 'MySQL', 'Git', 'Docker']
  }

  // Generate HTML with sample data
  let html = `
    <div class="resume-${props.template.slug}">
      <div class="header">
        <h1 class="name">${sampleData.name}</h1>
        <p class="title">${sampleData.title}</p>
        <div class="contact-info">
          <span>${sampleData.email}</span>
          <span>${sampleData.phone}</span>
          <span>${sampleData.location}</span>
        </div>
      </div>

      <div class="summary">
        <h2>Professional Summary</h2>
        <p>${sampleData.summary}</p>
      </div>

      <div class="experience">
        <h2>Work Experience</h2>
        ${sampleData.experience.map(exp => `
          <div class="exp-item">
            <div class="exp-header">
              <h3>${exp.job_title}</h3>
              <span class="company">${exp.company}</span>
              <span class="dates">${exp.start_date} - ${exp.end_date}</span>
            </div>
            <p class="description">${exp.description}</p>
          </div>
        `).join('')}
      </div>

      <div class="education">
        <h2>Education</h2>
        ${sampleData.education.map(edu => `
          <div class="edu-item">
            <h3>${edu.degree}</h3>
            <p>${edu.institution} - ${edu.graduation_year}</p>
          </div>
        `).join('')}
      </div>

      <div class="skills">
        <h2>Skills</h2>
        <p>${sampleData.skills.join(", ")}</p>
      </div>
    </div>
  `

  return `<style>${css}</style>${html}`
})
</script>

<style scoped>
.template-preview-container {
  max-height: 70vh;
  overflow-y: auto;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
}

.template-preview {
  padding: 1rem;
  background: white;
}
</style>
