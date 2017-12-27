<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yiic.php';

if(file_exists(dirname(__FILE__).'/config/console_local.php'))
    $config=dirname(__FILE__).'/config/console_local.php';
else
    $config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
