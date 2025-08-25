<template>
  <div class="resume-container">
    <!-- PDF Conversion Button -->
    <div class="pdf-controls">
      <button
        @click="generatePdf"
        :disabled="isGeneratingPdf"
        class="pdf-button"
      >
        <span v-if="isGeneratingPdf" class="flex items-center">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Generating PDF...
        </span>
        <span v-else class="flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Download PDF
        </span>
      </button>
    </div>

    <!-- Page 1 -->
    <div class="resume-page">
      <!-- Header Section -->
      <div class="header-section">
        <div class="left-header">
          <h1 class="name">{{ resumeData.personal_info.name }}</h1>
          <h2 class="title">{{ resumeData.personal_info.title }}</h2>
        </div>
        <div class="right-header">
          <div class="contact-info">
            <p v-for="contact in resumeData.contact_info" :key="contact.type">
              {{ contact.value }}
            </p>
          </div>
        </div>
      </div>

      <!-- Summary Section -->
      <div class="summary-section" v-if="resumeData.summary">
        <p class="summary-text">{{ resumeData.summary }}</p>
      </div>

      <!-- Work Experience Section -->
      <div class="experience-section" v-if="resumeData.experience.length > 0">
        <h3 class="section-title">Work Experience</h3>

        <div
          v-for="(exp, index) in resumeData.experience"
          :key="index"
          class="experience-item"
        >
          <div class="experience-header">
            <div class="job-info">
              <h4 class="job-title">{{ exp.job_title }}</h4>
              <p class="company">{{ exp.company }}</p>
            </div>
            <div class="dates">{{ formatDateRange(exp.start_date, exp.end_date) }}</div>
          </div>
          <p class="job-description">{{ exp.description }}</p>
        </div>
      </div>

      <!-- Projects Section -->
      <div class="projects-section" v-if="resumeData.projects.length > 0">
        <h3 class="section-title">Projects</h3>

        <div
          v-for="(project, index) in resumeData.projects"
          :key="index"
          class="project-item"
        >
          <h4 class="project-title">{{ project.title }}</h4>
          <p class="project-description">{{ project.description }}</p>
          <p class="project-tech"><strong>Technologies:</strong> {{ project.technologies }}</p>
          <p class="project-features"><strong>Features:</strong> {{ project.features }}</p>
          <p class="project-status">{{ project.status }}</p>
        </div>
      </div>
    </div>

    <!-- Page 2 -->
    <div class="resume-page">
      <!-- Additional Experience Section -->
      <div class="experience-section" v-if="resumeData.additional_experience?.length > 0">
        <div
          v-for="(exp, index) in resumeData.additional_experience"
          :key="index"
          class="experience-item"
        >
          <div class="experience-header">
            <div class="job-info">
              <h4 class="job-title">{{ exp.job_title }}</h4>
            </div>
            <div class="dates">{{ exp.dates }}</div>
          </div>
          <p class="job-description">{{ exp.description }}</p>
        </div>
      </div>

      <!-- Core Skills Section -->
      <div class="skills-section" v-if="resumeData.skills.length > 0">
        <h3 class="section-title">Core Skills</h3>
        <p class="skills-list">{{ resumeData.skills.join(', ') }}</p>
      </div>

      <!-- Education Section -->
      <div class="education-section" v-if="resumeData.education.length > 0">
        <h3 class="section-title">Education</h3>

        <div
          v-for="(edu, index) in resumeData.education"
          :key="index"
          class="education-item"
        >
          <div class="education-header">
            <div class="education-info">
              <h4 class="institution">{{ edu.institution }}</h4>
              <p class="degree">{{ edu.degree }}</p>
            </div>
            <div class="completion-date">{{ edu.completion_date }}</div>
          </div>
        </div>
      </div>

      <!-- Languages Section -->
      <div class="languages-section" v-if="resumeData.languages.length > 0">
        <h3 class="section-title">Languages</h3>
        <p class="languages-list">{{ resumeData.languages.join(', ') }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

// Reactive state
const isGeneratingPdf = ref(false)

// Resume data structure - DRY approach
const resumeData = computed(() => ({
  personal_info: {
    name: 'SUMAIM AHMED',
    title: 'Web Developer'
  },
  contact_info: [
    { type: 'email', value: 'sumaimahmed@gmail.com' },
    { type: 'linkedin', value: 'https://www.linkedin.com/in/sumaim-ahmed/' },
    { type: 'github', value: 'https://github.com/samkhan14' },
    { type: 'phone', value: '+92 342 261 9541' },
    { type: 'location', value: 'Karachi, Pakistan' }
  ],
  summary: 'Web Developer skilled in frontend and backend with HTML, CSS, JavaScript, React.js, Vue.js, PHP, Laravel, WordPress, MySQL, and CI/CD. Experienced in building responsive, user-friendly applications and improving systems to deliver quality solutions that support business growth.',
  experience: [
    {
      job_title: 'PHP Laravel Developer',
      company: 'Sleekhive Technologies | Karachi',
      start_date: 'Jul 2023',
      end_date: 'Present',
      description: 'Details responsibilities including developing CRMs, client portals, payment systems using Laravel, Inertia, Vue.js, implementing AI integrations and chatbot systems, managing cPanel deployments, resolving production issues, and utilizing Git with CI/CD.'
    },
    {
      job_title: 'PHP Laravel Developer',
      company: 'Softvira Inc | Karachi',
      start_date: 'Oct 2022',
      end_date: 'Jun 2023',
      description: 'Mentions work on Core PHP, Laravel, and WordPress projects, including a US notarization system and custom web solutions.'
    },
    {
      job_title: 'WordPress Developer',
      company: 'Agency Partner Interactive',
      start_date: 'Apr 2021',
      end_date: 'Sep 2022',
      description: 'Describes developing numerous WordPress projects (theme-based and custom), handling deployment and maintenance, and contributing to Laravel-based applications.'
    },
    {
      job_title: 'WordPress Developer',
      company: 'ABTACH LTD | Karachi, Pakistan',
      start_date: 'Jan 2019',
      end_date: 'Feb 2021',
      description: 'Details extensive work on WordPress projects, cPanel deployments, revision management, and delivering custom solutions with HTML, CSS, and Bootstrap for frontend development.'
    }
  ],
  projects: [
    {
      title: 'Inhouse TickTick - Project Management System',
      description: 'An internal project management platform.',
      technologies: 'Laravel & React.js.',
      features: 'Task assignment, project creation, category-wise management, role-based access, and various other functionalities.',
      status: 'Present'
    },
    {
      title: 'Law Assignments - Academic/LMS Portal',
      description: 'An academic assistance and document management platform.',
      technologies: 'WordPress + Laravel backend.',
      features: 'Client dashboards, order workflows, and secure file handling for students and professionals.',
      status: 'Present'
    },
    {
      title: 'Apocom Kitchen - Restaurant Ordering Platform',
      description: 'A restaurant food ordering and management system.',
      technologies: 'Laravel, Bootstrap, and MySQL.',
      features: 'Menu management, secure checkout, and a responsive interface for seamless online ordering.',
      status: 'Present'
    },
    {
      title: 'TreeNewal - Service Business Website',
      description: 'A professional tree care service website.',
      technologies: 'WordPress custom themes.',
      features: 'SEO optimization, enhanced performance, mobile responsiveness, and lead generation for local business growth.',
      status: 'Present'
    },
    {
      title: 'Dentalax - German Healthcare Platform',
      description: 'A multi-role platform for dentists to subscribe to paid packages and receive individual SEO-optimized landing pages.',
      technologies: 'Laravel + Bootstrap.',
      features: 'Appointment booking, subscription management, and profile customization with dashboard management.',
      status: 'Present'
    },
    {
      title: 'D4 Drivers - Healthcare/Testing Platform',
      description: 'A medical testing and driver certification platform.',
      technologies: 'Laravel & WordPress.',
      features: 'Managed deployment, integrations, and optimization for reliable performance and compliance.',
      status: 'Present'
    },
    {
      title: 'Kogents AI - SaaS Platform',
      description: 'An AI-driven SaaS application.',
      technologies: 'Laravel, Vue.js, and AI integrations.',
      features: 'Enhanced automation workflows and intelligent chatbot features.',
      status: 'Present'
    }
  ],
  additional_experience: [
    {
      job_title: 'D4 Drivers - Healthcare/Testing Platform',
      dates: 'Present',
      description: 'Contributed to a medical testing and driver certification platform built on Laravel & WordPress. Managed deployment, integrations, and optimization for reliable performance and compliance.'
    },
    {
      job_title: 'Kogents AI - SaaS Platform',
      dates: 'Present',
      description: 'Worked on an AI-driven SaaS application using Laravel, Vue.js, and AI integrations. Enhanced automation workflows and contributed to intelligent chatbot features.'
    },
    {
      job_title: 'Knox PV - E-commerce Store',
      dates: 'Present',
      description: 'Built a renewable energy products e-commerce platform with WordPress + WooCommerce. Implemented product catalog, secure payments, and order tracking for a smooth customer experience.'
    }
  ],
  skills: ['JS', 'HTML5/CSS3', 'Bootstrap', 'WordPress Customization', 'WordPress Page Builders', 'PHP/MYSQL', 'Laravel', 'React Js', 'Git', 'Vue Js', 'Automations', 'AI Integrations', 'CI CD'],
  education: [
    {
      institution: 'Aptech Computer Education',
      degree: 'Advanced Diploma in Software Engineering (ACCP PRO) Software Engineering',
      completion_date: 'Dec 2019'
    },
    {
      institution: 'Karachi Board',
      degree: 'Intermediate Commerce',
      completion_date: 'Dec 2011'
    },
    {
      institution: 'Karachi Board',
      degree: 'Matriculation Science',
      completion_date: 'Dec 2009'
    }
  ],
  languages: ['English', 'Urdu']
}))

// Methods - DRY approach
const formatDateRange = (startDate, endDate) => {
  if (!startDate) return 'Present'
  if (!endDate || endDate === 'Present') return `${startDate} - Present`
  return `${startDate} - ${endDate}`
}

const generatePdf = async () => {
  try {
    isGeneratingPdf.value = true

    // Get CSRF token from meta tag or cookie
    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    // If meta tag doesn't exist, try to get from cookie
    if (!csrfToken) {
      csrfToken = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1]

      if (csrfToken) {
        csrfToken = decodeURIComponent(csrfToken)
      }
    }

    if (!csrfToken) {
      throw new Error('CSRF token not found. Please refresh the page and try again.')
    }

    // Prepare resume data for PDF generation
    const pdfData = {
      resume_data: resumeData.value,
      template: 'default',
      filename: `SUMAIM_AHMED_Resume_${new Date().toISOString().split('T')[0]}.pdf`
    }

    // Send request to generate PDF
    const response = await fetch(route('pdf.generate-pdf'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/pdf'
      },
      body: JSON.stringify(pdfData)
    })

    if (response.ok) {
      // Create blob and download
      const blob = await response.blob()
      const url = window.URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = url
      a.download = pdfData.filename
      document.body.appendChild(a)
      a.click()
      window.URL.revokeObjectURL(url)
      document.body.removeChild(a)

      // Show success message
      alert('PDF generated successfully!')
    } else {
      const errorText = await response.text()
      console.error('PDF generation failed:', response.status, errorText)

      if (response.status === 419) {
        throw new Error('Session expired. Please refresh the page and try again.')
      } else if (response.status === 422) {
        throw new Error('Invalid data. Please check your resume information.')
      } else {
        throw new Error(`Failed to generate PDF (${response.status}). Please try again.`)
      }
    }
  } catch (error) {
    console.error('PDF generation error:', error)
    alert(error.message || 'Failed to generate PDF. Please try again.')
  } finally {
    isGeneratingPdf.value = false
  }
}
</script>

