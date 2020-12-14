<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    //Unauthenticated to / redirect to /login
    public function test_home_unauthenticated_get_root_redirects_to_login(){
        $response = $this->get(route('root'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Unauthenticated to /home redirects to /locale_get_display_name

    //Authenticated to / redirects to home

    //Authenticated to / returns home.index view

    //Admin returns 200

    //Leader returns 200

    //User returns 200
}
