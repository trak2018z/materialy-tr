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
    'setting_password' => array(
        'pattern'    => 'user/setting/password',
        'controller' => 'controller\UsersController::password',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'setting' => array(
        'pattern'    => 'user/setting',
        'controller' => 'controller\UsersController::setting',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'register_teacher' => array(
        'pattern'    => 'user/register/teacher',
        'controller' => 'controller\UsersController::registerTeacher',
        'roles'      => array('admin'),
        'secured'    => true,
    ),
    'register_student' => array(
        'pattern'    => 'user/register/student',
        'controller' => 'controller\UsersController::registerStudent',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    //MANAGER
    'manager_register' => array(
        'pattern'    => 'manager/register',
        'controller' => 'controller\ManagerController::register',
        'roles'      => array('admin'),
        'secured'    => true,
    ),
    'manager_view' => array(
        'pattern'    => 'manager/view',
        'controller' => 'controller\ManagerController::view',
        'roles'      => array('admin'),
        'secured'    => true,
    ),
    'manager_view_' => array(
        'pattern'    => 'manager/view/{1}',
        'controller' => 'controller\ManagerController::view',
        'roles'      => array('admin'),
        'secured'    => true,
    ),
    'manager_edit' => array(
        'pattern'    => 'manager/{1}/edit',
        'controller' => 'controller\ManagerController::edit',
        'roles'      => array('admin'),
        'secured'    => true,
    ),
);