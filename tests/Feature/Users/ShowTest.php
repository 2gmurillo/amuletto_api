<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_a_single_user()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $user = User::factory()->create();

        //Act
        $response = $this->jsonApi()->get(route('api.users.read', $user));

        //Assert
        $response->assertSee($user->name);
    }
}
