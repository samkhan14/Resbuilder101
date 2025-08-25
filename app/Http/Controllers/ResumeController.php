<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ResumeController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $resumes = $user->resumes()
            ->with('template')
            ->latest()
            ->paginate(12);

        return Inertia::render('Resumes/Index', [
            'resumes' => $resumes,
        ]);
    }

    public function create(Request $request)
    {
        $template = null;
        if ($request->has('template')) {
            $template = Template::findOrFail($request->template);
        }

        $availableTemplates = Template::with('category')
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return Inertia::render('ResumeEditor', [
            'resume' => null,
            'template' => $template,
            'availableTemplates' => $availableTemplates,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'personal_info.first_name' => 'required|string|max:255',
            'personal_info.last_name' => 'required|string|max:255',
            'personal_info.email' => 'required|email|max:255',
            'personal_info.phone' => 'nullable|string|max:255',
            'personal_info.location' => 'nullable|string|max:255',
            'personal_info.website' => 'nullable|url|max:255',
            'summary' => 'nullable|string|max:1000',
            'experience' => 'array',
            'experience.*.job_title' => 'required|string|max:255',
            'experience.*.company' => 'required|string|max:255',
            'experience.*.start_date' => 'nullable|string',
            'experience.*.end_date' => 'nullable|string',
            'experience.*.description' => 'nullable|string|max:1000',
            'education' => 'array',
            'education.*.degree' => 'required|string|max:255',
            'education.*.institution' => 'required|string|max:255',
            'education.*.field_of_study' => 'nullable|string|max:255',
            'education.*.graduation_year' => 'nullable|integer|min:1900|max:2030',
            'skills' => 'array',
            'skills.*' => 'string|max:255',
            'status' => 'required|in:draft,published,archived',
        ]);

        $user = $request->user();

        // For now, use a default template. Later, this will come from the form
        $defaultTemplate = Template::first();

        if (!$defaultTemplate) {
            return back()->withErrors(['template' => 'No templates available. Please contact administrator.']);
        }

        $resume = $user->resumes()->create([
            'template_id' => $defaultTemplate->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'content_data' => [
                'personal_info' => $request->personal_info,
                'summary' => $request->summary,
                'experience' => $request->experience ?? [],
                'education' => $request->education ?? [],
                'skills' => $request->skills ?? [],
                'projects' => [],
                'languages' => [],
            ],
            'settings' => [
                'colors' => [
                    'primary' => '#3B82F6',
                    'secondary' => '#6B7280',
                    'accent' => '#10B981',
                ],
                'fonts' => [
                    'heading' => 'Inter',
                    'body' => 'Inter',
                ],
            ],
            'last_edited_at' => now(),
        ]);

        return redirect()->route('resumes.edit', $resume)
            ->with('success', 'Resume created successfully!');
    }

    public function show(Request $request, Resume $resume): Response
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Resumes/Show', [
            'resume' => $resume->load('template'),
        ]);
    }

    public function edit(Request $request, Resume $resume): Response
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('ResumeEditor', [
            'resume' => $resume,
            'template' => $resume->template,
        ]);
    }

    public function update(Request $request, Resume $resume)
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'personal_info.first_name' => 'required|string|max:255',
            'personal_info.last_name' => 'required|string|max:255',
            'personal_info.email' => 'required|email|max:255',
            'personal_info.phone' => 'nullable|string|max:255',
            'personal_info.location' => 'nullable|string|max:255',
            'personal_info.website' => 'nullable|url|max:255',
            'summary' => 'nullable|string|max:1000',
            'experience' => 'array',
            'experience.*.job_title' => 'required|string|max:255',
            'experience.*.company' => 'required|string|max:255',
            'experience.*.start_date' => 'nullable|string',
            'experience.*.end_date' => 'nullable|string',
            'experience.*.description' => 'nullable|string|max:1000',
            'education' => 'array',
            'education.*.degree' => 'required|string|max:255',
            'education.*.institution' => 'required|string|max:255',
            'education.*.field_of_study' => 'nullable|string|max:255',
            'education.*.graduation_year' => 'nullable|integer|min:1900|max:2030',
            'skills' => 'array',
            'skills.*' => 'string|max:255',
            'status' => 'required|in:draft,published,archived',
        ]);

        $resume->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'content_data' => [
                'personal_info' => $request->personal_info,
                'summary' => $request->summary,
                'experience' => $request->experience ?? [],
                'education' => $request->education ?? [],
                'skills' => $request->skills ?? [],
                'projects' => $resume->content_data['projects'] ?? [],
                'languages' => $resume->content_data['languages'] ?? [],
            ],
            'last_edited_at' => now(),
        ]);

        return back()->with('success', 'Resume updated successfully!');
    }

    public function destroy(Request $request, Resume $resume)
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $resume->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Resume deleted successfully!');
    }

    public function duplicate(Request $request, Resume $resume)
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $newResume = $resume->replicate();
        $newResume->title = $resume->title . ' (Copy)';
        $newResume->slug = Str::slug($resume->title . ' copy ' . time());
        $newResume->status = 'draft';
        $newResume->created_at = now();
        $newResume->updated_at = now();
        $newResume->last_edited_at = now();
        $newResume->save();

        return back()->with('success', 'Resume duplicated successfully!');
    }

    public function download(Request $request, Resume $resume)
    {
        // Check if user owns this resume
        if ($resume->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $format = $request->input('format', 'pdf');

        // For now, return a simple response. Later, implement actual PDF/DOCX generation
        if ($format === 'pdf') {
            return response()->json([
                'message' => 'PDF download will be implemented soon',
                'resume_id' => $resume->id,
            ]);
        }

        if ($format === 'docx') {
            return response()->json([
                'message' => 'DOCX download will be implemented soon',
                'resume_id' => $resume->id,
            ]);
        }

        return response()->json(['error' => 'Invalid format'], 400);
    }
}
