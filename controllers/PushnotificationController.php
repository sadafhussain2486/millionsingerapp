<?php

namespace app\controllers;

use Yii;
use app\models\Pushnotification;
use app\models\PushnotificationSearch;

use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;
/**
 * Pushnotification implements the CRUD actions for Pushnotification model.
 */
class PushnotificationController extends Controller
{
    /**
     * @inheritdoc
     */    
    public function behaviors()
    {   
        //$this->enableCsrfValidation = false;     
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
     * Lists all Pushnotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PushnotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pushnotification model.
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
     * Creates a new Pushnotification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pushnotification();   
        $model2= new PushnotificationSearch(); 
        $model3= new UserSearch();        
        /*$title="Testing Andriod";
        $description="Testing Andriod description2";
        $url="http://eb01.com.hk/mit/web/assets/f45111d2/dist/img/login-logo.png";
        //$registerid="eIRCpiNq48g:APA91bF4xS7Gc3w_xF4kuK1tn5nIYTfCmzNd4NWyb7JkuMQ3fmzdShT3YHAXWQhOvBwgUbbfJM-6cWc880Nvn5FvCmmQ0eBQ5a9-pMhyhLMeKElQa92Wr21BgMUCoeTbBNlVE1Njhonc";
        //$registerid="dBva4yKutws:APA91bE6m5EweRUI1Yl39aLbExKCtFOk_usRYQDrV3NH9t7JbUY0Q2tW9M1IzgoKHiGSN_tqweJZfxdf-BwOi22kwVOJTkE5FDPne1zB-AJEBU1bD6O0MsO1thAh03fR6Mmg-im8f8XA";
        $model2->androidnotify($title,$description,$url,$registerid);*/
        if ($model->load(Yii::$app->request->post())) 
        {   
            $userid='0';
            /*if(!empty($model->user_id))
            {
                $userid=implode(",", $model->user_id);
            }*/
            $model->image = "";
            $model->user_id=$userid;
            $model->created_date=date('Y-m-d g:i:s');
            $model->modify_date=date('Y-m-d g:i:s');
            if($model->save())
            {
                $img="";
                if($_FILES['Pushnotification']['name']['image']!="")
                {
                    if($_FILES['Pushnotification']['size']['image']<=2097152)    //2097152=2MB
                    {
                        $id = $model->getPrimaryKey();
                        $model->image = UploadedFile::getInstance($model,'image');
                        $dt=$model->image->saveAs('upload/notify/'.$id.'.'.$model->image->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/notify/'.$id.'.'.$model->image->extension;
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/notify/default.jpg';
                        }       
                        $updatearr=array('image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);   
                    }                    
                }
                //SEND NOTIFICATION
                if(!empty($img))
                {
                    $url=$img;
                }
                else
                {
                    $url=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl."/assets/f45111d2/dist/img/login-logo.png";
                }
                $alluser=$model3->find()->where(['status'=>1,'role'=>2])->andWhere(['!=','register_id',''])->all();
                if(!empty($alluser))
                {
                    foreach ($alluser as $uservalue) 
                    {
                        $title=$model->title;
                        $description=$model->description;                        
                        $registerid=$uservalue["register_id"];
                        $model2->androidnotify($title,$description,$url,$registerid);
                    }
                    
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else 
            {
                return $this->render('create', [
                    'model' => $model,
                ]);
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
     * Updates an existing Pushnotification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);        
       
        if ($model->load(Yii::$app->request->post())) 
        {
            $userid=$model->user_id;
            if(!empty($model->user_id))
            {
                $userid=implode(",", $model->user_id);
            }
            $model->image = "";
            $model->user_id=$userid;
            $model->modify_date=date('Y-m-d g:i:s');
            $model->save();

            if($_FILES['Pushnotification']['name']['image']!="")
            {
                if($_FILES['Pushnotification']['size']['image']<=2097152)    //2097152=2MB
                {
                    $model->image = UploadedFile::getInstance($model,'image');            
                    if(!empty($model->image))
                    {               
                        $dt=$model->image->saveAs('upload/notify/'.$id.'.'.$model->image->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/notify/'.$id.'.'.$model->image->extension;               
                        }
                        else
                        {
                            $img = "";
                        }
                        
                        $updatearr=array(
                                    'image' => $img,
                                    );
                        $upd=$model->updateAll($updatearr, 'id = '.$id);                  
                    }
                }
                else
                {
                    ?>
                    <script type="text/javascript">
                        alert("Data Save But Image Not Save, (is too large).");
                    </script>
                    <?php
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
     * Deletes an existing Pushnotification model.
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
     * Finds the Pushnotification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pushnotification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pushnotification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPushnotification()
    {
        $model = new Pushnotification();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('Pushnotification', [
            'model' => $model,
        ]);
    }   
}
