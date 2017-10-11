<?php

namespace app\controllers;

use Yii;
use app\models\SetTarget;
use app\models\SetTargetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TargetController implements the CRUD actions for SetTarget model.
 */
class TargetController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        /*if(Yii::$app->user->isGuest)
        {
            $this->redirect(['site/login']);
        }*/
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
     * Lists all SetTarget models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SetTargetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SetTarget model.
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
     * Creates a new SetTarget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SetTarget();
        $type=Yii::$app->request->get('type');   
        $id=Yii::$app->request->get('id'); 
        if ($model->load(Yii::$app->request->post())) 
        {            
            $data=Yii::$app->request->post(); 
            $data2=Yii::$app->request->post();   
                 
            //print_r($data);
            $year = date("Y",strtotime(date('Y-m-d')));
            $month = date("m",strtotime(date('Y-m')));
            if($type==1) //INDIVIDUAL
            {
                $userdata=$model->find()->where(['user_id' => $id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
                $groupid=0;
            }
            if($type==2) //GROUP
            {
                $groupid=Yii::$app->request->get('groupid'); 
                $userdata=$model->find()->where(['group_id' => $groupid,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
                $data['income']=array_sum($data["income"]);
                $data['suggest_target']=$data["SetTarget"]["suggest_target"];
                $data['family_member']=0;
                $data['children_no']=0;
                $data['house_type']=0;
                $data['monthly_rent']=0;
                $data['investment_habit']=0;
                $data['working_member']=0;
                $data['confidence_meet_target']=0;
            }
            if(empty($userdata))    // FOR ADD 
            {
                $data['type']=$type;
                $data['user_id']=$id;
                $data['group_id']=$groupid;
                $data['created_date']=date('Y-m-d g:i:s');
                $data['modify_date']=date('Y-m-d g:i:s');

                $model->attributes = $data; 
                if ($model->save()) 
                {
                    $settargetid = $model->getPrimaryKey();
                    if($type==2)
                    {                      
                        foreach($data2['income'] as $key => $targetamt)
                        {
                            $targetdata=[
                                'settarget_id' => $settargetid,
                                'user_id' => $key,
                                'target_amount' => $targetamt,
                                'status' => "1",
                                'created_date' => date('Y-m-d g:i:s'),
                                'modify_date' => date('Y-m-d g:i:s'),
                            ];
                            $returnid=Yii::$app->db->createCommand()->insert('target_amount', $targetdata)->execute();
                            //print_r($targetdata);
                        }   
                    }
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
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } 
            else
            {
                ?>
                <script type="text/javascript">
                    alert("This Month Already Set Target.");
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
     * Updates an existing SetTarget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);       
        $connection=Yii::$app->getDB();
        if ($model->load(Yii::$app->request->post())) 
        {
            $data=Yii::$app->request->post('SetTarget'); 
            $data2=Yii::$app->request->post(); 
            $type=Yii::$app->request->get('type');  
            $year = date("Y",strtotime(date('Y-m-d')));
            $month = date("m",strtotime(date('Y-m')));   
            if($type==1)
            {                 
                $userdata=$model->find()->where(['user_id' => $model->user_id,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
            }
            if($type==2)
            {      
                $groupid=Yii::$app->request->get('groupid');             
                $userdata=$model->find()->where(['group_id' => $groupid,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
            }
            if(!empty($userdata))    // FOR ADD 
            {
                //print_r($userdata);
                if($type==1)
                {
                    $updatearr=array(
                        'income'=>$data['income'],
                        'family_member'=>$data['family_member'],
                        'children_no'=>$data['children_no'],
                        'house_type'=>$data['house_type'],
                        'monthly_rent'=>$data['monthly_rent'],
                        'investment_habit'=>$data['investment_habit'],
                        'suggest_target'=>$data['suggest_target'],
                        'working_member'=>$data['working_member'],
                        'confidence_meet_target'=>$data['confidence_meet_target'],
                        'modify_date' => date('Y-m-d g:i:s'),
                    );
                }
                if($type==2)
                {
                    $incomesum=array_sum($data2["income"]);
                    $updatearr=array(
                        'income'=>$incomesum,                    
                        'suggest_target'=>$data['suggest_target'],
                        'modify_date' => date('Y-m-d g:i:s'),
                    );
                }                
                $upd=SetTarget::updateAll($updatearr, 'id = '.$id);
                if ($upd===1) 
                {
                    if($type==2)
                    {                        
                        foreach($data2['income'] as $key => $targetamt)
                        {
                            $command = $connection->createCommand("Select * from target_amount where user_id='".$key."' and settarget_id='".$id."'");
                            $targetselect=$command->queryAll();
                            if(!empty($targetselect))       //FOR UPDATE
                            {
                                $targetid=Yii::$app->db->createCommand()->update('target_amount', [
                                    'settarget_id' => $id,
                                    'user_id' => $key,
                                    'target_amount' => $targetamt,
                                    'status' => "1",
                                    'modify_date' => date('Y-m-d g:i:s'),
                                ],'settarget_id = '.$id.' and user_id='.$key)->execute(); 
                            }
                            else
                            {
                                $targetdata2=[
                                    'settarget_id' => $id,
                                    'user_id' => $key,
                                    'target_amount' => $targetamt,
                                    'status' => "1",
                                    'created_date' => date('Y-m-d g:i:s'),
                                    'modify_date' => date('Y-m-d g:i:s'),
                                ];
                                $returnid=Yii::$app->db->createCommand()->insert('target_amount', $targetdata2)->execute();
                            }                                             
                        }
                        
                    }
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
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
            else
            {
                ?>
                <script type="text/javascript">
                    alert("This Month Already Set Target.");
                    window.close();
                </script>
                <?php
            }
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing SetTarget model.
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
     * Finds the SetTarget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SetTarget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SetTarget::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCalculatetarget()
    {
        $connection = Yii::$app->getDb();
        $data=Yii::$app->request->post();
        $type=$data["type"];
        if($type==1)        //Individual
        {   
            if($data["children"]>4)
            {
                $getchildren=4;
            }
            else
            {
                $getchildren=$data["children"];
            }
            if($data["familymem"]>5)
            {
                $getfamilymem=5;
            }
            else
            {
                if($data["familymem"]==0)
                {
                    $getfamilymem=1;
                }
                else
                {
                    $getfamilymem=$data["familymem"];
                }
            }
            $childrenmax = $connection->createCommand('Select max(incomefrom) from calculation where type=1');
            $childrenmaxvalue = $childrenmax->queryAll(); 
            //print_r($childrenmaxvalue);
            $childrenmax=$childrenmaxvalue[0]['max(incomefrom)'];
            if($childrenmax <= $data["income"])
            {
                $childrenvalue = $connection->createCommand('Select * from calculation where type=1 and incomefrom='.$childrenmax.'');
            }
            else
            {
                $childrenvalue = $connection->createCommand('Select * from calculation where type=1 AND "'.$data["income"].'" BETWEEN `incomefrom` AND `incometo`');
            }
            $datavalue = $childrenvalue->queryAll(); 

            //SECOND CALC
            if($getchildren>0)
            {
                $childrenmax2 = $connection->createCommand('Select * from calculation where type=2 AND children="'.$getchildren.'"');
                $datavalue2 = $childrenmax2->queryAll(); 
            }
            else
            {
                $datavalue2[0]['percentage']=0;
            }

            //THIRD CALC
            $childrenmax3 = $connection->createCommand('Select max(incomefrom) from calculation where type=3 AND children="'.$getfamilymem.'"');
            $childrenmaxvalue3 = $childrenmax3->queryAll(); 
            $childrenmax3=$childrenmaxvalue3[0]['max(incomefrom)'];
            if($childrenmax3 <= $data["income"])
            {
                $childrenvalue3 = $connection->createCommand('Select * from calculation where type=3 and incomefrom='.$childrenmax3.' AND children="'.$data["familymem"].'"');
            }
            else
            {
                $childrenvalue3 = $connection->createCommand('Select * from calculation where type=3 AND children="'.$data["familymem"].'" AND "'.$data["income"].'" BETWEEN `incomefrom` AND `incometo`');
            }
            $datavalue3 = $childrenvalue3->queryAll(); 

            //CALCULATION
            $childperc=($datavalue[0]['percentage']/100);
            $childratio=$datavalue2[0]['percentage'];
            $newpercration=($childperc*$childratio);
            $familyperc=$datavalue3[0]['percentage'];
            $finalperc=($data["income"]*($familyperc+$newpercration));
            $newfinalvalue=($data["income"]-$finalperc);
            if($data["confidence"]==1)
            {
                $confival=($newfinalvalue*0.70);            //70%
            }
            elseif($data["confidence"]==2)
            {
                $confival=($newfinalvalue*0.85);            //85%
            }
            elseif($data["confidence"]==3)
            {
                $confival=($newfinalvalue*1);            //100%
            }
            echo round($confival);
        }
        if($type==2)        //GROUP
        {   
            $childrenmax = $connection->createCommand('Select max(incomefrom) from calculation where type=4');
            $childrenmaxvalue = $childrenmax->queryAll(); 
            //print_r($childrenmaxvalue);
            $childrenmax=$childrenmaxvalue[0]['max(incomefrom)'];
            if($childrenmax <= $data["income"])
            {
                $childrenvalue = $connection->createCommand('Select * from calculation where type=4 and incomefrom='.$childrenmax.'');
            }
            else
            {
                $childrenvalue = $connection->createCommand('Select * from calculation where type=4 AND "'.$data["income"].'" BETWEEN `incomefrom` AND `incometo`');
            }
            $datavalue = $childrenvalue->queryAll();
            $newfinalvalue=0; 
            if(!empty($datavalue))
            {
                //CALCULATION
                $childperc=$datavalue[0]['percentage'];
                $finalperc=($data["income"]*$childperc);
                $newfinalvalue=($data["income"]-$finalperc);
            }
            echo round($newfinalvalue);
        }        
    }
}
