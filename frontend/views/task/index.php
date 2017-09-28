<?php

use common\models\Task;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <div>
      <ul id="tasks-tabs" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#my-tasks" aria-controls="my-tasks" role="tab" data-toggle="tab"><?=Yii::t('frontend', 'My tasks')?></a></li>
        <li><a href="#appointed-by-me" aria-controls="appointed-by-me" role="tab" data-toggle="tab"><?=Yii::t('frontend', 'Appointed by me')?></a></li>
      </ul>
      <!-- Содержимое вкладок -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="my-tasks">

            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => '',
                    'tableOptions' => [
                        'class' => 'table borderless'
                    ],
                    'columns' => [ 

                    [
                                  'attribute' => 'name',
                                  'label' => '',
                                  'encodeLabel' => false,
                                  'value' => function (Task $data) { 
                                        return '<div class="panel panel-default"><div class="panel-body"> ' .
                                        '<h4 style="margin-top: 0px;">' . Html::a(Html::encode($data->name), Url::to(['task/view', 'id' => $data->id])) . '</h4>' .
                                        '<i class="icon-user"></i> <a href="#">Admin</a> 
                                          | <i class="icon-calendar"></i> Sept 16th, 2012 at 4:20 pm
                                          | <i class="icon-comment"></i> <a href="#">3 Comments</a>
                                            | ' . Yii::t('frontend', 'Status') . ': в работе</a>
                                        </div>
                                    </div>';
                                    },
                                 'format' => 'raw',
                                 'filterInputOptions' => [
                                    'class'       => 'form-control',
                                    'placeholder' => Yii::t('frontend', 'Search task...')
                                 ]
                     ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
    
        </div>
        
        <div role="tabpanel" class="tab-pane" id="appointed-by-me">...</div>
        </div>
    </div>
</div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 

$script = <<< JS
    $('#tasks-tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    }) 
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
