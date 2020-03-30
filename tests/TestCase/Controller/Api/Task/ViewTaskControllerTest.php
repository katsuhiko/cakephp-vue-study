<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\ViewTaskController Test Case
 *
 * @uses \App\Controller\Api\Task\ViewTaskController
 */
class ViewTaskControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Tasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Test detail method
     *
     * @return void
     */
    public function test_該当1件を取得できること(): void
    {
        // Arrange
        $tasks = Fabricate::create('Tasks');

        // Act
        $this->get("/api/ca-task/view/{$tasks[0]->id}.json");

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals($tasks[0]->id, $actual['data']['id']);
    }

    /**
     * Test detail method
     *
     * @return void
     */
    public function test_存在しないとき404が返却されること(): void
    {
        // Arrange
        $id = 'c366f5be-360b-45cc-8282-65c80e434f72';

        // Act
        $this->get("/api/ca-task/view/{$id}.json");

        // Assert
        $this->assertResponseCode(404);
    }
}
