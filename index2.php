<?php

$yii = dirname(__FILE__) . '/protected/vendor/yiisoft/yii/framework/yii.php';

$config = dirname(__FILE__) . '/protected/config/main_local.php';
if (!file_exists($config)) {
    $config = dirname(__FILE__) . '/protected/config/main.php';
}

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


// remove the following lines when in production mode

defined('YII_DEBUG') or define('YII_DEBUG', APPLICATION_ENV === 'development');

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

if (APPLICATION_ENV === 'development' or true) {
    //die;
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set("display_errors", 1);
}

require_once($yii);
Yii::createWebApplication($config)->run();