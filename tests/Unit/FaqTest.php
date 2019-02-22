<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class FaqTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     use RefreshDatabase;

     public function testFaqModel()
     {
         // create and read data
         $faq = \App\Faq::create(['question' => 'question', 'answer' => 'answer']);
         $this->assertDatabaseHas('faqs', ['id' => $faq->id]);
         // update test
         $updated_faq = \App\Faq::find($faq->id)->update(['question' => 'questioning', 'answer' => 'answering']);
         $this->assertDatabaseHas('faqs', ['id' => $faq->id, 'question' => 'questioning', 'answer' => 'answering']);
         // Delete test
         \App\Faq::destroy($faq->id);
         $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
     }
}
