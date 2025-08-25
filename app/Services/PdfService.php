<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    /**
     * Generate PDF from resume data
     *
     * @param array $resumeData
     * @param string $template
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateResumePdf(array $resumeData, string $template = 'default'): \Barryvdh\DomPDF\PDF
    {
        $html = $this->generateResumeHtml($resumeData, $template);

        return PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'dpi' => 150,
                'defaultMediaType' => 'screen',
                'isFontSubsettingEnabled' => true,
            ]);
    }

    /**
     * Generate HTML content for resume
     *
     * @param array $resumeData
     * @param string $template
     * @return string
     */
    protected function generateResumeHtml(array $resumeData, string $template): string
    {
        $viewData = $this->prepareResumeData($resumeData);

        return view("resumes.templates.{$template}", $viewData)->render();
    }

    /**
     * Prepare resume data for view
     *
     * @param array $resumeData
     * @return array
     */
    protected function prepareResumeData(array $resumeData): array
    {
        return [
            'personal_info' => $resumeData['personal_info'] ?? [],
            'summary' => $resumeData['summary'] ?? '',
            'experience' => $resumeData['experience'] ?? [],
            'education' => $resumeData['education'] ?? [],
            'skills' => $resumeData['skills'] ?? [],
            'projects' => $resumeData['projects'] ?? [],
            'languages' => $resumeData['languages'] ?? [],
        ];
    }

    /**
     * Download PDF with custom filename
     *
     * @param array $resumeData
     * @param string $template
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadResumePdf(array $resumeData, string $template = 'default', string $filename = null): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generateResumePdf($resumeData, $template);

        $filename = $filename ?: $this->generateDefaultFilename($resumeData);

        return $pdf->download($filename);
    }

    /**
     * Generate default filename for resume
     *
     * @param array $resumeData
     * @return string
     */
    protected function generateDefaultFilename(array $resumeData): string
    {
        $name = $resumeData['personal_info']['first_name'] ?? 'Resume';
        $name .= '_' . ($resumeData['personal_info']['last_name'] ?? '');

        return trim($name) . '_' . date('Y-m-d') . '.pdf';
    }
}
