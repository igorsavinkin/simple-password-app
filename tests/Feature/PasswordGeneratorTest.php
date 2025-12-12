<?php

namespace Tests\Feature;

use App\Models\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('password.index');
    }

    public function test_can_generate_password_with_default_settings(): void
    {
        $response = $this->post('/', [
            'length' => 8,
            'small_letters' => 'on',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('password.index');
        $response->assertViewHas('password');
        
        $password = $response->viewData('password');
        $this->assertNotNull($password);
        $this->assertEquals(8, strlen($password));
    }

    public function test_can_generate_password_with_numbers(): void
    {
        $response = $this->post('/', [
            'length' => 12,
            'numbers' => 'on',
            'small_letters' => 'on',
        ]);

        $response->assertStatus(200);
        $password = $response->viewData('password');
        
        $this->assertEquals(12, strlen($password));
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
    }

    public function test_can_generate_password_with_uppercase(): void
    {
        $response = $this->post('/', [
            'length' => 10,
            'big_letters' => 'on',
        ]);

        $response->assertStatus(200);
        $password = $response->viewData('password');
        
        $this->assertEquals(10, strlen($password));
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
    }

    public function test_password_is_saved_to_database(): void
    {
        $this->post('/', [
            'length' => 8,
            'small_letters' => 'on',
        ]);

        $this->assertDatabaseCount('passwords', 1);
    }

    public function test_generated_passwords_are_unique(): void
    {
        $this->post('/', ['length' => 8, 'small_letters' => 'on']);
        $this->post('/', ['length' => 8, 'small_letters' => 'on']);
        
        $passwords = Password::pluck('value')->toArray();
        $this->assertCount(2, array_unique($passwords));
    }
}

