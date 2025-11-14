<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\Core\Configure;



/**
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
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);


Router::addUrlFilter(function ($params, $request) {
    if ($request->getParam('lang') && !isset($params['lang'])) {
        $params['lang'] = $request->getParam('lang');
    //} elseif (!isset($params['lang'])) {
    }



    return $params;
});

Router::scope('/', function (RouteBuilder $routes) {
    $routes->setExtensions(['xlsx', 'json', 'pdf']);
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
     $routes->connect('/', ['controller' => 'Users', 'action' => 'login','lang' => 'fr']);
     $routes->connect('/:lang', ['controller' => 'Users', 'action' => 'login']);
     $routes->connect('/:lang/login', ['controller' => 'Users', 'action' => 'login'] ,['_name' => 'login']);

     $routes->connect('/:lang/logout', ['controller' => 'Users', 'action' => 'logout'],['_name' => 'logout']);
     $routes->connect('/:lang/reglages', ['controller' => 'Dashboards', 'action' => 'reglages'],['_name' => 'reglages']);
     $routes->connect('/:lang/user-contacts', ['controller' => 'Users', 'action' => 'index', 1]);

     /**
      *  pour les devis factures et les factures antennes
      */
     $routes->connect('/:lang/factures/:action/*', ['controller' => 'DevisFactures'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);

     $routes->connect('/:lang/factures', ['controller' => 'DevisFactures'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);

     $routes->connect('/:lang/factures-antennes/:action/*', ['controller' => 'Factures'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);

     $routes->connect('/:lang/factures-antennes', ['controller' => 'Factures'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);
     
     /**
      *  pour les liens de manuel borne
      */
     
     $routes->connect('/:lang/manuel/*', ['controller' => 'SmsAutos', 'action' => 'voireDoc']);
     
    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/:lang/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */

     $routes->connect('/:lang/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);
     $routes->connect('/:lang/:controller/:action/*', [], ['routeClass' => 'DashedRoute'])
        ->setPatterns([
            'lang' => 'en|fr'
        ])
        ->setPersist(['lang']);


    $routes->connect('/d/:encoded', ['controller' => 'Devis', 'action' => 'decodeUrl'])->setPass(['encoded']);
    //DANGER NE PAS METTRE ça . JAMAIS
    //->setHost(Configure::read('url_payement'));
    $routes->connect('/f/:encoded', ['controller' => 'DevisFactures', 'action' => 'decodeUrl'])->setPass(['encoded'])->setHost(Configure::read('url_payement'))
;
    $routes->connect('/link/*', ['controller' => 'ShortLinks', 'action' => 'view'],['routeClass' => 'DashedRoute']);

    //$routes->fallbacks(DashedRoute::class);
    $routes->scope('/api', function ($routes) {
        $routes->setExtensions(['json']);
       // $routes->resources('Antennes');
        $routes->fallbacks(DashedRoute::class);
    });
});


/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
//Plugin::routes();
