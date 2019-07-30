<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

$app->get('/post/{id}', 'App\Controller\HomeController:viewPost')
    ->setName('view_post');

# ********** UserController routes **********

$app->get(  '/signup', 
            'App\Controller\UserController:routeSignUp')
            ->setName('signup_route');

$app->post( '/signup/handle',
            'App\Controller\UserController:handleSignUp')
            ->setName('signup_handle');

$app->get( '/signup/auth/{nonce}',
            'App\Controller\UserController:routeSignUpAuth')
            ->setName('signup_auth_route');

$app->get(  '/signin', 
            'App\Controller\UserController:routeSignIn')
            ->setName('signin_route');
 
$app->post( '/signin/handle',
            'App\Controller\UserController:handleSignIn')
            ->setName('signin_handle');

$app->get(  '/signout', 
            'App\Controller\UserController:routeSignOut')
            ->setName('signout_route');
 
$app->post( '/signout/handle',
            'App\Controller\UserController:handleSignOut')
            ->setName('signout_handle');

$app->get(  '/pwchange', 
            'App\Controller\UserController:routePasswordChange')
            ->setName('pwchange_route');
 
$app->post( '/pwchange/handle',
            'App\Controller\UserController:handlePasswordChange')
            ->setName('pwchange_handle');

$app->get(  '/pwforgot', 
            'App\Controller\UserController:routeForgottenPasswordUpdate')
            ->setName('pwforgot_route');
 
$app->post( '/pwforgot/handle',
            'App\Controller\UserController:handleForgottenPasswordUpdate')
            ->setName('pwforgot_handle');

$app->get(  '/idcancel', 
            'App\Controller\UserController:routeIdCancellation')
            ->setName('idcancel_route');
 
$app->post( '/idcancel/handle',
            'App\Controller\UserController:handleIdCancellation')
            ->setName('idcancel_handle');
