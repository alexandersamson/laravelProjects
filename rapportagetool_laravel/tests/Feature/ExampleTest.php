<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $urls = ['/users','/casefiles','/subjects','/clients','/vehicles','/assets','/licenses'];

        foreach($urls as $url) {
            $response = $this->get($url);
            $response->assertStatus(302, 404);

        }
    }
}
