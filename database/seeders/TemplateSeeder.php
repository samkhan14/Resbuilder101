<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\Category;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Get the ATS-Friendly category
        $atsCategory = Category::where('slug', 'ats-friendly')->first();

        if (!$atsCategory) {
            $this->command->error('ATS-Friendly category not found. Please run CategorySeeder first.');
            return;
        }

        $templates = [
            [
                'name' => 'ATS Modern 1 Col Format',
                'slug' => 'ats-modern-1-col-format',
                'description' => 'Modern single-column ATS-friendly resume template with clean design',
                'category_id' => $atsCategory->id,
                'is_ats_friendly' => true,
                'is_active' => true,
                'display_order' => 1,
                'html_content' => $this->getModernTemplateHtml(),
                'css_content' => $this->getModernTemplateCss(),
                'thumbnail' => 'templates/modern-ats-thumbnail.jpg'
            ],
            [
                'name' => 'ATS Classic 1 Col Format',
                'slug' => 'ats-classic-1-col-format',
                'description' => 'Classic single-column ATS-friendly resume template with traditional layout',
                'category_id' => $atsCategory->id,
                'is_ats_friendly' => true,
                'is_active' => true,
                'display_order' => 2,
                'html_content' => $this->getClassicTemplateHtml(),
                'css_content' => $this->getClassicTemplateCss(),
                'thumbnail' => 'templates/classic-ats-thumbnail.jpg'
            ],
            [
                'name' => 'ATS Executive 1 Col Format',
                'slug' => 'ats-executive-1-col-format',
                'description' => 'Executive single-column ATS-friendly resume template for senior professionals',
                'category_id' => $atsCategory->id,
                'is_ats_friendly' => true,
                'is_active' => true,
                'display_order' => 3,
                'html_content' => $this->getExecutiveTemplateHtml(),
                'css_content' => $this->getExecutiveTemplateCss(),
                'thumbnail' => 'templates/executive-ats-thumbnail.jpg'
            ],
            [
                'name' => 'ATS Minimal 1 Col Format',
                'slug' => 'ats-minimal-1-col-format',
                'description' => 'Minimalist single-column ATS-friendly resume template with clean typography',
                'category_id' => $atsCategory->id,
                'is_ats_friendly' => true,
                'is_active' => true,
                'display_order' => 4,
                'html_content' => $this->getMinimalTemplateHtml(),
                'css_content' => $this->getMinimalTemplateCss(),
                'thumbnail' => 'templates/minimal-ats-thumbnail.jpg'
            ]
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }

        $this->command->info('Templates seeded successfully!');
    }

    private function getModernTemplateHtml(): string
    {
        return '<div class="resume-modern">
            <div class="header">
                <h1 class="name">{{ personal_info.name }}</h1>
                <p class="title">{{ personal_info.title }}</p>
                <div class="contact-info">
                    <span>{{ personal_info.email }}</span>
                    <span>{{ personal_info.phone }}</span>
                    <span>{{ personal_info.location }}</span>
                </div>
            </div>

            <div class="summary" v-if="summary">
                <h2>Professional Summary</h2>
                <p>{{ summary }}</p>
            </div>

            <div class="experience" v-if="experience.length > 0">
                <h2>Work Experience</h2>
                <div v-for="exp in experience" class="exp-item">
                    <div class="exp-header">
                        <h3>{{ exp.job_title }}</h3>
                        <span class="company">{{ exp.company }}</span>
                        <span class="dates">{{ exp.start_date }} - {{ exp.end_date || "Present" }}</span>
                    </div>
                    <p class="description">{{ exp.description }}</p>
                </div>
            </div>

            <div class="education" v-if="education.length > 0">
                <h2>Education</h2>
                <div v-for="edu in education" class="edu-item">
                    <h3>{{ edu.degree }}</h3>
                    <p>{{ edu.institution }} - {{ edu.graduation_year }}</p>
                </div>
            </div>

            <div class="skills" v-if="skills.length > 0">
                <h2>Skills</h2>
                <p>{{ skills.join(", ") }}</p>
            </div>
        </div>';
    }

    private function getModernTemplateCss(): string
    {
        return '.resume-modern {
            font-family: Arial, sans-serif;
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            line-height: 1.4;
        }
        .header { text-align: center; margin-bottom: 1.5rem; }
        .name { font-size: 24pt; font-weight: bold; margin: 0 0 0.5rem 0; }
        .title { font-size: 14pt; color: #333; margin: 0 0 1rem 0; }
        .contact-info { font-size: 11pt; }
        .contact-info span { margin: 0 0.5rem; }
        h2 { font-size: 14pt; font-weight: bold; border-bottom: 2px solid #333; margin: 1.5rem 0 0.75rem 0; }
        .exp-item, .edu-item { margin-bottom: 1rem; }
        .exp-header { margin-bottom: 0.5rem; }
        .exp-header h3 { font-size: 12pt; font-weight: bold; margin: 0; }
        .company { font-weight: bold; }
        .dates { float: right; }
        .description { margin: 0.25rem 0; }';
    }

    private function getClassicTemplateHtml(): string
    {
        return '<div class="resume-classic">
            <div class="header">
                <h1 class="name">{{ personal_info.name }}</h1>
                <p class="title">{{ personal_info.title }}</p>
                <div class="contact-info">
                    <span>{{ personal_info.email }}</span>
                    <span>{{ personal_info.phone }}</span>
                    <span>{{ personal_info.location }}</span>
                </div>
            </div>

            <div class="summary" v-if="summary">
                <h2>Professional Summary</h2>
                <p>{{ summary }}</p>
            </div>

            <div class="experience" v-if="experience.length > 0">
                <h2>Work Experience</h2>
                <div v-for="exp in experience" class="exp-item">
                    <div class="exp-header">
                        <h3>{{ exp.job_title }}</h3>
                        <span class="company">{{ exp.company }}</span>
                        <span class="dates">{{ exp.start_date }} - {{ exp.end_date || "Present" }}</span>
                    </div>
                    <p class="description">{{ exp.description }}</p>
                </div>
            </div>

            <div class="education" v-if="education.length > 0">
                <h2>Education</h2>
                <div v-for="edu in education" class="edu-item">
                    <h3>{{ edu.degree }}</h3>
                    <p>{{ edu.institution }} - {{ edu.graduation_year }}</p>
                </div>
            </div>

            <div class="skills" v-if="skills.length > 0">
                <h2>Skills</h2>
                <p>{{ skills.join(", ") }}</p>
            </div>
        </div>';
    }

    private function getClassicTemplateCss(): string
    {
        return '.resume-classic {
            font-family: Times New Roman, serif;
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            line-height: 1.5;
        }
        .header { margin-bottom: 2rem; }
        .name { font-size: 22pt; font-weight: bold; margin: 0 0 0.5rem 0; }
        .title { font-size: 13pt; font-style: italic; margin: 0 0 1rem 0; }
        .contact-info { font-size: 11pt; }
        .contact-info span { margin: 0 0.75rem; }
        h2 { font-size: 13pt; font-weight: bold; margin: 1.5rem 0 0.75rem 0; }
        .exp-item, .edu-item { margin-bottom: 1.25rem; }
        .exp-header { margin-bottom: 0.5rem; }
        .exp-header h3 { font-size: 12pt; font-weight: bold; margin: 0; }
        .company { font-weight: bold; }
        .dates { float: right; }
        .description { margin: 0.25rem 0; }';
    }

    private function getExecutiveTemplateHtml(): string
    {
        return '<div class="resume-executive">
            <div class="header">
                <h1 class="name">{{ personal_info.name }}</h1>
                <p class="title">{{ personal_info.title }}</p>
                <div class="contact-info">
                    <span>{{ personal_info.email }}</span>
                    <span>{{ personal_info.phone }}</span>
                    <span>{{ personal_info.location }}</span>
                </div>
            </div>

            <div class="summary" v-if="summary">
                <h2>Executive Summary</h2>
                <p>{{ summary }}</p>
            </div>

            <div class="experience" v-if="experience.length > 0">
                <h2>Professional Experience</h2>
                <div v-for="exp in experience" class="exp-item">
                    <div class="exp-header">
                        <h3>{{ exp.job_title }}</h3>
                        <span class="company">{{ exp.company }}</span>
                        <span class="dates">{{ exp.start_date }} - {{ exp.end_date || "Present" }}</span>
                    </div>
                    <p class="description">{{ exp.description }}</p>
                </div>
            </div>

            <div class="education" v-if="education.length > 0">
                <h2>Education</h2>
                <div v-for="edu in education" class="edu-item">
                    <h3>{{ edu.degree }}</h3>
                    <p>{{ edu.institution }} - {{ edu.graduation_year }}</p>
                </div>
            </div>

            <div class="skills" v-if="skills.length > 0">
                <h2>Core Competencies</h2>
                <p>{{ skills.join(", ") }}</p>
            </div>
        </div>';
    }

    private function getExecutiveTemplateCss(): string
    {
        return '.resume-executive {
            font-family: Georgia, serif;
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            line-height: 1.6;
        }
        .header { text-align: center; margin-bottom: 2rem; }
        .name { font-size: 26pt; font-weight: bold; margin: 0 0 0.5rem 0; }
        .title { font-size: 15pt; color: #555; margin: 0 0 1rem 0; }
        .contact-info { font-size: 11pt; }
        .contact-info span { margin: 0 0.5rem; }
        h2 { font-size: 14pt; font-weight: bold; border-bottom: 3px solid #333; margin: 2rem 0 1rem 0; }
        .exp-item, .edu-item { margin-bottom: 1.5rem; }
        .exp-header { margin-bottom: 0.75rem; }
        .exp-header h3 { font-size: 13pt; font-weight: bold; margin: 0; }
        .company { font-weight: bold; }
        .dates { float: right; }
        .description { margin: 0.5rem 0; }';
    }

    private function getMinimalTemplateHtml(): string
    {
        return '<div class="resume-minimal">
            <div class="header">
                <h1 class="name">{{ personal_info.name }}</h1>
                <p class="title">{{ personal_info.title }}</p>
                <div class="contact-info">
                    <span>{{ personal_info.email }}</span>
                    <span>{{ personal_info.phone }}</span>
                    <span>{{ personal_info.location }}</span>
                </div>
            </div>

            <div class="summary" v-if="summary">
                <h2>Summary</h2>
                <p>{{ summary }}</p>
            </div>

            <div class="experience" v-if="experience.length > 0">
                <h2>Experience</h2>
                <div v-for="exp in experience" class="exp-item">
                    <div class="exp-header">
                        <h3>{{ exp.job_title }}</h3>
                        <span class="company">{{ exp.company }}</span>
                        <span class="dates">{{ exp.start_date }} - {{ exp.end_date || "Present" }}</span>
                    </div>
                    <p class="description">{{ exp.description }}</p>
                </div>
            </div>

            <div class="education" v-if="education.length > 0">
                <h2>Education</h2>
                <div v-for="edu in education" class="edu-item">
                    <h3>{{ edu.degree }}</h3>
                    <p>{{ edu.institution }} - {{ edu.graduation_year }}</p>
                </div>
            </div>

            <div class="skills" v-if="skills.length > 0">
                <h2>Skills</h2>
                <p>{{ skills.join(", ") }}</p>
            </div>
        </div>';
    }

    private function getMinimalTemplateCss(): string
    {
        return '.resume-minimal {
            font-family: Helvetica, Arial, sans-serif;
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            line-height: 1.4;
        }
        .header { margin-bottom: 1.5rem; }
        .name { font-size: 20pt; font-weight: 300; margin: 0 0 0.25rem 0; }
        .title { font-size: 12pt; color: #666; margin: 0 0 1rem 0; }
        .contact-info { font-size: 10pt; }
        .contact-info span { margin: 0 0.5rem; }
        h2 { font-size: 12pt; font-weight: 600; margin: 1.5rem 0 0.75rem 0; }
        .exp-item, .edu-item { margin-bottom: 1rem; }
        .exp-header { margin-bottom: 0.5rem; }
        .exp-header h3 { font-size: 11pt; font-weight: 600; margin: 0; }
        .company { font-weight: 500; }
        .dates { float: right; color: #666; }
        .description { margin: 0.25rem 0; }';
    }
}
