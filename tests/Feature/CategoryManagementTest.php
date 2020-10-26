<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryManagementTest extends TestCase
{
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    use RefreshDatabase;
    /** @test */
    public function a_category_can_be_added() {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/categories', [
            'name' => 'New category',
            'api_token' => $this->user->api_token
        ]);

        $response->assertOk();
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function a_name_is_required() {
        $response = $this->post('/api/categories', [
            'name' => '',
            'api_token' => $this->user->api_token
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Category::all());
    }

    /** @test */
    public function a_category_can_be_updated() {
        $this->withoutExceptionHandling();

        $this->post('/api/categories', [
            'name' => 'Category name',
            'api_token' => $this->user->api_token
        ]);

        $anotherUser = factory(User::class)->create();

        $category = Category::first();
        $this->patch('/api/categories/' . $category->id, [
            'name' => 'New category name',
            'api_token' => $anotherUser->api_token
        ]);

        $this->assertEquals('New category name' , Category::first()->name);

    }

    /** @test */
    public function a_category_can_be_deleted() {
        $this->withoutExceptionHandling();

        $this->post('/api/categories', [
            'name' => 'Category name',
            'api_token' => $this->user->api_token
        ]);

        $category = Category::first();
        $this->delete('/api/categories/' . $category->id);

        $this->assertCount(0 , Category::all());
    }
}
