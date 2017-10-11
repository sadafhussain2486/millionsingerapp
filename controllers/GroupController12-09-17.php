<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupSearch;

use app\models\User;
use app\models\Amount; 
use app\models\CategoryUser;
use app\models\Notice;
use app\models\SetTarget;
use app\models\CategorySearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\UserSearch;
/**
 * GroupController implements the CRUD actions for Group model.
 */
error_reporting(0);
class GroupController extends Controller
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
        $model = new User();
        $model1 = new Amount(); 
        $model2 = new CategoryUser();        
        $model3 = new Group();
        $model4 = new SetTarget();  
        $model5 = new Notice();
        $model6 = new UserSearch();

        $year = date("Y",strtotime(date('Y-m-d')));
        //$month = date("m",strtotime(date('Y-m')));  
        (!empty(@$_POST["analysiscat"]))?$month=@$_POST["analysiscat"]:$month=date('m');

        $groupdata=$model3->find()->where(['id'=>$id])->one();
        //print_r($groupdata);
        //$id=Yii::$app->request->get();
        $catdata=array();
        if(!empty(@$_POST["analysiscat"]))
        {
            $amountdata=$model1->find()->where(['status' => 1, 'type' => 1, 'account'=>$id,'DATE_FORMAT(selectdate,"%Y-%m")'=>$year."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all();

            $expensedata=$model1->find()->where(['status' => 1, 'type' => 2,'account'=>$id,'DATE_FORMAT(selectdate,"%Y-%m")'=>$year."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all(); 
        }
        else
        {
            $amountdata=$model1->find()->where(['status' => 1, 'type' => 1, 'account'=>$id])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all(); 

            $expensedata=$model1->find()->where(['status' => 1, 'type' => 2,'account'=>$id])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all();   
        }        							

        $userdata=$model->find()->where(['id'=>$groupdata['user_id']])->one();        

        $noticedata=$model5->find()->where(['group_id' => $id])
                                ->orderBy(['id'=>SORT_DESC])
                                ->all(); 
                  
        $checkcurrentmntdata=$model4->find()->where(['group_id' => $id,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();

        $targetdata=$model4->find()->where(['group_id' => $id, 'status' => 1])->orderBy(['id'=>SORT_DESC])->all();
        ##############################################################
        #               ANALYSIS PART START
        ##############################################################
        $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12');        
        //print_r($month);
        $currentyear=date('Y');
        $i=1;
        $j=1;
        $connection = Yii::$app->getDb();
        foreach ($monthno as $cashinmonth) 
        {
            //Cash In (Income)
            $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$cashinmonth."' AND type=1 and account!=0 and status=1 and recordbudget=1 and account=".$id."");
            $analysiscashin['cashin'][$i++] = $commandamtindi->queryAll();

            //Cash Out (Expense)
            $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$cashinmonth."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account=".$id."");
            $analysiscashin['cashout'][$j++] = $commandamtexp->queryAll();
        }
        
        //CATEGORY SECTION 
        $analsmonth=(!empty($_POST["analysiscat"]))?date("m",strtotime(date('Y-'.$_POST["analysiscat"]))):date('m');
        
        $ucatdata=$model2->find()->where(['group_id'=>$groupdata['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$analsmonth,'status'=>'1'])->all();
        $analcategory=$ucatdata;
        
        $ace=1;
        foreach ($analcategory as $analcatval) 
        {
            //Analysis Category wise  (Expense)            
            $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$analsmonth."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account=".$id." and category_id=".$analcatval["category_id"]."");
            $analysiscatexp['analycatexp'][$ace++] = $commandamtexp->queryAll();
        }
        if(empty($analysiscatexp))
        {
            $analysiscatexp[]=0;
        }
        //Analysis Total Sum    
        $commandamttotexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$analsmonth."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account=".$id."");
        $analysiscattotexp = $commandamttotexp->queryAll();
        $totalanacatexp=(empty($analysiscattotexp[0]['sum(amount)']))?'1':$analysiscattotexp[0]['sum(amount)'];
        //print_r($analysiscatexp);
        //END CATEGORY SECTION
        //print_r($analysiscashin);

        //Net Spending Userwise
        $userlist=$model6->displayGroupUserForSelect($id);
        $n=1;
        //print_r($userlist);
        $totalnetspent=0;
        $netspent="";
        
        foreach ($userlist as $uservalue) 
        {           
            $commandnetexpuser = $connection->createCommand("SELECT sum(amount),user_id FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account='".$id."' and user_id='".$uservalue['id']."'");
            $commandnetexpuser123 = $commandnetexpuser->queryAll();
            $totalnetspent+=$commandnetexpuser123[0]["sum(amount)"];
            $netspent[]=array('amount'=>$commandnetexpuser123[0]["sum(amount)"],'user_id'=>$uservalue["id"]);
        }
        if($totalnetspent==0)
        {
            $totalnetspent=1;
        }
        $stringpercnet="";
        if(!empty($netspent))
        {
            foreach ($netspent as $usershowvalue) 
            {
                $netamount=$usershowvalue["amount"];
                $totalpernet[]=round((($netamount*100)/$totalnetspent),2);
            }
            $stringpercnet=implode(",", $totalpernet);      //FOR GRAPH
        }
        ##############################################################
        #               ANALYSIS PART END
        ##############################################################


        $catdata=['amount'=>$amountdata,'expense'=>$expensedata,'user'=>$userdata,'categoryuser'=>$ucatdata,'targetuserdata'=>$targetdata,'currentmonth'=>$checkcurrentmntdata,'groupdata'=>$groupdata,'noticedata'=>$noticedata,'cashflow'=>$analysiscashin,'anaycatamt'=>$analysiscatexp,'anaycattotalamt'=>$totalanacatexp,'netspent'=>$netspent,'totalnetspent'=>$totalnetspent,'stringpercnet'=>$stringpercnet];

        echo $this->render('view',[
         'catdata' =>$catdata
        ]);
    }

    public function actionDisplaysummary()
    {
        $id = Yii::$app->request->post('id');
        $data=array();
        if (isset($id)) 
        {
            $mnt=Yii::$app->request->post('month');
            $model= new SetTarget();
            $model1 = new CategoryUser(); 
            $model2= new UserSearch();
            $model3 = new CategorySearch(); 
            $connection = Yii::$app->getDb();

            $year = date("Y",strtotime(date('Y-m-d')));
            $month = date("m",strtotime(date('Y-'.$mnt)));  

            //FIND CURRENT SET TARGET 
            $currentmonthtarget=$model->find()->where(['group_id' =>$id,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->orderBy(['id'=>SORT_DESC])->one();  
            
            //Cash In (Income)
            $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=1 and account=".$id." and status=1 and recordbudget=1");
            $analysiscashin=$commandamtindi->queryAll();
            $analcashin=round($analysiscashin[0]['sum(amount)']);
            //Cash Out (Expense)

            $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=2 and account=".$id." and status=1 and recordbudget=1");
            $analysiscashout=$commandamtexp->queryAll();     
            $analcashout=round($analysiscashout[0]['sum(amount)']);

            //NET CASH FLOW
            $netcashflow=($analcashin-$analcashout);
            if($analcashin>=$analcashout)
            {
                $targetachi="Passed";
            }
            else
            {
                $targetachi="Failed";
            }

            ###########################################################################
            #       BUDGET SECTION
            ###########################################################################
            //Total Budget
            $commandbudgettot = $connection->createCommand("SELECT sum(amount) FROM category_user where DATE_FORMAT(created_date,'%Y-%m')='".$year."-".$month."' and group_id=".$id." and status=1");
            $analysisbudgettot=$commandbudgettot->queryAll();
            $budgettotal=round($analysisbudgettot[0]['sum(amount)']);

            //Top Spent
            $ucatdata=$model1->find()->where(['group_id'=>$id,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();
            $prevmax=0;
            $prevmin=0;
            $maxval=0;
            $minval=0;
            $category="";
            $categorymin="";
            $minarr="";
            foreach ($ucatdata as $budgetvalue) 
            {                
                $expget=$model2->getExpenseMonthWise($type=2,$user=2,$monthn=$year."-".$month,$budgetvalue["group_id"],$budgetvalue["category_id"]);
                $minarr[$budgetvalue["category_id"]]=$expget;
                /*if(!empty($expget))
                {                    
                    if($expget>$maxval)
                    {
                        $maxval=$expget;            //1000 500 200 500
                        $category=$model3->categoryname($budgetvalue["category_id"]);
                    }
                    $prevmax=$expget;
                    //FOR MIN
                    if($expget<$prevmin)
                    {
                        $minval=$expget;         //1000 500 200 500
                        $categorymin=$model3->categoryname($budgetvalue["category_id"]);
                    }
                    $prevmin=$expget;
                }*/                
            }
            $value['minkey']=@array_keys($minarr, @min($minarr));
            $categorymin=$model3->categoryname($value['minkey'][0]);
            $minval=min($minarr);

            $value['maxkey']=array_keys($minarr, @max($minarr));
            $categorymax=$model3->categoryname($value['maxkey'][0]);
            $maxval=@max($minarr);

            //Spent
            $budgetdiff=($budgettotal-$analcashout);
            $result=array('totalinome'=>$analcashin,'totalexpense'=>$analcashout,'settarget'=>round($currentmonthtarget['suggest_target']),'netcashflow'=>$netcashflow,'targetachi'=>$targetachi,'budgettotal'=>$budgettotal,'budgetdiff'=>$budgetdiff,'budgettopspent'=>$maxval,'maxcategory'=>$categorymax,'budgetminspent'=>$minval,'mincategory'=>$categorymin);
            echo json_encode($result);
        }        
    }
    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } */
        if ($model->load(Yii::$app->request->post()) ) 
        {
            $model->group_icon=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/default.jpg';
            $model->created_date=date("Y-m-d g:i:s");
            $model->modify_date=date("Y-m-d g:i:s");
            //print_r($model->attributes);
            if($model->save())
            {
                if($_FILES['Group']['name']['group_icon']!="")
                {
                    if($_FILES['Group']['size']['group_icon']<=2097152)    //2097152=2MB
                    {
                        $model->group_icon = UploadedFile::getInstance($model,'group_icon');
                        $id = $model->getPrimaryKey();
                        $dt=$model->group_icon->saveAs('upload/group/'.$id.'.'.$model->group_icon->extension);
                        
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/'.$id.'.'.$model->group_icon->extension;
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/default.jpg';
                        }       
                        $updatearr=array('group_icon' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id); 
                    }  
                }           
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        else 
        {        
            return $this->render('create',[
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            if($_FILES['Group']['name']['group_icon']!="")
            {
                if($_FILES['Group']['size']['group_icon']<=2097152)    //2097152=2MB
                {
                    $model->group_icon = UploadedFile::getInstance($model,'group_icon');            
                    if(!empty($model->group_icon))
                    {               
                        $dt=$model->group_icon->saveAs('upload/group/'.$id.'.'.$model->group_icon->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/'.$id.'.'.$model->group_icon->extension;               
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/default.jpg';
                        }
                        
                        $updatearr=array(
                                    'group_icon' => $img,
                                    );
                        $upd=$model->updateAll($updatearr, 'id = '.$id); 
                        
                    }
                }
            }
            return $this->redirect(['index']);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGroup()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('group', [
            'model' => $model,
        ]);
    }
    //CHANGE STATUS
    public function actionChangestatus()
    {        
        $id = Yii::$app->request->post('id');
        $data=array();
        if (isset($id)) 
        {
            $model= new Group();
            $datanot=$model->find()->where(['id'=>$id])->one();
            if(!empty($datanot))
            {
                //print_r($datanot);
                if(!empty($datanot))
                {
                    if($datanot["status"]==1)
                    {
                        $updval=array(
                            'status'=>0,
                            );
                        echo "0";
                    }
                    else
                    {
                        $updval=array(
                            'status'=>1,
                            );
                        echo "1";
                    }
                    $upd=$model->updateAll($updval, 'id = '.$id);
                }                
            }            
        }         
    }   
}
