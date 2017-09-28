<?php

namespace common\models;  

use dektrium\user\models\User as BaseUser;
use Yii;

class User extends BaseUser implements \rmrevin\yii\module\Comments\interfaces\CommentatorInterface
{
	public function getCommentatorAvatar()
    {
        return Yii::$app->request->baseUrl . '/frontend/web/files/images/common/default-avatar.jpg';  
    }
    
    public function getCommentatorName()
    {
        return 'Kolya';
    }
    
    public function getCommentatorUrl()
    {
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);  
    }
     
}