<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
	        'translations' => [
	            'frontend*' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	            'backend*' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	            'app*' => [ 
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	        ],
	    ], 
	    'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ]  
    ],
    'modules' => [
	    'user' => [
	        'class' => 'dektrium\user\Module',
	        'modelMap' => [
		        'Profile' => '\common\models\Profile',
		        'User' => 'common\models\User',
		    ],
	    ],
	    'comments' => [
		    'class' => 'rmrevin\yii\module\Comments\Module',
		    'userIdentityClass' => 'common\models\User',
		    'useRbac' => true, 
		]
	],
];
