<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp() : void {
        parent::setUp();
        $this->withExceptionHandling();
    }


    /**
     * Override function to add seed call
     *
     * @return void
     */
    protected function refreshInMemoryDatabase()
    {
        $this->artisan('migrate', $this->migrateUsing());
        $this->artisan('db:seed');

        $this->app[Kernel::class]->setArtisan(null);
    }

    /**
     * Helper function to sign in any user
     * 
     */
    protected function signIn($user = null){
        $user = $user ?: create(User::class);
        $this->actingAs($user);
        return $this;
    }

    protected function signInAdmin(){
        $user = User::where('role', 'admin')->first();
        return $this->signIn($user);
    }

    protected function signInLeader(){
        $user = User::where('role', 'leader')->first();
        return $this->signIn($user);
    }

    protected function signInUser(){
        $user = User::where('role', 'user')->first();
        return $this->signIn($user);
    }
}
