<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    //Unauthenticated to /home redirects to /login`
    public function test_home_unauthenticated_get_home_redirects_to_login(){
        $response = $this->get(route('home.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated to / redirects to home
    public function test_home_authenticated_get_root_redirects_to_home(){
        $this->signInUser();
        $response = $this->get(route('root'));
        $response->assertStatus(301);
        $response->assertRedirect(route('home.index'));
    }

    //Authenticated to /home returns home.index view
    public function test_home_authenticated_get_home_shows_correct_view(){
        $this->signInUser();
        $response = $this->get(route('home.index'));
        $response->assertViewIs('views.home.index');
    }

    //Authenticated admin to home returns view and 200
    public function test_home_authenticated_admin_get_home_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('home.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.home.index');
    }

    //Authenticated leader to home returns view and 200
    public function test_home_authenticated_leader_get_home_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('home.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.home.index');
    }

    //Authenticated user to home returns view and 200
    public function test_home_authenticated_user_get_home_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('home.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.home.index');
    }
}
