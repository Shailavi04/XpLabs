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
            'banner' => BannerController::class,
            'vision' => VisionController::class,
            'about-us' => AboutusController::class,
            'professional' => ProfessionalController::class,
            'why-choose-us' => WhyChooseUsController::class,
            'instructor' => InstructorController::class,
            'companies' => CompaniesController::class,
            'certificate' => CertificateController::class,
            'join' => JoinCommunityController::class,
            'testimonial' => TestimonialController::class,
            'contact-us' => ContactUsController::class,
            'faq' => FAQController::class,
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
