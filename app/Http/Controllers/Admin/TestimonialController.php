<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    //public function __construct()
   // {
   //     $this->middleware(['auth', 'admin']);
   // }

    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', (int) $request->rating);
        }

        $testimonials = $query->ordered()->paginate(15)->withQueryString();

        $averageRating = Testimonial::avg('rating');

        $stats = [
            'total' => Testimonial::count(),
            'active' => Testimonial::where('is_active', true)->count(),
            'featured' => Testimonial::where('is_featured', true)->count(),
            'verified' => Testimonial::where('verified', true)->count(),
            'average_rating' => $averageRating ? round((float) $averageRating, 1) : 0,
        ];

        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'project_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'verified' => 'boolean',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
            }

            $validated['is_active'] = $request->has('is_active');
            $validated['is_featured'] = $request->has('is_featured');
            $validated['verified'] = $request->has('verified');

            $testimonial = Testimonial::create($validated);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial added successfully!');
        } catch (\Exception $e) {
            if (isset($validated['avatar'])) {
                Storage::disk('public')->delete($validated['avatar']);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to add testimonial: ' . $e->getMessage());
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'project_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'verified' => 'boolean',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                if ($testimonial->avatar) {
                    Storage::disk('public')->delete($testimonial->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
            }

            $validated['is_active'] = $request->has('is_active');
            $validated['is_featured'] = $request->has('is_featured');
            $validated['verified'] = $request->has('verified');

            $testimonial->update($validated);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial updated successfully!');
        } catch (\Exception $e) {
            if (isset($validated['avatar'])) {
                Storage::disk('public')->delete($validated['avatar']);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update testimonial: ' . $e->getMessage());
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            if ($testimonial->avatar) {
                Storage::disk('public')->delete($testimonial->avatar);
            }

            $testimonial->delete();

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete testimonial: ' . $e->getMessage());
        }
    }
}