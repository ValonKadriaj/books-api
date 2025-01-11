<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function token(User $user = null)
    {
        $user = $user ? $user : User::factory()->create();
        return JWTAuth::fromUser($user);
    }
    protected function setHeaders($user = null)
    {
        return $this->withHeaders(['Authorization' => 'Bearer ' . $this->token($user)]);
    }

    
}
