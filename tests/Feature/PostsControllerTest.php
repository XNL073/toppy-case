<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\PostsSeeder;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test if HTTP Status is OK
     *
     * @return void
     */
    public function testIndexReturnsValidData()
    {
        $this->seed(PostsSeeder::class);

        $response = $this->get('api/posts');
        $response->assertStatus(200);
    }

    /**
     * Test get specific post
     *
     * @return void
     */
    public function testGetSpecificPost()
    {
        $this->seed(PostsSeeder::class);

        $response = $this->get('api/posts', ['id' => 1]);
        $response->assertStatus(200);
    }

    /**
     * Test create new post
     *
     * @return void
     */
    public function testCreateNewPost()
    {
        $this->seed(PostsSeeder::class);

        $response = $this->post('api/posts',  ['title' => 'Test bericht', 'content' => 'Inhoud van het testbericht', 'enabled' => -1]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => '201 - Post added',
            ]);
    }

    // /**
    //  * Test delete existing post
    //  *
    //  * @return void
    //  */
    // public function testDeleteExistingPost()
    // {
    //     $this->seed(PostsSeeder::class);

    //     $response = $this->withHeaders([
    //         'Accept' => 'application/json',
    //     ])->delete('api/posts', ['id' => 1]);
    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             'message' => '200 - Post deleted',
    //         ]);
    // }
}
