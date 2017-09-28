<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property string $surname
 */
class Profile extends \dektrium\user\models\Profile
{
	public function rules()
    {
        return [
            'surname' => ['bio', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'surname' => \Yii::t('frontend', 'Surname'),
        ];
    }

    public function getfullName()
    {
       return $this->name.' '.$this->surname;
    } 
   
}