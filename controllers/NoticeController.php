<?php

namespace app\controllers;

use Yii;
use app\models\Notice;
use app\models\NoticeSearch;
use app\models\NoticeComment;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends Controller
{
    /**
     * @inheritdoc
     */    
    public function behaviors()
    {   
        $this->enableCsrfValidation = false;     
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
     * Lists all Notice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notice model.
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
     * Creates a new Notice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notice();

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->group_id=Yii::$app->request->get('group');
            $model->created_date=date('Y-m-d g:i:s');
            $model->modify_date=date('Y-m-d g:i:s');
            $model->save();
            ?>
                <script type="text/javascript">
                    alert("Save Successfully");
                    window.opener.location.reload();
                    window.close();
                </script>
            <?php 
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->modify_date=date('Y-m-d g:i:a');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ?>
                <script type="text/javascript">
                    alert("Save Successfully");
                    window.opener.location.reload();
                    window.close();
                </script>
            <?php 
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Notice model.
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
     * Finds the Notice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionNotice()
    {
        $model = new Notice();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('notice', [
            'model' => $model,
        ]);
    }
    public function actionViewcomment()
    {        
        $id = Yii::$app->request->post('id');
        $data=array();
        if (isset($id)) 
        {
            $model = new NoticeComment();
            $model1= new UserSearch();
            $datanot=$model->find()->where(['notice_id'=>$id])->all();
            if(!empty($datanot))
            {
                //$data['data']=$datanot;
                $i=1;
                foreach ($datanot as $value) 
                {
                    echo '
                    <tr>
                        <td>'.$i++.'</td>
                        <td>'.$model1->displayname($value["user_id"]).'</td>
                        <td>'.$value["comment"].'</td>
                        <td>'.$value["created_date"].'</td>
                        <td>&nbsp;</td>
                    </tr>
                    ';
                }
            }
            else
            {
                $data['error']="Data not Found.";
            }
        } 
        else 
        {
            $data['error'] = "Ajax failed";
        }
        //return $data;
        //return \yii\helpers\Json::encode($data);
    }
}
