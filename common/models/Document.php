<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property integer $id
 * @property string $file
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $task_id
 *
 * @property Task $task
 * @property User $user
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file','maxFiles' => 6, 'extensions' => 'doc,xls,xlsx,txt'],  
            [['user_id', 'task_id', 'created_at'], 'required'],   
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'Document'), 
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'task_id' => Yii::t('app', 'Task ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
