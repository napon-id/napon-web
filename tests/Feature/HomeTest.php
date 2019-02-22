<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function testBase()
    {
        Artisan::call('config:clear');
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testAbout()
    {
        Artisan::call('config:clear');
        $response = $this->get('/tentang-kami');
        $response->assertStatus(200);
    }

    public function testService()
    {
        Artisan::call('config:clear');
        Artisan::call('db:seed');
        $response = $this->get('layanan');
        $response->assertStatus(200);
    }

    public function testFaq()
    {
        Artisan::call('config:clear');
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }
}
