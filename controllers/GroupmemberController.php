<?php

namespace app\controllers;

use Yii;
use app\models\GroupMember;
use app\models\GroupmemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Group;
/**
 * GroupmemberController implements the CRUD actions for GroupMember model.
 */
class GroupmemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if(Yii::$app->user->isGuest==1)
        {
            ?>
            <script type="text/javascript">
                window.location.href="<?php echo Yii::$app->request->baseUrl; ?>";
            </script>
            <?php 
        }
        $this->enableCsrfValidation = false; 
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
     * Lists all GroupMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupmemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GroupMember model.
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
     * Creates a new GroupMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupMember();
        if (!empty($_POST)) 
        {
            $data=Yii::$app->request->post();
           
            $model->sent_by=$data["sent_by"];
            $model->user_id=$data["user_id"];
            $model->group_id=$data["group_id"];
            $model->invite_status=1;
            $model->exit_by=0;
            $model->remove_by=0;
            $model->status=1;
            $model->created_date=date('Y-m-d g:i:s');
            $model->modify_date=date('Y-m-d g:i:s');
            
            $model->attributes($data);
            //print_r($model->attributes);
            if($model->save())
            {
                ?>
                <script type="text/javascript">
                    alert("Save Successfully");
                    window.opener.location.reload();
                    window.close();
                </script>
                <?php 
            }
            else
            {
                ?>
                <script type="text/javascript">
                    alert("Not Save");
                    window.close();
                </script>
                <?php 
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GroupMember model.
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
     * Deletes an existing GroupMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemove()
    {
        $id = Yii::$app->request->post('id');
        $data=array();
        if (isset($id)) 
        {
            $model= new GroupMember();
            $datanot=$this->findModel($id);
            if(!empty($datanot))
            {
                if(!empty($datanot))
                {
                    if($datanot["exit_by"]==1)
                    {
                        $updval=array(
                            'exit_by'=>0,
                            );
                        echo "0";
                    }
                    else
                    {
                        $updval=array(
                            'exit_by'=>1,
                            );
                        echo "1";
                    }
                    $upd=$model->updateAll($updval, 'id = '.$id);
                }                
            } 
        }
    }
    /**
     * Finds the GroupMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupMember::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGroupmember()
    {
        $model = new GroupMember();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('groupmember', [
            'model' => $model,
        ]);
    }
    public function actionViewmember()
    {
        $model = new Groupmember();
        $model2 = new Group();
        $grpname="";
        $groupdata="";
        $data = $model->find()->where(['invite_status'=>1,'group_id'=>Yii::$app->request->get('id')])->all();
        $grpname = $model2->find()->where(['id'=>Yii::$app->request->get('id')])->one();
        //print_r($grpname);               
        //print_r($data);
        return $this->render('viewmember', [
            'data' => $data,
            'groupname' => $grpname["group_name"],
        ]);
    }

}
