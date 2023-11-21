<?php

namespace Tests\Feature\Auth;

// use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Database\Factories\UserFactory;

class LoginTest extends TestCase
{
    /** @test */
    public function user_can_view_a_login_form(): void
    {
        $user = (new UserFactory())->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/painel');
    }
}
