<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('adminlte', 'protected/vendor/almasaeed2010/adminlte');
Yii::setPathOfAlias('vendor', 'protected/vendor');
YII::setPathOfAlias('components.gii.bootstrap.BootstrapCode', 'protected/components/gii/bootstrap/BootstrapCode');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Entrenar-T',

    // preloading 'log' component
    //'preload' => array('log', 'booster'),
    'preload' => strpos($_SERVER['REQUEST_URI'], 'rbam') ? array('log') : array('log', 'booster'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.modules.*',
        'application.components.*',
        'application.modules.rbam.models.RBAMBaseModel',
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'pascal098deal',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.components.gii',
            ),
        ),
        'rbam' => array(
            'development' => true,
            'initialise' => true,
            //'class' => 'ext.rbam.RbamModule',
            // RBAM Configuration
        ),
    ),
    // application components
    'components' => array(
        'booster' => array(
            'class' => 'vendor.clevertech.yii-booster.src.components.Booster',
        ),
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'bootstrap.min.js' => false,
                'bootstrap.min.css' => false
            ),
            'coreScriptPosition' => CClientScript::POS_END,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            //'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'diarioManager' => array('class' => 'DiarioManager'),
        'session' => array(
            'timeout' => 1800,
            'sessionName' => 'EntrenarteSession'
        ),
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
        ),
        // database settings are configured in database.php
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=entrenarte',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'pascal098deal',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),

    ),
    'theme' => 'mutual',
    'language' => 'es',
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
