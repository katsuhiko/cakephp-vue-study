<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use App\Middleware\CorsMiddleware;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

// API
$routes->scope('/api', function (RouteBuilder $builder) {
    $builder->registerMiddleware('bodies', new BodyParserMiddleware());
    $builder->applyMiddleware('bodies');
    $builder->registerMiddleware('cors', new CorsMiddleware());
    $builder->applyMiddleware('cors');

    $builder->setExtensions(['json']);

    // Preflight request
    $builder->connect('/*', ['prefix' => 'Api', 'controller' => 'Cors', 'action' => 'options'])->setMethods(['OPTIONS']);

    // User
    $builder->connect('/user/search', ['prefix' => 'Api', 'controller' => 'User', 'action' => 'search'])->setMethods(['GET']);

    // Task
    $builder->connect('/task/search', ['prefix' => 'Api', 'controller' => 'Task', 'action' => 'search'])->setMethods(['GET']);
    $builder->connect('/task/view/:id', ['prefix' => 'Api', 'controller' => 'Task', 'action' => 'view'])->setPass(['id'])->setMethods(['GET']);
    $builder->connect('/task/create', ['prefix' => 'Api', 'controller' => 'Task', 'action' => 'create'])->setMethods(['POST']);
    $builder->connect('/task/update/:id', ['prefix' => 'Api', 'controller' => 'Task', 'action' => 'update'])->setPass(['id'])->setMethods(['PUT']);
    $builder->connect('/task/delete/:id', ['prefix' => 'Api', 'controller' => 'Task', 'action' => 'delete'])->setPass(['id'])->setMethods(['DELETE']);

    // CATask
    $builder->connect('/ca-task/search', ['prefix' => 'Api/Task', 'controller' => 'SearchTask', 'action' => 'execute'])->setMethods(['GET']);
    $builder->connect('/ca-task/view/:id', ['prefix' => 'Api/Task', 'controller' => 'ViewTask', 'action' => 'execute'])->setPass(['id'])->setMethods(['GET']);
    $builder->connect('/ca-task/create', ['prefix' => 'Api/Task', 'controller' => 'CreateTask', 'action' => 'execute'])->setMethods(['POST']);
    $builder->connect('/ca-task/update/:id', ['prefix' => 'Api/Task', 'controller' => 'UpdateTask', 'action' => 'execute'])->setPass(['id'])->setMethods(['PUT']);
    $builder->connect('/ca-task/delete/:id', ['prefix' => 'Api/Task', 'controller' => 'DeleteTask', 'action' => 'execute'])->setPass(['id'])->setMethods(['DELETE']);
});

$routes->scope('/', function (RouteBuilder $builder) {
    // Register scoped middleware for in scopes.
    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $builder->applyMiddleware('csrf');

    $builder->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
    $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);
    $builder->connect('/auth/callback', ['controller' => 'Auth', 'action' => 'callback']);
    $builder->connect('/auth/user', ['controller' => 'Auth', 'action' => 'user']);

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    // Vue.js のルートページ表示用です。
    $builder->connect('/*', ['controller' => 'Pages', 'action' => 'index']);

    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
