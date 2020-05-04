<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * HomeControllerTest class
 *
 * @uses \App\Controller\HomeController
 */
class HomeControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    public function test_HOMEページを表示(): void
    {
        // Act
        $this->get('/home');

        // Assert
        $this->assertResponseOk();
        $this->assertResponseContains('<div>Home</div>');
    }
}
