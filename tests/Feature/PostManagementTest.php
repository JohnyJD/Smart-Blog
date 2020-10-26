<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostManagementTest extends TestCase
{
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    use RefreshDatabase;
    /** @test */
    public function a_post_can_be_created() {
        Storage::fake('images');

        $this->withoutExceptionHandling();

        $response = $this->post('/api/posts', $this->data());

        $this->assertCount(1, Post::all());
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /** @test */
    public function a_post_can_be_added_only_by_signed_in_user() {
        Storage::fake('images');

        $response = $this->post('/api/posts',
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function a_post_can_be_fetched_by_user() {
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/posts/' . $post->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'post_id' => $post->id
            ],
            'links' => [
                'self' => $post->path()
            ]
        ]);
    }

    /** @test */
    public function a_posts_can_be_fetched_by_user() {
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/posts/?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'post_id' => $post->id
                    ],
                    'links' => [
                        'self' => $post->path()
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_slug_image_is_added_after_post_is_created() {
        $this->withoutExceptionHandling();
        Storage::fake('images');

        $this->post('/api/posts', $this->data());

        $this->assertCount(1, Post::all());
        $this->assertEquals($_SESSION['testing'], Post::first()->slug_image);
        Storage::disk('images')->assertExists($_SESSION['testing']);
    }

    /** @test */
    public function fields_are_required() {
        collect(['title', 'slug', 'text','categories', 'slug_image'])
            ->each(function($field) {

                $response = $this->post('/api/posts',
                    array_merge($this->data(), [$field => '']));


                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Post::all());
            });
    }

    /** @test */
    public function a_post_can_be_updated_with_new_data() {
        Storage::fake('images');

        $this->withoutExceptionHandling();

        $this->post('/api/posts', $this->data());

        $_SESSION['first_image'] = $_SESSION['testing'];
        Storage::disk('images')->assertExists($_SESSION['first_image']);

        $post = Post::first();
        $response = $this->patch('/api/posts/' . $post->id , $this->newData());

        $this->assertEquals('Very new title', Post::first()->title);
        $this->assertEquals('New text for the post.', Post::first()->text);
        $this->assertEquals('This is new slug', Post::first()->slug);
        $this->assertEquals('Category 2', Post::first()->categories[0]->name);
        $this->assertEquals('Category 3', Post::first()->categories[1]->name);
        $this->assertEquals($_SESSION['testing'], Post::first()->slug_image);
        Storage::disk('images')->assertExists($_SESSION['testing']);
        Storage::disk('images')->assertMissing($_SESSION['first_image']);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function a_post_can_be_updated_only_by_owner() {
        Storage::fake('images');

        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/posts/' . $post->id , array_merge($this->newData(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_post_can_be_deleted_with_all_data() {
        Storage::fake('images');
        $this->withoutExceptionHandling();

        $this->post('/api/posts', $this->data());

        $post = Post::first();
        $response = $this->delete('/api/posts/' . $post->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Post::all());
        Storage::disk('images')->assertMissing($_SESSION['testing']);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function a_post_can_be_deleted_only_by_owner() {
        $post = factory(Post::class)->create(["user_id" => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/posts/' . $post->id, ['api_token' => $anotherUser->api_token]);
        $response->assertStatus(403);
    }

    /** @test */
    public function a_categories_are_detached_after_deleting_post() {
        Storage::fake('images');

        $this->withoutExceptionHandling();
        $this->post('/api/posts', $this->data());


        $post = Post::first();
        $this->delete('/api/posts/' . $post->id, ['api_token' => $this->user->api_token]);

        $this->assertEquals(0, Category::where('name' , 'Category 1')->first()->posts->count());
        $this->assertEquals(0, Category::where('name' , 'Category 2')->first()->posts->count());
        $this->assertCount(2, Category::all());
    }

    /** @test */
    public function a_category_is_automaticly_created() {
        Storage::fake('images');
        $this->post('/api/posts', $this->data());
        $this->assertCount(2, Category::all());
    }

    /**
     * @return array
     */
    private function data(): array
    {
        return [
            'title' => 'New title',
            'slug' => 'This is slug',
            'text' => 'This is post text. Enjoy reading.',
            'categories' => ['Category 1', 'Category 2'],
            'slug_image' => UploadedFile::fake()->image('avatar.jpg'),
            'api_token' => $this->user->api_token
        ];
    }

    /**
     * @return array
     */
    private function newData(): array
    {
        return [
            'title' => 'Very new title',
            'slug' => 'This is new slug',
            'text' => 'New text for the post.',
            'categories' => ['Category 2', 'Category 3'],
            'slug_image' => UploadedFile::fake()->image('new_avatar.jpg'),
            'api_token' => $this->user->api_token
        ];
    }
}
