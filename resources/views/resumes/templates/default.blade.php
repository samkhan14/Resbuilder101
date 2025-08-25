<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $personal_info['first_name'] ?? 'Resume' }} {{ $personal_info['last_name'] ?? '' }}</title>
    <style>
        @page {
            margin: 0.5in;
            size: A4 portrait;
        }

        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            line-height: 1.3;
            color: #000;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }

        .resume-container {
            max-width: 100%;
            background: white;
        }

        .resume-page {
            padding: 0;
            min-height: 11in;
            page-break-after: always;
        }

        .resume-page:last-child {
            page-break-after: avoid;
        }

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

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 1.5rem 0 0.75rem 0;
            color: #000;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 0.25rem;
        }

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

        .skills-section {
            margin-bottom: 1.5rem;
        }

        .skills-list {
            font-size: 10pt;
            margin: 0;
            color: #000;
        }

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

        .languages-section {
            margin-bottom: 1rem;
        }

        .languages-list {
            font-size: 10pt;
            margin: 0;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="resume-container">
        <!-- Page 1 -->
        <div class="resume-page">
            <!-- Header Section -->
            <div class="header-section">
                <div class="left-header">
                    <h1 class="name">{{ $personal_info['first_name'] ?? '' }} {{ $personal_info['last_name'] ?? '' }}
                    </h1>
                    <h2 class="title">{{ $personal_info['title'] ?? 'Web Developer' }}</h2>
                </div>
                <div class="right-header">
                    <div class="contact-info">
                        @if (isset($personal_info['email']))
                            <p>{{ $personal_info['email'] }}</p>
                        @endif
                        @if (isset($personal_info['linkedin']))
                            <p>{{ $personal_info['linkedin'] }}</p>
                        @endif
                        @if (isset($personal_info['github']))
                            <p>{{ $personal_info['github'] }}</p>
                        @endif
                        @if (isset($personal_info['phone']))
                            <p>{{ $personal_info['phone'] }}</p>
                        @endif
                        @if (isset($personal_info['location']))
                            <p>{{ $personal_info['location'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            @if (!empty($summary))
                <div class="summary-section">
                    <p class="summary-text">{{ $summary }}</p>
                </div>
            @endif

            <!-- Work Experience Section -->
            @if (!empty($experience))
                <div class="experience-section">
                    <h3 class="section-title">Work Experience</h3>

                    @foreach ($experience as $exp)
                        <div class="experience-item">
                            <div class="experience-header">
                                <div class="job-info">
                                    <h4 class="job-title">{{ $exp['job_title'] ?? '' }}</h4>
                                    <p class="company">{{ $exp['company'] ?? '' }}</p>
                                </div>
                                <div class="dates">
                                    {{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}
                                </div>
                            </div>
                            @if (!empty($exp['description']))
                                <p class="job-description">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Projects Section -->
            @if (!empty($projects))
                <div class="projects-section">
                    <h3 class="section-title">Projects</h3>

                    @foreach ($projects as $project)
                        <div class="project-item">
                            <h4 class="project-title">{{ $project['title'] ?? '' }}</h4>
                            @if (!empty($project['description']))
                                <p class="project-description">{{ $project['description'] }}</p>
                            @endif
                            @if (!empty($project['technologies']))
                                <p class="project-tech"><strong>Technologies:</strong> {{ $project['technologies'] }}
                                </p>
                            @endif
                            @if (!empty($project['features']))
                                <p class="project-features"><strong>Features:</strong> {{ $project['features'] }}</p>
                            @endif
                            @if (!empty($project['status']))
                                <p class="project-status">{{ $project['status'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Page 2 -->
        <div class="resume-page">
            <!-- Core Skills Section -->
            @if (!empty($skills))
                <div class="skills-section">
                    <h3 class="section-title">Core Skills</h3>
                    <p class="skills-list">{{ implode(', ', $skills) }}</p>
                </div>
            @endif

            <!-- Education Section -->
            @if (!empty($education))
                <div class="education-section">
                    <h3 class="section-title">Education</h3>

                    @foreach ($education as $edu)
                        <div class="education-item">
                            <div class="education-header">
                                <div class="education-info">
                                    <h4 class="institution">{{ $edu['institution'] ?? '' }}</h4>
                                    <p class="degree">{{ $edu['degree'] ?? '' }}</p>
                                </div>
                                @if (!empty($edu['completion_date']))
                                    <div class="completion-date">{{ $edu['completion_date'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Languages Section -->
            @if (!empty($languages))
                <div class="languages-section">
                    <h3 class="section-title">Languages</h3>
                    <p class="languages-list">{{ implode(', ', $languages) }}</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
