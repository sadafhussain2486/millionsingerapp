<?php

namespace app\controllers;

use Yii;
use app\models\Amount;
use app\models\AmountSearch;
use app\models\CategoryUser;
use app\models\CategorySearch;
use app\models\User;
use app\models\UserSearch;
use app\models\Group;
use app\models\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * AmountController implements the CRUD actions for Amount model.
 */
class AmountController extends Controller
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
     * Lists all Amount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AmountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Amount model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionViewdetail($id)
    {
        $model = new Amount();

        $amountdata=$model->find()->where(['id'=>$id])->one();
        echo json_encode($amountdata['attributes']);
    }
    /**
     * Creates a new Amount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //echo Yii::$app->request->get('id');
        $model = new Amount();
        $model2= new UserSearch();     
        $model3= new GroupSearch();        
        if ($model->load(Yii::$app->request->post())) 
        {
            $account=Yii::$app->request->get('applied');
            $type=Yii::$app->request->get('type');            
            $id=Yii::$app->request->get('id');
            $groupid=Yii::$app->request->get('groupid');

            $data=Yii::$app->request->post('Amount');
            if(empty($groupid))
            {
                $newgroupid=0;
                $userid=$id;
            }
            else
            {
                $newgroupid=$groupid;
                $userid=$data["user_id"];
            }
            
            #####################--OPENING BALANCE MANAGE--#########################
            if(empty($groupid))  //Individual
            {
                $opening=$model2->find()->where(["id"=>$userid])->one();
                if($type==1)        //INCOME
                {
                    $nowbalance=$opening['opening_balance'];
                    $nowincome=$data["amount"];
                    $totalopb=round(($nowbalance+$nowincome),2);
                }
                else                //EXPENSE
                {
                    $nowbalance=$opening['opening_balance'];
                    $nowexpense=$data["amount"];
                    //$totalopb=$opening['opening_balance'];      //SET DEFAULT
                    $totalopb=round(($nowbalance-$nowexpense),2);
                    /*if($nowbalance>=$nowexpense)
                    {
                        $totalopb=round(($nowbalance-$nowexpense),2);
                        
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            alert("Opening Balance is less than Expense Amount.");
                            window.opener.location.reload();
                            window.close();
                        </script>
                        <?php
                        exit;
                    }   */                 
                }
                //print_r($opening);
            }
            else                //GROUP
            {
                $opening=$model3->find()->where(["id"=>$newgroupid])->one();
                if($type==1)        //INCOME
                {
                    $nowbalance=$opening['opening_balance'];
                    $nowincome=$data["amount"];
                    $totalopb=round(($nowbalance+$nowincome),2);
                }
                else                //EXPENSE
                {
                    $nowbalance=$opening['opening_balance'];
                    $nowexpense=$data["amount"];
                    //$totalopb=$opening['opening_balance'];      //SET DEFAULT
                    $totalopb=round(($nowbalance-$nowexpense),2);
                    /*if($nowbalance>=$nowexpense)
                    {
                        $totalopb=round(($nowbalance-$nowexpense),2);                        
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            alert("Opening Balance is less than Expense Amount.");
                            window.opener.location.reload();
                            window.close();
                        </script>
                        <?php
                        exit;
                    }*/                    
                }
                //print_r($opening);
            }
            ###################--END OPENING BALANCE MANAGE--#######################

            $model->type=$type;
            $model->user_id=$userid;
            $model->selectdate=date('Y-m-d');
            $model->category_id=$data["category_id"];
            $model->payment_detail=$data["payment_detail"];
            $model->amount=$data["amount"];
            $model->account=$newgroupid;
            $model->note=$data["note"];
            $model->repeat=($data["repeat"]=="")?'0':$data["repeat"];
            $model->repitition_period=($data["repitition_period"]=="")?'0':$data["repitition_period"];
            $model->recordbudget=$data["recordbudget"];
            $model->status=1;
            $model->created_date=date('Y-m-d g:i:s');
            $model->modify_date=date('Y-m-d g:i:s');
            if($model->save())
            {
                //=========OPENING BALANCE===========                
                if(empty($groupid))
                {
                    $updopb=array('opening_balance' => $totalopb);
                    $upd=$model2->updateAll($updopb, 'id = '.$userid);
                }
                else
                {
                    $updopb=array('opening_balance' => $totalopb);
                    $upd=$model3->updateAll($updopb, 'id = '.$newgroupid);
                }
                //=========END OPENING BALANCE=======
                if($_FILES['Amount']['name']['bill_image']!="")
                {
                    if($_FILES['Amount']['size']['bill_image']<=2097152)    //2097152=2MB
                    {
                        $model->bill_image = UploadedFile::getInstance($model,'bill_image');
                        $id = $model->getPrimaryKey();
                        $dt=$model->bill_image->saveAs('upload/amount/'.$id.'.'.$model->bill_image->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/amount/'.$id.'.'.$model->bill_image->extension;
                        }
                        else
                        {
                            $img = '';
                        }       
                        $updatearr=array('bill_image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);   
                    } 
                } 
                //return $this->redirect(['view', 'id' => $model->id]);
                ?>
                <script type="text/javascript">
                    alert("Data Save Successfully");
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
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Amount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2= new UserSearch();     
        $model3= new GroupSearch(); 
        if ($model->load(Yii::$app->request->post())) 
        {            
            $data=Yii::$app->request->post('Amount');
            $account=Yii::$app->request->get('applied');
            $groupid=Yii::$app->request->get('groupid');
            $type=Yii::$app->request->get('type');
            $id=Yii::$app->request->get('id');
            /*if($account==2)
            {
                $model->user_id=$data["user_id"];
            }*/
            if($account==1)
            {
                $userid=Yii::$app->request->get('userid');
            }
            else
            {
                $userid=$data["user_id"];
            }
            #####################--OPENING BALANCE MANAGE--#########################
            if(empty($groupid))  //Individual
            {
                $opening=$model2->find()->where(["id"=>$userid])->one();
                $openingold=$model->find()->where(["id"=>$id])->one();
                //print_r($openingold);
                if($type==1)        //INCOME
                {
                    $nowbalance=$opening['opening_balance'];
                    $oldincome=$openingold["amount"];        //AMOUNT TABLE INCOME
                    $nowincome=$data["amount"];
                    $totalopb=round((($nowbalance-$oldincome)+$nowincome),2);
                }
                else                //EXPENSE
                {
                    $nowbalance=$opening['opening_balance'];
                    $oldincome=$openingold["amount"];        //AMOUNT TABLE INCOME
                    $nowexpense=$data["amount"];
                    //$totalopb=$opening['opening_balance'];      //SET DEFAULT
                    $totalopb=round((($nowbalance+$oldincome)-$nowexpense),2); 
                    /*if($nowbalance>=$nowexpense)
                    {
                        $totalopb=round((($nowbalance+$oldincome)-$nowexpense),2);                        
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            alert("Opening Balance is less than Expense Amount.");
                            window.opener.location.reload();
                            window.close();
                        </script>
                        <?php
                        exit;
                    }*/                    
                }
                //print_r($opening);
            }
            else                //GROUP
            {
                $opening=$model3->find()->where(["id"=>$groupid])->one();
                $openingold=$model->find()->where(["id"=>$id])->one();
                if($type==1)        //INCOME
                {
                    $nowbalance=$opening['opening_balance'];
                    $oldincome=$openingold["amount"];        //AMOUNT TABLE INCOME
                    $nowincome=$data["amount"];
                    $totalopb=round((($nowbalance-$oldincome)+$nowincome),2);
                }
                else                //EXPENSE
                {
                    $nowbalance=$opening['opening_balance'];
                    $oldincome=$openingold["amount"];        //AMOUNT TABLE INCOME
                    $nowexpense=$data["amount"];
                    //$totalopb=$opening['opening_balance'];      //SET DEFAULT
                    $totalopb=round((($nowbalance+$oldincome)-$nowexpense),2);   
                    /*if($nowbalance>=$nowexpense)
                    {
                        $totalopb=round((($nowbalance+$oldincome)-$nowexpense),2);          
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            alert("Opening Balance is less than Expense Amount.");
                            window.opener.location.reload();
                            window.close();
                        </script>
                        <?php
                        exit;
                    } */                   
                }
                //print_r($opening);
            }
            ###################--END OPENING BALANCE MANAGE--#######################
            $model->user_id=$userid;
            $model->category_id=$data["category_id"];
            $model->payment_detail=$data["payment_detail"];
            $model->amount=$data["amount"];
            $model->note=$data["note"];
            $model->repeat=($data["repeat"]=="")?'0':$data["repeat"];
            $model->repitition_period=($data["repitition_period"]=="")?'0':$data["repitition_period"];
            $model->recordbudget=$data["recordbudget"];
            
            if($model->save())
            {
                //=========OPENING BALANCE===========                
                if(empty($groupid))
                {
                    $updopb=array('opening_balance' => $totalopb);
                    $upd=$model2->updateAll($updopb, 'id = '.$userid);
                }
                else
                {
                    $updopb=array('opening_balance' => $totalopb);
                    $upd=$model3->updateAll($updopb, 'id = '.$groupid);
                }
                //=========END OPENING BALANCE=======
                if($_FILES['Amount']['name']['bill_image']!="")
                {
                    if($_FILES['Amount']['size']['bill_image']<=2097152)    //2097152=2MB
                    {
                        $model->bill_image = UploadedFile::getInstance($model,'bill_image');
                        $dt=$model->bill_image->saveAs('upload/amount/'.$id.'.'.$model->bill_image->extension);
                        if(!empty($dt))
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/amount/'.$id.'.'.$model->bill_image->extension;
                        }
                        else
                        {
                            $img = '';
                        }       
                        $updatearr=array('bill_image' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);   
                    } 
                } 
                ?>
                <script type="text/javascript">
                    alert("Data Save Successfully");
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
            //return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,  
            ]);
        }
    }

    /**
     * Deletes an existing Amount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model2 = new UserSearch();
        $model4 = new GroupSearch();
        $model3 = new Amount();
        //echo $currpage = Yii::$app->controller->id;
        $exp=explode("?", $_SERVER["HTTP_REFERER"]);
        $exp2=explode("/", $exp[0]);
        $endpage=end($exp2);
        //FETCH USER OPENING BALANCE3
        $singledata=$model3->find()->where(['id'=>$id])->one();        
        if($singledata["type"]==1)              //INCOME
        {
            if($endpage=="viewincome")              //USER  
            {
                $userdata=$model2->find()->where(["id"=>$singledata["user_id"]])->one();            //USER TABLE
                $previncome=$userdata["opening_balance"];
                $delamount=$singledata["amount"];
                $newamount=($previncome-$delamount);
                $updateopening=array(
                    'opening_balance' => $newamount,
                    'last_update_date' => date('Y-m-d g:i:s'),
                    );
                $upd=$model2->updateAll($updateopening, 'id='.$userdata["id"].'');
            }
            if($endpage=="view")                    //GROUP
            {
                $userdata=$model4->find()->where(["id"=>$singledata["account"]])->one();            //GROUP TABLE
                $previncome=$userdata["opening_balance"];
                $delamount=$singledata["amount"];
                $newamount=($previncome-$delamount);
                $updateopening=array(
                    'opening_balance' => $newamount,
                    'modify_date' => date('Y-m-d g:i:s'),
                    );
                $upd=$model4->updateAll($updateopening, 'id='.$userdata["id"].'');
            }
            
        }
        else                                    //EXPENSE
        {
            if($endpage=="viewincome")              //USER  
            {
                $userdata=$model2->find()->where(["id"=>$singledata["user_id"]])->one();            //USER TABLE
                $previncome=$userdata["opening_balance"];
                $delamount=$singledata["amount"];
                $newamount=($previncome+$delamount);
                $updateopening=array(
                    'opening_balance' => $newamount,
                    'last_update_date' => date('Y-m-d g:i:s'),
                    );
                $upd=$model2->updateAll($updateopening, 'id='.$userdata["id"].'');
            }
            if($endpage=="view")                    //GROUP
            {   
                $userdata=$model4->find()->where(["id"=>$singledata["account"]])->one();            //GROUP TABLE
                $previncome=$userdata["opening_balance"];
                $delamount=$singledata["amount"];
                $newamount=($previncome+$delamount);
                $updateopening=array(
                    'opening_balance' => $newamount,
                    'modify_date' => date('Y-m-d g:i:s'),
                    );
                $upd=$model4->updateAll($updateopening, 'id='.$userdata["id"].'');
            }            
        }
        //print_r($updateopening);
        $this->findModel($id)->delete();        
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Amount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Amount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Amount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAmount()
    {
        $model = new Amount();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('amount', [
            'model' => $model,
        ]);
    }
    public function actionBudget()
    {
        $model = new CategoryUser();
        $model2 = new CategorySearch();
        //$id=Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) ) 
        {            
            $data=Yii::$app->request->post(); 
            $groupid=Yii::$app->request->get('group');
            if($groupid!=0)
            {
                $newusersid=$data["CategoryUser"]["user_id"];
                $newgroupid=Yii::$app->request->get('group');
            }
            else
            {
                $newusersid=Yii::$app->request->get('id');
                $newgroupid=Yii::$app->request->get('group');
            }
            $model->user_id=$newusersid;
            $model->group_id=$newgroupid;
            $model->status=1;
            $model->created_date=date('Y-m-d g:i:s');
            $model->modify_date=date('Y-m-d g:i:s');
            $selectedcategorylist=$model2->displaySelectedCategory($model->user_id,$groupid);
            if(in_array($model->category_id, $selectedcategorylist))
            {
                ?>
                <script type="text/javascript">
                    alert("This Category is Already Save");
                </script>
                <?php 
                 return $this->render('budget', [
                        'model' => $model,
                    ]);
            }
            else
            {
                if($model->save())
                {
                    ?>
                    <script type="text/javascript">
                        alert("Data Save Successfully");
                        window.opener.location.reload();
                        window.close();
                    </script>
                    <?php 
                }
                else
                {
                    ?>
                    <script type="text/javascript">
                        alert("Data Not Save Successfully");
                    </script>
                    <?php 
                    return $this->render('budget', [
                        'model' => $model,
                    ]);
                }  
            }                               
        } 
        else
        {
            return $this->render('budget', [
                'model' => $model,
            ]);
        }    
        
    }
    public function actionBudgetupdate()
    {
        $model = new CategoryUser();        
        if (Yii::$app->request->post()) 
        {
            $data=Yii::$app->request->post(); 
            $id=$data["id"];
            $updatearr=array('amount' => $data["amount"],'group_id' => $data["group"],'repeat_type' => $data["repeat"]);
            $upd=$model->updateAll($updatearr, 'id = '.$id); 
        }
    }
    public function actionViewbudgetexpense()
    {
        $model = new Amount();     
        $model2 = new CategorySearch();        
        if (Yii::$app->request->post()) 
        {
            $data=Yii::$app->request->post(); 
            if($data["account"]==0)
            {
                $amountdata=$model->find()->where(['type' => 2, 'user_id'=>$data["id"], 'category_id'=>$data["categoryid"], 'account'=>$data["account"]])->orderBy(['selectdate'=>SORT_DESC])->all();     
            }
            else
            {
                $amountdata=$model->find()->where(['type' => 2, 'category_id'=>$data["categoryid"], 'account'=>$data["account"]])->orderBy(['selectdate'=>SORT_DESC])->all();  
            }
            
            if(!empty($amountdata)):?>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Payment Detail</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Image</th>
                            <th>Repeat</th>
                        </tr>
                        <?php 
                        $r=1;
                        foreach ($amountdata as $value): ?>
                        <tr>
                            <td><?php echo $r++; ?></td>                              
                            <td>
                                <?php echo $value["payment_detail"]; ?>
                                <br><small class="badge badge-primary"><?php echo $value["selectdate"]; ?></small>
                            </td>
                            <td><?php echo $model2->categoryname($value["category_id"]); ?></td>                              
                            <td><?php echo $value["amount"]; ?></td>
                            <td><?php echo $value["note"]; ?></td>                              
                            <td><a href="javascript:;" onclick="showimage('myImg2')"><img id="myImg2" src="<?php echo $value["bill_image"]; ?>" height="50" width="50" /></a></td>
                            <td>
                                <small><?php echo($value["repeat"]==1)?'Yes':'No'; ?></small><br>
                                <small>
                                    <?php 
                                        if($value["repitition_period"]==1){echo "Daily"; }
                                        elseif($value["repitition_period"]==2){echo "Weekly"; }
                                        elseif($value["repitition_period"]==3){echo "Monthly"; } 
                                        elseif($value["repitition_period"]==4){echo "Quaterly"; }
                                        elseif($value["repitition_period"]==5){echo "Half-Yearly"; }
                                        elseif($value["repitition_period"]==6){echo "Yearly"; }
                                    ?>
                                        
                                </small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>                    
                </table>
                <?php                 
            endif;
        }
    }
}
