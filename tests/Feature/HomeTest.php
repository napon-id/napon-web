<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBase()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testAbout()
    {
        $response = $this->get('/tentang-kami');
        $response->assertStatus(200);
    }

    public function testService()
    {
        $response = $this->get('/layanan');
        $response->assertStatus(200);
    }

    public function testFaq()
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }
}
