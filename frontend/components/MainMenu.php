<?php
namespace frontend\components;
 
use yii\base\Widget;
use yii\helpers\Html;
 
class MainMenu extends Widget{
 
	public function init(){
			parent::init();
	}

	public function run(){
			return $this->render('mainMenu');
	}

}
?>
