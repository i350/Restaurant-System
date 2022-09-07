<?php

namespace Tests\Traits;

use Tests\TestCase;

trait SeedDatabase
{
    protected function setUpSeedDatabase(): void
    {
        $this->artisan('db:seed');
    }
}
