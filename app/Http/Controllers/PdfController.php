<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use App\Traits\ResumeTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PdfController extends Controller
{
    use ResumeTrait;

    protected PdfService $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Show PDF generation form
     *
     * @return \Inertia\Response
     */
    public function showGenerateForm()
    {
        return Inertia::render('PdfGenerator', [
            'defaultResumeData' => $this->getDefaultResumeStructure()
        ]);
    }

    /**
     * Generate and download PDF
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePdf(Request $request)
    {
        try {
            // Log the request for debugging
            Log::info('PDF generation request received', [
                'headers' => $request->headers->all(),
                'has_csrf_token' => $request->hasHeader('X-CSRF-TOKEN'),
                'session_id' => $request->session()->getId(),
                'user_agent' => $request->userAgent()
            ]);

            $request->validate([
                'resume_data' => 'required|array',
                'template' => 'string|in:default,professional,modern,creative',
                'filename' => 'nullable|string|max:255'
            ]);

            $resumeData = $request->input('resume_data');
            $template = $request->input('template', 'default');
            $filename = $request->input('filename');

            // Validate resume data structure
            if (!$this->validateResumeData($resumeData)) {
                abort(400, 'Invalid resume data structure');
            }

            Log::info('Generating PDF', [
                'template' => $template,
                'filename' => $filename,
                'data_keys' => array_keys($resumeData)
            ]);

            return $this->pdfService->downloadResumePdf($resumeData, $template, $filename);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('PDF validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('PDF generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview PDF without downloading
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function previewPdf(Request $request)
    {
        $request->validate([
            'resume_data' => 'required|array',
            'template' => 'string|in:default,professional,modern,creative'
        ]);

        $resumeData = $request->input('resume_data');
        $template = $request->input('template', 'default');

        if (!$this->validateResumeData($resumeData)) {
            abort(400, 'Invalid resume data structure');
        }

        try {
            $pdf = $this->pdfService->generateResumePdf($resumeData, $template);
            return $pdf->stream('resume-preview.pdf');
        } catch (\Exception $e) {
            abort(500, 'Failed to generate PDF preview: ' . $e->getMessage());
        }
    }

    /**
     * Get available PDF templates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTemplates()
    {
        $templates = [
            'default' => [
                'name' => 'Default Template',
                'description' => 'Clean and professional ATS-friendly template',
                'preview' => '/images/templates/default-preview.png'
            ],
            'professional' => [
                'name' => 'Professional Template',
                'description' => 'Traditional business-style template',
                'preview' => '/images/templates/professional-preview.png'
            ],
            'modern' => [
                'name' => 'Modern Template',
                'description' => 'Contemporary design with clean lines',
                'preview' => '/images/templates/modern-preview.png'
            ],
            'creative' => [
                'name' => 'Creative Template',
                'description' => 'Unique and creative design',
                'preview' => '/images/templates/creative-preview.png'
            ]
        ];

        return response()->json($templates);
    }
}
