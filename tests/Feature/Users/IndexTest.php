<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_users()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $users = User::factory()->times(3)->create();

        //Act
        $response = $this->jsonApi()->get(route('api.users.index'));

        //Assert
        $response->assertSee($users[0]->name);
    }
}
