<?php
return array(
	'aliases' => array(
		'vendor' => 'application.vendor',
	),
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR .'..',
	'name' => 'My Awesome Yii Site',
	'components' => array(
		'db' => array(
			// MySQL
			'connectionString' => 'mysql:host=localhost;dbname=my_yii_database',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
	),
	'params' => array(
		'composer.callbacks' => array(
			// args for Yii command runner
			'yiisoft/yii-install' => array('yiic', 'webapp', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'),
			'post-update' => array('yiic', 'migrate'),
			'post-install' => array('yiic', 'migrate'),
		),
	),
);