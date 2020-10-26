<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_1() {
        $user = factory(User::class)->create();

        $this->assertCount(1, User::all());
    }
}