<style scoped>
/* Resume Container */
.resume-container {
  max-width: 8.5in;
  margin: 0 auto;
  background: white;
  font-family: 'Calibri', 'Arial', sans-serif !important;
  line-height: 1.3;
  color: #000;
  font-size: 11pt;
  position: relative;
}

/* PDF Controls */
.pdf-controls {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1000;
}

.pdf-button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  font-size: 14px;
}

.pdf-button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.pdf-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Resume Page */
.resume-page {
  padding: 0.5in;
  min-height: 11in;
  page-break-after: always;
}

.resume-page:last-child {
  page-break-after: avoid;
}

/* Header Section */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
}

.left-header {
  flex: 1;
}

.name {
  font-size: 24pt;
  font-weight: bold;
  margin: 0 0 0.25rem 0;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  line-height: 1.1;
}

.title {
  font-size: 14pt;
  font-weight: 600;
  margin: 0;
  color: #000;
}

.right-header {
  text-align: right;
  flex: 0 0 auto;
}

.contact-info p {
  margin: 0.1rem 0;
  font-size: 10pt;
  color: #000;
  line-height: 1.2;
}

/* Summary Section */
.summary-section {
  margin-bottom: 1.5rem;
}

.summary-text {
  font-size: 11pt;
  line-height: 1.4;
  margin: 0;
  text-align: left;
  color: #000;
}

