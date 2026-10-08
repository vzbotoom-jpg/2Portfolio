<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware(['auth', 'admin']);
    //}

    /**
     * Display settings page.
     */
    public function index()
    {
        $portfolioConfig = config('portfolio');
        $seoConfig = config('seo');

        return view('admin.settings.index', compact('portfolioConfig', 'seoConfig'));
    }

    /**
     * Update portfolio settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
            'response_time' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'social_github' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
        ]);

        try {
            // Update .env file with new values
            $this->updateEnvFile([
                'PORTFOLIO_AUTHOR' => $validated['author'],
                'PORTFOLIO_TITLE' => $validated['title'],
                'PORTFOLIO_EMAIL' => $validated['email'],
                'PORTFOLIO_PHONE' => $validated['phone'] ?? '',
                'PORTFOLIO_LOCATION' => $validated['location'] ?? '',
                'PORTFOLIO_AVAILABILITY' => $validated['availability'] ?? '',
                'PORTFOLIO_RESPONSE_TIME' => $validated['response_time'] ?? '',
                'PORTFOLIO_HERO_TITLE' => $validated['hero_title'] ?? '',
                'PORTFOLIO_HERO_SUBTITLE' => $validated['hero_subtitle'] ?? '',
                'PORTFOLIO_HERO_DESCRIPTION' => $validated['hero_description'] ?? '',
                'PORTFOLIO_GITHUB' => $validated['social_github'] ?? '',
                'PORTFOLIO_LINKEDIN' => $validated['social_linkedin'] ?? '',
                'PORTFOLIO_TWITTER' => $validated['social_twitter'] ?? '',
                'PORTFOLIO_INSTAGRAM' => $validated['social_instagram'] ?? '',
            ]);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Update .env file with new values.
     */
    private function updateEnvFile(array $values)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        foreach ($values as $key => $value) {
            // Escape special characters for .env
            $escapedValue = str_replace('"', '\"', $value);

            if (str_contains($envContent, $key . '=')) {
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=\"{$escapedValue}\"",
                    $envContent
                );
            } else {
                $envContent .= "\n{$key}=\"{$escapedValue}\"";
            }
        }

        File::put($envPath, $envContent);
    }
}