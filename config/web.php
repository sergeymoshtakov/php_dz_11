<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'G-q8dpDT1npUjf6Z7i0z6rK1ZrlGinE2', // ключ для валидации cookie
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache', // файловое кеширование
        ],
        'user' => [
            'identityClass' => 'app\models\User', // класс пользователя
            'enableAutoLogin' => true, // автологин пользователя
        ],
        'errorHandler' => [
            'errorAction' => 'site/error', // действие при ошибке
        ],
        'mailer' => [
            'class' => 'yii\symfonymailer\Mailer', // настройка почтового компонента
            'viewPath' => '@app/mail',
            'useFileTransport' => true, // отправка почты будет в файлы
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0, // уровень трассировки логов
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget', // файловый логгер
                    'levels' => ['error', 'warning'], // уровни логгирования
                ],
            ],
        ],
        'db' => $db, // настройки базы данных
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // менеджер RBAC на основе базы данных
        ],
        'elFinder' => [
            'class' => 'mihaildev\elfinder\PathController', // настройка ElFinder для работы с файлами
            'access' => ['@'], // доступ только для авторизованных пользователей
            'root' => [
                'baseUrl' => '@web/uploads', // базовый URL для доступа к файлам
                'basePath' => '@webroot/uploads', // базовый путь к файлам на сервере
                'access' => ['read' => '*', 'write' => '*'], // разрешение на чтение и запись
            ],
            'watermark' => [
                'source' => __DIR__.'/logo.png', // путь к файлу с водяным знаком
                'marginRight' => 5, // отступ справа
                'marginBottom' => 5, // отступ снизу
                'quality' => 95, // качество изображения JPEG
                'transparency' => 70, // прозрачность водяного знака (0-100)
                'targetType' => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP // поддерживаемые форматы изображений
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true, // использование красивых URL
            'showScriptName' => false, // скрытие скриптового имени
            'rules' => [
                // правила маршрутизации для ElFinder
                'elfinder/connector' => 'elfinder/connector',
                'elfinder/manager' => 'elfinder/manager',
            ],
        ],
    ],
    'params' => $params, // параметры приложения
    'modules' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Module', // модуль ElFinder
            'controllerMap' => [
                'connector' => 'mihaildev\elfinder\controllers\ConnectorController',
                'manager' => 'mihaildev\elfinder\controllers\ManageController',
            ],
            'roots' => [
                [
                    'baseUrl' => '@web/uploads',
                    'basePath' => '@webroot/uploads',
                    'access' => ['read' => '*', 'write' => '*'], // доступ на чтение и запись
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // настройки для разработки
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // разрешенные IP-адреса
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // разрешенные IP-адреса
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
