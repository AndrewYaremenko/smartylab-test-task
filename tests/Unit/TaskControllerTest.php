<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskControllerTest extends TestCase
{

    private $user;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('TestToken')->accessToken;
    }

    public function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function testIndexRequiresAuthentication()
    {
        $this->get('/api/tasks/')->assertStatus(401);
    }

    public function testUserAutorization()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/');

        $response->assertStatus(200);
    }

    //TaskController:index
    public function testAuthenticatedUserIndex()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'endDate',
                    'completed',
                ],
            ],
        ])->assertStatus(200);
    }

    public function testAuthenticatedUserIndexWithParamComletedForSort()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/?completed=true');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'endDate',
                    'completed',
                ],
            ],
        ])->assertStatus(200);
    }

    public function testAuthenticatedUserIndexWithParamEndDateForSort()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/?endDate=2023-09-24');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'endDate',
                    'completed',
                ],
            ],
        ])->assertStatus(200);
    }

    public function testAuthenticatedUserIndexWithParamSortAscForSort()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/?sort=asc');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'endDate',
                    'completed',
                ],
            ],
        ])->assertStatus(200);
    }

    public function testAuthenticatedUserIndexWithParamSortDescForSort()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/?sort=desc');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'endDate',
                    'completed',
                ],
            ],
        ])->assertStatus(200);
    }

    //TaskController:show
    public function testAuthenticatedUserShow()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/tasks/5');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'endDate',
                'completed',
            ],
        ])->assertStatus(200);
    }

    //TaskController:store
    public function testAuthenticatedUserStore()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'endDate' => now()->addDays(3)->format('Y-m-d'),
            'completed' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/tasks', $taskData);

        $response->assertJson([
            'data' => [
                'title' => 'Test Task',
                'description' => 'This is a test task',
                'endDate' => now()->addDays(3)->format('Y-m-d'),
                'completed' => false,
            ],
        ])->assertStatus(201);
    }

    //TaskController:update
    public function testAuthenticatedUserUpdate()
    {
        //Создаем таск специально для этого теста
        $taskData = [
            'title' => 'Task for update',
            'description' => 'This is a test task for update',
            'endDate' => now()->addDays(5)->format('Y-m-d'),
            'completed' => true,
        ];
        $task = Task::create($taskData);

        $updatedTaskData = [
            'title' => 'Updated Task',
            'description' => 'This is an updated task',
            'endDate' => now()->addDays(10)->format('Y-m-d'),
            'completed' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/tasks/' . $task->id, $updatedTaskData);

        $response->assertJson([
            'data' => [
                'title' => 'Updated Task',
                'description' => 'This is an updated task',
                'endDate' => now()->addDays(10)->format('Y-m-d'),
                'completed' => true,
            ],
        ])->assertStatus(200);
    }

    //TaskController:destroy
    public function testAuthenticatedUserDestroy()
    {
        //Создаем таск специально для этого теста
        $taskData = [
            'title' => 'Task for destroy',
            'description' => 'This is a test task for destroy',
            'endDate' => now()->addDays(5)->format('Y-m-d'),
            'completed' => true,
        ];
        $task = Task::create($taskData);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete('/api/tasks/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task has been deleted',
            ]);
    }
}