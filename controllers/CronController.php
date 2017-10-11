<?php

namespace app\controllers;

use Yii;
use app\models\Amount;
use app\models\AmountSearch;
use app\models\SetTarget;
use app\models\CategoryUser;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoticecommentController implements the CRUD actions for NoticeComment model.
 */
class CronController extends Controller
{   
    public function actionIncome()
    {
        $model = new Amount();
        $repeat=Yii::$app->request->get('repeat');
        $repeatperiod=Yii::$app->request->get('period');
        if(!empty($repeat) && !empty($repeatperiod))
        {              
            if($repeatperiod=="daily")
            {
                $lastday = date('Y-m-d', strtotime(' -1 day')); 
                $userstatus=$model->find()->where(['repeat'=>1,'repitition_period'=>1,'status'=>1,'selectdate'=>''.$lastday.''])->orderBy(['selectdate'=>SORT_DESC])->all();  
                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            elseif($repeatperiod=="weekly")
            {
                $lastweek=date("Y-m-d", strtotime("last week monday"));
                $currweek = date("Y-m-d",strtotime(date('Y-m-d')));  
                $connection = Yii::$app->getDb();  
                $commandamtindi = $connection->createCommand('SELECT * FROM `amount` WHERE DATE_FORMAT(selectdate,"%Y-%m-%d") BETWEEN "'.$lastweek.'" AND "'.$currweek.'" AND `status`=1 AND `repeat`=1 AND `repitition_period`=2');
                $userstatus = $commandamtindi->queryAll();
                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    //print_r($model->attributes);
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            elseif($repeatperiod=="monthly")
            {
                $date = date("Y-m",strtotime('last month'));
                $userstatus=$model->find()->where(['DATE_FORMAT(selectdate,"%Y-%m")'=>$date, 'repeat'=>1,'repitition_period'=>3])->all();
                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    //print_r($model->attributes);
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            elseif($repeatperiod=="quaterly")
            { 
                $quaterdate = date("Y-m",strtotime('-3 month'));
                $currmonth = date("Y-m-d",strtotime(date('Y-m-d')));  
                $connection = Yii::$app->getDb();                
                $commandamtindi = $connection->createCommand('SELECT * FROM `amount` WHERE DATE_FORMAT(selectdate,"%Y-%m-%d") BETWEEN "'.$quaterdate.'" AND "'.$currmonth.'" AND `status`=1 AND `repeat`=1 AND `repitition_period`=4');
                $userstatus = $commandamtindi->queryAll();

                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    //print_r($model->attributes);
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            elseif($repeatperiod=="halfyearly")
            {
                $halfyeardate = date("Y-m",strtotime('-6 month'));
                $currmonth = date("Y-m-d",strtotime(date('Y-m-d')));  
                $connection = Yii::$app->getDb();                
                $commandamtindi = $connection->createCommand('SELECT * FROM `amount` WHERE DATE_FORMAT(selectdate,"%Y-%m-%d") BETWEEN "'.$halfyeardate.'" AND "'.$currmonth.'" AND `status`=1 AND `repeat`=1 AND `repitition_period`=5');
                $userstatus = $commandamtindi->queryAll();  
                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    //print_r($model->attributes);
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            elseif($repeatperiod=="yearly")
            {
                $halfyeardate = date("Y-m",strtotime('-1 year'));
                $currmonth = date("Y-m-d",strtotime(date('Y-m-d')));  
                $connection = Yii::$app->getDb();                
                $commandamtindi = $connection->createCommand('SELECT * FROM `amount` WHERE DATE_FORMAT(selectdate,"%Y-%m-%d") BETWEEN "'.$halfyeardate.'" AND "'.$currmonth.'" AND `status`=1 AND `repeat`=1 AND `repitition_period`=6');
                $userstatus = $commandamtindi->queryAll(); 

                foreach ($userstatus as $value) 
                {
                    $model->type=$value["type"];
                    $model->user_id=$value["user_id"];
                    $model->selectdate=date('Y-m-d');
                    $model->category_id=$value["category_id"];
                    $model->payment_detail=$value["payment_detail"];
                    $model->amount=$value["amount"];
                    $model->account=$value["account"];
                    $model->note=$value["note"];
                    $model->repeat=$value["repeat"];
                    $model->repitition_period=$value["repitition_period"];
                    $model->status=1;
                    $model->created_date=date('Y-m-d g:i:s');
                    $model->modify_date=date('Y-m-d g:i:s');
                    //print_r($model->attributes);
                    /*if($model->save())
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }
                print_r($userstatus);
            }
            else
            {
                echo "Invalid Parameter.";
            }
        }
        else
        {
            echo "Direct Access Not Allow.";
        }
    }

    ################################################################################################
    #                               SET TARGET SECTION
    ################################################################################################
    public function actionSettarget()
    {
        //$this->layout = false;
        $repeatperiod=Yii::$app->request->get('period');
        if(!empty($repeatperiod) && $repeatperiod=="monthly")
        {  
            $model = new SetTarget();
            $date = date("Y-m",strtotime('last month'));
            $userdata=$model->find()->where(['DATE_FORMAT(created_date,"%Y-%m")'=>$date, 'status' => 1])->all();
            if(!empty($userdata))    // FOR ADD 
            {
                foreach ($userdata as $value) 
                {
                    $data['user_id']=$value["user_id"];
                    $data['type']=$value["type"];
                    $data['group_id']=$value["group_id"];
                    $data['income']=$value["income"];
                    $data['family_member']=$value["family_member"];
                    $data['children_no']=$value["children_no"];
                    $data['house_type']=$value["house_type"];
                    $data['monthly_rent']=$value["monthly_rent"];
                    $data['investment_habit']=$value["investment_habit"];
                    $data['suggest_target']=$value["suggest_target"];
                    $data['working_member']=$value["working_member"];
                    $data['confidence_meet_target']=$value["confidence_meet_target"];
                    $data['status']=$value["status"];
                    $data['created_date']=date('Y-m-d g:i:s');
                    $data['modify_date']=date('Y-m-d g:i:s');
                    $model->attributes = $data; 
                    print_r($model->attributes);
                    /*if ($model->save()) 
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }                
            }
        }
        else
        {
            echo "Direct Access Not Allow.";
        }
    }

    ################################################################################################
    #                               BUDGET SECTION
    ################################################################################################
    public function actionBudget()
    {
        $repeatperiod=Yii::$app->request->get('period');
        if(!empty($repeatperiod))
        {  
            $model = new CategoryUser();
            if($repeatperiod=="weekly")
            {   
                $week = date("Y-m-d", strtotime("last week monday"));
                $currweek = date("Y-m-d",strtotime(date('Y-m-d')));  
                $connection = Yii::$app->getDb();                
                $commandamtindi = $connection->createCommand('SELECT * FROM `category_user` WHERE DATE_FORMAT(created_date,"%Y-%m-%d") BETWEEN "'.$week.'" AND "'.$currweek.'" AND `status`=1 AND `repeat_type`=1');
                $userdata = $commandamtindi->queryAll();
                              
            }
            
            if($repeatperiod=="monthly")
            {
                $date = date("Y-m",strtotime('last month'));
                $currdate = date("Y-m",strtotime(date('Y-m-d')));
                $userdata=$model->find()->where(['DATE_FORMAT(created_date,"%Y-%m")'=>$date, 'status' => 1, 'repeat_type' => 2])
                        ->andWhere(['!=','DATE_FORMAT(created_date,"%Y-%m")',$currdate])
                        ->all();
            }
            
            if(!empty($userdata))    // FOR ADD 
            {
                foreach ($userdata as $value) 
                {
                    $data['user_id']=$value["user_id"];
                    $data['group_id']=$value["group_id"];
                    $data['category_id']=$value["category_id"];
                    $data['amount']=$value["amount"];
                    $data['repeat_type']=$value["repeat_type"];
                    $data['status']=$value["status"];
                    $data['created_date']=date('Y-m-d g:i:s');
                    $data['modify_date']=date('Y-m-d g:i:s');
                    $model->attributes = $data; 
                    print_r($model->attributes);
                    /*if ($model->save()) 
                    {
                        echo "User ID: ".$value["user_id"]." New Record Insert. Date: ".date('Y-m-d g:i:s');
                    }
                    else
                    {
                        echo "User ID".$value["user_id"]." Record Not Insert. Date: ".date('Y-m-d g:i:s');
                    }*/
                }                
            }
        }
        else
        {
            echo "Direct Access Not Allow.";
        }
    }
}
