<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Template;
use App\Models\User;
use App\Models\Resume;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total_users' => User::count(),
            'total_resumes' => Resume::count(),
            'total_templates' => Template::count(),
            'total_categories' => Category::count(),
        ];

        $recent_resumes = Resume::with('user', 'template')
            ->latest()
            ->take(5)
            ->get();

        $recent_users = User::latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_resumes' => $recent_resumes,
            'recent_users' => $recent_users,
        ]);
    }

    public function templates()
    {
        $templates = Template::with('category')
            ->orderBy('display_order')
            ->get();

        return Inertia::render('Admin/Templates', [
            'templates' => $templates,
        ]);
    }

    public function categories()
    {
        $categories = Category::withCount('templates')
            ->orderBy('display_order')
            ->get();

        return Inertia::render('Admin/Categories', [
            'categories' => $categories,
        ]);
    }

    public function users()
    {
        $users = User::withCount('resumes')
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }
}
