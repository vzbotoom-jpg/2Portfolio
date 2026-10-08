<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    //public function __construct()
    //{
       // $this->middleware(['auth', 'admin']);
    //}

    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $services = $query->ordered()->paginate(15)->withQueryString();

        $stats = [
            'total' => Service::count(),
            'active' => Service::where('is_active', true)->count(),
            'featured' => Service::where('is_featured', true)->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services')],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'pricing_start' => 'nullable|numeric|min:0',
            'pricing_unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('services', 'public');
            }

            $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
            $validated['is_active'] = $request->has('is_active');
            $validated['is_featured'] = $request->has('is_featured');
            $validated['sort_order'] = $validated['sort_order'] ?? (Service::max('sort_order') + 1);

            $service = Service::create($validated);

            return redirect()->route('admin.services.index')
                ->with('success', 'Service "' . $service->title . '" created successfully!');
        } catch (\Exception $e) {
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services')->ignore($service->id)],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'pricing_start' => 'nullable|numeric|min:0',
            'pricing_unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $validated['image'] = $request->file('image')->store('services', 'public');
            }

            $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
            $validated['is_active'] = $request->has('is_active');
            $validated['is_featured'] = $request->has('is_featured');

            $service->update($validated);

            return redirect()->route('admin.services.index')
                ->with('success', 'Service "' . $service->title . '" updated successfully!');
        } catch (\Exception $e) {
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        try {
            $title = $service->title;

            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $service->delete();

            return redirect()->route('admin.services.index')
                ->with('success', 'Service "' . $title . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}