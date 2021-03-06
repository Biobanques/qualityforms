<?php

// Define a path alias for the Bootstrap extension as it's used internally.
// In this example we assume that you unzipped the extension under protected/extensions.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Biobanques Quality Forms',
     //par defaut en français
    'language' => 'fr',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'ext.*',
        'ext.YiiMongoDbSuite.*',
        'ext.YiiMongoDbSuite.extra.*',
        'application.models.*',
        'application.components.*',
    ),
    /* theme : classic , bootstrap */
    'theme'=>'bootstrap',
    'modules' => array(
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => CommonProperties::$CONNECTION_STRING,
            'dbName' => 'qualityformsdb',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                 array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, trace',
                ),
                array(
                'class'=>'CWebLogRoute',
                'levels' => 'error, trace',
                //'categories'=>'system.db.*',
                //'except'=>'system.db.ar.*', // shows all db level logs but nothing in the ar category
                'enabled'=>true,
                'showInFireBug'=>true
            ),
            ),
        ),
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'nicolas.malservet@inserm.fr',
    ),
);
