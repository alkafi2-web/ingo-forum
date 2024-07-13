<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Page;
use App\Models\User;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('admin.page'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.content.page.index');
    }

    /**
     * Test the storeOrUpdate method for creating a page.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'page_title' => 'Test Page',
            'page_slug' => 'test-page',
            'page_details' => 'Page details here.',
        ];

        $response = $this->post(route('page.storeOrUpdate'), $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Page created successfully']);

        $this->assertDatabaseHas('pages', ['title' => 'Test Page']);
    }

    /**
     * Test the storeOrUpdate method for updating a page.
     *
     * @return void
     */
    public function testUpdate()
    {
        $page = Page::create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'details' => 'Old details.',
        ]);

        $data = [
            'page_id' => $page->id,
            'page_title' => 'Updated Title',
            'page_slug' => 'updated-title',
            'page_details' => 'Updated details.',
        ];

        $response = $this->post(route('page.storeOrUpdate'), $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Page updated successfully']);

        $this->assertDatabaseHas('pages', ['title' => 'Updated Title']);
    }

    /**
     * Test the edit method.
     *
     * @return void
     */
    public function testEdit()
    {
        $page = Page::create([
            'title' => 'Sample Page',
            'slug' => 'sample-page',
            'details' => 'Sample details.',
        ]);

        $response = $this->get(route('page.edit', $page->id));
        $response->assertStatus(200);
        $response->assertJson($page->toArray());
    }

    /**
     * Test the verifySlug method.
     *
     * @return void
     */
    public function testVerifySlug()
    {
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'details' => 'Test details.',
        ]);

        $response = $this->get(route('slug.verify', ['slug' => 'test-page']));
        $response->assertStatus(200);
        $response->assertJson(['exists' => true]);

        $response = $this->get(route('slug.verify', ['slug' => 'new-page']));
        $response->assertStatus(200);
        $response->assertJson(['exists' => false]);
    }

    /**
     * Test the toggleVisibility method.
     *
     * @return void
     */
    public function testToggleVisibility()
    {
        // Create a page with visibility set to true (1)
        $page = Page::create([
            'title' => 'Visible Page',
            'slug' => 'visible-page',
            'details' => 'Details for visible page.',
            'visibility' => 1,  // 1 represents true
        ]);

        // Send a POST request to toggle the page visibility
        $response = $this->post(route('page.toggleVisibility'), ['id' => $page->id]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Page visibility updated successfully']);

        // Refresh the page instance
        $page->refresh();

        // Assert that the visibility has been toggled to false (0)
        $this->assertEquals(0, $page->visibility, 'Failed to toggle visibility to false.');

        // Toggle the visibility back to true (1)
        $response = $this->post(route('page.toggleVisibility'), ['id' => $page->id]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Page visibility updated successfully']);

        // Refresh the page instance
        $page->refresh();

        // Assert that the visibility has been toggled back to true (1)
        $this->assertEquals(1, $page->visibility, 'Failed to toggle visibility back to true.');
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        $page = Page::create([
            'title' => 'Page to Delete',
            'slug' => 'page-to-delete',
            'details' => 'Details for page to delete.',
        ]);

        $response = $this->delete(route('page.destroy'), ['id' => $page->id]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Page has been deleted successfully.']);

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
