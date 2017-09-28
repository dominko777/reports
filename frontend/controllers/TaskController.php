<?php

namespace frontend\controllers;

use Yii;
use common\models\Image;
use common\models\Document;
use common\models\Task;
use frontend\controllers\InnerController;
use frontend\models\TaskSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends InnerController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [ 
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */ 
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        $image = new Image(); 
        $document = new Document(); 
        $model->created_at = time(); 
        $model->edited_at = time();
        $model->status = Task::STATUS_NOT_ACTIVE;
        $model->appointed_id = 2; 
        $model->owner_id =  Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $image->file = UploadedFile::getInstances($image, 'file');
            foreach ($image->file as $key => $file) {  
                $file->saveAs( Yii::getAlias('@frontend'). '/web/files/images/task/'. $file->baseName . '.' . $file->extension);
                $newImage = new Image();     
                $newImage->file = $file->baseName . '.' . $file->extension;   
                $newImage->user_id = Yii::$app->user->id;
                $newImage->task_id = $model->id;
                $newImage->created_at = time();
                $newImage->save();     
            }

            $document->file = UploadedFile::getInstances($document, 'file');
            foreach ($document->file as $key => $file) {  
                $file->saveAs( Yii::getAlias('@frontend'). '/web/files/documents/task/'. $file->baseName . '.' . $file->extension);
                $newDocument = new Document();      
                $newDocument->file = $file->baseName . '.' . $file->extension;   
                $newDocument->user_id = Yii::$app->user->id;
                $newDocument->task_id = $model->id;
                $newDocument->created_at = time();
                $newDocument->save();     
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
                'document' => $document, 
            ]);
        } 
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
