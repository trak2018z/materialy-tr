<?php

error_reporting(E_ALL ^ E_NOTICE);

define('APP_PATH', __DIR__.'/app');
define('URL_PREFIX', '/materialy');

if ($_SERVER['REQUEST_URI'] === (URL_PREFIX.'/')) {
    header('Location: '.URL_PREFIX.'/home');
}

function __autoload($className)
{
    $aClassName = explode('\\', $className);
    if ('controller' === $aClassName[0]
        || 'model' === $aClassName[0]
        || 'modules' === $aClassName[0]
    ) {
        $sPath = __DIR__.'/app/'.$className.'.class.php';
        include str_replace('\\', '/', $sPath);
    } else {
        $sPath = __DIR__.'/'.$className.'.class.php';
        include str_replace('\\', '/', $sPath);
    }

}

include(__DIR__.'/app/config.php');

$oRouting = new core\Routing(APP_PATH.'/routing.php');
$oRouting->setRoute($_GET['page'])->load();
