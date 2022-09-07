<?php

namespace Tests\Traits;

trait AuthenticateAsCustomer
{
    protected function setUpAuthenticateAsCustomer(): void
    {
        $this->postJson('/api/login', [
            'email' => 'customer@email.com',
            'password' => 'password',
        ]);
    }
}
