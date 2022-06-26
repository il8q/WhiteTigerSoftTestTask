<?php

namespace backend\models;

use common\models\AccessToken;
use common\models\Blog;
use common\models\User;
use DateTime;
use yii\base\Model;

/**
 * Signup form
 */
class BlogForm extends Model
{
    public $access_token;
    public $content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_token', 'content'], 'required'],
            [['access_token', 'content'], 'string'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function publish(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Blog();
        $this->checkAccessToken();
        $user->access_token = $this->access_token;
        $user->text = $this->content;

        $date = new DateTime('now');
        $user->created_at = $date->format('Y-m-d');
        return $user->save();
    }

    private function checkAccessToken()
    {
        $user = AccessToken::findOne(['access_token' => $this->access_token]);
        if (!$user)
        {
            throw new \Error('Access token incorrect');
        }
    }
}
