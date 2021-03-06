<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// // Register component on container
// $container['view'] = function ($container) {
//     return new \Slim\Views\PhpRenderer(__DIR__ . '/templates/');
// };

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// PDO database library 
$container['db'] = function ($c) {
    $db = $c['settings']['dbSettings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
        
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// doctrine EntityManager
// $container['em'] = function ($c) {
//     $settings = $c->get('settings');
//     $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
//         $settings['doctrine']['meta']['entity_path'],
//         $settings['doctrine']['meta']['auto_generate_proxies'],
//         $settings['doctrine']['meta']['proxy_dir'],
//         $settings['doctrine']['meta']['cache'],
//         false
//     );
//     return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
// };

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\Controller\HomeController'] = function ($c) {
    return new App\Controller\HomeController($c);
};

$container['App\Controller\UserController'] = function ($c) {
    $userModel = $c->get('UserModel');
    return new App\Controller\UserController($c);
};

// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------
$container['testModel'] = function ($container) {
    $settings = $container->get('settings');
    $testModel = new App\Model\TestModel($container->get('db'));
    return $testModel;
};

$container['UserModel'] = function ($container) {
    $settings = $container->get('settings');
    $userModel = new App\Model\UserModel($container->get('db'));
    return $userModel;
};

