<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
   // public function __construct()
   // {
   //     $this->middleware(['auth', 'admin']);
   // }

    public function index(Request $request)
    {
        $query = Skill::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('level')) {
            $level = $request->level;

            $query->when($level === 'expert', fn ($q) => $q->where('level', '>=', 90))
                ->when($level === 'advanced', fn ($q) => $q->whereBetween('level', [70, 89]))
                ->when($level === 'intermediate', fn ($q) => $q->whereBetween('level', [50, 69]));
        }

        $skills = $query->ordered()->paginate(20)->withQueryString();

        $categories = Skill::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $stats = [
            'total' => Skill::count(),
            'active' => Skill::where('is_active', true)->count(),
            'featured' => Skill::where('is_featured', true)->count(),
            'expert' => Skill::where('level', '>=', 90)->count(),
        ];

        return view('admin.skills.index', compact('skills', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = config('portfolio.skills.categories', [
            'Frontend Development',
            'Backend Development',
            'Database & DevOps',
            'Design & Tools',
            'Other',
        ]);
        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('skills')],
            'category' => 'required|string|max:100',
            'level' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'years_of_experience' => 'nullable|integer|min:0',
            'certification_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['sort_order'] = Skill::max('sort_order') + 1;

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill added successfully!');
    }

    public function edit(Skill $skill)
    {
        $categories = config('portfolio.skills.categories', [
            'Frontend Development',
            'Backend Development',
            'Database & DevOps',
            'Design & Tools',
            'Other',
        ]);
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('skills')->ignore($skill->id)],
            'category' => 'required|string|max:100',
            'level' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'years_of_experience' => 'nullable|integer|min:0',
            'certification_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully!');
    }
}