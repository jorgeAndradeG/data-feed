<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Commands\FeedXml;
use Illuminate\Foundation\Testing\RefreshDatabase;


class DataFeedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_not_process_file()
    {
        $this->expectNotToPerformAssertions();
        $file = (new FeedXml())->proces_file('feed.xml');
        // $this->assertEquals(1,0);
    }

    public function test_not_found_log_file_returns_a_file()
    {
        $this->expectNotToPerformAssertions();
        $file = (new FeedXml())->create_log_file();
        
    }

    public function test_write_on_log()
    {
        $this->expectNotToPerformAssertions();
        $file = (new FeedXml())->write_on_log("File don't exist");
    }

    // public function test_example()
    // {
    //     $this->assertTrue(true);
    // }
}
