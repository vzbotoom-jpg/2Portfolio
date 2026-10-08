<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->ordered()->get();
        return view('pages.services', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$service) {
            throw new NotFoundHttpException("Service not found.");
        }

        $allServices = Service::active()->ordered()->get();
        return view('pages.service-detail', compact('service', 'allServices'));
    }
}