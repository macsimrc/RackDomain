<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Rack Domain',
	'theme'=>'abound',
	'sourceLanguage'=>'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
		'ext.YiiMailer.YiiMailer',
	),
	
	// Associates a behavior-class with the onBeginRequest event.
    // By placing this within the primary array, it applies to the application as a whole
    'behaviors'=>array(
        'onBeginRequest' => array(
            'class' => 'application.components.behaviors.BeginRequest'
        ),
    ),


	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
		'rights'=>array(
			'install' => false,
			'enableBizRule' => true,
			//'enableBizRuleData' => false,
			'superuserName' => 'Admin',
			'layout' => '//layouts/main',
		),
		
		'user'=>array(
                'tableUsers' => 'tbl_users',
                'tableProfiles' => 'tbl_profiles',
                'tableProfileFields' => 'tbl_profiles_fields',
                
				# encrypting method (php hash function)
                'hash' => 'md5',
                # send activation email
                'sendActivationMail' => true,
                # allow access for non-activated users
                'loginNotActiv' => false,
                # activate user on registration (only sendActivationMail = false)
                'activeAfterRegister' => false,
                # automatically login from registration
                'autoLogin' => true,
                # registration path
                'registrationUrl' => array('/user/registration'),
                # recovery password path
                'recoveryUrl' => array('/user/recovery'),
                # login form path
                'loginUrl' => array('/user/login'),
                # page after login
                'returnUrl' => array('/user/profile'),
                # page after logout
                'returnLogoutUrl' => array('/user/login'),
        ),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/user/login'),
		),
		//'cache' => array('class' => 'system.caching.CDummyCache'),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=infrastructuredb',
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'username' => 'root',
			'password' => 'RootPass1683*',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
		
		
		
		'request'=>array(
            'enableCookieValidation'=>true,
            //'enableCsrfValidation'=>true
			//'enableCsrfValidation' => isset($_POST['dontvalidate']) ? true : false,
			'enableCsrfValidation' => false,
			),
		
		'authManager' => array(
			'class' => 'RDbAuthManager',
			'connectionID' => 'db',
			'itemTable' => 'items',
            'assignmentTable' => 'assignments',
            'itemChildTable' => 'itemchildren',
			'rightsTable' => 'rights',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'miguel.carrillo@hotmail.com',
		'notificationEmail'=>'miguel.carrillo@hotmail.info',
		'languages'=>array('es'=>'Español', 'en'=>'English'),

	),
);