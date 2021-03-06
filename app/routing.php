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
    //SUBJECT
    'subject_show' => array(
        'pattern'    => 'subject/show',
        'controller' => 'controller\SubjectController::show',
        'roles'      => array('admin', 'teacher', 'student'),
        'secured'    => true,
    ),
    'subject_add' => array(
        'pattern'    => 'subject/add',
        'controller' => 'controller\SubjectController::add',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_view' => array(
        'pattern'    => 'subject/{1}/view',
        'controller' => 'controller\SubjectController::view',
        'roles'      => array('admin', 'teacher', 'student'),
        'secured'    => true,
    ),
    'subject_leader_add' => array(
        'pattern'    => 'subject/{1}/leader/add',
        'controller' => 'controller\SubjectController::addLeader',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_leader_delete' => array(
        'pattern'    => 'subject/{1}/leader/{2}/delete',
        'controller' => 'controller\SubjectController::deleteLeader',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_view_delete' => array(
        'pattern'    => 'subject/{1}/delete',
        'controller' => 'controller\SubjectController::delete',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_view_confirm_delete' => array(
        'pattern'    => 'subject/{1}/confirm/delete',
        'controller' => 'controller\SubjectController::confirm',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_advertisement_add' => array(
        'pattern'    => 'subject/{1}/advertisement/add',
        'controller' => 'controller\SubjectController::advertisementAdd',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_advertisement_delete' => array(
        'pattern'    => 'subject/{1}/advertisement/{2}/delete',
        'controller' => 'controller\SubjectController::advertisementDelete',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_category_add' => array(
        'pattern'    => 'subject/{1}/category/add',
        'controller' => 'controller\SubjectController::categoryAdd',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_category_edit' => array(
        'pattern'    => 'subject/{1}/category/{2}/edit',
        'controller' => 'controller\SubjectController::categoryEdit',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_category_delete' => array(
        'pattern'    => 'subject/{1}/category/{2}/delete',
        'controller' => 'controller\SubjectController::categoryDelete',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_subcategory_add' => array(
        'pattern'    => 'subject/{1}/subcategory/{2}/add',
        'controller' => 'controller\SubjectController::subcategoryAdd',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_subcategory_edit' => array(
        'pattern'    => 'subject/{1}/subcategory/{2}/edit',
        'controller' => 'controller\SubjectController::subcategoryEdit',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_subcategory_delete' => array(
        'pattern'    => 'subject/{1}/subcategory/{2}/delete',
        'controller' => 'controller\SubjectController::subcategoryDelete',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_subcategory_addfile' => array(
        'pattern'    => 'subject/{1}/subcategory/{2}/add/file',
        'controller' => 'controller\SubjectController::fileAdd',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'subject_subcategory_deletefile' => array(
        'pattern'    => 'subject/{1}/file/{2}/delete',
        'controller' => 'controller\SubjectController::fileDelete',
        'roles'      => array('admin', 'teacher'),
        'secured'    => true,
    ),
    'search' => array(
        'pattern'    => 'subject/search',
        'controller' => 'controller\SubjectController::search',
        'roles'      => array('admin', 'teacher', 'student'),
        'secured'    => true,
    ),
    //FILE
    'subject_file_download' => array(
        'pattern'    => 'file/{1}/{2}',
        'controller' => 'controller\SubjectController::fileDownload',
        'roles'      => array('admin', 'teacher', 'student'),
        'secured'    => true,
    ),
);