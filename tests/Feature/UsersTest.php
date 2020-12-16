<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    //Valid user data for testing
    public $user = [
      'name' => 'Updated user',
      'email' => 'email@email.com',
      'password' => 'Password',
      'password_confirmation' => 'Password'
    ];

    /**
     * users.create route
     */

    //Unauthenticated to users.create redirect to /login
    public function test_users_create_unauthenticated_redirects_to_login(){
        $response = $this->get(route('users.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to users.create returns view and 200
    public function test_users_create_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.create');
    }

    //Authenticated leader to users.create returns view and 200
    public function test_users_create_authenticated_leader_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.create');
    }

    //Authenticated user to users.create returns view and 200
    public function test_users_create_authenticated_user_shows_correct_view(){
        $this->signInUser();
        $response = $this->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.create');
    }

    /**
     * users.edit route
     * In all tests assuming for convenience test data is correct and user->id = 5 corresponds to user with role 'user'
     */

   //Unauthenticated to users.edit redirect to /login
    public function test_users_edit_unauthenticated_redirects_to_login(){
        $response = $this->get(route('users.edit', ['user'=> 5])); 
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to users.edit returns view and 200
    public function test_users_edit_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('users.edit', ['user'=> 5]));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.edit');
    }

    //Authenticated leader to users.edit returns view and 200
    public function test_users_edit_authenticated_leader_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('users.edit', ['user'=> 5]));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.edit');
    }

    //Authenticated user to users.edit returns view and 200
    public function test_users_edit_authenticated_user_shows_correct_view(){
        $this->signInUser();
        $response = $this->get(route('users.edit', ['user'=> 5]));
        $response->assertStatus(200);
        $response->assertViewIs('views.users.edit');
    }

    //Request to users.edit with invalid id returns 404
    public function test_users_edit_invalid_user_returns_404(){
        $this->signInUser();
        $response = $this->get(route('users.edit', ['user'=> 'NaN']));
        $response->assertStatus(404);
    }

    //Request to users.edit with is admin returns 403
    public function test_users_edit_admin_returns_403(){
        $this->signInUser();
        $response = $this->get(route('users.edit', ['user'=> 1 ]));
        $response->assertStatus(403);
    }

      //Request to users.edit with invalid id returns 404
    public function test_users_edit_leader_returns_403(){
        $this->signInUser();
        $response = $this->get(route('users.edit', ['user'=> 2]));
        $response->assertStatus(403);
    }

    /**
     * users.store route
     */

    //Unauthenticated request leads to 'login'
    public function test_users_store_unauthenticated_redirects_login(){
      $response = $this->post(route('users.store'));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Request missing name returns error
    public function test_users_store_authenticated_no_name_error(){
      $this->signInUser();
      unset($this->user['name']);
      $response = $this->post(route('users.store'), $this->user);      $response->assertSessionHasErrors(['name']);
    }
    
    //Request with name above 255 chars returns error
    public function test_users_store_authenticated_long_name_error(){
      $this->signInUser();
      $this->user['name'] = str_repeat('A', 256);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['name']);
    }

    //Request missing email returns error
    public function test_users_store_no_email_error(){
      $this->signInUser();
      unset($this->user['email']);
      $response = $this->post(route('users.store'), $this->user);      $response->assertSessionHasErrors(['email']);
    }
    
    //Request with email above 255 chars returns error
    public function test_users_store_long_email_error(){
      $this->signInUser();
      $this->user['email'] = str_repeat('A', 256);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request with bad email returns error
    public function test_users_store_bad_email_error(){
      $this->signInUser();
      $this->user['email'] = 'email';
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request with non unique email returns error
    public function test_users_non_unique_email_error(){
      $this->signInUser();
      $this->user['email'] = 'admin@admin.com'; //assume correct test data
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request missing password returns no error
    public function test_users_store_no_password_error(){
      $this->signInUser();
      unset($this->user['password']);
      $response = $this->post(route('users.store', $this->user));      $response->assertSessionHasErrors(['password']);
    }
    
    //Request with password above 255 chars returns error
    public function test_users_store_long_password_error(){
      $this->signInUser();
      $this->user['password'] = str_repeat('A', 256);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }

    //Request with password below 255 chars returns error
    public function test_users_store_short_password_error(){
      $this->signInUser();
      $this->user['password'] = str_repeat('A', 2);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }

    //Request with non confirmed password returns error
    public function test_users_store_unconfirmed_password_error(){
      $this->signInUser();
      $this->user['password'] = 'Different password';
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }

    //Request missing confirmed password returns error
    public function test_users_store_no_confirmed_password_error(){
      $this->signInUser();
      unset($this->user['password_confirmation']);
      $response = $this->post(route('users.store', $this->user));      $response->assertSessionHasErrors(['password_confirmation']);
    }
    
    //Request with confirmed password above 255 chars returns error
    public function test_users_store_long_confirmed_password_error(){
      $this->signInUser();
      $this->user['password_confirmation'] = str_repeat('A', 256);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['password_confirmation']);
    }

    //Request with confirmed password below 255 chars returns error
    public function test_users_store_short_confirmed_password_error(){
      $this->signInUser();
      $this->user['password_confirmation'] = str_repeat('A', 2);
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertSessionHasErrors(['password_confirmation']);
    }

    //Request with correct data add to database
    public function test_users_store_valid_perists_to_db(){
      $this->signInUser();
      $response = $this->post(route('users.store'), $this->user);
      unset($this->user['password']);
      unset($this->user['password_confirmation']);
      $this->assertDatabaseHas('users', $this->user);
    }

    //Request with correct data redirects to home
    public function test_users_store_valid_redirects_home(){
      $this->signInUser();
      $response = $this->post(route('users.store'), $this->user);      
      $response->assertStatus(302);
      $response->assertRedirect(route('home.index'));
    }

    /**
     * users.update route
     */

    //Unauthenticated request leads to 'login'
    public function test_users_update_unauthenticated_redirects_login(){
      $response = $this->patch(route('users.update', ['user' => 5]));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Request missing name returns error
    public function test_users_update_authenticated_no_name_error(){
      $this->signInUser();
      unset($this->user['name']);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      $response->assertSessionHasErrors(['name']);
    }
    
    //Request with name above 255 chars returns error
    public function test_users_update_authenticated_long_name_error(){
      $this->signInUser();
      $this->user['name'] = str_repeat('A', 256);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['name']);
    }

    //Request missing email returns error
    public function test_users_update_no_email_error(){
      $this->signInUser();
      unset($this->user['email']);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      $response->assertSessionHasErrors(['email']);
    }
    
    //Request with email above 255 chars returns error
    public function test_users_update_long_email_error(){
      $this->signInUser();
      $this->user['email'] = str_repeat('A', 256);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request with bad email returns error
    public function test_users_update_bad_email_error(){
      $this->signInUser();
      $this->user['email'] = 'email';
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request with non unique email returns error
    public function test_users_update_non_unique_email_error(){
      $this->signInUser();
      $this->user['email'] = 'admin@admin.com'; //assume correct test data
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['email']);
    }

    //Request with models existing email does not return error
    public function test_users_update_existing_email_no_error(){
      $this->signInUser();
      $user = User::find(5);
      $this->user['email'] = $user->email;
      $response = $this->patch(route('users.update', ['user' => $user->id]), $this->user);      
      $response->assertSessionHasNoErrors(['email']);
    }

    //Request missing password returns error
    public function test_users_update_no_password_error(){
      $this->signInUser();
      unset($this->user['password']);
      unset($this->user['password_confirmation']);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);  
      $response->assertSessionHasNoErrors(['password']);
    }
    
    //Request with password above 255 chars returns error
    public function test_users_update_long_password_error(){
      $this->signInUser();
      $this->user['password'] = str_repeat('A', 256);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }

    //Request with password below min` chars returns error
    public function test_users_update_short_password_error(){
      $this->signInUser();
      $this->user['password'] = str_repeat('A', 2);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }

    //Request with non confirmed password returns error
    public function test_users_update_unconfirmed_password_error(){
      $this->signInUser();
      $this->user['password'] = 'Different password';
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['password']);
    }
    
    //Request with confirmed password above 255 chars returns error
    public function test_users_update_long_confirmed_password_error(){
      $this->signInUser();
      $this->user['password_confirmation'] = str_repeat('A', 256);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['password_confirmation']);
    }

    //Request with confirmed password below 255 chars returns error
    public function test_users_update_short_confirmed_password_error(){
      $this->signInUser();
      $this->user['password_confirmation'] = str_repeat('A', 2);
      $response = $this->patch(route('users.update', ['user' => 5]), $this->user);      
      $response->assertSessionHasErrors(['password_confirmation']);
    }

    //Request with correct data add to database
    public function test_users_update_valid_perists_to_db(){
      $this->signInUser();
      $user = User::find(5);
      $this->patch(route('users.update', ['user' => $user->id]), $this->user);      
      $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $this->user['name'],
        'email' => $this->user['email']
      ]);
    }

    //Request with correct data but no password defined does not lead to password loss
    public function test_users_update_valid_no_password_no_affect(){
      $this->signInUser();
      $user = User::find(5);
      unset($this->user['password']);
      unset($this->user['password_confirmation']);
      $this->patch(route('users.update', ['user' => $user->id]), $this->user);      
      $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $this->user['name'],
        'email' => $this->user['email'],
        'password' => $user->password
      ]);
    }

    //Request with correct data redirects to home
    public function test_users_update_valid_redirects_home(){
      $this->signInUser();
      $user = User::find(5);
      $response = $this->patch(route('users.update', ['user' => $user->id]), $this->user);      
      $response->assertStatus(302);
      $response->assertRedirect(route('home.index'));
    }

    //Correct request to update admin leads to 403
    public function test_users_update_admin_leads_403(){
      $this->signInUser();
      $response = $this->patch(route('users.update', ['user' => 1]), $this->user);      
      $response->assertStatus(403);
    }

    //Correct request to update leader leads to 403
    public function test_users_update_leader_leads_403(){
      $this->signInUser();
      $response = $this->patch(route('users.update', ['user' => 2]), $this->user);      
      $response->assertStatus(403);
    }

    /**
     * users.destroy route
     * To simplify, assume correct test data, user->id = 5 is user, user->id = 1 is admin, user->id = 2 is leader
     */

    //Unauthenticated request leads to 405
    public function test_users_destroy_unauthenticated_redirects_login(){
      $response = $this->delete(route('users.destroy', ['user' => 5]));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Authenticated request to delete non existent user leads to 403
    public function test_users_destroy_nonexistent_user_404(){
      $this->signInUser();
      $response = $this->delete(route('users.destroy', ['user' => 'NaN']));
      $response->assertStatus(404);
    }

    //Authenticated request to delete admin leads to 403
    public function test_users_destroy_admin_403(){
      $this->signInUser();
      $response = $this->delete(route('users.destroy', ['user' => 1]));
      $response->assertStatus(403);
    }

    //Authenticated request to delete leader leads to 403
    public function test_users_destroy_leader_403(){
      $this->signInUser();
      $response = $this->delete(route('users.destroy', ['user' => 2]));
      $response->assertStatus(403);
    }

    //Request with correct data removes from db from user
    public function test_users_destroy_valid_from_user_removes_from_db(){
      $this->signInUser();
      $this->delete(route('users.destroy', ['user' => 5]));      
      $this->assertDatabaseMissing('users', ['id' => 5]);
    }

    //Request with correct data removes from db from leader
    public function test_users_destroy_valid_from_leader_removes_from_db(){
      $this->signInLeader();
      $this->delete(route('users.destroy', ['user' => 5]));      
      $this->assertDatabaseMissing('users', ['id' => 5]);
    }

    //Request with correct data removes from db from admin
    public function test_users_destroy_valid_from_admin_removes_from_db(){
      $this->signInAdmin();
      $this->delete(route('users.destroy', ['user' => 5]));      
      $this->assertDatabaseMissing('users', ['id' => 5]);
    }

}
