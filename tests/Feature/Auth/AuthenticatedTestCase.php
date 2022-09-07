<?php

namespace Tests\Feature\Auth;

use Tests\CustomerTestCase;

class AuthenticatedTestCase extends CustomerTestCase
{
    /**
     * A basic test for authenticated route.
     */
    public function testUserInfo(): void
    {
        $response = $this->getJson('/api/user/');

        $response->assertStatus(200);
        $response->assertJsonPath('email', auth()->user()->email);
    }
}
