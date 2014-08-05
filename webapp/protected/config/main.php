<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Biobanques Quality Forms',
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
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'nicolas',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            // add additional generator path
            'generatorPaths' => array(
                'ext.YiiMongoDbSuite.gii'
            ),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => "mongodb://qfuseradmin:bbanques2015@localhost/qualityformsdb",
            'dbName' => 'qualityformsdb',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                 array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                'class'=>'CWebLogRoute',
                'levels' => 'error, warning',
                //'categories'=>'system.db.*',
                //'except'=>'system.db.ar.*', // shows all db level logs but nothing in the ar category
                'enabled'=>true,
                'showInFireBug'=>true
            ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'nicolas.malservet@inserm.fr',
    ),
);
