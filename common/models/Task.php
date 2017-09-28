<?php

namespace common\models;

use Yii;
use common\models\Document;
use common\models\Image;

/**
 * This is the model class for table "Task".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $owner_id
 * @property integer $appointed_id
 * @property integer $created_at
 * @property integer $edited_at
 * @property integer $status
 * @property integer $estimated_time
 *
 * @property Comment[] $comments
 * @property User $appointed
 * @property User $owner
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_FINISHED = 3;

    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            [['name', 'text', 'owner_id', 'appointed_id', 'created_at', 'edited_at', 'status'], 'required'],
            [['estimated_hours', 'estimated_minutes'], 'safe'],
            [['estimated_hours', 'estimated_minutes'], 'number'],
            [['text'], 'string'],
            ['appointed_id', 'number', 'min' => 1, 'tooSmall' => Yii::t('frontend', 'Choose coworker')],
            [['owner_id', 'appointed_id', 'created_at', 'edited_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['appointed_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['appointed_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'name' => Yii::t('frontend', 'Name'),
            'text' => Yii::t('frontend', 'Text'),
            'owner_id' => Yii::t('frontend', 'Owner user'),
            'appointed_id' => Yii::t('frontend', 'Appointed user'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'edited_at' => Yii::t('frontend', 'Edited At'),
            'status' => Yii::t('frontend', 'Status'), 
            'estimated_hours' => Yii::t('frontend', 'Estimated hours'), 
            'estimated_minutes' => Yii::t('frontend', 'Estimated minutes'),   
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['task_id' => 'id']); 
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['task_id' => 'id']); 
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointed()
    {
        return $this->hasOne(User::className(), ['id' => 'appointed_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
