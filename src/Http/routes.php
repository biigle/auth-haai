<?php

$router->get('auth/haai/redirect', [
   'as'   => 'haai-redirect',
   'uses' => 'HaaiController@redirect',
]);

$router->get('auth/haai/callback', [
   'as'   => 'haai-callback',
   'uses' => 'HaaiController@callback',
]);

$router->get('auth/haai/register', [
   'as'   => 'haai-register-form',
   'uses' => 'RegisterController@showRegistrationForm',
]);

$router->post('auth/haai/register', [
   'as'   => 'haai-register',
   'uses' => 'RegisterController@register',
]);