/* Section Titles */
.section-title {
  font-size: 12pt;
  font-weight: bold;
  margin: 1.5rem 0 0.75rem 0;
  color: #000;
  text-transform: uppercase;
  border-bottom: 1px solid #000;
  padding-bottom: 0.25rem;
}

/* Experience Section */
.experience-section {
  margin-bottom: 1.5rem;
}

.experience-item {
  margin-bottom: 1rem;
}

.experience-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.25rem;
}

.job-info {
  flex: 1;
}

.job-title {
  font-size: 11pt;
  font-weight: bold;
  margin: 0 0 0.1rem 0;
  color: #000;
}

.company {
  font-size: 10pt;
  font-weight: 600;
  margin: 0;
  color: #000;
}

.dates {
  font-size: 10pt;
  font-weight: 600;
  color: #000;
  text-align: right;
  flex: 0 0 auto;
  margin-left: 1rem;
}

.job-description {
  font-size: 10pt;
  line-height: 1.3;
  margin: 0;
  text-align: left;
  color: #000;
}

/* Projects Section */
.projects-section {
  margin-bottom: 1.5rem;
}

.project-item {
  margin-bottom: 1rem;
  padding: 0;
  border: none;
  background: transparent;
}

.project-title {
  font-size: 11pt;
  font-weight: bold;
  margin: 0 0 0.25rem 0;
  color: #000;
}

