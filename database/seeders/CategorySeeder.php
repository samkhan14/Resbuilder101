<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'ATS-Friendly',
                'slug' => 'ats-friendly',
                'description' => 'Optimized for Applicant Tracking Systems with clean, simple layouts',
                'icon' => '🎯',
                'display_order' => 1,
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'Contemporary designs with bold typography and clean spacing',
                'icon' => '✨',
                'display_order' => 2,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Traditional business layouts perfect for corporate environments',
                'icon' => '💼',
                'display_order' => 3,
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'description' => 'Unique designs for creative industries and portfolios',
                'icon' => '🎨',
                'display_order' => 4,
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'description' => 'Clean, simple designs focusing on content over decoration',
                'icon' => '⚪',
                'display_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
