<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function test_index()
    {
        $this->get('api/tasks')
            ->assertOk()
            ->assertJson([
                [
                    "id" => 1
                ]
            ]);
    }

    public function test_listApproved()
    {
        $this->get('api/tasks/approved/3')
            ->assertOk();
    }

    public function test_store()
    {
        $this->post('api/tasks', [
            "name" => "It was popularised in the 1960s",
            "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            "status" => "backlog",
            "file_url" => "https://www.lipsum.com/"
        ])
            ->assertStatus(201)
            ->assertJson([
                "name" => "It was popularised in the 1960s",
                "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                "status" => "backlog",
                "file_url" => "https://www.lipsum.com/"
            ]);
    }

    public function test_store_tag()
    {
        $this->post('api/tasks/tag', [
            "tag_name" => "tag",
            "task_id" => 1
        ])
            ->assertStatus(204);
    }

    public function test_update()
    {
        $this->put('api/tasks/1', [
            "name" => "It in the 1960s"
        ])
            ->assertStatus(204);
    }

    public function test_patch()
    {
        $this->patch('api/tasks/1', [
            "status" => "waiting_customer_approval"
        ])
            ->assertStatus(204);
    }
}
