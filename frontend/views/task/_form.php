<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use common\models\Profile;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>
 
<?php 
    $users =  ArrayHelper::map(Profile::find()->orderBy('name')->all(), 'user_id', 'fullName');
    array_unshift($users , Yii::t('frontend', 'Select a user you want to appoint this task ...'));
?>

<style type="text/css">
    .input-group-addon {
      border-left-width: 0;
      border-right-width: 0;
    }
    .input-group-addon:first-child {
      border-left-width: 1px;
    }
    .input-group-addon:last-child {
      border-right-width: 1px;
    }
</style>

<div class="task-form">

    <?php $form = ActiveForm::begin([
            'options'=>[
                'enctype'=>'multipart/form-data'
            ]
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?php 
    $model->appointed_id = 0;
    echo $form->field($model, 'appointed_id')->widget(Select2::classname(), [
            'data' => $users, 
            'value' => 0,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

    <?= $form->field($model, 'estimated_hours')->textInput() ?>

    <?= $form->field($model, 'estimated_minutes')->textInput() ?>

    <?= $form->field($image, 'file[]')->widget(FileInput::classname(), [ 
            'options' => ['multiple' => 'true', 'accept' => 'image/*'],
            'pluginLoading' => false,
            'pluginOptions' => [
                'maxFileCount' => 6,
                'showUpload' => false, 
                'allowedFileExtensions' => ['jpg','jpeg','png'],
                'overwriteInitial' => false
            ] 
    ])->label(Yii::t('frontend', 'Images')) ?> 


    <?= $form->field($document, 'file[]')->widget(FileInput::classname(), [  
            'options' => ['multiple' => 'true'],
            'pluginLoading' => false,
            'pluginOptions' => [
                'maxFileCount' => 6,
                'showUpload' => false, 
                'allowedFileExtensions' => ['doc','xls','xlsx','txt'],
                'overwriteInitial' => false
            ] 
    ])->label(Yii::t('frontend', 'Documents')) ?>  


    <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>


    <?php ActiveForm::end(); ?>

</div>
