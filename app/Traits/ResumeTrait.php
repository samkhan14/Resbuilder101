<?php

namespace App\Traits;

trait ResumeTrait
{
    /**
     * Format date range for display
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return string
     */
    protected function formatDateRange(?string $startDate, ?string $endDate = null): string
    {
        if (!$startDate) {
            return 'Present';
        }

        $formattedStart = $this->formatDate($startDate);
        $formattedEnd = $endDate ? $this->formatDate($endDate) : 'Present';

        return "{$formattedStart} - {$formattedEnd}";
    }

    /**
     * Format date for display
     *
     * @param string $date
     * @return string
     */
    protected function formatDate(string $date): string
    {
        if (strlen($date) === 4) {
            return $date; // Year only
        }

        try {
            $dateObj = new \DateTime($date);
            return $dateObj->format('M Y');
        } catch (\Exception $e) {
            return $date;
        }
    }

    /**
     * Generate resume filename
     *
     * @param array $personalInfo
     * @param string $extension
     * @return string
     */
    protected function generateResumeFilename(array $personalInfo, string $extension = 'pdf'): string
    {
        $firstName = $personalInfo['first_name'] ?? 'Resume';
        $lastName = $personalInfo['last_name'] ?? '';

        $name = trim($firstName . ' ' . $lastName);
        $date = date('Y-m-d');

        return "{$name}_{$date}.{$extension}";
    }

    /**
     * Validate resume data structure
     *
     * @param array $data
     * @return bool
     */
    protected function validateResumeData(array $data): bool
    {
        $requiredSections = ['personal_info', 'summary', 'experience'];

        foreach ($requiredSections as $section) {
            if (!isset($data[$section])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Clean and sanitize resume text
     *
     * @param string $text
     * @return string
     */
    protected function sanitizeResumeText(string $text): string
    {
        return htmlspecialchars(trim($text), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get default resume structure
     *
     * @return array
     */
    protected function getDefaultResumeStructure(): array
    {
        return [
            'personal_info' => [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'location' => '',
                'website' => '',
                'linkedin' => '',
                'github' => '',
            ],
            'summary' => '',
            'experience' => [],
            'education' => [],
            'skills' => [],
            'projects' => [],
            'languages' => [],
        ];
    }
}
