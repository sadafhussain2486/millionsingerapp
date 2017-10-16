<?php

namespace app\controllers;

use Yii;
use app\models\Country;
use app\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * AdsmgmtController implements the CRUD actions for AdsMgmt model.
 */
class CountryController extends Controller
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
     * Lists all AdsMgmt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdsMgmt model.
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
     * Creates a new AdsMgmt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdsMgmt();
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->ads_image=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/ads/default.jpg';
            $model->created_date=date("Y-m-d g:i:s");
            $model->modify_date=date("Y-m-d g:i:s");
            if($model->save())
            {
                if($_FILES['AdsMgmt']['name']['ads_image']!="")
                {
                    if($_FILES['AdsMgmt']['size']['ads_image']<=2097152)    //2097152=2MB
                    {
                        $model->ads_image = UploadedFile::getInstance($model,'ads_image');
                        $id = $model->getPrimaryKey();
                        $dt=$model->ads_image->saveAs('upload/ads/'.$id.'.'.$model->ads_image->extension);                    
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/ads/'.$id.'.'.$model->ads_image->extension;
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/ads/default.jpg';
                        }       
                        $updatearr=array('ads_image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);  
                    } 
                }           
                return $this->redirect(['view', 'id' => $model->id]);
            }  
            return $this->redirect(['create']);
        } 
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdsMgmt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->ads_image=$model['oldAttributes']["ads_image"];
            $model->modify_date=date("Y-m-d g:i:s");
            $model->save();

            if($_FILES['AdsMgmt']['name']['ads_image']!="")
            {
                if($_FILES['AdsMgmt']['size']['ads_image']<=2097152)    //2097152=2MB
                {
                    $model->ads_image = UploadedFile::getInstance($model,'ads_image');
                    if(!empty($model->ads_image))
                    {
                        $dt=$model->ads_image->saveAs('upload/ads/'.$id.'.'.$model->ads_image->extension);                    
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/ads/'.$id.'.'.$model->ads_image->extension;
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/ads/default.jpg';
                        }       
                        $updatearr=array('ads_image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id); 
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
     * Deletes an existing AdsMgmt model.
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
     * Finds the AdsMgmt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdsMgmt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdsMgmt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdsmgmt()
    {
        $model = new AdsMgmt();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('adsmgmt', [
            'model' => $model,
        ]);
    }
}
