<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if(Yii::$app->user->isGuest)
        {
            $this->redirect(['site/login']);
        }
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     // 
     */
	
    public function actionCreate()
    {
		 $model = new News();
		//print_r(Yii::$app->request->baseUrl);
		if ($model->load(Yii::$app->request->post()) ) 
		{			
			//save path to db
			$model->image = "";
			$model->status=1;
            $model->created_date=date('Y-m-d g:i:s');
            $model->modified_date=date('Y-m-d g:i:s');
			if($model->save())
            {
                $id = $model->getPrimaryKey();
                if($_FILES['News']['name']['file']!="")
                {
                    if($_FILES['News']['size']['file']<=2097152)    //2097152=2MB
                    {                        
            			$model->file = UploadedFile::getInstance($model,'file');
            			$dt=$model->file->saveAs('upload/news/'.$id.'.'.$model->file->extension);
            			if(!empty($dt))
            			{
            				$img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/'.$id.'.'.$model->file->extension;
            			}
            			else
            			{
            				$img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/default.jpg';
            			}    	
            			$updatearr=array('image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);   
                    }
                }  		
                if($_FILES['News']['name']['image_c']!="")
                {                
                    if($_FILES['News']['size']['image_c']<=2097152)    //2097152=2MB
                    {
                        $model->image_c = UploadedFile::getInstance($model,'image_c'); 
                        if(!empty($model->image_c))
                        {               
                            $dt=$model->image_c->saveAs('upload/news/'.$id.'_c.'.$model->image_c->extension);
                            if(!empty($dt))
                            {
                                $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/'.$id.'_c.'.$model->image_c->extension;               
                            }
                            else
                            {
                                $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/default.jpg';
                            }
                            
                            $updatearr=array(
                                        'image_c' => $img,
                                        );
                            $upd=News::updateAll($updatearr, 'id = '.$id);                  
                        }
                    }     
                }	
    			return $this->redirect(['view', 'id' => $model->id]);
    		}
		
		}
        else 
		{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
       
    }
	

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		//print_r($model);
		// $preimg = $model->image;
		
        //
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            //print_r($model->attributes);
            if($_FILES['News']['name']['file']!="")
            {
                if($_FILES['News']['size']['file']<=2097152)    //2097152=2MB
                {
                    $model->file = UploadedFile::getInstance($model,'file');            
                    if(!empty($model->file))
                    {               
                        $dt=$model->file->saveAs('upload/news/'.$id.'.'.$model->file->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/'.$id.'.'.$model->file->extension;               
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/default.jpg';
                        }
                        
                        $updatearr=array(
                                    'image' => $img,
                                    );
                        $upd=News::updateAll($updatearr, 'id = '.$id);                  
                    }
                }                
                
			}
            if($_FILES['News']['name']['image_c']!="")
            {                
                if($_FILES['News']['size']['image_c']<=2097152)    //2097152=2MB
                {
                    $model->image_c = UploadedFile::getInstance($model,'image_c'); 
                    if(!empty($model->image_c))
                    {               
                        $dt=$model->image_c->saveAs('upload/news/'.$id.'_c.'.$model->image_c->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/'.$id.'_c.'.$model->image_c->extension;               
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/news/default.jpg';
                        }
                        
                        $updatearr=array(
                                    'image_c' => $img,
                                    );
                        $upd=News::updateAll($updatearr, 'id = '.$id);                  
                    }
                }     
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
