<?php

namespace frontend\controllers;

use yii\web\Controller;


/**
 * TaskController implements the CRUD actions for Task model.
 */
class InnerController extends Controller
{
	public function beforeAction($action)
	 {
	    $this->layout = 'inner_layout'; 
	    return parent::beforeAction($action);
	 }
}