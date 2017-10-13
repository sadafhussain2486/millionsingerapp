<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\PushnotificationSearch;
use app\models\Amount;
//use app\models\CategoryUser;
use app\models\CategorySearch;
use app\models\NewsSearch;
use app\models\FeedbackSearch;
use app\models\GroupSearch;
use app\models\AmountSearch;
use app\models\SetTarget;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\swiftmailer\Mailer;
/**
 * UserController implements the CRUD actions for User model.
 */
error_reporting(0);
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {        
        //print_r(Yii::$app->user->isGuest);
        //$session = Yii::$app->session;
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {           
        $searchModel = new UserSearch();
        Yii::$app->language = 'zh-CN';
        //print_r(Yii::$app->session);
        //print_r(Yii::$app->request->queryParams);
        //$username = 'Alexander';
        //echo Yii::t('app', 'Hello, {username}!', ['username' => $username]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
 public function actionViewDet()
    {    
	}	
    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionViewsettarget($id)
    {
        $model4 = new SetTarget();   
        $targetdata=$model4->find()->where(['id' => $id, 'status' => 1])->one();

        return $this->render('viewsettarget',['data'=>$targetdata]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model1 = new UserSearch();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } */
        $data=array();
        if ($model->load(Yii::$app->request->post()) ) 
        {
            $data=Yii::$app->request->post();
			$model->nick_name = $data["User"]["nick_name"];
			$model->location = $data["User"]["location"];
			$model->age = $data["User"]["age"];
			$model->horoscope = $data["User"]["horoscope"];
			$model->dob = $data["User"]["dob"];
			$model->intro = $data["User"]["intro"];
			$model->image = $_FILES['User']['name']['image'];
            //$regid=$model1->generateRegId();
            $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);  
            // $otpcode=substr(mt_rand(100000,999999),0,6);
            // $data["otp_code"]=$otpcode;
            //$data["regid"]= $regid;
            // $data["session_key"]= $sessionkey;
            // $data["password"]= md5($data['User']['password']);
            // $data["image"]=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
            $data["verify_no"]=1;
            $data["status"]=1;
            $data["role"]=2;
			// $data["lang"]=2;
            $data["registration_type"]=1;
            $data["created_date"]=date("Y-m-d g:i:a");
            $data["updated_date"]=date("Y-m-d g:i:a");
            $model->scenario = User::SCENARIO_CREATE;
            $model->attributes = $data;
            if($data['User']['number'])
            {
                if($model->save())
                {
                    //SEND MAIL
                    // $to=$data["name"];
                    // $subject="This is Registration Mail";
                    // $username=$data["nick_name"];
                    // $from=Yii::$app->params['adminEmail'];
                    // $fromname=Yii::$app->params['adminName'];
                    //$message="Thankyou for Register With us <br><br> This is OTP code: ".$otpcode;
                    // require_once('email/registration.php');        //Message Variable Come From This File
                    // $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname);
                    //END MAIL
                    /*if($_FILES['User']['name']['image']!="")
                    {
                        if($_FILES['User']['size']['image']<=2097152)    //2097152=2MB
                        {
                            $model->image = UploadedFile::getInstance($model,'image');
                            $id = $model->getPrimaryKey();
                            $dt=$model->image->saveAs('upload/user/'.$id.'.'.$model->image->extension);
                            if(!empty($dt))
                            {
                                $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/'.$id.'.'.$model->image->extension;
                            }
                            else
                            {
                                $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                            }       
                            $updatearr=array('image' => $img);
                            $upd=$model->updateAll($updatearr, 'id = '.$id);   
                        } 
                    }*/          
                    return $this->redirect(['index']);
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
                    alert("Something Wrong")
                </script>
                <?php
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->image=$model['oldAttributes']["image"];
            $model->last_update_date=date("Y-m-d g:i:s");
            $model->save();   
            if($_FILES['User']['name']['image']!="")
            {
                if($_FILES['User']['size']['image']<=2097152)    //2097152=2MB
                {
                    $model->image = UploadedFile::getInstance($model,'image');
                    $id = $model->getPrimaryKey();
                    $dt=$model->image->saveAs('upload/user/'.$id.'.'.$model->image->extension);
                    if(!empty($dt))
                    {
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/'.$id.'.'.$model->image->extension;
                    }
                    else
                    {
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                    }       
                    $updatearr=array('image' => $img);
                    $upd=$model->updateAll($updatearr, 'id = '.$id); 
                }   
            }     
            return $this->redirect(['viewincome', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdatesettarget($id)
    {
        /*$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
        return $this->render('updatesettarget');
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUser()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('user', [
            'model' => $model,
        ]);
    }
 public function actionViewdetail($id)
    {
		$model = new User();
		$userdata=$model->find()->where(['id'=>$id])->one(); 
		// $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('viewdetail', [
            'model' => $model,
            'userdata' => $userdata,
        ]);
		// echo 'user';
		print_r($userdata);
	}
    public function actionViewincome1($id)
    {
        $model = new User();
        $model1 = new Amount(); 
        $model2 = new CategoryUser(); 
        $model3 = new UserSearch();
        $model4 = new SetTarget();        
        //$id=Yii::$app->request->get();
        //print_r(Yii::$app->request->post());
        $year = date("Y",strtotime(date('Y-m-d')));
        //$month = date("m",strtotime(date('Y-m')));   
        $searchmonth=@$_POST["analysiscat"];
        $searchyear=@$_POST["analysisyear"];
        (!empty($searchmonth))?$month=$searchmonth:$month=date('m');
        (!empty($searchyear))?$monthyear=$searchyear:$monthyear=date('Y');        
        $catdata=array();        
        if(!empty($searchmonth))
        {
            $amountdata=$model1->find()->where(['status' => 1, 'type' => 1, 'user_id'=>$id, 'account'=>0,'DATE_FORMAT(selectdate,"%Y-%m")'=>$monthyear."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all(); 

            $expensedata=$model1->find()->where(['status' => 1, 'type' => 2, 'user_id'=>$id, 'account'=>'!=0','DATE_FORMAT(selectdate,"%Y-%m")'=>$monthyear."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all(); 
        }        
        else
        {
            $amountdata=$model1->find()->where(['status' => 1, 'type' => 1, 'user_id'=>$id, 'account'=>0,'DATE_FORMAT(selectdate,"%Y-%m")'=>$monthyear."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all(); 

            $expensedata=$model1->find()->where(['status' => 1, 'type' => 2, 'user_id'=>$id, 'account'=>'!=0','DATE_FORMAT(selectdate,"%Y-%m")'=>$monthyear."-".$month])
                                ->orderBy(['selectdate'=>SORT_DESC])
                                ->all();   
        }
        $userdata=$model->find()->where(['id'=>$id])->one();   

        //$maxDays=date('t');
        //echo $currentDayOfMonth=date('w');
        //$model3->getExpenseMonthWise($type=2,$user=1,$month='2017-07-04',$userid=2);
        //THIS IS FOR SETTARGET SECTION ONLY         
        $checkcurrentmntdata=$model4->find()->where(['user_id' => $id,'group_id'=>0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();

        $targetdata=$model4->find()->where(['type'=>1,'user_id' => $id,'group_id' => 0, 'status' => 1])->orderBy(['id'=>SORT_DESC])->all();

        $currenttargetdata=$model4->find()->where(['type'=>1,'user_id' => $id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->one();
        //print_r($currenttargetdata);
        if(!empty($currenttargetdata))
        {
            $currenttarget=$currenttargetdata;
        }
        else
        {
            $currenttarget=array();
        }
        //echo $currenttarget;
        ##############################################################
        #               ANALYSIS PART START
        ##############################################################
        //$monthno=array('01','02','03','04','05','06','07','08','09','10','11','12');    
        if(isset($searchmonth) && !empty($searchmonth))
        {
            if($searchyear==date('Y',strtotime('last year')))
            {
                $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12'); 
                $cashyear=date('Y',strtotime('last year'));
            }   
            else
            {
                if($searchmonth=="12month")
                {
                    for ($i = 0; $i <= 11; $i++){
                        $monthno[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
                    }
                    $cashyear="";
                }
                else
                {
                    $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12'); 
                    $cashyear=date('Y');
                }
            }
        }
        else
        {
            if($searchyear==date('Y',strtotime('last year')))
            {
                $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12'); 
                $cashyear=date('Y',strtotime('last year'));

            }   
            else
            {
                $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12'); 
                $cashyear=date('Y');
            }            
        }    
        //print_r($monthno);
        //$currentyear=date('Y');
        $i=1;
        $j=1;
        $connection = Yii::$app->getDb();
        foreach ($monthno as $cashinmonth) 
        {
            //Cash In (Income)            
            $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".trim($cashyear."-".$cashinmonth,'-')."' AND type=1 and account=0 and status=1 and recordbudget=1 and user_id=".$id."");
            $analysiscashin['cashin'][$i++] = $commandamtindi->queryAll();

            //Cash Out (Expense)
            $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".trim($cashyear."-".$cashinmonth,'-')."' AND type=2 and account=0 and status=1 and recordbudget=1 and user_id=".$id."");
            $analysiscashin['cashout'][$j++] = $commandamtexp->queryAll();
        }
        
        //CATEGORY SECTION    
        //$analsmonth=(!empty($_POST["analysiscat"]))?date("m",strtotime(date('Y-'.$_POST["analysiscat"]))):date('m');
        $analsmonth=$month;
        ##################---NEW BUDGET----------#######################
        // $newbudget["withoutbudget"]=$model1->find()->where(['type'=>2,'DATE_FORMAT(selectdate, "%Y-%m")' => $monthyear."-".$analsmonth,'user_id' => $id,'account' => 0,'recordbudget'=>1])->groupBy(['category_id'])->all();
        $newbudget["withbudget"]=$model2->find()->where(['user_id'=>$id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$monthyear."-".$analsmonth,'status'=>'1'])->all();
      
        //print_r($newbudgetdata);
        //$analcategory=$ucatdata;

        ##################---NEW BUDGET END------#######################
        $ucatdata=$model2->find()->where(['user_id'=>$id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$monthyear."-".$analsmonth,'status'=>'1'])->all();
        $analcategory=$ucatdata;
        $ace=1;
        foreach ($analcategory as $analcatval) 
        {
            //Analysis Category wise  (Expense)            
            // $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".trim($cashyear."-".$analsmonth,'-')."' AND type=2 and account=0 and status=1 and recordbudget=1 and user_id=".$id." and category_id=".$analcatval["category_id"]."");
            $analysiscatexp['analycatexp'][$ace++] = $commandamtexp->queryAll();
        }
        //print_r($analysiscatexp);
        if(empty($analysiscatexp))
        {
            $analysiscatexp[]=0;
        }
        //Analysis Total Sum       
        $commandamttotexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".trim($cashyear."-".$analsmonth,'-')."' AND type=2 and account=0 and status=1 and recordbudget=1 and user_id=".$id."");
        $analysiscattotexp = $commandamttotexp->queryAll();
        $totalanacatexp=(empty($analysiscattotexp[0]['sum(amount)']))?'1':$analysiscattotexp[0]['sum(amount)'];
        //print_r($analysiscatexp);
        //END CATEGORY SECTION
        //print_r($analysiscashin);

        
        ##############################################################
        #               ANALYSIS PART END
        ##############################################################

        #################------RETURN DATA------######################
        // $catdata=['amount'=>$amountdata,'expense'=>$expensedata,'user'=>$userdata,'newbudgetdata'=>$newbudget,'categoryuser'=>$ucatdata,'targetuserdata'=>$targetdata,'currentmonth'=>$checkcurrentmntdata,'cashflow'=>$analysiscashin,'anaycatamt'=>$analysiscatexp,'anaycattotalamt'=>$totalanacatexp,'currenttarget'=>$currentmonthtarget["suggest_target"]];
        //print_r($catdata);
        echo $this->render('viewincome1',[
         'catdata' =>$catdata,
         'currenttarget'=>$currenttarget
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
            $currentmonthtarget=$model->find()->where(['user_id' => $id,'group_id' =>0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->orderBy(['id'=>SORT_DESC])->one();  

            //Cash In (Income)
            $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=1 and account=0 and status=1 and recordbudget=1 and user_id=".$id."");
            $analysiscashin=$commandamtindi->queryAll();
            $analcashin=round($analysiscashin[0]['sum(amount)']);
            //Cash Out (Expense)

            $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=2 and account=0 and status=1 and recordbudget=1 and user_id=".$id."");
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
            // $commandbudgettot = $connection->createCommand("SELECT sum(amount) FROM category_user where DATE_FORMAT(created_date,'%Y-%m')='".$year."-".$month."' and group_id=0 and status=1 and user_id=".$id."");
            $analysisbudgettot=$commandbudgettot->queryAll();
            $budgettotal=round($analysisbudgettot[0]['sum(amount)']);

            //Top Spent
            $ucatdata=$model1->find()->where(['user_id'=>$id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();
            $prevmax=0;
            $prevmin=0;
            $maxval=0;
            $minval=0;
            $category="";
            $categorymin="";
            foreach ($ucatdata as $budgetvalue) 
            {
                // $expget=$model2->getExpenseMonthWise($type=2,$user=1,$monthn=$year.'-'.$month,$budgetvalue["user_id"],$budgetvalue["category_id"]);

                // $minarr[$budgetvalue["category_id"]]=$expget;

                //$expminget=$model2->getExpenseMonthWise($type=2,$user=1,$monthm=$year.'-'.$month,$budgetvalue["user_id"],$budgetvalue["category_id"]);
                /*echo $expminget.'-'.$budgetvalue["category_id"];
                if(!empty($expget))
                {                    
                    if($expget>$prevmax)
                    {
                        $maxval=$expget;
                        $category=$model3->categoryname($budgetvalue["category_id"]);
                    }
                    $prevmax=$expget;
                }

                if(!empty($expminget))
                {                    
                    if($expminget<$prevmin)
                    {
                        $minval=$expminget;
                        $categorymin=$model3->categoryname($budgetvalue["category_id"]);
                    }
                    $prevmin=$expminget;
                }*/                
            }
            
            $value['minkey']=array_keys($minarr, min($minarr));
            // $categorymin=$model3->categoryname($value['minkey'][0]);
            $minval=min($minarr);

            $value['maxkey']=array_keys($minarr, max($minarr));
            // $categorymax=$model3->categoryname($value['maxkey'][0]);
            $maxval=max($minarr);
            
            //Spent
            $budgetdiff=($budgettotal-$analcashout);
            // $result=array('totalinome'=>$analcashin,'totalexpense'=>$analcashout,'settarget'=>round($currentmonthtarget['suggest_target']),'netcashflow'=>$netcashflow,'targetachi'=>$targetachi,'budgettotal'=>$budgettotal,'budgetdiff'=>$budgetdiff,'budgettopspent'=>$maxval,'maxcategory'=>$categorymax,'budgetminspent'=>$minval,'mincategory'=>$categorymin);
            echo json_encode($result);
        }        
    }
    public function actionDashboard()
    {
        //TOTAL DISPLAY SECTION
        $model1 = new UserSearch(); 
        $user=$model1->find()->where(['status'=>1])->andWhere(['!=','role', '1'])->all();
        $cntuser=count($user);

        // $model2 = new CategorySearch(); 
        // $category=$model2->find()->where(['status'=>1])->all();
        // $cntcategory=count($category);

        // $model3 = new NewsSearch(); 
        // $news=$model3->find()->where(['status'=>1])->all();
        // $cntnews=count($news);

        // $model4 = new FeedbackSearch(); 
        // $feedback=$model4->find()->where(['status'=>1])->all();
        // $cntfeedback=count($feedback);

        //GRID SECTION
        $weeklastdate=date('Y-m-d', strtotime('-7 days'));
        //User Section
        $weekuser=$model1->find()->where(['status'=>1])
                                ->andWhere(['>=','created_date', $weeklastdate])
                                ->andWhere(['!=','role', '1'])
                                ->all();

        //Group Section
        // $model5 = new GroupSearch(); 
        // $weekgroup=$model5->find()->where(['status'=>1])
                                // ->andWhere(['>=','created_date', $weeklastdate])
                                // ->all();

        //Income Section
        // $model6 = new AmountSearch(); 
        // $acctype=isset($_POST['incexpfilter'])?$_POST['incexpfilter']:'0';
        // $weekincome=$model6->find()->where(['status'=>1,'account'=>$acctype])
                                // ->andWhere(['>=','selectdate', $weeklastdate])
                                // ->all();

        $connection = Yii::$app->getDb();
        #########################################################################
                                //Chart Section INDIVIDUAL SECTION
        #########################################################################
        $posttype=$_POST["expensechart"];
        if(empty($_POST["expensechart"]) || $posttype==1)
        {
            //Individual Section GET Category
            // $expindicat=$model6->find()->where(['type'=>2,'account'=>0,'status'=>1])
                                    // ->groupBy('category_id')
                                    // ->all(); 
            if(!empty($expindicat))
            {
                //Chart Dashboard Exp Indi
                foreach ($expindicat as $expindival) {
                    $getcategindi[]=$model2->find()->where(['id'=>$expindival['category_id']])->one(); 
                }
            }
            // $expindi=$model6->find()->where(['type'=>2,'account'=>0,'status'=>1])->all();        

            if(!empty($expindi))
            {
                //GETTING TOTAL SUM
                $expinditotalsum="";
                foreach ($expindi as $expindivalue) {
                    $expinditotalsum+=$expindivalue['amount']; 
                }
                //GETTING PERCENTAGE                   
                foreach ($expindicat as $expindival) {                
                    $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where type=2 and account=0 and recordbudget=1 and status=1 and category_id=".$expindival['category_id']."");
                    $dataindiexp = $commandamtindi->queryAll();
                    $dataindiexpview[] =round($dataindiexp[0]['sum(amount)']);
                    $expinditotallist[]=round(($dataindiexp[0]['sum(amount)']*100)/$expinditotalsum,2);
                }
                $showlistexpindi=implode(",", $expinditotallist);
                //print_r($dataindiexpview);
            }
        }           

        #########################################################################
                            //Chart Section FAMILY SECTION
        #########################################################################
        if(isset($_POST["expensechart"]) && $posttype==2 || $posttype==3)
        {
            //Family Section GET Category
            $expfamilycat=$connection->createCommand("SELECT * FROM amount where `type`=2 and `account`!=0 and status=1 and recordbudget=1 GROUP BY category_id");
            $expfamilycategory = $expfamilycat->queryAll(); 
            foreach ($expfamilycategory as $expfamilyvalue) 
            {
                $arrayfamilycate=$model2->find()->where(['id'=>$expfamilyvalue['category_id'],'applied_for'=>$posttype])->one();
                if(!empty($arrayfamilycate))
                {
                    $getcategindi[]=$arrayfamilycate;    
                }                
            }           
            if(!empty($getcategindi))
            {
                //GETTING TOTAL SUM
                $expinditotalsum="";
                foreach ($getcategindi as $expindivalue) 
                {
                    $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where type=2 and status=1 and recordbudget=1 and category_id=".$expindivalue['id']."");
                    $expamtfamily = $commandamtindi->queryAll(); 
                    $expinditotalsum+=$expamtfamily[0]['sum(amount)']; 
                }
                //echo $expinditotalsum;
                //GETTING PERCENTAGE  
                foreach ($getcategindi as $expindival) {                
                    $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where type=2 and status=1 and recordbudget=1 and category_id=".$expindival['id']."");
                    $dataindiexp = $commandamtindi->queryAll(); 
                    $dataindiexpview[] =round($dataindiexp[0]['sum(amount)']);
                    $expinditotallist[]=round(($dataindiexp[0]['sum(amount)']*100)/$expinditotalsum,2);
                }
                $showlistexpindi=implode(",", $expinditotallist);
                //print_r($dataindiexpview);
            }
        }

        $data=array('category'=>$cntcategory,'news'=>$cntnews,'users'=>$cntuser,'feedback'=>$cntfeedback,'weekuser'=>$weekuser,'weekgroup'=>$weekgroup,'weekincome'=>$weekincome,'expchartindi'=>array('categorylist'=>$getcategindi,'categoryper'=>$showlistexpindi,'expinditotallist'=>$expinditotallist));

        echo $this->render('dashboard',['dashboarddata'=>$data]);
    }
    public function actionResetpassword()
    {
        $data=Yii::$app->request->post();
        if(!empty($data["id"]) && !empty($data["str"]))
        {            
            $newpassword = md5($data["str"]);
            $updatearr=array(
                'password' => $newpassword,                   
                'last_update_date' => date('Y-m-d g:i:s'),
                );
            $upd=User::updateAll($updatearr, 'id = '.$data['id']); 
            if ($upd==1)
            {
                $response['msg']="Update Successfully";
            } 
            else 
            {
                $response['msg']="Error Found.";
            }  
        }
        else 
        {
            $response['msg']="Invalid Data";
        }   
        echo $response["msg"];      
    }
    public function actionProfile()
    {
        $model = new User();
        $id=Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) ) 
        {
            $data=Yii::$app->request->post(); 
            empty($data["User"]["image"])?$data["User"]["image"]:$data["User"]["image"];
            $updatearr=array(
                'username' => $data["User"]["username"],
                'nick_name' => $data["User"]["nick_name"],     
                'last_update_date' => date('Y-m-d g:i:s'),
            );
            $upd=$model->updateAll($updatearr, 'id = '.$id);
            //FILE UPLOAD            
            if($_FILES['User']['name']['image']!="")
            {
                if($_FILES['News']['size']['file']<=2097152)    //2097152=2MB
                {
                    $model->image = UploadedFile::getInstance($model,'image');
                    $dt=$model->image->saveAs('upload/user/'.$id.'.'.$model->image->extension);
                    if(!empty($dt))
                    {
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/'.$id.'.'.$model->image->extension;
                    }
                    else
                    {
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                    }       
                    $updatearr2=array('image' => $img);
                    $upd2=$model->updateAll($updatearr2, 'id = '.$id); 
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
                                               
        }
        $userdata=$model->find()->where(['id'=>$id,'role'=>1])->one();
        //print_r($userdata);      
        return $this->render('profile', [
            'model' => $userdata,
        ]);
    } 
    //Change Admin Password   
    public function actionChangepassword()
    {
        $adminid=Yii::$app->user->identity->id;        
        if(Yii::$app->request->post())
        {
            $data=Yii::$app->request->post();
            if(!empty($adminid))
            {
                $model= new User();
                $dataadmin=$model->find()->where(['id'=>$adminid])->one();
                if(!empty($dataadmin))
                {
                    if($dataadmin["password"]==$data["currentpassword"])  
                    {
                        $newpassword = $data["newpassword"];
                        if($newpassword==$data["confirmpassword"])
                        {
                            $updatearr=array(
                                'password' => $newpassword,                   
                                'last_update_date' => date('Y-m-d g:i:s'),
                                );
                            $upd=User::updateAll($updatearr, 'id = '.$adminid); 
                            if ($upd==1)
                            {
                                ?>
                                <script type="text/javascript">
                                    alert("New Password Update Successfully.");
                                    window.location.href="<?php echo Yii::$app->request->baseUrl."/user/dashboard"?>";
                                </script>
                                <?php 
                            } 
                            else 
                            {
                                ?>
                                <script type="text/javascript">
                                    alert("There is some Error Found Try After Some Time.");
                                    window.location.href="<?php echo Yii::$app->request->baseUrl."/user/changepassword"?>";
                                </script>
                                <?php 
                            }  
                        }
                        else
                        {
                            ?>
                            <script type="text/javascript">
                                alert("New Password And Confirm Password Not Match.");
                                window.location.href="<?php echo Yii::$app->request->baseUrl."/user/changepassword"?>";
                            </script>
                            <?php 
                        }
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            alert("Old Password Not Match.");
                            window.location.href="<?php echo Yii::$app->request->baseUrl."/user/changepassword"?>";
                        </script>
                        <?php 
                    }
                }
            }            
        }         
        return $this->render('changepassword');    
    }
    //MAIL SECTION    
    public function actionMail()
    { 
        $data=$_POST;  
        //require(__DIR__ . '/extensions/smtpgmail.php'); 
        if(isset($_POST["submit"]) && $_POST["submit"]=="Send")
        {
            if(!empty($data["to"]) && !empty($data["subject"]))
            {
                $fetid=Yii::$app->request->get('id');
                if(empty($fetid))
                {
                    $id=Yii::$app->db->createCommand()->insert('email', [
                        'to' => $data["to"],
                        'subject' => $data["subject"],
                        'message' => $data["message"],
                        'status' => "1",
                        'created_date' => date('Y-m-d g:i:s'),
                        'modify_date' => date('Y-m-d g:i:s'),
                    ])->execute();
                }
                else
                {
                    $id=Yii::$app->db->createCommand()->update('email', [
                        'to' => $data["to"],
                        'subject' => $data["subject"],
                        'message' => $data["message"],
                        'modify_date' => date('Y-m-d g:i:s'),
                    ],'id='.$fetid)->execute();
                }
                /*echo $id;
                if($_FILES['attachment']['name']!="")
                {
                    if($_FILES['attachment']['size']<=2097152)    //2097152=2MB
                    {                        
                        $exp=explode(".", $_FILES['attachment']['name']);
                        $extension=end($exp);
                        $rt=['jpg','png'];
                        if(in_array(strtolower($extension), $rt))
                        {
                            $dt=move_uploaded_file($_FILES['attachment']['tmp_name'], '/upload/email/aasas.'.$extension.'');
                            if(!empty($dt))
                            {
                                $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/email/'.$id.'.'.$extension;
                                $upd2=Yii::$app->db->createCommand()->update('email', [
                                    'image' => $data["to"]
                                ],'id = '.$id)->execute();
                            }
                        }
                         else
                        {
                            ?>
                            <script type="text/javascript">
                                alert("Data Save But Image Extension not support.");
                            </script>
                            <?php
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
                }*/
                if(!empty($id))
                {
                    //SEND EMAIL                    
                    $to=$data["to"];
                    $subject=$data["subject"];
                    $message=$data["message"];
                    $from=Yii::$app->params['adminEmail'];
                    $fromname=Yii::$app->params['adminName'];
                    $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname); 
                    
                    if(!empty($returnmail))
                    {
                    ?>
                    <script type="text/javascript">
                        alert("Send Successfully");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/mail"?>";
                    </script>
                    <?php
                    }
                }
                
            }
            else
            {
                ?>
                <script type="text/javascript">
                    alert("Please Provide All Data.");
                </script>
                <?php
            }
        }
        echo $this->render('mail');
    }
    public function actionOutbox()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("Select * from email where id>0 order by id desc");
        $dataemail = $command->queryAll();
        $get=Yii::$app->request->get();
        if(isset($get['delete']) && !empty($get['delete']))
        {
            $connection ->createCommand()->delete('email', 'id='.$get['delete'].'')->execute();
            $this->redirect(['user/outbox']);
        }
        else
        {
            echo $this->render('outbox',['data'=>$dataemail]);
        }
        
    }
    public function actionSetting()
    {
        $connection = Yii::$app->getDb();        
        /*####################---------Start Children Section----------##########################*/
        if(isset($_POST["childexpense"]))
        {
            $data=$_POST;
            if($_POST["childexpense"]=="Save")
            {
                $return=Yii::$app->db->createCommand()->insert('calculation', [
                    'type' => "1",
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'status' => "1",
                    'created_date' => date('Y-m-d g:i:s'),
                    'modify_date' => date('Y-m-d g:i:s'),
                ])->execute();
                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Save Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
            if($_POST["childexpense"]=="Update")
            {
                $id=Yii::$app->request->get('id');
                $return=Yii::$app->db->createCommand()->update('calculation', [
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'modify_date' => date('Y-m-d g:i:s'),
                ],'id = '.$id)->execute();

                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Update Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
        }
        $command = $connection->createCommand("Select * from calculation where type=1");
        $datachildren = $command->queryAll(); 
        if(Yii::$app->request->get('type')==1)
        {
            if(!empty(Yii::$app->request->get('action')) && Yii::$app->request->get('action')=='update')
            {
                $id=Yii::$app->request->get('id');
                $editcommand = $connection->createCommand("Select * from calculation where type=1 and id=".$id."");
                $editvalue = $editcommand->queryAll(); 
            }
        }
        //print_r($editvalue);
        /*####################---------End Children Section----------##########################*/

        /*####################---------Start Child Ratio Section----------##########################*/
        if(isset($_POST["childratio"]))
        {
            $data=$_POST;
            if($_POST["childratio"]=="Save")
            {
                $return=Yii::$app->db->createCommand()->insert('calculation', [
                    'type' => "2",
                    'children' => $data["noofchildren"],
                    'percentage' => $data["percentage"],
                    'status' => "1",
                    'created_date' => date('Y-m-d g:i:s'),
                    'modify_date' => date('Y-m-d g:i:s'),
                ])->execute();
                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Save Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
            if($_POST["childratio"]=="Update")
            {
                $id=Yii::$app->request->get('id');
                $return=Yii::$app->db->createCommand()->update('calculation', [
                    'children' => $data["noofchildren"],
                    'percentage' => $data["percentage"],
                    'modify_date' => date('Y-m-d g:i:s'),
                ],'id = '.$id)->execute();

                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Update Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
        }
        $childcommand = $connection->createCommand("Select * from calculation where type=2");
        $datachildratio = $childcommand->queryAll(); 
        if(Yii::$app->request->get('type')==2)
        {
            if(!empty(Yii::$app->request->get('action')) && Yii::$app->request->get('action')=='update')
            {
                $id=Yii::$app->request->get('id');
                $editcommand = $connection->createCommand("Select * from calculation where type=2 and id=".$id."");
                $editvalue = $editcommand->queryAll(); 
            }
        }        
        /*####################---------End Child Ratio Section----------##########################*/

        /*####################---------Start family expense Section----------##########################*/
        if(isset($_POST["familyexpense"]))
        {
            $data=$_POST;
            if($_POST["familyexpense"]=="Save")
            {
                $return=Yii::$app->db->createCommand()->insert('calculation', [
                    'type' => "3",
                    'children' => $data["noofchildren"],
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'status' => "1",
                    'created_date' => date('Y-m-d g:i:s'),
                    'modify_date' => date('Y-m-d g:i:s'),
                ])->execute();
                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Save Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
            if($_POST["familyexpense"]=="Update")
            {
                $id=Yii::$app->request->get('id');
                $return=Yii::$app->db->createCommand()->update('calculation', [
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'modify_date' => date('Y-m-d g:i:s'),
                ],'id = '.$id)->execute();

                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Update Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
        }
        $command = $connection->createCommand("Select * from calculation where type=3");
        $datafamily = $command->queryAll(); 
        if(Yii::$app->request->get('type')==3)
        {
            if(!empty(Yii::$app->request->get('action')) && Yii::$app->request->get('action')=='update')
            {
                $id=Yii::$app->request->get('id');
                $editcommand = $connection->createCommand("Select * from calculation where type=3 and id=".$id."");
                $editvalue = $editcommand->queryAll(); 
            }
        }
        /*####################---------End family expense Section----------##########################*/

        /*####################---------Start House Hold Section----------##########################*/
        if(isset($_POST["household"]))
        {
            $data=$_POST;
            if($_POST["household"]=="Save")
            {
                $return=Yii::$app->db->createCommand()->insert('calculation', [
                    'type' => "4",
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'status' => "1",
                    'created_date' => date('Y-m-d g:i:s'),
                    'modify_date' => date('Y-m-d g:i:s'),
                ])->execute();
                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Save Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
            if($_POST["household"]=="Update")
            {
                $id=Yii::$app->request->get('id');
                $return=Yii::$app->db->createCommand()->update('calculation', [
                    'incomefrom' => $data["incomefrom"],
                    'incometo' => $data["incometo"],
                    'percentage' => $data["percentage"],
                    'modify_date' => date('Y-m-d g:i:s'),
                ],'id = '.$id)->execute();

                if(!empty($return))
                {
                    ?>
                    <script type="text/javascript">
                        alert("Update Successfully.");
                        window.location.href="<?php echo Yii::$app->request->baseUrl."/user/setting"; ?>";
                    </script>
                    <?php
                }
            }
        }
        $command = $connection->createCommand("Select * from calculation where type=4");
        $datahousehold = $command->queryAll(); 
        if(Yii::$app->request->get('type')==4)
        {
            if(!empty(Yii::$app->request->get('action')) && Yii::$app->request->get('action')=='update')
            {
                $id=Yii::$app->request->get('id');
                $editcommand = $connection->createCommand("Select * from calculation where type=4 and id=".$id."");
                $editvalue = $editcommand->queryAll(); 
            }
        }
        /*####################---------End House Hold Section----------##########################*/

        echo $this->render('setting',['data'=>['children'=>$datachildren,'childratio'=>$datachildratio,'family'=>$datafamily,'household'=>$datahousehold,'editval'=>$editvalue]]);
        
    }
    //CHANGE STATUS
    public function actionChangestatus()
    {        
        $id = Yii::$app->request->post('id');
        $data=array();
        if (isset($id)) 
        {
            $model= new User();
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
