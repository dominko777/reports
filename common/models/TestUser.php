<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_user".
 *
 * @property integer $id
 * @property string $fio
 * @property string $position
 * @property string $email
 * @property string $phone
 * @property string $login
 * @property string $password
 */
class TestUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'position', 'email', 'phone', 'login', 'password'], 'required'],
            [['fio', 'position', 'email', 'login', 'password'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fio' => Yii::t('app', 'Fio'),
            'position' => Yii::t('app', 'Position'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'login' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
        ];
    }
}
