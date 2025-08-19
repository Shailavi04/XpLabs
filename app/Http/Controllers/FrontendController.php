<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebsiteController\AboutusController;
use App\Http\Controllers\WebsiteController\BannerController;
use App\Http\Controllers\WebsiteController\CertificateController;
use App\Http\Controllers\WebsiteController\CompaniesController;
use App\Http\Controllers\WebsiteController\ContactUsController;
use App\Http\Controllers\WebsiteController\FAQController;
use App\Http\Controllers\WebsiteController\InstructorController;
use App\Http\Controllers\WebsiteController\JoinCommunityController;
use App\Http\Controllers\WebsiteController\ProfessionalControler;
use App\Http\Controllers\WebsiteController\ProfessionalController;
use App\Http\Controllers\WebsiteController\TestimonialController;
use App\Http\Controllers\WebsiteController\VisionController;
use App\Http\Controllers\WebsiteController\WhyChooseUsController;
use App\Models\frontend_elements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\ViewNotFoundSolutionProvider;

class FrontendController extends Controller
{

    public function index()
    {
        $sections = frontend_elements::pluck('section_key');

        return view('frontend.index', compact('sections'));
    }

    public function showSection(string $key)
    {
        $key = strtolower(trim(preg_replace('/\s+/', ' ', $key)));

        $controllerMap = [
            'banner section' => BannerController::class,
            'vision section' => VisionController::class,
            'about us section' => AboutusController::class,
            'professional section' => ProfessionalController::class,
            'why choose us section' => WhyChooseUsController::class,
            'instructor section' => InstructorController::class,
            'companies section' => CompaniesController::class,
            'certificate section' => CertificateController::class,
            'join section' => JoinCommunityController::class,
            'testimonial section' => TestimonialController::class,
            'contact us section' => ContactUsController::class,
            'faq section' => FAQController::class,
        ];

        if (isset($controllerMap[$key])) {
            return app($controllerMap[$key])->index();
        }

        $section = frontend_elements::where('section_key', $key)->firstOrFail();

        $data = json_decode($section->data, true);
        $viewPath = "admin.sections.{$key}.index";

        if (!view()->exists($viewPath)) {
            abort(404, "View for section '{$key}' not found.");
        }

        return view($viewPath, compact('data'));
    }
}
