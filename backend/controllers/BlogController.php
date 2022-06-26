<?php

namespace backend\controllers;

use backend\models\BlogForm;
use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class BlogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['add'],
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
                    'add' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Publish post to user blog.
     * Request like http://backend.test/index.php?r=blog%2Fpublish
     *
     * @return string
     */
    public function actionPublish(): string
    {
        $model = new BlogForm();
        if ($model->load(Yii::$app->request->post(), "data") && $model->publish()) {
            return json_encode(
                ['result' => 'success']
            );
        }
        return json_encode(['error' => $model->errors]);
    }
}
