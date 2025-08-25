<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resume;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $categories = Category::active()
            ->ordered()
            ->with(['templates' => function ($query) {
                $query->active()->ordered();
            }])
            ->get();

        $userResumes = $user ? $user->resumes()
            ->with('template')
            ->latest()
            ->get() : collect();

        return Inertia::render('Dashboard', [
            'categories' => $categories,
            'userResumes' => $userResumes,
            'stats' => [
                'totalResumes' => $userResumes->count(),
                'publishedResumes' => $userResumes->where('status', 'published')->count(),
                'draftResumes' => $userResumes->where('status', 'draft')->count(),
            ],
        ]);
    }
}
