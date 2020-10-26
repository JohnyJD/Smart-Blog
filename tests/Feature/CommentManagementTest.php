<?php

namespace Tests\Feature;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentManagementTest extends TestCase
{
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    use RefreshDatabase;

    /** @test */
    public function a_comment_can_be_added() {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->post('/api/comments', [
            'text' => 'Comment text',
            'post_id' => $post->id,
            'api_token' => $this->user->api_token
        ]);

        $this->assertCount(1, Comment::all());
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /** @test */
    public function a_comment_can_be_added_only_by_signed_in_user() {
        $post = factory(Post::class)->create();

        $response = $this->post('/api/comments', [
            'text' => 'Comment text',
            'post_id' => $post->id,
            'api_token' => ''
        ]);

        $response->assertRedirect('/login');
        $this->assertCount(0, Comment::all());
    }


    /** @test */
    public function a_text_is_required() {
        $post = factory(Post::class)->create();

        $response = $this->post('/api/comments', [
            'text' => '',
            'post_id' => $post->id,
            'api_token' => $this->user->api_token
        ]);

        $response->assertSessionHasErrors('text');
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function a_post_id_is_required() {

        $response = $this->post('/api/comments', [
            'text' => 'Comment text',
            'post_id' => '',
            'api_token' => $this->user->api_token
        ]);

        $response->assertSessionHasErrors('post_id');
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function a_comment_can_be_updated() {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $this->post('/api/comments', [
            'text' => 'Comment text',
            'post_id' => $post->id,
            'api_token' => $this->user->api_token
        ]);
        $comment = Comment::first();

        $response = $this->patch('/api/comments/' . $comment->id, [
            'text' => 'New comment text',
            'post_id' => $post->id,
            'api_token' => $this->user->api_token
        ]);
        $this->assertEquals('New comment text', Comment::first()->text);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function a_comment_can_be_updated_only_by_owner() {
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create(['user_id' => $this->user->id, 'post_id' => $post->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/comments/' . $comment->id, [
            'text' => 'New comment text',
            'post_id' => $post->id,
            'api_token' => $anotherUser->api_token
        ]);

        $response->assertStatus(403);

    }

    /** @test */
    public function a_comment_can_be_deleted() {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $this->post('/api/comments', [
            'text' => 'Comment text',
            'post_id' => $post->id,
            'api_token' => $this->user->api_token
        ]);
        $comment = Comment::first();

        $response = $this->delete('/api/comments/' . $comment->id, ['api_token' => $this->user->api_token]);
        $this->assertCount(0, Comment::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function a_comment_can_be_deleted_only_by_owner() {
        $post = factory(Post::class)->create();

        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ]);


        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/comments/' . $comment->id, ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);
        $this->assertCount(1, Comment::all());
    }
}
