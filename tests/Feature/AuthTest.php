<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_unauthenticated_user_cannot_access_product()
    {
        $response = $this->get('/products');
        $response->assertStatus(302);
        $response->assertRedirect('signin');
    }

    public function test_login_redirect_to_product(){

        User::create([
             'name' => 'User',
             'email' => 'user@gmail.com',
             'password' => bcrypt('password')
        ]); 

        $response = $this->post('/signin',[
            'email' => 'user@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
    }
}
