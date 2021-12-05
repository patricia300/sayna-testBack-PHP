<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test HTTP request /register.
     *
     * @return void
     */
    public function test_register_new_user()
    {
        $response = $this->post('/register',[
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'Jane@Doe.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'date_naissance' => date('yyyy-m-d'),
            'sexe' => 'féminin'
        ]);

        $response->assertStatus(200);

    }

    public function test_user_can_login(){
        $response = $this->post('/login',[
            'email' => 'Jane@Doe.com',
            'password' => '123456789',
        ]);

        $response->assertStatus(200);
    }
}
