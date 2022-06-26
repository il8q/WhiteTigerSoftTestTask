<?php

namespace backend\controllers;

use common\models\AccessToken;
use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class RegistraionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'en',
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Register user.
     * Request-url like http://backend.test/index.php?r=registraion%2Fregister
     *
     * @return string
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), "data") && $model->signup()) {
            return json_encode(
                ['access_token' => $model->getAccessToken()]
            );
        }
        return json_encode(['error' => $model->errors]);
    }
}
