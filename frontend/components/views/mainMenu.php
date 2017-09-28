<?php
use kartik\sidenav\SideNav;
use yii\bootstrap\Html;
use yii\helpers\Url;
     
echo SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	//'heading' => 'Options',
	'items' => [
		[
			'url' => Url::to('/task/index'), 
			'label' => Yii::t('frontend', 'Tasks'),
			//'icon' => 'home'
		],
		[
			'url' => '#',
			'label' => Yii::t('frontend', 'News'), 
			//'icon' => 'home'
		],
		[
			'url' => Url::to('/image/index'),
			'label' => Yii::t('frontend', 'Drawings'),
			//'icon' => 'home' 
		],
		[
			'url' => Url::to('/document/index'), 
			'label' => Yii::t('frontend', 'Documents'),
			//'icon' => 'home' 
		],
		[
			'url' => '#',
			'label' => Yii::t('frontend', 'Settings'),
			//'icon' => 'home' 
		]
	],
]); 
?>
<p>
        <?= Html::a(Yii::t('frontend', 'Create Task'), ['create'], ['class' => 'btn btn-success', 'style' => 'width: 100%']) ?>
</p>