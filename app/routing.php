<?php

return array(
    'main_page' => array(
        'pattern'    => 'home',
        'controller' => 'controller\MainController::index',
    ),
    'contact' => array(
        'pattern'    => 'contact',
        'controller' => 'controller\MainController::contact',
    ),
    // USER
    'login' => array(
        'pattern'    => 'login',
        'controller' => 'controller\UsersController::login',
    ),
    'logout' => array(
        'pattern'    => 'logout',
        'controller' => 'controller\UsersController::logout',
        'roles'      => array('admin', 'teacher', 'student'),
        'secured'    => true,
    ),
);