.project-description {
  font-size: 10pt;
  margin: 0 0 0.25rem 0;
  color: #000;
}

.project-tech {
  font-size: 10pt;
  margin: 0 0 0.1rem 0;
  color: #000;
}

.project-features {
  font-size: 10pt;
  margin: 0 0 0.25rem 0;
  color: #000;
}

.project-status {
  font-size: 9pt;
  font-weight: bold;
  color: #000;
  margin: 0;
}

/* Skills Section */
.skills-section {
  margin-bottom: 1.5rem;
}

.skills-list {
  font-size: 10pt;
  margin: 0;
  color: #000;
}

/* Education Section */
.education-section {
  margin-bottom: 1.5rem;
}

.education-item {
  margin-bottom: 0.75rem;
}

.education-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.education-info {
  flex: 1;
}

.institution {
  font-size: 11pt;
  font-weight: bold;
  margin: 0 0 0.1rem 0;
  color: #000;
}

.degree {
  font-size: 10pt;
  margin: 0;
  color: #000;
}

.completion-date {
  font-size: 10pt;
  font-weight: 600;
  color: #000;
  text-align: right;
  flex: 0 0 auto;
  margin-left: 1rem;
}

/* Languages Section */
.languages-section {
  margin-bottom: 1rem;
}

.languages-list {
  font-size: 10pt;
  margin: 0;
  color: #000;
}

/* Print Styles */
@media print {
  .pdf-controls {
    display: none;
  }

  .resume-container {
    max-width: none;
    margin: 0;
  }

  .resume-page {
    padding: 0.5in;
    min-height: auto;
    page-break-after: always;
  }

  .resume-page:last-child {
    page-break-after: avoid;
  }
}
</style>

