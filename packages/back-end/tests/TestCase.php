<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loggedIn(): self
    {
        $user = User::factory()->createOne();
        return $this->actingAs($user, 'api');
    }
}
