<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class GuestTestCase extends TestCase
{
    /**
     * A basic test for authenticated route.
     */
    public function testUserInfo(): void
    {
        $response = $this->getJson('/api/user/');

        $response->assertStatus(401);
    }
}
