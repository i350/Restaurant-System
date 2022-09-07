<?php

namespace Tests;

use Tests\Traits\AuthenticateAsCustomer;

abstract class CustomerTestCase extends TestCase
{
    use AuthenticateAsCustomer;
}
