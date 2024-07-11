<?php

namespace app\controllers;

use Yii;
use mihaildev\elfinder\ElFinder;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;


class ElfinderController extends Controller
{
    public $roots;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // allow authenticated users
                    ],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'connector' => [
                'class' => 'mihaildev\elfinder\ConnectorAction',
                'settings' => [
                    'root' => Yii::getAlias('@webroot/files'),
                    'URL' => Yii::getAlias('@web/files'),
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none',
                    'uploadAllow' => ['image/*'],
                    'uploadDeny' => ['all'],
                    'uploadOrder' => ['deny', 'allow'],
                ],
            ],
            'manager' => [
                'class' => 'mihaildev\elfinder\PathController',
                'settings' => [
                    'root' => Yii::getAlias('@webroot/files'),
                    'URL' => Yii::getAlias('@web/files'),
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none',
                    'uploadAllow' => ['image/*'],
                    'uploadDeny' => ['all'],
                    'uploadOrder' => ['deny', 'allow'],
                ],
            ],
        ];
    }
}
