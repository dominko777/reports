<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Documents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <h1 class="no-top-margin"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'',
        'columns' => [
            [
               'attribute' => 'file',
               'format' => 'raw', 
               'value' => function ($model) {
                   return '<a download="' . $model->file . '" href="' . Yii::$app->request->baseUrl . '/frontend/web/files/documents/task/'. $model->file . '"  style="padding-right: 10px" class="download-document"><span class="glyphicon glyphicon-download"></span></a>' . 
            '<a target="_blank" href="' . Yii::$app->request->baseUrl . '/frontend/web/files/documents/task/'. $model->file . '">' . $model->file . '</a>';
               } 
             ],  
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
            ],
        ],
    ]); ?> 
<?php Pjax::end(); ?></div>
