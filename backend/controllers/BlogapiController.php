<?php

namespace backend\controllers;

use app\models\User;
use backend\models\BlogForm;
use common\models\Blog;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class BlogapiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['add', 'all'],
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
                    'all' => ['get'],
                    'my' => ['get'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Publish post to user blog.
     * Request like http://backend.test/index.php?r=blogapi%2Fpublish
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

    /**
     * Get all posts.
     * Request like http://backend.test/index.php?r=blogapi%2Fall&limit=2&offset=2
     *
     * @return string
     */
    public function actionAll(): string
    {
        $data = Yii::$app->request->get();
        $offset = $data['offset'] ?? 0;
        $limit = $data['limit'] ?? 5;

        return JSON::encode(
            Blog::find()
                ->where(['between', 'id', $offset, $offset + $limit - 1 ])
                ->all(),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Get all posts.
     * Request like http://backend.test/index.php?r=blogapi%2Fmy&access_token=K_or5snpWK9BfEXFZcSjqvHMMzom2102_1656163864
     *
     * @return string
     */
    public function actionMy(): string
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access_token'] ?? null;
        BlogForm::checkAccessToken((string)$access_token);

        return JSON::encode(
            Blog::find()
                ->where(['access_token' => $access_token])
                ->all(),
            JSON_PRETTY_PRINT
        );
    }

}
