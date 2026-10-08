<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use App\View\Components\ProjectCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PageSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_and_xml_endpoints_render_successfully(): void
    {
        $project = Project::create([
            'title' => 'Public smoke project',
            'slug' => 'public-smoke-project',
            'category' => 'Test',
            'description' => 'Public project detail smoke test',
            'is_published' => true,
        ]);
        $service = Service::create([
            'title' => 'Public smoke service',
            'slug' => 'public-smoke-service',
            'description' => 'Public service detail smoke test',
            'is_active' => true,
        ]);

        foreach (['/', '/about', '/projects', '/services', '/contact'] as $path) {
            $this->get($path)->assertOk();
        }

        $this->get(route('projects.show', $project->slug))->assertOk();
        $this->get(route('services.show', $service->slug))->assertOk();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('<urlset', false);

        $this->get('/feed')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/rss+xml')
            ->assertSee('<rss', false);
    }

    public function test_contact_form_stores_a_valid_submission(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Smoke Test',
            'email' => 'smoke@example.test',
            'subject' => 'Test inquiry',
            'message' => 'Testing the public contact form.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'smoke@example.test',
            'subject' => 'Test inquiry',
        ]);
    }

    public function test_project_card_uses_the_registered_project_detail_route(): void
    {
        $project = (object) ['slug' => 'smoke-test-project'];

        $this->assertSame(
            route('projects.show', 'smoke-test-project'),
            (new ProjectCard($project))->getProjectUrl()
        );
    }

    public function test_admin_pages_render_for_an_admin_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $project = Project::create([
            'title' => 'Smoke test project',
            'slug' => 'smoke-test-project',
            'category' => 'Test',
        ]);
        $skill = Skill::create([
            'name' => 'Smoke test skill',
            'slug' => 'smoke-test-skill',
            'category' => 'Test',
        ]);
        $service = Service::create([
            'title' => 'Smoke test service',
            'slug' => 'smoke-test-service',
            'description' => 'Test service',
        ]);
        $testimonial = Testimonial::create([
            'name' => 'Smoke Test',
            'content' => 'Test testimonial',
            'rating' => 5,
        ]);
        $message = ContactMessage::create([
            'name' => 'Smoke Test',
            'email' => 'smoke@example.test',
            'subject' => 'Test message',
            'message' => 'Test content',
        ]);

        $this->actingAs($admin);

        foreach ([
            route('admin.dashboard'),
            route('admin.projects.index'),
            route('admin.projects.create'),
            route('admin.projects.show', $project),
            route('admin.projects.edit', $project),
            route('admin.skills.index'),
            route('admin.skills.create'),
            route('admin.skills.edit', $skill),
            route('admin.services.index'),
            route('admin.services.create'),
            route('admin.services.edit', $service),
            route('admin.testimonials.index'),
            route('admin.testimonials.create'),
            route('admin.testimonials.edit', $testimonial),
            route('admin.messages.index'),
            route('admin.messages.show', $message),
            route('admin.settings.index'),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
