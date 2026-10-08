<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    //public function __construct()
   // {
    //    $this->middleware(['auth', 'admin']);
    //}

    public function index()
    {
        $stats = [
            'projects' => [
                'total' => Project::count(),
                'published' => Project::where('is_published', true)->count(),
                'draft' => Project::where('is_published', false)->count(),
                'featured' => Project::where('featured', true)->count(),
            ],
            'services' => [
                'total' => Service::count(),
                'active' => Service::where('is_active', true)->count(),
                'featured' => Service::where('is_featured', true)->count(),
            ],
            'skills' => [
                'total' => Skill::count(),
                'active' => Skill::where('is_active', true)->count(),
            ],
            'testimonials' => [
                'total' => Testimonial::count(),
                'active' => Testimonial::where('is_active', true)->count(),
                'verified' => Testimonial::where('verified', true)->count(),
            ],
            'messages' => [
                'total' => ContactMessage::count(),
                'unread' => ContactMessage::where('is_read', false)->count(),
            ],
        ];

        $recentMessages = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
        $recentProjects = Project::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects'));
    }

    public function stats()
    {
        $stats = [
            'projects' => Project::count(),
            'services' => Service::count(),
            'skills' => Skill::count(),
            'testimonials' => Testimonial::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        return response()->json($stats);
    }
}