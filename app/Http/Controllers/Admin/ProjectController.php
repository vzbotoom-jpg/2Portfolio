<?php

// app/Http/Controllers/Admin/ProjectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     */
   // public function __construct()
   // {
   //     $this->middleware('auth');
   //     $this->middleware('admin');
   //}

    /**
     * Display a listing of the projects.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === 'yes');
        }

        // Sorting
        $sortField = $request->get('sort', 'sort_order');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSortFields = ['title', 'category', 'sort_order', 'created_at', 'updated_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('sort_order', 'asc');
        }

        // Get projects with pagination
        $projects = $query->paginate(15)->withQueryString();

        // Get categories for filter dropdown
        $categories = Project::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        // Statistics
        $stats = [
            'total' => Project::count(),
            'published' => Project::where('is_published', true)->count(),
            'draft' => Project::where('is_published', false)->count(),
            'featured' => Project::where('featured', true)->count(),
        ];

        return view('admin.projects.index', compact(
            'projects',
            'categories',
            'stats',
            'sortField',
            'sortDirection'
        ));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $categories = $this->getCategories();
        $technologies = $this->getTechnologies();
        $skills = \App\Models\Skill::ordered()->get();

        return view('admin.projects.create', compact('categories', 'technologies', 'skills'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $this->uploadImage(
                    $request->file('image'),
                    'projects'
                );
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $this->uploadImage(
                    $request->file('thumbnail'),
                    'projects/thumbnails'
                );
            }

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = $this->generateUniqueSlug($validated['title']);
            }

            // Set default values
            $validated['is_published'] = $request->has('is_published');
            $validated['featured'] = $request->has('featured');
            
            // Get the next sort order
            if (empty($validated['sort_order'])) {
                $validated['sort_order'] = Project::max('sort_order') + 1;
            }

            // Create project
            $project = Project::create($validated);

            if ($request->has('skills')) {
                $selectedSkills = collect($request->input('skills', []))->filter(fn ($skillId) => !empty($skillId));

                $project->skills()->sync(
                    $selectedSkills->mapWithKeys(fn ($skillId) => [
                        (int) $skillId => ['relevance_level' => (int) ($request->input('skill_relevance.' . $skillId) ?: 50)],
                    ])->all()
                );
            }

            Log::info('Created new project', [
                'project_id' => $project->id,
                'title' => $project->title,
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project "' . $project->title . '" created successfully!');

        } catch (\Exception $e) {
            // Clean up uploaded files if there's an error
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            if (isset($validated['thumbnail'])) {
                Storage::disk('public')->delete($validated['thumbnail']);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load('skills'); // If you have skills relationship
        
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $categories = $this->getCategories();
        $technologies = $this->getTechnologies();
        $skills = \App\Models\Skill::ordered()->get();

        return view('admin.projects.edit', compact('project', 'categories', 'technologies', 'skills'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request, $project->id);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                
                $validated['image'] = $this->uploadImage(
                    $request->file('image'),
                    'projects'
                );
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($project->thumbnail) {
                    Storage::disk('public')->delete($project->thumbnail);
                }
                
                $validated['thumbnail'] = $this->uploadImage(
                    $request->file('thumbnail'),
                    'projects/thumbnails'
                );
            }

            // Update slug if title changed
            if ($validated['title'] !== $project->title && empty($validated['slug'])) {
                $validated['slug'] = $this->generateUniqueSlug($validated['title'], $project->id);
            }

            // Set boolean fields
            $validated['is_published'] = $request->has('is_published');
            $validated['featured'] = $request->has('featured');

            // Update project
            $project->update($validated);

            if ($request->has('skills')) {
                $selectedSkills = collect($request->input('skills', []))->filter(fn ($skillId) => !empty($skillId));

                $project->skills()->sync(
                    $selectedSkills->mapWithKeys(fn ($skillId) => [
                        (int) $skillId => ['relevance_level' => (int) ($request->input('skill_relevance.' . $skillId) ?: 50)],
                    ])->all()
                );
            } else {
                $project->skills()->detach();
            }

            Log::info('Updated project', [
                'project_id' => $project->id,
                'title' => $project->title,
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project "' . $project->title . '" updated successfully!');

        } catch (\Exception $e) {
            // Clean up newly uploaded files if there's an error
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            if (isset($validated['thumbnail'])) {
                Storage::disk('public')->delete($validated['thumbnail']);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $title = $project->title;

            // Delete associated images
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            // Delete project
            $project->delete();

            Log::info('Deleted project', [
                'project_id' => $project->id,
                'title' => $title,
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project "' . $title . '" deleted successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    /**
     * Toggle project publication status.
     */
    public function togglePublish(Project $project)
    {
        try {
            $project->update([
                'is_published' => !$project->is_published
            ]);

            $status = $project->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "Project {$status} successfully!",
                'is_published' => $project->is_published
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project status.'
            ], 500);
        }
    }

    /**
     * Toggle project featured status.
     */
    public function toggleFeatured(Project $project)
    {
        try {
            $project->update([
                'featured' => !$project->featured
            ]);

            $status = $project->featured ? 'featured' : 'unfeatured';
            
            return response()->json([
                'success' => true,
                'message' => "Project {$status} successfully!",
                'featured' => $project->featured
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project featured status.'
            ], 500);
        }
    }

    /**
     * Bulk delete projects.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:projects,id'
        ]);

        try {
            $projects = Project::whereIn('id', $request->ids)->get();
            
            foreach ($projects as $project) {
                // Delete associated images
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                if ($project->thumbnail) {
                    Storage::disk('public')->delete($project->thumbnail);
                }
            }

            $count = Project::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} projects deleted successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete projects.'
            ], 500);
        }
    }

    /**
     * Bulk publish/unpublish projects.
     */
    public function bulkPublish(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:projects,id',
            'action' => 'required|in:publish,unpublish'
        ]);

        try {
            $isPublished = $request->action === 'publish';
            
            $count = Project::whereIn('id', $request->ids)
                ->update(['is_published' => $isPublished]);

            $action = $isPublished ? 'published' : 'unpublished';

            return response()->json([
                'success' => true,
                'message' => "{$count} projects {$action} successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update projects.'
            ], 500);
        }
    }

    /**
     * Reorder projects.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:projects,id',
            'orders.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->orders as $order) {
                Project::where('id', $order['id'])
                    ->update(['sort_order' => $order['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Projects reordered successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder projects.'
            ], 500);
        }
    }

    /**
     * Export projects data.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $projects = Project::all();

        if ($format === 'csv') {
            return $this->exportToCsv($projects);
        } elseif ($format === 'json') {
            return $this->exportToJson($projects);
        }

        return redirect()->back()->with('error', 'Invalid export format.');
    }

    /**
     * Validate project request data.
     */
    private function validateProject(Request $request, $projectId = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('projects')->ignore($projectId),
            ],
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:5000',
            'short_description' => 'nullable|string|max:500',
            'image' => [
                $projectId ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,webp',
                'max:5120' // 5MB
            ],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048' // 2MB
            ],
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|integer|exists:skills,id',
            'skill_relevance' => 'nullable|array',
            'skill_relevance.*' => 'nullable|integer|min:0|max:100',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'client' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:100',
            'completed_at' => 'nullable|date',
            'challenges' => 'nullable|string|max:5000',
            'solutions' => 'nullable|string|max:5000',
            'results' => 'nullable|string|max:5000',
            'testimonial' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'featured' => 'boolean',
        ];

        return $request->validate($rules);
    }

    /**
     * Upload image to storage.
     */
    private function uploadImage($file, $path)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        $filePath = $file->storeAs($path, $filename, 'public');
        
        return $filePath;
    }

    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = Project::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Project::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Get available project categories.
     */
    private function getCategories()
    {
        $categories = Project::distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        // Add default categories if empty
        if (empty($categories)) {
            $categories = [
                'WEB APPLICATION',
                'MOBILE DEVELOPMENT',
                'DATA ANALYTICS',
                'E-COMMERCE',
                'EDUCATION',
                'HEALTHCARE',
                'FINANCE',
                'OTHER'
            ];
        }

        return $categories;
    }

    /**
     * Get available technologies.
     */
    private function getTechnologies()
    {
        $technologies = Project::all()
            ->pluck('technologies')
            ->flatten()
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Add default technologies if empty
        if (empty($technologies)) {
            $technologies = [
                'Laravel',
                'Vue.js',
                'React',
                'Node.js',
                'Python',
                'Flutter',
                'MySQL',
                'PostgreSQL',
                'MongoDB',
                'Redis',
                'AWS',
                'Docker',
                'Tailwind CSS',
                'Bootstrap'
            ];
        }

        return $technologies;
    }

    /**
     * Export projects to CSV.
     */
    private function exportToCsv($projects)
    {
        $filename = 'projects-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['ID', 'Title', 'Category', 'Description', 'Technologies', 'Client', 'Duration', 'Status', 'Featured'];

        $callback = function() use ($projects, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($projects as $project) {
                fputcsv($file, [
                    $project->id,
                    $project->title,
                    $project->category,
                    $project->description,
                    is_array($project->technologies) ? implode(', ', $project->technologies) : $project->technologies,
                    $project->client,
                    $project->duration,
                    $project->is_published ? 'Published' : 'Draft',
                    $project->featured ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export projects to JSON.
     */
    private function exportToJson($projects)
    {
        $filename = 'projects-export-' . date('Y-m-d') . '.json';
        
        return response()->json($projects)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}