<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

//use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * PagesControllerTest class
 *
 * @uses \App\Controller\PagesController
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Tasks',
        'app.CopyTasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        // 認証を通す。
        $this->session([
            'auth0__user' => [
                'sub' => 'auth0|xxxxxxxxxxxxxxxxxxxxxxxx',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_Vueルートページを表示(): void
    {
        // Act
        $this->get('/');

        // Assert
        $this->assertResponseOk();
        $this->assertResponseContains('<div id="app">');
    }

    /**
     * @return void
     */
    public function test_どんなアクセスでもVueルートページを表示(): void
    {
        // Act
        $this->get('/hoge/bar');

        // Assert
        $this->assertResponseOk();
        $this->assertResponseContains('<div id="app">');
    }

    // /**
    //  * testMultipleGet method
    //  *
    //  * @return void
    //  */
    // public function testMultipleGet(): void
    // {
    //     $this->get('/');
    //     $this->assertResponseOk();
    //     $this->get('/');
    //     $this->assertResponseOk();
    // }

    // /**
    //  * testDisplay method
    //  *
    //  * @return void
    //  */
    // public function testDisplay(): void
    // {
    //     $this->get('/pages/home');
    //     $this->assertResponseOk();
    //     $this->assertResponseContains('CakePHP');
    //     $this->assertResponseContains('<html>');
    // }

    // /**
    //  * Test that missing template renders 404 page in production
    //  *
    //  * @return void
    //  */
    // public function testMissingTemplate(): void
    // {
    //     Configure::write('debug', false);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseError();
    //     $this->assertResponseContains('Error');
    // }

    // /**
    //  * Test that missing template in debug mode renders missing_template error page
    //  *
    //  * @return void
    //  */
    // public function testMissingTemplateInDebug(): void
    // {
    //     Configure::write('debug', true);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseFailure();
    //     $this->assertResponseContains('Missing Template');
    //     $this->assertResponseContains('Stacktrace');
    //     $this->assertResponseContains('not_existing.php');
    // }

    // /**
    //  * Test directory traversal protection
    //  *
    //  * @return void
    //  */
    // public function testDirectoryTraversalProtection(): void
    // {
    //     $this->get('/pages/../Layout/ajax');
    //     $this->assertResponseCode(403);
    //     $this->assertResponseContains('Forbidden');
    // }

    // /**
    //  * Test that CSRF protection is applied to page rendering.
    //  *
    //  * @return void
    //  */
    // public function testCsrfAppliedError(): void
    // {
    //     $this->post('/pages/home', ['hello' => 'world']);

    //     $this->assertResponseCode(403);
    //     $this->assertResponseContains('CSRF');
    // }

    // /**
    //  * Test that CSRF protection is applied to page rendering.
    //  *
    //  * @return void
    //  */
    // public function testCsrfAppliedOk(): void
    // {
    //     $this->enableCsrfToken();
    //     $this->post('/pages/home', ['hello' => 'world']);

    //     $this->assertResponseCode(200);
    //     $this->assertResponseContains('CakePHP');
    // }
}
