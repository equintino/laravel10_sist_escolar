<?php

namespace Tests\Feature;

use Tests\TestCase;

class RedirectTest extends TestCase
{
    /** @test */
    public function get_if_initial_page_is_correct(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function get_if_not_logged_is_redirect_to_login(): void
    {
        $response = $this->get('/painel');
        $response->assertRedirect('/login');
    }
}
