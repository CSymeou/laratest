<?php

namespace Tests;


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
     * Overwrite refreshTestDatabase to add seed call
     */
    protected function refreshTestDatabase()
    {
        if (! RefreshDatabaseState::$migrated) {

            $this->artisan('migrate');
            $this->artisan('db:seed');

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    /**
     * Helper function to sign in any user
     * 
     */
    protected function signIn($user = null){
        $user = $user ?: create('App\Models\User');
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
