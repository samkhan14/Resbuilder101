<?php

namespace App\Helpers;

class ResumeHelper
{
    /**
     * Format experience duration
     *
     * @param string $startDate
     * @param string|null $endDate
     * @return string
     */
    public static function formatExperienceDuration(string $startDate, ?string $endDate = null): string
    {
        if (!$endDate || $endDate === 'Present') {
            return self::formatDate($startDate) . ' - Present';
        }

        return self::formatDate($startDate) . ' - ' . self::formatDate($endDate);
    }

    /**
     * Format date for display
     *
     * @param string $date
     * @return string
     */
    public static function formatDate(string $date): string
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
     * Calculate experience years
     *
     * @param string $startDate
     * @param string|null $endDate
     * @return int
     */
    public static function calculateExperienceYears(string $startDate, ?string $endDate = null): int
    {
        try {
            $start = new \DateTime($startDate);
            $end = $endDate ? new \DateTime($endDate) : new \DateTime();

            $interval = $start->diff($end);
            return $interval->y;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Generate skills tags
     *
     * @param array $skills
     * @param int $maxTags
     * @return array
     */
    public static function generateSkillsTags(array $skills, int $maxTags = 10): array
    {
        $tags = [];
        $count = 0;

        foreach ($skills as $skill) {
            if ($count >= $maxTags) break;

            $tags[] = [
                'name' => $skill,
                'level' => self::getSkillLevel($skill),
                'category' => self::categorizeSkill($skill)
            ];

            $count++;
        }

        return $tags;
    }

    /**
     * Get skill level based on experience
     *
     * @param string $skill
     * @return string
     */
    protected static function getSkillLevel(string $skill): string
    {
        $advancedSkills = ['Laravel', 'Vue.js', 'React.js', 'MySQL', 'Git', 'CI/CD'];
        $intermediateSkills = ['PHP', 'JavaScript', 'HTML5', 'CSS3', 'WordPress'];

        if (in_array($skill, $advancedSkills)) {
            return 'Advanced';
        } elseif (in_array($skill, $intermediateSkills)) {
            return 'Intermediate';
        }

        return 'Basic';
    }

    /**
     * Categorize skill
     *
     * @param string $skill
     * @return string
     */
    protected static function categorizeSkill(string $skill): string
    {
        $categories = [
            'Frontend' => ['HTML5', 'CSS3', 'JavaScript', 'Vue.js', 'React.js', 'Bootstrap'],
            'Backend' => ['PHP', 'Laravel', 'MySQL'],
            'Tools' => ['Git', 'CI/CD', 'cPanel'],
            'CMS' => ['WordPress'],
            'AI' => ['AI Integrations', 'Automations']
        ];

        foreach ($categories as $category => $skills) {
            if (in_array($skill, $skills)) {
                return $category;
            }
        }

        return 'Other';
    }

    /**
     * Validate email format
     *
     * @param string $email
     * @return bool
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone format
     *
     * @param string $phone
     * @return bool
     */
    public static function isValidPhone(string $phone): bool
    {
        // Remove all non-digit characters
        $digits = preg_replace('/[^0-9]/', '', $phone);

        // Check if it has 10-15 digits (international format)
        return strlen($digits) >= 10 && strlen($digits) <= 15;
    }

    /**
     * Generate resume summary suggestions
     *
     * @param array $experience
     * @param array $skills
     * @return array
     */
    public static function generateSummarySuggestions(array $experience, array $skills): array
    {
        $suggestions = [];

        // Count years of experience
        $totalYears = 0;
        foreach ($experience as $exp) {
            $totalYears += self::calculateExperienceYears($exp['start_date'] ?? '', $exp['end_date'] ?? null);
        }

        if ($totalYears > 0) {
            $suggestions[] = "Experienced professional with {$totalYears}+ years of experience";
        }

        // Highlight key skills
        $keySkills = array_slice($skills, 0, 5);
        if (!empty($keySkills)) {
            $suggestions[] = "Skilled in " . implode(', ', $keySkills);
        }

        return $suggestions;
    }
}
