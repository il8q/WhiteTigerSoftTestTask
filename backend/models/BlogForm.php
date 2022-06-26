<?php

namespace backend\models;

use common\models\Blog;
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

        $user->access_token = $this->access_token;
        $user->text = $this->content;

        $date = new DateTime('now');
        $user->created_at = $date->format('Y-m-d');
        return $user->save();
    }
}
