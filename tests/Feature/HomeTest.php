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
        $response->assertSeeText('napon.id');
    }
}
