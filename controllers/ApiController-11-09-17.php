<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Group;
use app\models\GroupMember;
use app\models\ExpenseCategory;
use app\models\IncomeCategory;
use app\models\Category;
use app\models\IncomeAmount;
use app\models\ExpenseAmount;
use app\models\SetTarget;
use app\models\Pages;
use app\models\News;
use app\models\Feedback;
use app\models\Notice;
use app\models\NoticeComment;
use app\models\Amount;
use app\models\CategoryUser;
use app\models\CategorySearch;
use app\models\AdsmgmtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\connection;
use yii\web\UploadedFile;
/**
 * UserController implements the CRUD actions for User model.
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */   
    //public $layout=false;
    public $enableCsrfValidation=false;
    public function behaviors()
    {
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
        /*$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        echo "403 This Page is Forbidden.";
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

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    ##############################################################################################
    #                       REGISTER USER SECTION                                                #
    ##############################################################################################
    public function actionCreateuser()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();       
        //print_r($model->attributes);      //THIS IS GIVE THE ALL COLUMN OF TABLE
        //echo $otpcode=substr(mt_rand(100000,999999),0,6);        
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            $error=$model2->validateRegister($data);

            if($error['error'])
            {
                $response=$error;
            }
            else
            {   
                $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);  
                $regid=$model2->generateRegId();
                $otpcode=substr(mt_rand(100000,999999),0,6);                    
                //$otpcode="123456";
                if($data["register_by"]==1)
                {
                    if(!empty($data["device_id"]) && !empty($data["device_type"]) && !empty($data["register_id"]))
                    {
                        $hashpassword = md5($data["password"]);   
                        $data["regid"]= $regid;             
                        $data['password']=$hashpassword;
                        $data['otp_code']=$otpcode;
                        $data['otpverify']=0;                    
                        $data['facebook_id']="";
                        $data['status']=1;
                        $data['role']=2;
                        $data['token']=$sessionkey;
                        $data['created_date']=date('Y-m-d g:i:s');
                        $data['last_update_date']=date('Y-m-d g:i:s');
                        $model->device_type=$data["device_type"];
                        $model->register_id=$data["register_id"];
                        $model->scenario = User::SCENARIO_CREATE;
                        $model->attributes = $data;
                        //print_r($data);
                        if ($model->save()) 
                        {
                            //SEND MAIL
                            $to=$data["username"];
                            $subject="This is Registration Mail";
                            $username=$data["username"];
                            $from=Yii::$app->params['adminEmail'];
                            $fromname=Yii::$app->params['adminName'];
                            //$message="Thankyou for Register With us <br><br> This is OTP code: ".$otpcode;
                            require_once('email/registration.php');        //Message Variable Come From This File
                            $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname);
                            //END MAIL
                            $response['error']=false;
                            $response['userid']=$model->getPrimaryKey();
                            $response['token']=$sessionkey;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        } 
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=202;
                            $response['msg']="Not Save";
                        } 
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";  
                    }
                    
                }
                elseif($data["register_by"]==2)         //SOCIAL LOGIN
                { 
                    if(!empty($data["device_id"]) && !empty($data["device_type"]) && !empty($data["register_id"]) && !empty($data["facebook_id"]) && !empty($data["gender"]) && !empty($data["nick_name"]) && !empty($data["image"]))
                    {                        
                        $data["regid"]= $regid;       
                        $datea['otpverify']=1;
                        $data['status']=1;
                        $data['role']=2;
                        $data['token']=$sessionkey;
                        $data['created_date']=date('Y-m-d g:i:s');
                        $data['last_update_date']=date('Y-m-d g:i:s'); 
                        $model->device_type=$data["device_type"];                   
                        $model->facebook_id=$data["facebook_id"];
                        $model->image=$data["image"];
                        $model->nick_name=$data["nick_name"];
                        $model->gender=ucwords($data["gender"]);
                        $model->age=$data["age"];
                        $model->mobile_no=$data["mobile_no"];
                        $model->scenario = User::SCENARIO_CREATE;
                        $model->attributes = $data;
                        //print_r($model->attributes);
                        if ($model->save()) 
                        {
                            //SEND MAIL
                            $to=$data["username"];
                            $subject="This is Registration Mail";
                            $username=$data["username"];
                            $from=Yii::$app->params['adminEmail'];
                            $fromname=Yii::$app->params['adminName'];

                            require_once('email/fbregistration.php');        //Message Variable Come From This File
                            $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname);
                            //END MAIL
                            $response['error']=false;
                            $response['userid']=$model->getPrimaryKey();
                            $response['token']=$sessionkey;
                            $response['userverify']=1;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        } 
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=202;
                            $response['msg']="Not Save";
                        }                       
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";  
                    }
                }
                else 
                {
                    $response['error']=true;
                    $response['statuscode']=512;
                    $response['msg']="Invalid Request";
                } 
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
        die;
    }
    ##############################################################################################
    #                       USER CHANGE EMAIL SECTION                                            #
    ##############################################################################################
    public function actionChangeemail()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]) && isset($data["email"]) && !empty($data["email"]) && isset($data["email"]))
            {            
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {                    
                    $emailcheck=$model->find()->where(['username'=>$data["email"]])->one(); 
                    if(empty($emailcheck))
                    {
                        $email=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                        if($email["otpverify"]!=1)
                        {
                            $otpcode=$email["otp_code"];
                           
                            //SEND MAIL
                            $to=$data["email"];
                            $subject="This is Email Change Mail";
                            $from=Yii::$app->params['adminEmail'];
                            $fromname=Yii::$app->params['adminName'];

                            $username=(!empty($email["nick_name"]))?$email["nick_name"]:$email["username"];
                            require_once('email/changepassword.php');        //Message Variable Come From This File
                            $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname);
                            //END MAIL
                            //UPDATE INTO DATABASE
                            $updatearr=array(
                                'username' => $data["email"],                   
                                'last_update_date' => date('Y-m-d g:i:s'),
                                );
                            $upd=User::updateAll($updatearr, 'id = '.$email['id']); 

                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        }
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=413;
                            $response['msg']="Email Not Change";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=303;
                        $response['msg']="Email is already registered.";
                    }                    
                } 
                else 
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }                
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";                
            }                
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);      
    }
    ##############################################################################################
    #                       OTP VERIFY SECTION                                                   #
    ##############################################################################################
    public function actionOtpverify()
    {   
        $response=array();
        $model2=new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["otpcode"]))
                    {
                        //$otpcode="123456";
                        $user=$model2->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                        if($user["otp_code"]==trim($data["otpcode"]))
                        //if($otpcode==trim($data["otpcode"]))
                        {
                            //UPDATE INTO DATABASE
                            $updatearr=array(
                                'otpverify' => 1,                   
                                'last_update_date' => date('Y-m-d g:i:s'),
                                );
                            $upd=User::updateAll($updatearr, 'id = '.$getid['id']); 

                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=404;
                            $response['msg']="Invalid Otp Code.";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=401;
                        $response['msg']="Please Enter Value";
                    } 
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }                       
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
    }
    ##############################################################################################
    #                       USER DETAIL UPDATE SECTION                                           #
    ##############################################################################################
    public function actionUserupdate()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();        
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $error=$model2->validateUpdate($data);
                    if($error['error'])
                    {
                        $response=$error;
                    }
                    else
                    {
                        $updatearr=array(
                            'mobile_no' => $data["mobile_no"],
                            'nick_name' => $data["nick_name"],
                            'occupation' => $data["occupation"],   
                            'gender' => $data["gender"],
                            'age' => $data["age"],  
                            'opening_balance' => $data["opening_balance"],                 
                            'last_update_date' => date('Y-m-d g:i:s'),
                        );                                      
                        $upd=User::updateAll($updatearr, 'id = '.$getid["id"]); 
                        if ($upd===1)
                        {
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        } 
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=202;
                            $response['msg']="Not Save";
                        }
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=402;
                $response['msg']="Token Not Matched";
            }                      
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
        die;
    }
    ##############################################################################################
    #                       USER UPDATE PROFILE PIC SECTION                                      #
    ##############################################################################################
    public function actionProfilepic()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();        
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($_FILES))
                    {
                        $path=Yii::getAlias('@webroot');
                        $model->image = UploadedFile::getInstanceByName('image');                        
                        if($model->image) 
                        {   
                            $userdata=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 

                            $fullpath=$path.'/upload/user/'.$getid["id"].time().'.'.$model->image->extension;
                            $model->image->saveAs($fullpath);
                            $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/'.$getid["id"].time().'.'.$model->image->extension;
                            $updatearr=array(
                                'image' => $webpath,
                                );
                            $upd=User::updateAll($updatearr, 'id = '.$getid["id"]); 
                            if ($upd===1)
                            {
                                //Delete Image                                
                                if(!empty($userdata["image"]))
                                {
                                    $emp=explode("/", $userdata["image"]);
                                    $imgname=end($emp);
                                    @unlink( '.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.$imgname);
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }
                        }
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=416;
                            $response['msg']="Error Found";
                        }
                    }  
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=402;
                $response['msg']="Token Not Matched";
            }                      
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
        die;
    }
    ##############################################################################################
    #                       USER DETAIL VIEW SECTION                                             #
    ##############################################################################################
    public function actionAlluser()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        $count=20;
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]) && !empty($data["data"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                    if($data["data"]=="single")        //SINGLE PROFILE
                    {
                        $catdata=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                        if(!empty($catdata))
                        {                            
                            $cat[]=array(
                                    'user_id' => $catdata['id'],
                                    'registerid'=>$catdata['regid'],
                                    'email'=>$catdata['username'],
                                    'nick_name'=>(!empty($catdata['nick_name']))?$catdata['nick_name']:$catdata['username'],
                                    'facebook_id'=>$catdata['facebook_id'],
                                    'image'=>(!empty($catdata['image']))?$catdata['image']:$defaultimg,
                                    'mobile_no' => $catdata["mobile_no"],
                                    'alternate_no' => (!empty($catdata["alternate_no"]))?$catdata["alternate_no"]:'',
                                    'device_id' => $catdata["device_id"],
                                    'otpverify'=>$catdata['otpverify'],         
                                    'occupation' => $catdata["occupation"],   
                                    'gender' => $catdata["gender"],
                                    'age' => $catdata["age"],  
                                    'register_by' => $catdata["register_by"],
                                    'status' => $catdata["status"],
                                    'opening_balance' => round($catdata["opening_balance"],0),                 
                                    'created_date' => $catdata["created_date"],
                                    'last_update_date' => $catdata["last_update_date"],     
                                );
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                            $response['users']=$cat;
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        } 
                    }
                    elseif($data["data"]=="all")                            //ALL USER PROFILE
                    {
                        if(!empty($data["page"]))
                        {      
                            $page=$data["page"];                   
                            if($page==0)
                            {
                                $offset=0;
                            }
                            else
                            {
                                $offset=$count*$page;
                            }                  
                            $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
                                            ->orderBy(['nick_name'=>SORT_ASC])
                                            ->limit($count)
                                            ->offset($offset)
                                            ->all(); 
                        }
                        else
                        {
                            $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
                                            ->orderBy(['nick_name'=>SORT_ASC])
                                            ->all(); 
                        }                        
                        if(!empty($catdata))
                        {
                            foreach ($catdata as $value) 
                            {       
                                $cat[]=array(                                    
                                    'user_id' => $value['id'],
                                    'registerid'=>$value['regid'],
                                    'email'=>$value['username'],
                                    'nick_name'=>(!empty($value['nick_name']))?$value['nick_name']:$value['username'],
                                    'facebook_id'=>$value['facebook_id'],
                                    'image'=>(!empty($value['image']))?$value['image']:$defaultimg,
                                    'mobile_no' => $value["mobile_no"],
                                    'alternate_no' => (!empty($value["alternate_no"]))?$value["alternate_no"]:'',
                                    'device_id' => $value["device_id"],
                                    'otpverify'=>$value['otpverify'],         
                                    'occupation' => $value["occupation"],   
                                    'gender' => $value["gender"],
                                    'age' => $value["age"],  
                                    'register_by' => $value["register_by"],
                                    'status' => $value["status"],
                                    'opening_balance' => round($value["opening_balance"],2),
                                    'created_date' => $value["created_date"],
                                    'last_update_date' => $value["last_update_date"],                           
                                );
                            }
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                            $response['users']=$cat;
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        } 
                    }
                    elseif($data["data"]=="search")                            //ALL USER PROFILE
                    {
                        if(isset($data["key"]))
                        {
                            if(isset($data["page"]))
                            {      
                                $page=$data["page"];                   
                                if($page==0)
                                {
                                    $offset=0;
                                }
                                else
                                {
                                    $offset=$count*$page;
                                }                 
                                $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
                                                ->andFilterWhere(['like', 'username', $data["key"]])
                                                ->orFilterWhere(['like', 'nick_name', $data["key"]])
                                                ->orderBy(['nick_name'=>SORT_ASC])
                                                ->limit($count)
                                                ->offset($offset)
                                                ->all(); 
                            }
                            else
                            {
                                $catdata=$model->find()->where(['status'=>1,'otpverify'=>1])
                                                ->andFilterWhere(['like', 'username', $data["key"]])
                                                ->orFilterWhere(['like', 'nick_name', $data["key"]])
                                                ->orderBy(['nick_name'=>SORT_ASC])
                                                ->all(); 
                            }                        
                            if(!empty($catdata))
                            {
                                foreach ($catdata as $value) 
                                {       
                                    $cat[]=array(                                    
                                        'user_id' => $value['id'],                                        
                                        'email'=>$value['username'],
                                        'nick_name'=>(!empty($value['nick_name']))?$value['nick_name']:$value['username'],
                                        'image'=>(!empty($value['image']))?$value['image']:$defaultimg                           
                                    );
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['users']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            } 
                        }
                        else
                        {   
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=512;
                        $response['msg']="Invalid Request";
                    }                     
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }                     
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       LOGIN SECTION                                                        #
    ##############################################################################################
    public function actionLogin()
    {           
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {            
            $data=Yii::$app->request->post();
            $error=$model2->validateLogin($data);
            if($error['error'])
            {
                $response=$error;
            }
            else
            {   
                if(isset($data["register_by"]) && !empty($data["register_by"]) && isset($data["device_type"]) && !empty($data["device_type"]))
                {
                    $userdata=$model->find()->where(['username' => $data['username'], 'role' => 2, 'status' => 1])
                                    ->limit(1)
                                    ->orderBy(['id'=>SORT_ASC])
                                    ->one(); 
                    if(!empty($userdata))
                    {             
                        $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);          
                        if($data["register_by"]==1)
                        {
                            $hashpassword = md5($data["password"]);
                            if($userdata["password"]==$hashpassword)
                            {
                                if($userdata["status"]==1)
                                {                                
                                    //UPDATE INTO DATABASE
                                    $updatearr=array(
                                        'token' => $sessionkey, 
                                        'device_type'=>$data['device_type'],                 
                                        'last_update_date' => date('Y-m-d g:i:s'),
                                        );
                                    $upd=User::updateAll($updatearr, 'id = '.$userdata['id']); 
                                    $response['error']=false;                        
                                    $response['userid']=$userdata["id"];
                                    $response['token']=$sessionkey;
                                    $response['userverify']=$userdata["otpverify"];
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=415;
                                    $response['msg']="Account is Disable By Administration";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=406;
                                $response['msg']="Invalid Password";
                            }
                        }
                        else if($data["register_by"]==2)
                        {
                            if($userdata["status"]==1)
                            {
                                //UPDATE INTO DATABASE
                                $updatearr=array(
                                    'token' => $sessionkey, 
                                    'facebook_id' => $data["facebook_id"], 
                                    'device_type'=>$data['device_type'],                  
                                    'last_update_date' => date('Y-m-d g:i:s'),
                                    );
                                $upd=User::updateAll($updatearr, 'id = '.$userdata['id']); 
                                $response['error']=false;                        
                                $response['userid']=$userdata["id"];
                                $response['token']=$sessionkey;
                                $response['userverify']=$userdata["otpverify"];
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=415;
                                $response['msg']="Account is Disable By Administration";
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=405;
                            $response['msg']="Invalid Username";
                        }                    
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=405;
                        $response['msg']="Invalid Username";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=412;
                    $response['msg']="Pass All Parameter";
                }
                
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
    }

    ##############################################################################################
    #                       USER LOGOUT SECTION                                                  #
    ##############################################################################################
    public function actionLogout()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["token"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $updatearr=array(
                            'token' => "",           
                            'last_update_date' => date('Y-m-d g:i:s'),
                            );
                    $upd=User::updateAll($updatearr, 'id = '.$getid["id"]); 
                    if ($upd===1)
                    {
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                    } 
                    else 
                    {
                        $response['error']=true;
                        $response['statuscode']=202;
                        $response['msg']="Error Found";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }                
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);      
    }
    ##############################################################################################
    #                       USER FORGOT PASSWORD SECTION                                         #
    ##############################################################################################
    public function actionForgotpassword()
    {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["email"]))
            {
                if($model2->isExistEmail($data["email"])==true)
                {
                    $email=$model->find()->where(['username'=>$data["email"],'status' => 1])->one(); 
                    //print_r($email);
                    if (!empty($email))
                    {
                        //$otpcode="123456";
                        $otpcode=substr(mt_rand(100000,999999),0,6);
                        //SEND MAIL
                        $to=$data["email"];
                        $subject="This is Forgot Password Mail";
                        $from=Yii::$app->params['adminEmail'];
                        $fromname=Yii::$app->params['adminName'];
                        //$message="This is OTP code: ".$otpcode;
                        $username=(!empty($email["nick_name"]))?$email["nick_name"]:$email["username"];
                        require_once('email/forgotpassword.php');        //Message Variable Come From This File
                        $returnmail=Yii::$app->mycomponent->Simplmail($to,$subject,$message,$from,$fromname);
                        //END MAIL

                        $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);
                        //UPDATE INTO DATABASE
                        $updatearr=array(
                            'token' => $sessionkey,
                            'otp_code' => $otpcode, 
                            'otpverify' => 0,                   
                            'last_update_date' => date('Y-m-d g:i:s'),
                            );
                        $upd=User::updateAll($updatearr, 'id = '.$email['id']); 

                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['userid']=$email["id"];
                        $response['token']=$sessionkey;
                    } 
                    else 
                    {
                        $response['error']=true;
                        $response['statuscode']=403;
                        $response['msg']="User not Found.";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=302;
                    $response['msg']="Please enter valid email.";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=411;
                $response['msg']="Email Is Empty";
            }                
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);      
    }

    ##############################################################################################
    #                       CHANGE PASSWORD SECTION                                              #
    ##############################################################################################
    public function actionChangepassword()
    {   
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data['current_password']))
                    {   
                        if(!empty($data['new_password']))
                        {   
                            $userdata=$model->find()->where(['id' => $getid['id'], 'role' => 2, 'status' => 1])
                                        ->limit(1)
                                        ->orderBy(['id'=>SORT_ASC])
                                        ->one(); 
                            if(!empty($userdata))
                            {
                                $hashpassword = md5($data["current_password"]);
                                if($userdata["password"]==$hashpassword)
                                {
                                    $newpassword = md5($data["new_password"]);
                                    $updatearr=array(
                                        'password' => $newpassword,                   
                                        'last_update_date' => date('Y-m-d g:i:s'),
                                        );
                                    $upd=User::updateAll($updatearr, 'id = '.$getid['id']); 
                                    if ($upd===1)
                                    {
                                        $response['error']=false;
                                        $response['statuscode']=200;
                                        $response['msg']="Success";
                                    } 
                                    else 
                                    {
                                        $response['error']=true;
                                        $response['statuscode']=202;
                                        $response['msg']="Not Save";
                                    }  
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=406;
                                    $response['msg']="Invalid Password";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=403;
                                $response['msg']="User not Found.";
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=407;
                            $response['msg']="New Password Not Empty.";
                        }       
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=408;
                        $response['msg']="Current Password Not Empty.";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);         
    }
    ##############################################################################################
    #                       ADD GROUP SECTION                                                    #
    ##############################################################################################
    public function actionAddgroup()
    {
        $response=array();
        $model = new Group();
        $model2 = new UserSearch(); 
        $model3 = new GroupMember();
        $model4 = new SetTarget();
        $connection=Yii::$app->getDB();
        $count=50;      
        $year = date("Y",strtotime(date('Y-m-d')));
        $month = date("m",strtotime(date('Y-m'))); 
        $defaultgrpimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/default.jpg'; 
        $defaultusrimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg'; 
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            //print_r($data);
            if(!empty($data['token']) && isset($data['token']) && isset($data["request"]) && !empty($data["request"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {                    
                    if($data["request"]=="add")     // FOR ADD NEW GROUP
                    {   
                        if(isset($data["group_name"]) && !empty($data["group_name"]) && isset($data["group_type"]) && !empty($data["group_type"]) && isset($data["opening_balance"]) && !empty($data["opening_balance"]))
                        {   
                            if(strpos($data["opening_balance"],".") !== false)
                            {                      
                                $data2['user_id']=$getid["id"]; 
                                $data2['group_name']=$data["group_name"];
                                //$data2['group_slug']=null;
                                $data2['group_icon']="a";
                                $data2['group_type']=$data["group_type"];
                                $data2['opening_balance']=$data["opening_balance"];
                                $data2['status']=1;
                                $data2['created_date']=date('Y-m-d g:i:s');
                                $data2['modify_date']=date('Y-m-d g:i:s');

                                $model->attributes = $data2;
                                if ($model->save()) 
                                {
                                    $insid=$model->getPrimaryKey();
                                    //FILE UPLOAD
                                    if(!empty($_FILES))
                                    {
                                        if($_FILES['group_icon']['size']<=2097152)    //2097152=2MB
                                        {
                                            $path=Yii::getAlias('@webroot');
                                            $model->group_icon = UploadedFile::getInstanceByName('group_icon');
                                            if($model->group_icon) 
                                            {
                                                $fullpath=$path.'/upload/group/'.$insid.time().'.'.$model->group_icon->extension;
                                                $model->group_icon->saveAs($fullpath);
                                                $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/'.$insid.time().'.'.$model->group_icon->extension;
                                            }
                                            $updatearr=array(
                                                'group_icon' => $webpath,
                                            );
                                            $upd=$model->updateAll($updatearr, 'id = '.$insid);
                                        }
                                    }  
                                    //ADD GROUP MEMBER ON ADD GROUP TIME
                                    if(isset($data["user_id"]) && !empty($data["user_id"]))
                                    {
                                        if(strpos($data["user_id"], ",")!==false)
                                        {
                                            $exp=explode(",", $data["user_id"]);    
                                        }
                                        else
                                        {
                                            $exp[]=$data["user_id"];
                                        }
                                        foreach ($exp as $expvlaue) 
                                        {
                                            $secondcountmem=$model3->find()->where(['group_id' => $insid,'exit_by'=>0])
                                                ->count();
                                            if($secondcountmem<9)  //Select MAXIMUM 9 MEMBER 
                                            {
                                                if(!empty($expvlaue))
                                                {
                                                    $data['group_id']=$insid;
                                                    $data['user_id']=$expvlaue;
                                                    $data['sent_by']=$getid["id"];
                                                    $data['invite_status']=0;
                                                    $data['exit_by']=0;
                                                    $data['remove_by']=0;
                                                    $data['status']=1;
                                                    $data['created_date']=date('Y-m-d g:i:s');
                                                    $data['modify_date']=date('Y-m-d g:i:s');
                                                    $model3->attributes = $data;
                                                    $model3->id = NULL;
                                                    $model3->isNewRecord = true;
                                                    $model3->save(); 
                                                }   
                                            }                                                                    
                                        }   
                                    }                                

                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                                /*//CHECK HOW MANY GROUP MAXMIMUM 2 ACORDING TO GROUP_TYPE
                                $countgroup=$model->find()->where(['user_id'=>$getid["id"],'group_type'=>$data["group_type"],'status' => 1])->count();
                                if($countgroup>0)
                                {
                                    $response['error']=true;
                                    $response['statuscode']=418;
                                    $response['msg']="Maximum Limit of Group you create.";
                                }
                                else
                                {
                                    
                                }*/
                            }  
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=417;
                                $response['msg']="Opening balance not in Decimal.";
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";  
                        }                      
                    }
                    elseif($data["request"]=="edit")     // FOR EDIT GROUP
                    {
                        if(isset($data["id"]) && !empty($data["id"]) && isset($data["group_name"]) && !empty($data["group_name"]) && isset($data["group_type"]) && !empty($data["group_type"]) && isset($data["opening_balance"]) && !empty($data["opening_balance"]))
                        {
                            if(strpos($data["opening_balance"],".") !== false)
                            {
                                $updatearr=array(
                                    'group_name' => $data["group_name"],
                                    'group_type' => $data["group_type"],
                                    'opening_balance' => $data["opening_balance"],                     
                                    'modify_date' => date('Y-m-d g:i:s'),
                                    );
                                $upd=Group::updateAll($updatearr, 'id = '.$data["id"]);
                                if ($upd===1) 
                                {
                                    $insid=$data["id"];
                                    //FILE UPLOAD
                                    if(!empty($_FILES))
                                    {
                                        if($_FILES['group_icon']['size']<=2097152)    //2097152=2MB
                                        {
                                            $path=Yii::getAlias('@webroot');
                                            $model->group_icon = UploadedFile::getInstanceByName('group_icon');
                                            if($model->group_icon) 
                                            {
                                                $userdata=$model->find()->where(['id'=>$data["id"],'status' => 1])->one();

                                                $fullpath=$path.'/upload/group/'.$insid.time().'.'.$model->group_icon->extension;
                                                $model->group_icon->saveAs($fullpath);
                                                $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/'.$insid.time().'.'.$model->group_icon->extension;

                                                //Delete Image                                
                                                if(!empty($userdata["group_icon"]))
                                                {
                                                    $emp=explode("/", $userdata["group_icon"]);
                                                    $imgname=end($emp);
                                                    @unlink( '.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'group'.DIRECTORY_SEPARATOR.$imgname);
                                                }

                                            }
                                            $updatearr=array(
                                                'group_icon' => $webpath,
                                            );
                                            $upd=$model->updateAll($updatearr, 'id = '.$insid);
                                        }
                                    }
                                    //ADD GROUP MEMBER ON ADD GROUP TIME
                                    if(isset($data["user_id"]) && !empty($data["user_id"]))
                                    {
                                        if(strpos($data["user_id"], ",")!==false)
                                        {
                                            $exp=explode(",", $data["user_id"]);    
                                        }
                                        else
                                        {
                                            $exp[]=$data["user_id"];
                                        }
                                        foreach ($exp as $expvlaue) 
                                        {
                                            if(!empty($expvlaue))
                                            {
                                                $datarow=$model3->find()->where(['group_id'=>$data["id"],'user_id' => $expvlaue,'status' => 1,'sent_by'=>$getid["id"]])
                                                    ->orderBy(['id'=>SORT_DESC])
                                                    ->one();
                                                if(empty($datarow))
                                                {
                                                    $data['group_id']=$insid;
                                                    $data['user_id']=$expvlaue;
                                                    $data['sent_by']=$getid["id"];
                                                    $data['invite_status']=0;
                                                    $data['exit_by']=0;
                                                    $data['remove_by']=0;
                                                    $data['status']=1;
                                                    $data['created_date']=date('Y-m-d g:i:s');
                                                    $data['modify_date']=date('Y-m-d g:i:s');
                                                    $model3->attributes = $data;
                                                    $model3->id = NULL;
                                                    $model3->isNewRecord = true;
                                                    $model3->save(); 
                                                } 
                                                
                                            }                                                                       
                                        }   
                                    } 
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }  
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=417;
                                $response['msg']="Opening balance not in Decimal.";
                            }
                            
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter."; 
                        }                
                    } 
                    elseif($data["request"]=="view")
                    {
                        if(!isset($data["group_type"]) && empty($data["group_type"]))
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                            echo json_encode($response);  
                            exit;
                        }
                        else
                        {                            
                            if($data["group_type"]==0)          //Mygroup
                            {
                                if(isset($data["page"]))
                                {      
                                    $page=$data["page"];                   
                                    if($page==0)
                                    {
                                        $offset=0;
                                    }
                                    else
                                    {
                                        $offset=$count*$page;
                                    }                  
                                    $catdata=$model->find()->where(['user_id'=>$getid["id"],'status' => 1])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->orderBy(['id'=>SORT_ASC])
                                                    ->all(); 
                                }
                                else
                                {
                                    $catdata=$model->find(['group_icon'])->where(['user_id'=>$getid["id"],'status' => 1])
                                            ->orderBy(['id'=>SORT_ASC])
                                            ->all(); 
                                }
                                $cat="";
                                $r=0;                             
                                if(!empty($catdata))
                                {
                                    foreach ($catdata as $value) 
                                    {   
                                        //GET SETTARGET AMOUNT                             
                                        $settargetdata=$model4->find()->where(['group_id' => $value['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                        //print_r($settargetdata);
                                        $groicon=$value['oldAttributes']['group_icon'];  
                                        $cat[]=array(
                                            'group_id' => (!empty($value['id']))?$value['id']:'',
                                            'user_id'=>(!empty($value['user_id']))?$value['user_id']:'',
                                            'group_name'=>(!empty($value['group_name']))?$value['group_name']:'',
                                            'group_icon'=>(!empty($groicon))?$groicon:$defaultgrpimg,
                                            'group_type'=>(!empty($value['group_type']))?$value['group_type']:'',
                                            'opening_balance'=>(!empty($value['opening_balance']))?$value['opening_balance']:'0',
                                            'groupstatus'=>1,
                                            'groupmessage'=>"Accept",
                                            'groupacctypestatus'=>"0",
                                            'groupacctype'=>"Admin",
                                            'grouptotalincome'=>(!empty($settargetdata["income"]))?$settargetdata["income"]:'0.0',
                                            'status'=>(!empty($value['status']))?$value['status']:'',
                                            'created_date'=>(!empty($value['created_date']))?$value['created_date']:'',
                                            'modify_date'=>$value['modify_date'],
                                        );
                                        $groupdata=$model3->find()->where(['sent_by'=>$getid["id"],'group_id'=>$value['id'],'exit_by'=>0,'status' => 1])
                                            ->andWhere(['!=','invite_status',2])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->limit(9)
                                            ->all();   
                                        $mem=0;                                 
                                        if(!empty($groupdata))
                                        {   
                                            foreach ($groupdata as $groupvalue) 
                                            {
                                                $nickname=$model2->displayname($groupvalue["user_id"]);
                                                $emailid=$model2->displayname($groupvalue["user_id"],'username');
                                                $userimage=$model2->displayname($groupvalue["user_id"],'image');
                                                
                                                if($groupvalue['invite_status']==0){$invstatus= 'Status Pending'; }
                                                elseif($groupvalue['invite_status']==1){ $invstatus='Status Accept'; } 
                                                else { $invstatus='Status Reject'; }
                                                $cat[$r]["groupdetail"][]=array(
                                                    'id' => $groupvalue['id'],
                                                    'user_id'=>$groupvalue['user_id'],
                                                    'user'=>(!empty($nickname))?$nickname:$emailid,
                                                    'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                                    'invitestatus'=>$groupvalue['invite_status'],
                                                    'invitemessage'=>$invstatus,
                                                    'membertype'=>'Member',
                                                    //'income'=>'0.0'
                                                );
                                                //GET INCOME FROM SETTARGET
                                                /*if($groupvalue['invite_status']==1)
                                                {
                                                    $userlist=$model2->displayGroupUserForSelect($settargetdata["group_id"]);
                                                    //print_r($userlist);
                                                    if(!empty($userlist))
                                                    {
                                                        foreach ($userlist as $usergrpvalue) 
                                                        {    
                                                            if(!empty($usergrpvalue["id"]))
                                                            {
                                                                if($usergrpvalue["id"]==$groupvalue['user_id'])
                                                                {
                                                                    $editcommand = $connection->createCommand("Select * from target_amount where settarget_id='".$settargetdata["id"]."' and user_id='".$usergrpvalue["id"]."'");

                                                                    $viewtarget = $editcommand->queryAll(); 
                                                                    if(!empty($viewtarget))
                                                                    {
                                                                        $cat[$r]["groupdetail"][$mem]['income']=$viewtarget[0]["target_amount"];
                                                                    } 
                                                                }
                                                                                                               
                                                            }                                            
                                                        }
                                                    } 
                                                }*/
                                                $mem++;
                                            }                                    
                                        }
                                        //GROUP ADMIN DETAIL
                                        $nicknameadmin=$model2->displayname($getid["id"]);
                                        $emailidadmin=$model2->displayname($getid["id"],'username');
                                        $userimageadmin=$model2->displayname($getid["id"],'image');
                                        //SELECT TARGET
                                        $editcommand2 = $connection->createCommand("Select * from target_amount where settarget_id='".$settargetdata["id"]."' and user_id='".$getid["id"]."'");
                                        $viewtarget2 = $editcommand2->queryAll(); 

                                        $cat[$r]['groupdetail'][]=array(
                                                    'id' => (!empty($value['id']))?$value['id']:'',
                                                    'user_id'=>(!empty($value['user_id']))?$value['user_id']:'',
                                                    'user'=>(!empty($nicknameadmin))?$nicknameadmin:$emailidadmin,
                                                    'userpic'=>(!empty($userimageadmin))?$userimageadmin:$defaultusrimg,
                                                    'invitestatus'=>"1",                                            
                                                    'invitemessage'=>"Accept",
                                                    'membertype'=>'Admin',
                                                    'income'=>(!empty($viewtarget2[0]["target_amount"]))?$viewtarget2[0]["target_amount"]:'0.0'
                                                );
                                        $cat[$r]['totalmember']=$mem+1;
                                        $r++;
                                    }
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";                            
                                    $response['groups']=$cat;
                                }                           
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                } 
                            }
                            elseif($data["group_type"]==1)      //Member
                            {
                                //FETCH INVITION
                                if(isset($data["page"]))
                                {      
                                    $page=$data["page"];                   
                                    if($page==0)
                                    {
                                        $offset=0;
                                    }
                                    else
                                    {
                                        $offset=$count*$page;
                                    } 
                                    $catdata2=$model3->find(['group_icon'])->where(['user_id'=>$getid["id"],'status' => 1])
                                        ->andWhere(['!=','invite_status',2])
                                        ->limit($count)
                                        ->offset($offset)
                                        ->orderBy(['id'=>SORT_ASC])
                                        ->all(); 
                                }
                                else
                                {
                                    $catdata2=$model3->find(['group_icon'])->where(['user_id'=>$getid["id"],'status' => 1])
                                        ->andWhere(['!=','invite_status',2])
                                        ->orderBy(['id'=>SORT_ASC])
                                        ->all(); 
                                }
                                $s=0;
                                if(!empty($catdata2))
                                {
                                    foreach ($catdata2 as $value2) 
                                    {   
                                         //GET SETTARGET AMOUNT                             
                                        $settargetdata2=$model4->find()->where(['group_id' => $value2['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                        //print_r($settargetdata2);
                                        $catdata22=$model->find(['group_icon'])->where(['user_id'=>$value2["sent_by"],'id'=>$value2["group_id"],'status' => 1])
                                            ->one(); 
                                        $groicon2=$catdata22['oldAttributes']['group_icon']; 
                                        
                                        if($value2['invite_status']==0){$grpstatus= 'Pending'; }
                                        elseif($value2['invite_status']==1){ $grpstatus='Accept'; } 
                                        else { $grpstatus='Reject'; }                           
                                        $cat[]=array(
                                            'group_id' => (!empty($catdata22['id']))?$catdata22['id']:'',
                                            'user_id'=>(!empty($catdata22['user_id']))?$catdata22['user_id']:'',
                                            'group_name'=>(!empty($catdata22['group_name']))?$catdata22['group_name']:'',
                                            'group_icon'=>(!empty($groicon2))?$groicon2:$defaultgrpimg,
                                            'group_type'=>(!empty($catdata22['group_type']))?$catdata22['group_type']:'',
                                            'opening_balance'=>(!empty($catdata22['opening_balance']))?round($catdata22['opening_balance'],0):'0',
                                            'groupstatus'=>$value2['invite_status'],
                                            'groupmessage'=>$grpstatus,
                                            'groupacctypestatus'=>"1",
                                            'groupacctype'=>"Member",
                                            'grouptotalincome'=>(!empty($settargetdata2["income"]))?$settargetdata2["income"]:'0.0',
                                            'status'=>(!empty($catdata22['status']))?$catdata22['status']:'',
                                            'created_date'=>(!empty($catdata22['created_date']))?$catdata22['created_date']:'',
                                            'modify_date'=>(!empty($catdata22['modify_date']))?$catdata22['modify_date']:'',
                                        );
                                        $groupdata2=$model3->find()->where(['group_id'=>$catdata22['id'],'exit_by'=>0,'status' => 1])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->limit(9)
                                            ->all();   
                                        $mem=0;                                 
                                        if(!empty($groupdata2))
                                        {       
                                            //GET SETTARGET AMOUNT                             
                                            $settargetdata=$model4->find()->where(['group_id' => $value['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                            //print_r($settargetdata);                                
                                            foreach ($groupdata2 as $groupvalue2) 
                                            {
                                                $mem++;
                                                $nickname=$model2->displayname($groupvalue2["user_id"]);
                                                $emailid=$model2->displayname($groupvalue2["user_id"],'username');
                                                $userimage=$model2->displayname($groupvalue2["user_id"],'image');                                   
                                                if($groupvalue2['invite_status']==0){$invstatus2= 'Status Pending'; }
                                                elseif($groupvalue2['invite_status']==1){ $invstatus2='Status Accept'; } 
                                                else { $invstatus2='Status Reject'; }
                                                $cat[$s]["groupdetail"][]=array(
                                                    'id' => $groupvalue2['id'],
                                                    'user_id'=>$groupvalue2['user_id'],
                                                    'user'=>(!empty($nickname))?$nickname:$emailid,
                                                    'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                                    'invitestatus'=>$groupvalue2['invite_status'],
                                                    'invitemessage'=>$invstatus2,
                                                    'membertype'=>'Member'
                                                );
                                                //GET INCOME FROM SETTARGET
                                                if($groupvalue['invite_status']==1)
                                                {
                                                    $userlist=$model2->displayGroupUserForSelect($settargetdata["group_id"]);
                                                    //print_r($userlist);
                                                    if(!empty($userlist))
                                                    {
                                                        foreach ($userlist as $usergrpvalue) 
                                                        {    
                                                            if(!empty($usergrpvalue["id"]))
                                                            {
                                                                if($usergrpvalue["id"]==$groupvalue['user_id'])
                                                                {
                                                                    $editcommand = $connection->createCommand("Select * from target_amount where settarget_id='".$settargetdata["id"]."' and user_id='".$usergrpvalue["id"]."'");

                                                                    $viewtarget = $editcommand->queryAll(); 
                                                                    if(!empty($viewtarget))
                                                                    {
                                                                        $cat[$r]["groupdetail"][$mem]['income']=$viewtarget[0]["target_amount"];
                                                                    } 
                                                                }
                                                                                                               
                                                            }                                            
                                                        }
                                                    } 
                                                }
                                                $mem++;
                                            }                                    
                                        }
                                        //GROUP ADMIN DETAIL
                                        $nicknameadmin2=$model2->displayname($catdata22["user_id"]);
                                        $emailidadmin2=$model2->displayname($catdata22["user_id"],'username');
                                        $userimageadmin2=$model2->displayname($catdata22["user_id"],'image');
                                        $cat[$s]['groupdetail'][]=array(
                                                    'id' => (!empty($catdata22['id']))?$catdata22['id']:'',
                                                    'user_id'=>(!empty($catdata22['user_id']))?$catdata22['user_id']:'',
                                                    'user'=>(!empty($nicknameadmin2))?$nicknameadmin2:$emailidadmin2,
                                                    'userpic'=>(!empty($userimageadmin2))?$userimageadmin2:$defaultusrimg,
                                                    'invitestatus'=>"1",                                            
                                                    'invitemessage'=>"Accept",
                                                    'membertype'=>'Admin',
                                                );
                                        $cat[$s]['totalmember']=$mem+1;
                                        $s++;
                                    }                                
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";                            
                                    $response['groups']=$cat;
                                }                                
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                } 
                            }
                            elseif($data["group_type"]==2)          //All Group
                            {
                                if(isset($data["page"]))
                                {      
                                    $page=$data["page"];                   
                                    if($page==0)
                                    {
                                        $offset=0;
                                    }
                                    else
                                    {
                                        $offset=$count*$page;
                                    }                  
                                    $catdata=$model->find()->where(['user_id'=>$getid["id"],'status' => 1])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->orderBy(['id'=>SORT_ASC])
                                                    ->all(); 
                                }
                                else
                                {
                                    $catdata=$model->find(['group_icon'])->where(['user_id'=>$getid["id"],'status' => 1])
                                            ->orderBy(['id'=>SORT_ASC])
                                            ->all(); 
                                }
                                $cat="";
                                $r=0;                             
                                if(!empty($catdata))
                                {
                                    foreach ($catdata as $value) 
                                    {   
                                        //GET SETTARGET AMOUNT                             
                                        $settargetdata=$model4->find()->where(['group_id' => $value['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                        //print_r($settargetdata);
                                        $groicon=$value['oldAttributes']['group_icon'];  
                                        $cat[]=array(
                                            'group_id' => (!empty($value['id']))?$value['id']:'',
                                            'user_id'=>(!empty($value['user_id']))?$value['user_id']:'',
                                            'group_name'=>(!empty($value['group_name']))?$value['group_name']:'',
                                            'group_icon'=>(!empty($groicon))?$groicon:$defaultgrpimg,
                                            'group_type'=>(!empty($value['group_type']))?$value['group_type']:'',
                                            'opening_balance'=>(!empty($value['opening_balance']))?$value['opening_balance']:'0',
                                            'groupstatus'=>1,
                                            'groupmessage'=>"Accept",
                                            'groupacctypestatus'=>"0",
                                            'groupacctype'=>"Admin",
                                            'grouptotalincome'=>(!empty($settargetdata["income"]))?$settargetdata["income"]:'0.0',
                                            'status'=>(!empty($value['status']))?$value['status']:'',
                                            'created_date'=>(!empty($value['created_date']))?$value['created_date']:'',
                                            'modify_date'=>$value['modify_date'],
                                        );
                                        $groupdata=$model3->find()->where(['sent_by'=>$getid["id"],'group_id'=>$value['id'],'exit_by'=>0,'status' => 1])
                                            ->andWhere(['!=','invite_status',2])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->limit(9)
                                            ->all();   
                                        $mem=0;                                 
                                        if(!empty($groupdata))
                                        {   
                                            foreach ($groupdata as $groupvalue) 
                                            {
                                                $nickname=$model2->displayname($groupvalue["user_id"]);
                                                $emailid=$model2->displayname($groupvalue["user_id"],'username');
                                                $userimage=$model2->displayname($groupvalue["user_id"],'image');
                                                
                                                if($groupvalue['invite_status']==0){$invstatus= 'Status Pending'; }
                                                elseif($groupvalue['invite_status']==1){ $invstatus='Status Accept'; } 
                                                else { $invstatus='Status Reject'; }
                                                $cat[$r]["groupdetail"][]=array(
                                                    'id' => $groupvalue['id'],
                                                    'user_id'=>$groupvalue['user_id'],
                                                    'user'=>(!empty($nickname))?$nickname:$emailid,
                                                    'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                                    'invitestatus'=>$groupvalue['invite_status'],
                                                    'invitemessage'=>$invstatus,
                                                    'membertype'=>'Member',
                                                    //'income'=>'0.0'
                                                );                                                
                                                $mem++;
                                            }                                    
                                        }
                                        //GROUP ADMIN DETAIL
                                        $nicknameadmin=$model2->displayname($getid["id"]);
                                        $emailidadmin=$model2->displayname($getid["id"],'username');
                                        $userimageadmin=$model2->displayname($getid["id"],'image');
                                        //SELECT TARGET
                                        $editcommand2 = $connection->createCommand("Select * from target_amount where settarget_id='".$settargetdata["id"]."' and user_id='".$getid["id"]."'");
                                        $viewtarget2 = $editcommand2->queryAll(); 

                                        $cat[$r]['groupdetail'][]=array(
                                                    'id' => (!empty($value['id']))?$value['id']:'',
                                                    'user_id'=>(!empty($value['user_id']))?$value['user_id']:'',
                                                    'user'=>(!empty($nicknameadmin))?$nicknameadmin:$emailidadmin,
                                                    'userpic'=>(!empty($userimageadmin))?$userimageadmin:$defaultusrimg,
                                                    'invitestatus'=>"1",                                            
                                                    'invitemessage'=>"Accept",
                                                    'membertype'=>'Admin',
                                                    'income'=>(!empty($viewtarget2[0]["target_amount"]))?$viewtarget2[0]["target_amount"]:'0.0'
                                                );
                                        $cat[$r]['totalmember']=$mem+1;
                                        $r++;
                                    }
                                    //FETCH INVITION
                                    $catdata2=$model3->find(['group_icon'])->where(['user_id'=>$getid["id"],'status' => 1])
                                            ->andWhere(['!=','invite_status',2])
                                            ->andWhere(['!=','invite_status',0])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->all(); 

                                    foreach ($catdata2 as $value2) 
                                    {   
                                         //GET SETTARGET AMOUNT                             
                                        $settargetdata=$model4->find()->where(['group_id' => $value2["group_id"],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                        //print_r($settargetdata);

                                        $catdata22=$model->find(['group_icon'])->where(['user_id'=>$value2["sent_by"],'id'=>$value2["group_id"],'status' => 1])
                                            ->one(); 
                                        $groicon2=$catdata22['oldAttributes']['group_icon']; 
                                        
                                        if($value2['invite_status']==0){$grpstatus= 'Pending'; }
                                        elseif($value2['invite_status']==1){ $grpstatus='Accept'; } 
                                        else { $grpstatus='Reject'; }                           
                                        $cat[]=array(
                                            'group_id' => (!empty($catdata22['id']))?$catdata22['id']:'',
                                            'user_id'=>(!empty($catdata22['user_id']))?$catdata22['user_id']:'',
                                            'group_name'=>(!empty($catdata22['group_name']))?$catdata22['group_name']:'',
                                            'group_icon'=>(!empty($groicon2))?$groicon2:$defaultgrpimg,
                                            'group_type'=>(!empty($catdata22['group_type']))?$catdata22['group_type']:'',
                                            'opening_balance'=>(!empty($catdata22['opening_balance']))?round($catdata22['opening_balance'],0):'0',
                                            'groupstatus'=>$value2['invite_status'],
                                            'groupmessage'=>$grpstatus,
                                            'groupacctypestatus'=>"1",
                                            'groupacctype'=>"Member",
                                            'grouptotalincome'=>(!empty($settargetdata["income"]))?$settargetdata["income"]:'0.0',
                                            'status'=>(!empty($catdata22['status']))?$catdata22['status']:'',
                                            'created_date'=>(!empty($catdata22['created_date']))?$catdata22['created_date']:'',
                                            'modify_date'=>(!empty($catdata22['modify_date']))?$catdata22['modify_date']:'',
                                        );
                                        $groupdata2=$model3->find()->where(['group_id'=>$catdata22['id'],'exit_by'=>0,'status' => 1])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->limit(9)
                                            ->all();   
                                        $mem=0;                                 
                                        if(!empty($groupdata2))
                                        {                                       
                                            foreach ($groupdata2 as $groupvalue2) 
                                            {
                                                $mem++;
                                                $nickname=$model2->displayname($groupvalue2["user_id"]);
                                                $emailid=$model2->displayname($groupvalue2["user_id"],'username');
                                                $userimage=$model2->displayname($groupvalue2["user_id"],'image');                                   
                                                if($groupvalue2['invite_status']==0){$invstatus2= 'Status Pending'; }
                                                elseif($groupvalue2['invite_status']==1){ $invstatus2='Status Accept'; } 
                                                else { $invstatus2='Status Reject'; }
                                                $cat[$r]["groupdetail"][]=array(
                                                    'id' => $groupvalue2['id'],
                                                    'user_id'=>$groupvalue2['user_id'],
                                                    'user'=>(!empty($nickname))?$nickname:$emailid,
                                                    'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                                    'invitestatus'=>$groupvalue2['invite_status'],
                                                    'invitemessage'=>$invstatus2,
                                                    'membertype'=>'Member'
                                                );
                                            }                                    
                                        }
                                        //GROUP ADMIN DETAIL
                                        $nicknameadmin2=$model2->displayname($catdata22["user_id"]);
                                        $emailidadmin2=$model2->displayname($catdata22["user_id"],'username');
                                        $userimageadmin2=$model2->displayname($catdata22["user_id"],'image');
                                        $cat[$r]['groupdetail'][]=array(
                                                    'id' => (!empty($catdata22['id']))?$catdata22['id']:'',
                                                    'user_id'=>(!empty($catdata22['user_id']))?$catdata22['user_id']:'',
                                                    'user'=>(!empty($nicknameadmin2))?$nicknameadmin2:$emailidadmin2,
                                                    'userpic'=>(!empty($userimageadmin2))?$userimageadmin2:$defaultusrimg,
                                                    'invitestatus'=>"1",                                            
                                                    'invitemessage'=>"Accept",
                                                    'membertype'=>'Admin',
                                                );
                                        $cat[$r]['totalmember']=$mem+1;
                                    $r++;
                                    }
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";                            
                                    $response['groups']=$cat;
                                }                           
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                } 
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=512;
                                $response['msg']="Invalid Request";
                            }
                        }                                                
                    }
                    elseif($data["request"]=="single")
                    {
                        if(!isset($data["group_id"]) || empty($data["group_id"]))
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                            echo json_encode($response);  
                            exit;
                        }
                        else
                        {                           
                            $singledata=$model->find()->where(['status'=>1,'id'=>$data["group_id"]])->one();  
                            //print_r($singledata);
                           
                            if(!empty($singledata))
                            {
                                //GET SETTARGET AMOUNT                             
                                $settargetdata=$model4->find()->where(['group_id' => $singledata['id'],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();
                                //print_r($settargetdata);
                                $groicon=$singledata['oldAttributes']['group_icon'];  
                                /*$cat=array(
                                    'group_id' => (!empty($singledata['id']))?$singledata['id']:'',
                                    'user_id'=>(!empty($singledata['user_id']))?$singledata['user_id']:'',
                                    'group_name'=>(!empty($singledata['group_name']))?$singledata['group_name']:'',
                                    'group_icon'=>(!empty($groicon))?$groicon:$defaultgrpimg,
                                    'group_type'=>(!empty($singledata['group_type']))?$singledata['group_type']:'',
                                    'opening_balance'=>(!empty($singledata['opening_balance']))?$singledata['opening_balance']:'0',
                                    'groupstatus'=>1,
                                    'groupmessage'=>"Accept",
                                    'groupacctypestatus'=>"0",
                                    'groupacctype'=>"Admin",
                                    'grouptotalincome'=>(!empty($settargetdata["income"]))?$settargetdata["income"]:'0.0',
                                    'status'=>(!empty($singledata['status']))?$singledata['status']:'',
                                    'created_date'=>(!empty($singledata['created_date']))?$singledata['created_date']:'',
                                    'modify_date'=>$singledata['modify_date'],
                                );*/
                                    $cat['group_id'] = (!empty($singledata['id']))?$singledata['id']:'';
                                    $cat['user_id']=(!empty($singledata['user_id']))?$singledata['user_id']:'';
                                    $cat['group_name']=(!empty($singledata['group_name']))?$singledata['group_name']:'';
                                    $cat['group_icon']=(!empty($groicon))?$groicon:$defaultgrpimg;
                                    $cat['group_type']=(!empty($singledata['group_type']))?$singledata['group_type']:'';
                                    $cat['opening_balance']=(!empty($singledata['opening_balance']))?$singledata['opening_balance']:'0';
                                    $cat['groupstatus']=1;
                                    $cat['groupmessage']="Accept";
                                    $cat['groupacctypestatus']=($singledata["user_id"]==$getid["id"])?"0":'1';;
                                    $cat['groupacctype']=($singledata["user_id"]==$getid["id"])?"Admin":'Member';
                                    $cat['grouptotalincome']=(!empty($settargetdata["income"]))?$settargetdata["income"]:'0.0';
                                    $cat['status']=(!empty($singledata['status']))?$singledata['status']:'';
                                    $cat['created_date']=(!empty($singledata['created_date']))?$singledata['created_date']:'';
                                    $cat['modify_date']=$singledata['modify_date'];

                                $groupdata=$model3->find()->where(['sent_by'=>$getid["id"],'group_id'=>$singledata['id'],'exit_by'=>0,'status' => 1])
                                    ->andWhere(['!=','invite_status',2])
                                    ->orderBy(['id'=>SORT_DESC])
                                    ->limit(9)
                                    ->all();   
                                $r=0;                                 
                                if(!empty($groupdata))
                                {   
                                    foreach ($groupdata as $groupvalue) 
                                    {
                                        $nickname=$model2->displayname($groupvalue["user_id"]);
                                        $emailid=$model2->displayname($groupvalue["user_id"],'username');
                                        $userimage=$model2->displayname($groupvalue["user_id"],'image');
                                        
                                        if($groupvalue['invite_status']==0){$invstatus= 'Status Pending'; }
                                        elseif($groupvalue['invite_status']==1){ $invstatus='Status Accept'; } 
                                        else { $invstatus='Status Reject'; }
                                        $cat["groupdetail"][]=array(
                                            'id' => $groupvalue['id'],
                                            'user_id'=>$groupvalue['user_id'],
                                            'user'=>(!empty($nickname))?$nickname:$emailid,
                                            'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                            'invitestatus'=>$groupvalue['invite_status'],
                                            'invitemessage'=>$invstatus,
                                            'membertype'=>'Member'
                                        );
                                        $r++;
                                    }                                    
                                }
                                //GROUP ADMIN DETAIL
                                $nicknameadmin=$model2->displayname($getid["id"]);
                                $emailidadmin=$model2->displayname($getid["id"],'username');
                                $userimageadmin=$model2->displayname($getid["id"],'image');

                                $cat['groupdetail'][$r]=array(
                                            'id' => (!empty($singledata['id']))?$singledata['id']:'',
                                            'user_id'=>(!empty($singledata['user_id']))?$singledata['user_id']:'',
                                            'user'=>(!empty($nicknameadmin))?$nicknameadmin:$emailidadmin,
                                            'userpic'=>(!empty($userimageadmin))?$userimageadmin:$defaultusrimg,
                                            'invitestatus'=>"1",                                            
                                            'invitemessage'=>"Accept",
                                            'membertype'=>'Admin',
                                        );
                                $cat['totalmember']=$r+1;                                                       
                                $response=$cat;
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";                                
                            }    
                            
                        }
                    }
                    elseif($data["request"]=="search")
                    {
                        if(!isset($data["key"]) || empty($data["key"]) || !isset($data["group_type"]))
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                            echo json_encode($response);  
                            exit;
                        }
                        else
                        {
                            if(strlen($data["key"])>=3)
                            {
                                if($data["group_type"]==0)          //OWN GROUP
                                {
                                    $searchdata=$model->find()->where(['user_id'=>$getid['id']])
                                            ->andFilterWhere(['like', 'group_name', $data["key"]])
                                            ->orderBy(['group_name'=>SORT_ASC])
                                            ->all();     
                                }
                                elseif($data["group_type"]==1)      //MEMBER GROUP
                                {
                                    $searchquery=$connection->createCommand('SELECT * FROM `group_member` INNER JOIN `group` ON group_member.sent_by=group.user_id AND group_member.group_id=group.id WHERE group.group_name LIKE "%'.$data["key"].'%" AND group_member.invite_status=1 AND group_member.user_id="'.$getid["id"].'" ORDER BY `group_name`');
                                    $searchdata=$searchquery->queryAll();
                                }                               
                                elseif($data["group_type"]==2)    //BOTH GROUP
                                {
                                     $defaultgrpimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/group/default.jpg'; 
                                    $searchdata=$model->find()->where(['user_id'=>$getid['id']])
                                            ->andFilterWhere(['like', 'group_name', $data["key"]])
                                            ->orderBy(['group_name'=>SORT_ASC])
                                            ->all();     

                                    $searchquery2=$connection->createCommand('SELECT * FROM `group_member` INNER JOIN `group` ON group_member.sent_by=group.user_id AND group_member.group_id=group.id WHERE group.group_name LIKE "%'.$data["key"].'%" AND group_member.user_id="'.$getid["id"].'" ORDER BY `group_name`');
                                    $searchdata2=$searchquery2->queryAll();
                                    if(!empty($searchdata2))
                                    {
                                        foreach ($searchdata2 as $searchvalue2) 
                                        {
                                            if($data["group_type"]==0)
                                            {
                                                $groicon=$searchvalue2['oldAttributes']['group_icon']; 
                                            }
                                            elseif($data["group_type"]==1)
                                            {
                                                $groicon=$searchvalue2['group_icon'];     
                                            }
                                            
                                            $cat[]=array(
                                                'group_id' => (!empty($searchvalue2['id']))?$searchvalue2['id']:'',
                                                'group_name'=>(!empty($searchvalue2['group_name']))?$searchvalue2['group_name']:'',
                                                'group_icon'=>(!empty($groicon))?$groicon:$defaultgrpimg,
                                            );
                                        }
                                        $response['error']=false;
                                        $response['statuscode']=200;
                                        $response['msg']="Success";                            
                                        $response['groups']=$cat;
                                    }
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=416;
                                    $response['msg']="Error Found";
                                }
                                //print_r($searchdata);
                               
                                if(!empty($searchdata))
                                {
                                    foreach ($searchdata as $searchvalue) 
                                    {
                                        if($data["group_type"]==0)
                                        {
                                            $groicon=$searchvalue['oldAttributes']['group_icon']; 
                                        }
                                        elseif($data["group_type"]==1)
                                        {
                                            $groicon=$searchvalue['group_icon'];     
                                        }
                                        
                                        $cat[]=array(
                                            'group_id' => (!empty($searchvalue['id']))?$searchvalue['id']:'',
                                            'group_name'=>(!empty($searchvalue['group_name']))?$searchvalue['group_name']:'',
                                            'group_icon'=>(!empty($groicon))?$groicon:$defaultgrpimg,
                                        );
                                    }
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";                            
                                    $response['groups']=$cat;
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";                                
                                }    
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=424;
                                $response['msg']="Enter atleast 3 characters.";
                            }
                        }
                    }
                    elseif($data["request"]=="delete")
                    {
                        if(isset($data["id"]) && !empty($data["id"]))
                        {                            
                            //$model3 = Group::findOne($data["id"]);
                            //$model3->delete();
                            $countadmin=$model3->find()->where(['group_id' => $data["id"],'exit_by'=>0])
                                ->andWhere(['!=','invite_status',2])
                                ->count();
                            if($countadmin<=0)
                            {
                                $updatearr=array(
                                    'status' => 0,                 
                                    'modify_date' => date('Y-m-d g:i:s'),
                                    );
                                //print_r($updatearr);
                                //$upd=Group::update($updatearr, 'id = '.$data["id"]);  
                                $targetid=Yii::$app->db->createCommand()->update('group', $updatearr,'id = "'.$data["id"].'"')->execute();
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=423;
                                $response['msg']="Group Admin can't delete the group.";
                            }
                        }  
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }
                    }                        
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=512;
                        $response['msg']="Invalid Request";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter1";
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    ##############################################################################################
    #                       ADD/DELETE GROUP MEMBER SECTION                                      #
    ##############################################################################################
    public function actionGroupmember()
    {
        $response=array();
        $model = new GroupMember();
        $model2 = new UserSearch();
        $user = new User();
        $group = new Group();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']) && isset($data["request"]) && !empty($data["request"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {                       
	                if($data['request']=="invite")     // FOR ADD NEW GROUP MEMBER
	                {
                        if(!empty($data['user_id']) && isset($data['user_id']) && isset($data["group_id"]) && !empty($data["group_id"]))
                        {
                            if(strpos($data["user_id"], ",")!==false)
                            {
                                $exp=explode(",", $data["user_id"]);    
                            }
                            else
                            {
                                $exp[]=$data["user_id"];
                            }
                            $firstcountmem=$model->find()->where(['group_id' => $data["group_id"],'exit_by'=>0])
                                ->andWhere(['!=','invite_status',2])
                                ->count();
                            if($firstcountmem<9)  //Select MAXIMUM 9 MEMBER 
                            {
                                foreach ($exp as $expvlaue) 
                                {
                                    $secondcountmem=$model->find()->where(['group_id' => $data["group_id"],'exit_by'=>0])
                                        ->andWhere(['!=','invite_status',2])
                                        ->count();
                                    if($secondcountmem<9)  //Select MAXIMUM 9 MEMBER 
                                    {
                                        if(!empty($expvlaue))
                                        {
                                            $datarow=$model->find()->where(['group_id'=>$data["group_id"],'user_id' => $expvlaue,'status' => 1,'sent_by'=>$getid["id"]])
                                                ->orderBy(['id'=>SORT_DESC])
                                                ->one();
                                            if(empty($datarow))
                                            {
                                                $data['user_id']=$expvlaue;
                                                $data['sent_by']=$getid["id"];
                                                $data['invite_status']=0;
                                                $data['exit_by']=0;
                                                $data['remove_by']=0;
                                                $data['status']=1;
                                                $data['created_date']=date('Y-m-d g:i:s');
                                                $data['modify_date']=date('Y-m-d g:i:s');
                                                $model->attributes = $data;
                                                $model->id = NULL;
                                                $model->isNewRecord = true;
                                                $model->save();  
                                            }
                                        }  
                                    }
                                }  
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";                                
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=419;
                                $response['msg']="Maximum user add in this group";
                            }                           
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }
	                }
                    elseif($data['request']=="viewinvite")     // FOR ADD NEW GROUP MEMBER
                    {                       
                        $datarow=$model->find()->where(['invite_status' => 0,'status' => 1,'user_id'=>$getid["id"],'exit_by'=>0])
                                                ->orderBy(['id'=>SORT_DESC])
                                                ->all(); 
                        if(!empty($datarow))
                        {
                            $defaultusrimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';  
                            foreach ($datarow as $value) 
                            {   
                                $nickname=$model2->displayname($value["user_id"]);
                                $emailid=$model2->displayname($value["user_id"],'username');
                                $userimage=$model2->displayname($value["user_id"],'image');
                                if($value['invite_status']==0){$invstatus2= 'Status Pending'; }
                                elseif($value['invite_status']==1){ $invstatus2='Status Accept'; } 
                                else { $invstatus2='Status Reject'; }
                                $cat[]=array(
                                        'id' => $value['id'],
                                        'user_id'=>$value['user_id'],
                                        'user'=>(!empty($nickname))?$nickname:$emailid,
                                        'userpic'=>(!empty($userimage))?$userimage:$defaultusrimg,
                                        'invitestatus'=>$value['invite_status'],
                                        'invitemessage'=>$invstatus2,
                                        'membertype'=>'Member'
                                    );
                            }
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                            $response['data']=$cat;
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        }  
                    }
                    elseif($data['request']=="accept")     // FOR ADD NEW GROUP MEMBER
                    {                       
                        if(isset($data["group_id"]) && !empty($data["group_id"]))
                        {
                            $countinvite=$model->find()->where(['group_id' => $data["group_id"],'invite_status'=>1])->count();
                            if($countinvite>9)   //LIMIT SET MAXIMUM 9 USER ONLY IN GROUP 
                            {
                                $response['error']=true;
                                $response['statuscode']=419;
                                $response['msg']="Maximum user add in this group";
                            }
                            else
                            {
                                $updatearr=array(
                                    'invite_status' => 1,                     
                                    'modify_date' => date('Y-m-d g:i:s'),
                                );
                                //$upd=GroupMember::updateAll($updatearr, ['id' => $data["id"]]);
                                $upd=GroupMember::updateAll($updatearr, ['group_id' => $data["group_id"],'user_id' => $getid["id"]]);
                                if ($upd===1) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }    
                            }                            
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }                        
                        
                    }
                    elseif($data['request']=="reject")     // FOR ADD NEW GROUP MEMBER
                    {                       
                        if(isset($data["group_id"]) && !empty($data["group_id"]))
                        {
                            $updatearr=array(
                                'invite_status' => 2,                     
                                'modify_date' => date('Y-m-d g:i:s'),
                            );
                            $upd=GroupMember::updateAll($updatearr, ['id' => $data["group_id"]]);
                            if ($upd===1) 
                            {
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }
                    }
	                elseif($data['request']=="exitgroup")     // FOR EDIT GROUP
	                {
	                    if(isset($data["id"]) && !empty($data["id"]))
                        {
                            $countadmin=$model->find()->where(['id' => $data["id"]])->one();
                            if($countadmin["sent_by"]!=$getid["id"])
                            {
                                $updatearr=array(
                                    'exit_by' => 1,
                                    'remove_by' => $getid["id"],                     
                                    'modify_date' => date('Y-m-d g:i:s'),
                                );
                                $upd=GroupMember::updateAll($updatearr, ['id' => $data["id"]]);
                                if ($upd===1) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=422;
                                $response['msg']="Group Admin can't exit the group.";
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }                               
	                }
	                else
	                {
	                    $response['error']=true;
	                    $response['statuscode']=512;
	                    $response['msg']="Invalid Request";
	                }
		        }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    ##############################################################################################
    #                       CATEGORY SECTION                                                     #
    ##############################################################################################
    public function actionCategory()
    {
        $response=array();
        $model = new Category();
        $model2 = new UserSearch();
        $count=20;
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(isset($data["type"]) && !empty($data["type"]) && isset($data["applied"]))
                    {
                        //FOR VIEW FIRST TIME
                        if(empty($data["date"]))
                        {                  
                            if($data["page"]!=null)
                            {     
                                $page=$data["page"];                   
                                if($page==0)
                                {
                                    $offset=0;
                                }
                                else
                                {
                                    $offset=$count*$page;
                                }
                                if($data["applied"]==0)  // GET ALL CATEGORY According to TYPE
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"]])->orderBy(['category_sort'=>SORT_ASC])
                                                ->limit($count)
                                                ->offset($offset)
                                                ->all(); 
                                }
                                else
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"],'applied_for'=>$data["applied"]])->orderBy(['category_sort'=>SORT_ASC])
                                                ->limit($count)
                                                ->offset($offset)
                                                ->all(); 
                                }
                            }
                            else
                            {
                                if($data["applied"]==0)  // GET ALL CATEGORY According to TYPE
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"]])->orderBy(['category_sort'=>SORT_ASC])
                                                ->all();
                                }
                                else
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"],'applied_for'=>$data["applied"]])->orderBy(['category_sort'=>SORT_ASC])
                                                ->all();
                                }
                            }


                            if(!empty($catdata))
                            {
                                foreach ($catdata as $value) 
                                {                    
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'category_name'=>$value['category_name'],
                                        'category_chinese'=>$value['category_name_c'],
                                        'category_color'=>$value['category_color'],
                                        'category_icon'=>$value['category_icon'],
                                        //'category_type'=>$value['category_type'],
                                        'applied_for'=>$value['applied_for'],
                                        'status'=>$value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['category']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            }  
                        }
                        else if(isset($data["date"])) //FOR SYNC 
                        {
                            $date = date("Y-m-d",strtotime($data["date"]));     //OLD DATE WHICH IS UPDATE
                            $currdate = date("Y-m-d");
                            if($data["page"]!=null)
                            {     
                                $page=$data["page"];                   
                                if($page==0)
                                {
                                    $offset=0;
                                }
                                else
                                {
                                    $offset=$count*$page;
                                }
                                if($data["applied"]==0)  // GET ALL CATEGORY According to TYPE
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"]])
                                                    ->andWhere(['>=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$date])
                                                    ->andWhere(['<=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$currdate])
                                                    ->orderBy(['category_name'=>SORT_DESC])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->all(); 
                                }
                                else
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"],'applied_for'=>$data["applied"]])
                                                    ->andWhere(['>=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$date])
                                                    ->andWhere(['<=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$currdate])
                                                    ->orderBy(['category_name'=>SORT_DESC])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->all(); 
                                }   
                            }
                            else
                            {
                                if($data["applied"]==0)  // GET ALL CATEGORY According to TYPE
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"]])
                                                    ->andWhere(['>=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$date])
                                                    ->andWhere(['<=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$currdate])
                                                    ->orderBy(['category_name'=>SORT_DESC])
                                                    ->all();  
                                }
                                else
                                {
                                    $catdata=$model->find()->where(['status' => 1,'type'=>$data["type"],'applied_for'=>$data["applied"]])
                                                    ->andWhere(['>=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$date])
                                                    ->andWhere(['<=','DATE_FORMAT(modify_date, "%Y-%m-%d")',$currdate])
                                                    ->orderBy(['category_name'=>SORT_DESC])
                                                    ->all();  
                                }
                            }

                            
                            if(!empty($catdata))
                            {
                                foreach ($catdata as $value) 
                                {                    
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'category_name'=>$value['category_name'],
                                        'category_icon'=>$value['category_icon'],
                                        'category_type'=>$value['category_type'],
                                        'applied_for'=>$value['applied_for'],
                                        'status'=>$value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['category']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            } 
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        }
                    }                    
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";   
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }           
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }

    
    ##############################################################################################
    #                       ADD/EDIT/VIEW EXPENSE/INCOME AMOUNT                                  #
    ##############################################################################################
    public function actionAmount()
    {
        $response=array();
        $model = new Amount();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["request"]) && isset($data["request"]) && !empty($data["type"]) && isset($data["type"]))
                    {
                        if($data["request"]=="add")     // FOR ADD NEW INCOME
                        {   
                            $data['user_id']=$getid["id"];
                            $data['status']=1;
                            $data['created_date']=date('Y-m-d g:i:s');
                            $data['modify_date']=date('Y-m-d g:i:s');
                            $model->attributes = $data;
                            if ($model->save()) 
                            {
                                $insid=$model->getPrimaryKey();
                                //FILE UPLOAD
                                if(!empty($_FILES))
                                {
                                    if($_FILES['bill_image']['size']<=2097152)    //2097152=2MB
                                    {
                                        $path=Yii::getAlias('@webroot');
                                        $model->bill_image = UploadedFile::getInstanceByName('bill_image');
                                        if($model->bill_image) 
                                        {
                                            $fullpath=$path.'/upload/amount/'.$insid.'.'.$model->bill_image->extension;
                                            $model->bill_image->saveAs($fullpath);
                                            $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/amount/'.$insid.'.'.$model->bill_image->extension;
                                        }
                                        $updatearr=array(
                                            'bill_image' => $webpath,
                                        );
                                        $upd=$model->updateAll($updatearr, 'id = '.$insid);
                                    }
                                }                       
                                 
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }
                        }
                        elseif($data["request"]=="view")
                        {                            
                            if(!isset($data["group_id"]))
                            {
                                $groupid=0;
                            }
                            else
                            {
                                $groupid=$data["group_id"];
                            }
                            if(!empty($data["id"]))
                            {
                                $catdata=$model->find()->where(['status' => 1, 'type'=>$data["type"], 'user_id'=>$getid["id"],'account'=>$groupid, 'id' => $data["id"]])
                                    ->orderBy(['selectdate'=>SORT_DESC])
                                    ->all();
                            }
                            else
                            {
                                if(!empty($data["date"]))
                                {
                                    $date = date("Y-m-d g:i:s",strtotime($data["date"]));
                                    $currdate = date("Y-m-d g:i:s");
                                    $catdata=$model->find()->where(['status' => 1, 'type'=>$data["type"], 'user_id'=>$getid["id"]])
                                                    ->andWhere(['>=','DATE_FORMAT(modify_date, "%Y-%m-%d %g:%i:%s")',$date])
                                                    ->andWhere(['<=','DATE_FORMAT(modify_date, "%Y-%m-%d %g:%i:%s")',$currdate])
                                                    ->orderBy(['selectdate'=>SORT_DESC])
                                                    ->all();
                                }
                                else
                                {                                    
                                    $catdata=$model->find()->where(['status' => 1, 'type'=>$data["type"], 'user_id'=>$getid["id"],'account'=>$groupid])
                                    ->orderBy(['selectdate'=>SORT_DESC])
                                    ->all();
                                }                                  
                            }
                            
                            if(!empty($catdata))
                            {
                                foreach ($catdata as $value) 
                                {                    
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'user_id' => $value['user_id'],
                                        'type'=>$value['type'],
                                        'selectdate'=>$value['selectdate'],
                                        'category_id'=>$value['category_id'],
                                        'payment_detail'=>$value['payment_detail'],
                                        'amount'=>$value['amount'],
                                        'account'=>$value['account'],
                                        'note'=>$value['note'],
                                        'bill_image'=>$value['bill_image'],
                                        'repeat'=>$value['repeat'],
                                        'repitition_period'=>$value['repitition_period'],
                                        'status'=>$value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['category']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            }
                        }
                        elseif($data["request"]=="edit")     // FOR EDIT 
                        {
                            if(!empty($data["id"]))
                            {
                                $userdata=$model->find()->where(['id' => $data["id"], 'status' => 1])
                                                ->limit(1)
                                                ->one();
                                if(!empty($userdata))
                                {
                                    $updatearr=array(
                                        'category_id' => $data["category_id"],
                                        'payment_detail' => $data["payment_detail"],
                                        'amount' => $data["amount"],
                                        'account' => $data["account"],
                                        'note' => $data["note"],
                                        'repeat' => $data["repeat"],
                                        'repitition_period' => $data["repitition_period"],
                                        'modify_date' => date('Y-m-d g:i:s'),
                                        );
                                    $upd=Amount::updateAll($updatearr, 'id = '.$data["id"]);
                                    if ($upd===1) 
                                    {
                                        $insid=$data["id"];
                                        //FILE UPLOAD
                                        if(!empty($_FILES))
                                        {
                                            if($_FILES['bill_image']['size']<=2097152)    //2097152=2MB
                                            {
                                                $path=Yii::getAlias('@webroot');
                                                $model->bill_image = UploadedFile::getInstanceByName('bill_image');
                                                if($model->bill_image) 
                                                {
                                                    $fullpath=$path.'/upload/amount/'.$insid.'.'.$model->bill_image->extension;
                                                    $model->bill_image->saveAs($fullpath);
                                                    $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/amount/'.$insid.'.'.$model->bill_image->extension;
                                                }
                                                $updatearr2=array(
                                                    'bill_image' => $webpath,
                                                );
                                                $upd=$model->updateAll($updatearr2, 'id = '.$insid);
                                            }
                                        }  
                                        $response['error']=false;
                                        $response['statuscode']=200;
                                        $response['msg']="Success";
                                    } 
                                    else 
                                    {
                                        $response['error']=true;
                                        $response['statuscode']=202;
                                        $response['msg']="Not Save";
                                    }
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                    
                        }                        
                        elseif($data["request"]=="delete")
                        {                            
                            if(!empty($data["id"]))
                            {
                                
                                $model3 = Amount::findOne($data["id"]);
                                $model3->delete();
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";                               
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";  
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=512;
                            $response['msg']="Invalid Request";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }                    
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";   
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    ##############################################################################################
    #                       VIEW INCOME/EXPENSE BY CATEGORY SECTION                              #
    ##############################################################################################
    public function actionViewexpense()         // BY CATEGORY WISE
    { 
        $response=array();
        $model = new Amount();
        $model2 = new UserSearch();
        $model3 = new CategorySearch();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["type"]) && isset($data["type"]) && !empty($data["category_id"]) && isset($data["category_id"]))
                    {
                        $catdata=$model->find()->where(['user_id' => $getid["id"],'type' => $data["type"],'category_id' => $data["category_id"],'status' => 1])
                                        ->orderBy(['id'=>SORT_DESC])
                                        ->all(); 
                        if(!empty($catdata))
                        {
                            foreach ($catdata as $value) 
                            {
                                $catname=$model3->categoryname($value['category_id']);
                                $caticon=$model3->categoryname($value['category_id'],'category_icon');
                                $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'selectdate'=>$value['selectdate'],
                                        'category_id' => $value['category_id'],
                                        'category_name' => ($catname!=null)?$catname:'',
                                        'category_icon' => ($caticon!=null && $caticon!='a')?$caticon:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png',
                                        'payment_detail'=>$value['payment_detail'],
                                        'amount'=>$value['amount'],
                                        'account'=>$value['account'],
                                        'note'=>$value['note'],
                                        'bill_image'=>$value['bill_image'],
                                        'repeat'=>$value['repeat'],
                                        'status'=>$value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                            }
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                            $response['data']=$cat;
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }   
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";   
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                        
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    
    ##############################################################################################
    #                       ADD/EDIT SET TARGET SECTION                                          #
    ##############################################################################################
    public function actionSettarget()
    {
        $response=array();
        $model = new SetTarget();
        $model2 = new UserSearch();
        $connection=Yii::$app->getDB();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();            
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $type=$data["type"];
                    if(!empty($data["request"]) && isset($data["request"]) && !empty($data["type"]) && isset($data["type"]))
                    {
                        $year = date("Y",strtotime(date('Y-m-d')));
                        $month = date("m",strtotime(date('Y-m')));   
                        if($type==1)
                        {
                            if(!isset($data["income"]) || !isset($data["family_member"]) || !isset($data["house_type"]) || !isset($data["monthly_rent"]) || !isset($data["investment_habit"]) || !isset($data["suggest_target"]) || !isset($data["working_member"]) || !isset($data["group_id"]) || !isset($data["confidence_meet_target"]))
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                                echo json_encode($response);  
                                exit;
                            }

                            $userdata=$model->find()->where(['group_id' =>0,'user_id' => $getid["id"],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
                        }                 
                        if($type==2)
                        {
                            if($data["request"]!="view")
                            {
                                if(!isset($data["group_id"]) || !isset($data["income"]))
                                {
                                    $response['error']=true;
                                    $response['statuscode']=412;
                                    $response['msg']="Pass All Parameter";
                                    echo json_encode($response);  
                                    exit;
                                }
                            }
                            
                            $userdata=$model->find()->where(['group_id' => $data["group_id"],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->one();
                        } 

                        if($data["request"]=="add")     
                        {   
                            if(empty($userdata))    // FOR ADD 
                            {                                
                                if($type==2)
                                {
                                    $data['family_member']=0;
                                    $data['children_no']=0;
                                    $data['house_type']=0;
                                    $data['monthly_rent']=0;
                                    $data['investment_habit']=0;
                                    $data['working_member']=0;
                                    $data['confidence_meet_target']=0;
                                }

                                $data['user_id']=$getid["id"];
                                $data['status']=1;
                                $data['created_date']=date('Y-m-d g:i:s');
                                $data['modify_date']=date('Y-m-d g:i:s');
                                $model->attributes = $data;
                                //print_r($model->attributes);
                                if ($model->save()) 
                                {
                                    //SET USER AMOUNT IN TARGET_AMOUNT TABLE
                                    /*if(!empty($data["userincome"]) && isset($data["userincome"]))
                                    {
                                        $settargetid = $model->getPrimaryKey();                                    
                                        $usertarget=explode("@", $data["userincome"]);
                                        if(!empty($usertarget))
                                        {
                                            foreach ($usertarget as $amtvalue) 
                                            {
                                                $useramt=plode("-", $amtvalue);
                                                $amtarray[]=array('key'=>$useramt[0],'value'=>$useramt[1]);
                                            }
                                            foreach($amtarray as $key2 => $targetamt)
                                            {
                                                $targetdata=[
                                                    'settarget_id' => $settargetid,
                                                    'user_id' => $targetamt['key'],
                                                    'target_amount' => $targetamt['value'],
                                                    'status' => "1",
                                                    'created_date' => date('Y-m-d g:i:s'),
                                                    'modify_date' => date('Y-m-d g:i:s'),
                                                ];
                                                $returnid=Yii::$app->db->createCommand()->insert('target_amount', $targetdata)->execute();
                                            }
                                        } 
                                    }  */                                 
                                    
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                            }
                            else                //FOR UPDATE
                            {
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
                                        'modify_date' => date('Y-m-d g:i:s'),
                                        );
                                }
                                if($type==2)
                                {
                                    $updatearr=array(
                                        'income'=>$data["income"],                    
                                        'suggest_target'=>$data['suggest_target'],
                                        'modify_date' => date('Y-m-d g:i:s'),
                                    );
                                    //SET USER AMOUNT IN TARGET_AMOUNT TABLE
                                    /*if(!empty($data["userincome"]) && isset($data["userincome"]))
                                    {
                                        $settargetid = $userdata["id"];          
                                        if(strpos($data["userincome"], "@")!==false)
                                        {
                                            $usertarget=explode("@", $data["userincome"]); 
                                        }
                                        else
                                        {
                                            $usertarget[]=$data["userincome"];
                                        }                          
                                        
                                        if(!empty($usertarget))
                                        {
                                            foreach ($usertarget as $amtvalue) 
                                            {
                                                $useramt=explode("-", $amtvalue);
                                                $amtarray[]=array('key'=>$useramt[0],'value'=>$useramt[1]);
                                            }
                                            foreach($amtarray as $key2 => $targetamt)
                                            {                                                
                                                $command = $connection->createCommand("Select * from target_amount where user_id='".$targetamt['key']."' and settarget_id='".$settargetid."'");
                                                $targetselect=$command->queryAll();
                                                if(!empty($targetselect))       //FOR UPDATE
                                                {
                                                    $targetdata=[
                                                        'settarget_id' => $settargetid,
                                                        'user_id' => $targetamt['key'],
                                                        'target_amount' => $targetamt['value'],
                                                        'status' => "1",
                                                        'modify_date' => date('Y-m-d g:i:s'),
                                                    ];  
                                                    $targetid=Yii::$app->db->createCommand()->update('target_amount', $targetdata,'settarget_id = '.$settargetid.' and user_id='.$targetamt['key'])->execute();
                                                }
                                                else
                                                {
                                                    $targetdata2=[
                                                        'settarget_id' => $settargetid,
                                                        'user_id' => $targetamt['key'],
                                                        'target_amount' => $targetamt['value'],
                                                        'status' => "1",
                                                        'created_date' => date('Y-m-d g:i:s'),
                                                        'modify_date' => date('Y-m-d g:i:s'),
                                                    ];
                                                    $returnid=Yii::$app->db->createCommand()->insert('target_amount', $targetdata2)->execute();
                                                }                                                      
                                            }
                                        } 
                                    }*/
                                } 
                                $upd=SetTarget::updateAll($updatearr, 'id = '.$userdata["id"]);
                                if ($upd===1) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                            }                            
                        }
                        elseif($data["request"]=="view")     // FOR EDIT
                        {
                            if(!empty($userdata))
                            {
                                $cat=array(
                                    'income'=>$userdata['income'],
                                    'family_member'=>$userdata['family_member'], 
                                    'children_no'=>$userdata['children_no'], 
                                    'house_type'=>$userdata['house_type'], 
                                    'monthly_rent'=>$userdata['monthly_rent'], 
                                    'investment_habit'=>$userdata['investment_habit'], 
                                    'suggest_target'=>$userdata['suggest_target'], 
                                    'working_member'=>$userdata['working_member'], 
                                    'status'=>$userdata['status'], 
                                    'created_date'=>$userdata['created_date'], 
                                    'modify_date'=>$userdata['modify_date'],                   
                                );
                                if($type==2)
                                {
                                    $userlist=$model2->displayGroupUserForSelect($data["group_id"]);
                                    if(!empty($userlist))
                                    {
                                        foreach ($userlist as $value) 
                                        {    
                                            if(!empty($value["id"]))
                                            {
                                                $editcommand = $connection->createCommand("Select * from target_amount where settarget_id='".$userdata["id"]."' and user_id='".$value["id"]."'");
                                                $viewtarget = $editcommand->queryAll();  
                                                //print_r( $viewtarget);
                                                if(!empty($viewtarget))
                                                {
                                                    $cat["userlist"][]=array('userid'=>$value["id"],'amount'=>$viewtarget[0]["target_amount"]);
                                                }                                                
                                            }                                            
                                        }
                                    }                                    
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['targetdata']=$cat; 
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            }                    
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=512;
                            $response['msg']="Invalid Request";
                        } 
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    } 
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";   
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }  
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    ##############################################################################################
    #                       CALCULATE TARGET                                                     #
    ##############################################################################################
    public function actionCalculatetarget()
    {
        $response=array();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $connection = Yii::$app->getDb();
                    $data=Yii::$app->request->post();
                    $type=$data["type"];                    
                    if($type==1)        //Individual
                    {   
                        if(empty($data["familymem"]))
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                            echo json_encode($response);  
                            exit;
                        }
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
                            $getfamilymem=$data["familymem"];
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
                        //print_r($datavalue);
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
                            $childrenvalue3 = $connection->createCommand('Select * from calculation where type=3 and incomefrom='.$childrenmax3.' AND children="'.$getfamilymem.'"');
                        }
                        else
                        {
                            $childrenvalue3 = $connection->createCommand('Select * from calculation where type=3 AND children="'.$getfamilymem.'" AND "'.$data["income"].'" BETWEEN `incomefrom` AND `incometo`');
                        }
                        $datavalue3 = $childrenvalue3->queryAll(); 
                        //print_r($datavalue3);
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
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['target']=round($confival); 
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
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['target']=round($newfinalvalue);
                    }   
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";   
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }  
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }
    ##############################################################################################
    #                       PAGES SECTION                                                        #
    ##############################################################################################
    public function actionPages()
    {
        $response=array();
        $model = new Pages();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['page']) && isset($data['page']))
            {
                $catdata=$model->find()->where(['page_slug'=>$data["page"],'status' => 1])->one(); 
                if(!empty($catdata))
                {
                    $cat[]=array(
                            'title' => $catdata['title'],
                            'content'=>$catdata['content']                    
                        );
                    $response['error']=false;
                    $response['statuscode']=200;
                    $response['msg']="Success";
                    $response['data']=$cat;
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=409;
                    $response['msg']="No Record Found";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    } 
    ##############################################################################################
    #                       NEWS SECTION                                                         #
    ##############################################################################################
    public function actionNews()
    {
        $response=array();
        $model = new News();
        $model2 = new UserSearch();
        $count=5;
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {

                    if($data["page"]!=null)
                    {     
                        $page=$data["page"];                   
                        if($page==0)
                        {
                            $offset=0;
                        }
                        else
                        {
                            $offset=$count*$page;
                        }
                        $catdata=$model->find()->where(['status' => 1])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->limit($count)
                                            ->offset($offset)
                                            ->all(); 
                    }
                    else
                    {
                        $catdata=$model->find()->where(['status' => 1])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->all(); 
                    }
                    
                    if(!empty($catdata))
                    {
                        foreach ($catdata as $value) 
                        {       
                            $cat[]=array(
                                'id' => $value['id'],
                                'title'=>$value['title'],
                                'description'=>$value['description'], 
                                'image'=>$value['image'],  
                                'created_date'=>$value['created_date'],                            
                            );
                        }
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['data']=$cat;
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=409;
                        $response['msg']="No Record Found";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }    

    ##############################################################################################
    #                       FEEDBACK SECTION                                                     #
    ##############################################################################################
    public function actionFeedback()
    {
        $response=array();
        $model = new Feedback();
        $user = new User();
        $model2 = new UserSearch();
        $count=20;
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["request"]))
                    {
                        if($data["request"]=="view")
                        {
                            if(isset($data["page"]))
                            {      
                                $page=$data["page"];                   
                                if($page==0)
                                {
                                    $offset=0;
                                }
                                else
                                {
                                    $offset=$count*$page;
                                }                  
                                $catdata=$model->find()->where(['status' => 1])
                                                    ->orderBy(['sortorder'=>SORT_DESC])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->all(); 
                            }
                            else
                            {
                                $catdata=$model->find()->where(['status' => 1])
                                                    ->orderBy(['id'=>SORT_DESC])
                                                    ->all(); 
                            }
                            if(!empty($catdata))
                            {                            
                                foreach ($catdata as $value) 
                                {   
                                    $udata=$user->find()->where(['id' => $value['user_id']])
                                                    ->one(); 
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'user_id'=>$udata['id'],
                                        'userimage'=>$udata['image'],
                                        'comment'=>$value['comment'],
                                        'user'=>$udata['nick_name'], 
                                        'created_date'=>$value['created_date'],                            
                                    );
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['data']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            }
                        }
                        elseif($data["request"]=="add")
                        {
                            $data['user_id']=$getid["id"];
                            $data['status']=0;
                            $data['created_date']=date('Y-m-d g:i:s');
                            $data['modify_date']=date('Y-m-d g:i:s');
                            $model->attributes = $data;
                            if ($model->save()) 
                            {
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }                        
                        }
                        elseif($data["request"]=="edit")
                        {                            
                            $updatearr=array(
                                'comment' => $data["comment"],
                                'status' => 0,                   
                                'modify_date' => date('Y-m-d g:i:s'),
                                );
                            $upd=$model->updateAll($updatearr, 'user_id='.$getid["id"].' AND id = '.$data["id"]);
                            if ($upd===1) 
                            {
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }                       
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=512;
                            $response['msg']="Invalid Request";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=512;
                        $response['msg']="Invalid Request";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       NOTICE SECTION                                                       #
    ##############################################################################################
    public function actionNotice()
    {
        $response=array();
        $model = new Notice();
        $user = new User();
        $model2 = new UserSearch();
        $model3 = new NoticeComment();
        $count=20;
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["request"]))
                    {
                        if($data["request"]=="add")
                        {
                            $data['user_id']=$getid["id"];
                            $data['status']=1;
                            $data['created_date']=date('Y-m-d g:i:s');
                            $data['modify_date']=date('Y-m-d g:i:s');
                            $model->attributes = $data;
                            if ($model->save()) 
                            {
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else 
                            {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']="Not Save";
                            }                        
                        }                        
                        elseif($data["request"]=="edit")
                        {
                            if(isset($data["id"]) && !empty($data["id"]))
                            {
                                $updatearr=array(
                                    'description'=>$data['description'],                                
                                    'modify_date' => date('Y-m-d g:i:s'),
                                    );
                                $upd=$model->updateAll($updatearr, 'id = '.$data["id"]);
                                if ($upd===1) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                            
                        }
                        elseif($data["request"]=="view")
                        {
                            if(isset($data["group_id"]) && !empty($data["group_id"]))
                            {
                                if(isset($data["page"]))
                                {      
                                    $page=$data["page"];                   
                                    if($page==0)
                                    {
                                        $offset=0;
                                    }
                                    else
                                    {
                                        $offset=$count*$page;
                                    }   

                                    if($data["data"]=="user")
                                    {
                                        if(!empty($data["id"]) && isset($data["id"]))
                                        {
                                            $con=['group_id'=>$data["group_id"],'id'=>$data["id"],'status' => 1];
                                        }
                                        else
                                        {
                                            $con=['group_id'=>$data["group_id"],'user_id'=>$getid["id"],'status' => 1];
                                        } 
                                    }                                    
                                    else
                                    {
                                        $con=['group_id'=>$data["group_id"],'status' => 1]; 
                                    }  
                                    $catdata=$model->find()->where($con)
                                                    ->orderBy(['id'=>SORT_DESC])
                                                    ->limit($count)
                                                    ->offset($offset)
                                                    ->all(); 
                                }
                                else
                                {
                                    if($data["data"]=="user")
                                    {
                                        if(!empty($data["id"]) && isset($data["id"]))
                                        {
                                            $con=['group_id'=>$data["group_id"],'id'=>$data["id"],'status' => 1];
                                        }
                                        else
                                        {
                                            $con=['group_id'=>$data["group_id"],'user_id'=>$getid["id"],'status' => 1];
                                        }                                        
                                    }
                                    else
                                    {
                                        $con=['group_id'=>$data["group_id"],'status' => 1]; 
                                    }  
                                    $catdata=$model->find()->where($con)
                                                    ->orderBy(['id'=>SORT_DESC])
                                                    ->all(); 
                                }
                                if(!empty($catdata))
                                {                            
                                    foreach ($catdata as $value) 
                                    {   
                                        //COUNT COMMENT
                                        $commentcnt=$model3->find()->where(['notice_id' => $value['id']])->count(); 
                                        $nickname=$model2->displayname($value["user_id"]);
                                        $emailid=$model2->displayname($value["user_id"],'username');
                                        $userimage=$model2->displayname($value["user_id"],'image');
                                        $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                                        $cat[]=array(
                                            'id' => $value['id'],
                                            'user_id'=>$value['user_id'],
                                            'group_id'=>$value['group_id'],
                                            'user'=>(!empty($nickname))?$nickname:$emailid,
                                            'user_image'=>(!empty($userimage))?$userimage:$defaultimg, 
                                            'comments_count'=>$commentcnt,
                                            'description'=>$value['description'],
                                            'created_date'=>$value['created_date'],                            
                                        );
                                    }
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                    $response['notices']=$cat;
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }
                        }   
                        elseif($data["request"]=="delete")
                        {
                            if(isset($data["id"]) && !empty($data["id"]))
                            {
                                $model3 = Notice::findOne($data["id"]);
                                $model3->delete();
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                            
                        }                     
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=512;
                            $response['msg']="Invalid Request";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       NOTICE COMMENT SECTION                                               #
    ##############################################################################################
    public function actionComment()
    {      
        $response=array();
        $model = new NoticeComment();
        $user = new User();
        $model2 = new UserSearch();
        $count=20;
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(!empty($data["request"]))
                    {
                        if($data["request"]=="add")
                        {
                            if(isset($data["comment"]) && !empty($data["comment"]) && isset($data["notice_id"]) && !empty($data["notice_id"]))
                            {
                                $data['user_id']=$getid["id"];
                                $data['status']=1;
                                $data['created_date']=date('Y-m-d g:i:s');
                                $data['modify_date']=date('Y-m-d g:i:s');
                                $model->attributes = $data;
                                if ($model->save()) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }  
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                                                  
                        }
                        elseif($data["request"]=="view")
                        {   
                            if(isset($data["notice_id"]) && !empty($data["notice_id"]))
                            {                         
                                if(isset($data["page"]))
                                {      
                                    $page=$data["page"];                   
                                    if($page==0)
                                    {
                                        $offset=0;
                                    }
                                    else
                                    {
                                        $offset=$count*$page;
                                    }
                                    $catdata=$model->find()->where(['notice_id'=>$data["notice_id"],'status' => 1])
                                                        ->orderBy(['id'=>SORT_DESC])
                                                        ->limit($count)
                                                        ->offset($offset)
                                                        ->all(); 
                                }
                                else
                                {
                                    $catdata=$model->find()->where(['notice_id'=>$data["notice_id"],'status' => 1])
                                                        ->orderBy(['id'=>SORT_DESC])
                                                        ->all(); 
                                } 

                                if(!empty($catdata))
                                {                            
                                    foreach ($catdata as $value) 
                                    {   
                                        //$udata=$user->find()->where(['id' => $value['user_id']])->one(); 
                                        $nickname=$model2->displayname($value["user_id"]);
                                        $emailid=$model2->displayname($value["user_id"],'username');
                                        $userimage=$model2->displayname($value["user_id"],'image');
                                        $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                                        $cat[]=array(
                                            'id' => $value['id'],
                                            'user_id'=>$value['user_id'],
                                            'user'=>(!empty($nickname))?$nickname:$emailid,
                                            'user_image'=>(!empty($userimage))?$userimage:$defaultimg, 
                                            'comment'=>$value['comment'],
                                            'created_date'=>$value['created_date'],                            
                                        );
                                    }
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                    $response['data']=$cat;
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=409;
                                    $response['msg']="No Record Found";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }
                        }   
                        elseif($data["request"]=="edit")
                        {
                            if(isset($data["id"]) && !empty($data["id"]))
                            {
                                $updatearr=array(
                                    'comment'=>$data['comment'],                                
                                    'modify_date' => date('Y-m-d g:i:s'),
                                    );
                                $upd=$model->updateAll($updatearr, 'id = '.$data["id"]);
                                if ($upd===1) 
                                {
                                    $response['error']=false;
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                } 
                                else 
                                {
                                    $response['error']=true;
                                    $response['statuscode']=202;
                                    $response['msg']="Not Save";
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                            
                        }
                        elseif($data["request"]=="delete")
                        {
                            if(isset($data["id"]) && !empty($data["id"]))
                            {
                                $model3 = $model->findOne($data["id"]);
                                $model3->delete();
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=412;
                                $response['msg']="Pass All Parameter";
                            }                            
                        }                     
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=512;
                            $response['msg']="Invalid Request";
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       MONTHLY SPEND DETAIL SECTION                                         #
    ##############################################################################################
    public function actionMonthlyspend()
    {
        $response=array();
        $model = new Amount();
        $model2 = new UserSearch();
        $model3 = new CategorySearch();
        $model4 = new SetTarget();
        $model5 = new CategoryUser();
        $connection=Yii::$app->getDB();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $year = date("Y",strtotime($data["mydate"]));
                    $month = date("m",strtotime($data["mydate"]));
                    if(!empty($data['datetype']) && isset($data['datetype']))
                    {
                        if($data['datetype']=="M")
                        {                            
                            $datefilter=['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month];
                        }
                        else if($data['datetype']=="D")
                        {       
                            $date = date("Y-m-d",strtotime($data["mydate"]));                     
                            $datefilter=['DATE_FORMAT(selectdate, "%Y-%m-%d")' => $date];
                        }
                        else
                        {                            
                            $datefilter=['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month];
                        }
                    }
                    else
                    {
                        $datefilter=['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month];
                    }
                    //SELECT * FROM `amount` WHERE DATE_FORMAT(selectdate, "%Y-%m") = "2017-06"
                    //FOR SORTING
                    if(!empty($data["sort"]) && isset($data["sort"]))
                    {
                        if($data["sort"]=="asc")
                        {
                            $sort=['payment_detail'=>SORT_ASC];
                        }
                        else if($data["sort"]=="desc")
                        {
                            $sort=['payment_detail'=>SORT_DESC];
                        }
                        else
                        {
                            $sort=['payment_detail'=>SORT_ASC];
                        }
                    }
                    else
                    {
                        $sort=['id'=>SORT_DESC];
                    }

                    if(!empty($data["type"]) && isset($data["type"]))
                    {
                        if(!empty($data["group_id"]) && isset($data["group_id"]))
                        {
                            $catdata=$model->find()->where(['type'=>$data["type"],'account'=>$data["group_id"],'user_id'=>$getid["id"],'status' => 1])
                                            ->andWhere($datefilter)
                                            ->orderBy($sort)
                                            ->all();  
                        }
                        else
                        {                            
                            $catdata=$model->find()->where(['type'=>$data["type"],'account'=>0,'user_id'=>$getid["id"],'status' => 1])
                                            ->andWhere($datefilter)
                                            ->orderBy($sort)
                                            ->all();                    
                        }
                    }
                    else
                    {
                        if(!empty($data["group_id"]) && isset($data["group_id"]))
                        {
                            $catdata=$model->find()->where(['user_id'=>$getid["id"],'account'=>$data["group_id"],'status' => 1])
                                            ->andWhere($datefilter)
                                            ->orderBy($sort)
                                            ->all();  
                        }
                        else
                        {                            
                            $catdata=$model->find()->where(['user_id'=>$getid["id"],'account'=>0,'status' => 1])
                                            ->andWhere($datefilter)
                                            ->orderBy($sort)
                                            ->all();                    
                        }
                    }       
                    $totalincome=0;   
                    $totalexpense=0; 
                    $cashin=0;
                    $totalbudget=0;
                    //Suggest target of Current Month   
                    $target=$model4->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id' => $data["group_id"]])->orderBy(['id'=>SORT_DESC])->one();

                    //Net-worth
                    $previousmonth = date("Y-m",strtotime($data["mydate"]." -1 month"));
                    $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$previousmonth."' AND type=1 and account='".$data["group_id"]."' and status=1 and recordbudget=1 and user_id='".$getid["id"]."'");
                    $analysiscashinarray= $commandamtexp->queryAll();
                    //print_r($analysiscashinarray);
                    $cashin=round($analysiscashinarray[0]['sum(amount)']);        
                    if(!empty($catdata))
                    { 
                        foreach ($catdata as $value) 
                        {   
                            //Select Budget CATEGORY WISE
                            $selectbudgetdata=$model5->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id'=>$data["group_id"],'category_id'=>$value['category_id'],'status' => 1])->one();

                            $catname=$model3->categoryname($value['category_id']);
                            $caticon=$model3->categoryname($value['category_id'],'category_icon');
                            $cat[]=array(
                                'id' => $value['id'],
                                'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                'user_id' => $value['user_id'],
                                'selectdate' => $value['selectdate'],
                                'category_id' => $value['category_id'],
                                'category_name' => ($catname!=null)?$catname:'',
                                'category_icon' => ($caticon!=null && $caticon!='a')?$caticon:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png',
                                'payment_detail' => $value['payment_detail'],
                                'amount' => $value['amount'],
                                'account' => $value['account'],
                                'note' => $value['note'],
                                'bill_image' => $value['bill_image'],
                                'repeat' => $value['repeat'],
                                'repitition_period' => $value['repitition_period'],
                                'status' => $value['status'],
                                'created_date'=>$value['created_date'],
                                'modify_date'=>$value['modify_date'],
                            );
                            $totalincome+=($value['type']==1)?$value['amount']:0;
                            $totalexpense+=($value['type']==2)?$value['amount']:0;
                            $totalbudget+=(!empty($selectbudgetdata))?$selectbudgetdata['amount']:0;
                        }
                    }
                    else
                    {
                        $cat=array();
                    }
                    $totalnetworth=round((($cashin+$totalincome)-$totalexpense),2);
                    $targetamt=round($target["suggest_target"],2);
                    $spentamt=round(($target["suggest_target"]-$totalexpense),2);
                    $remainamt=round(($targetamt-$spentamt),2);

                    $response['error']=false;
                    $response['statuscode']=200;
                    $response['msg']="Success";
                    $response['networth']=$totalnetworth;
                    $response['targetamount']=$targetamt;
                    $response['spentamount']=$spentamt;
                    $response['remainamount']=$remainamt;
                    $response['totalincome']=$totalincome;
                    $response['totalexpense']=$totalexpense;
                    $response['totalbudget']=$totalbudget;
                    $response['incomeexpense']=$cat;
                    /*else
                    {
                        $response['error']=true;
                        $response['statuscode']=409;
                        $response['msg']="No Record Found";
                    }    */                      
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       MONTHLY BUDGET DETAIL SECTION   BUDEGET SCREEN                       #
    ##############################################################################################
    /*public function actionMonthlybudget()
    {
        $response=array();
        $model = new Amount();        
        $model2 = new UserSearch();
        $model3 = new Category();
        $model4 = new SetTarget();        
        $model5 = new CategoryUser();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(isset($data["mydate"]) && !empty($data["mydate"]))
                    {
                        $year = date("Y",strtotime($data["mydate"]));
                        $month = date("m",strtotime($data["mydate"]));
                        if(empty($data["category_id"]))
                        {
                            $target=$model4->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id' => $data["group_id"]])->orderBy(['id'=>SORT_DESC])->one();
                            $totaltarget='0';
                            //print_r($target);
                            $catdata=$model->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->groupBy(['category_id'])->all();
                            if(!empty($catdata))
                            {           
                                $totalsumoftarget="0.00";                                                 
                                foreach ($catdata as $value) 
                                {   
                                    $sum="0.00";                                    
                                    $cdata=$model3->find()->where(['id' => $value['category_id']])->one(); 

                                    $csumdata=$model5->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id' => $getid['id'],'group_id' => $data["group_id"],'category_id' => $value['category_id']])->one(); 

                                    $sumdata=$model->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'category_id'=>$value["category_id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->all();
                                    foreach ($sumdata as $sumvalue) 
                                    {
                                        $sum+=$sumvalue["amount"];
                                    }
                                   
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'user_id' => $value['user_id'],
                                        'selectdate' => $value['selectdate'],
                                        'category_id' => $value['category_id'],
                                        'category_name' => ($cdata['category_name']!=null)?$cdata['category_name']:'',
                                        'category_icon' => ($cdata['category_icon']!=null && $cdata['category_icon']!='a')?$cdata['category_icon']:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png',
                                        'payment_detail' => $value['payment_detail'],
                                        'amount' => $sum,
                                        'suggest_target'=>(!empty($csumdata['amount']))?$csumdata['amount']:'',
                                        'account' => $value['account'],
                                        'note' => $value['note'],
                                        'bill_image' => $value['bill_image'],
                                        'repeat' => $value['repeat'],
                                        'repitition_period' => $value['repitition_period'],
                                        'status' => $value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                    $totaltarget+=$sum;
                                    $totalsumoftarget+=(!empty($csumdata['amount']))?$csumdata['amount']:'0';
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                //$response['target']=round($target["suggest_target"],2);
                                $response['target']=round($totalsumoftarget,2);
                                $response['totalexpense']=$totaltarget;
                                $response['data']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            } 
                        }
                        else
                        {
                            $catdata=$model->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'category_id'=>$data["category_id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->all();

                            if(!empty($catdata))
                            {    
                                $cdata=$model3->find()->where(['id' => $data['category_id']])->one();
                                $csumdata=$model5->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id' => $getid['id'],'group_id' => $data["group_id"],'category_id' => $data['category_id']])->one(); 

                                $total="0.00";                        
                                foreach ($catdata as $value) 
                                {   
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'user_id' => $value['user_id'],
                                        'selectdate' => $value['selectdate'],                                        
                                        'payment_detail' => $value['payment_detail'],
                                        'amount' => $value['amount'],
                                        'account' => $value['account'],
                                        'note' => $value['note'],
                                        'bill_image' => $value['bill_image'],
                                        'repeat' => $value['repeat'],
                                        'repitition_period' => $value['repitition_period'],
                                        'status' => $value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                    $total+=$value['amount'];
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['total']=$total;
                                $response['suggest_target']=(!empty($csumdata['amount']))?$csumdata['amount']:'';
                                $response['category_name']=$cdata["category_name"];
                                $response['category_icon']=($cdata['category_icon']!=null && $cdata['category_icon']!='a')?$cdata['category_icon']:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png';
                                $response['categoryexpense']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            } 
                        }                         
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }                                                   
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }  
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                           
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }*/
    public function actionMonthlybudget()
    {
        $response=array();
        $model = new Amount();        
        $model2 = new UserSearch();
        $model3 = new Category();
        $model4 = new SetTarget();        
        $model5 = new CategoryUser();
        $connection = Yii::$app->getDb();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    if(isset($data["mydate"]) && !empty($data["mydate"]))
                    {
                        $year = date("Y",strtotime($data["mydate"]));
                        $month = date("m",strtotime($data["mydate"]));
                        if(empty($data["category_id"]))
                        {
                            $csumdata=$model5->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id' => $getid['id'],'group_id' => $data["group_id"]])->all(); 
                            if(!empty($csumdata))
                            { 
                                $totaltarget='0';
                                $totalsumoftarget="0.00";   
                                foreach ($csumdata as $value) 
                                {
                                    $sum="0.00";                                    
                                    $cdata=$model3->find()->where(['id' => $value['category_id']])->one(); 
                                    //GET AMOUNT DETAIL       
                                    if($data["group_id"]==0)
                                    {
                                        $usergroup="user_id=".$getid["id"]."";
                                        $accountquery="account=0";
                                    }
                                    if($data["group_id"]!=0)
                                    {
                                        $groupid=$data["group_id"];
                                        $usergroup="account=".$groupid."";
                                        $accountquery="account!=0";
                                    }                             
                                    $commandamtexp2 = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=2 AND $accountquery AND status=1 AND recordbudget=1 AND $usergroup and category_id=".$value["category_id"]."");
                                    $analysiscatexptotal = $commandamtexp2->queryAll();
                                    $sum=$analysiscatexptotal[0]['sum(amount)'];

                                    //$catdata=$model->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->groupBy(['category_id'])->all();

                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>'EXPENSE',
                                        'user_id' => $value['user_id'],
                                        //'selectdate' => $value['selectdate'],
                                        'category_id' => $value['category_id'],
                                        'category_name' => ($cdata['category_name']!=null)?$cdata['category_name']:'',
                                        'category_icon' => ($cdata['category_icon']!=null && $cdata['category_icon']!='a')?$cdata['category_icon']:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png',
                                        //'payment_detail' => $value['payment_detail'],
                                        'expense_amount' => (!empty($sum))?$sum:'0',
                                        'budget'=>(!empty($value["amount"]))?$value["amount"]:'0',
                                        //'account' => $value['account'],
                                        //'note' => $value['note'],
                                        //'bill_image' => $value['bill_image'],
                                        //'repeat' => $value['repeat'],
                                        //'repitition_period' => $value['repitition_period'],
                                        //'status' => $value['status'],
                                        //'created_date'=>$value['created_date'],
                                        //'modify_date'=>$value['modify_date'],
                                    );
                                    $totaltarget+=$sum;
                                    $totalsumoftarget+=(!empty($value['amount']))?$value['amount']:'0';
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['target']=round($totalsumoftarget,2);
                                $response['totalexpense']=$totaltarget;
                                $response['monthlybudgets']=$cat;
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                            }                            
                        }
                        else
                        {
                            $catdata=$model->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'category_id'=>$data["category_id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->all();
                            
                            $total="0.00"; 
                            $cdata=$model3->find()->where(['id' => $data['category_id']])->one();
                            $csumdata=$model5->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id' => $getid['id'],'group_id' => $data["group_id"],'category_id' => $data['category_id']])->one(); 

                            if(!empty($catdata))
                            {                           
                                foreach ($catdata as $value) 
                                {   
                                    $cat[]=array(
                                        'id' => $value['id'],
                                        'type'=>($value['type']==1)?'INCOME':'EXPENSE',
                                        'user_id' => $value['user_id'],
                                        'selectdate' => $value['selectdate'],                                        
                                        'payment_detail' => $value['payment_detail'],
                                        'expense_amount' => $value['amount'],
                                        'account' => $value['account'],
                                        'note' => $value['note'],
                                        'bill_image' => $value['bill_image'],
                                        'repeat' => $value['repeat'],
                                        'repitition_period' => $value['repitition_period'],
                                        'recordbudget' => ($value['recordbudget']==1)?'YES':'NO',
                                        'status' => $value['status'],
                                        'created_date'=>$value['created_date'],
                                        'modify_date'=>$value['modify_date'],
                                    );
                                    if($value['recordbudget']==1)
                                    {
                                        $total+=$value['amount'];
                                    }                                    
                                }
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['total']=$total;
                                $response['budget']=(!empty($csumdata['amount']))?$csumdata['amount']:'';
                                $response['category_name']=$cdata["category_name"];
                                $response['category_icon']=($cdata['category_icon']!=null && $cdata['category_icon']!='a')?$cdata['category_icon']:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/dafault.png';
                                $response['categoryexpense']=$cat;
                            }
                            else
                            {                                
                                $response['error']=true;
                                $response['statuscode']=409;
                                $response['msg']="No Record Found";
                                $response['total']="0.00";
                                $response['budget']=(!empty($csumdata['amount']))?$csumdata['amount']:'';
                            } 
                        }                         
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']="Pass All Parameter";
                    }                                                   
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }  
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                           
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       MONTHLY / WEEKLY SET BUDGET SECTION                                  #
    ##############################################################################################
    public function actionMonthlycategory()
    {
        $response=array();
        $model = new CategoryUser();
        $model2 = new UserSearch(); 
        $model3 = new CategorySearch();  
        $model4 = new Amount();  
        $model6 = new SetTarget();       
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']) && isset($data["request"]) && !empty($data["request"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {                    
                    if($data["request"]=="addamount")     // FOR ADD NEW GROUP
                    {   
                        if(isset($data["group_id"]) && isset($data["value"]))
                        { 
                            if($data["value"]=="")
                            {
                                //echo "delete";
                                //echo $getid["id"];
                                $year = date("Y");
                                $month = date("m");                            
                                $deletedata=$model->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id'=>$data["group_id"],'status' => 1])
                                        ->orderBy(['id'=>SORT_DESC])
                                        ->all();
                                //SELECT CATEGORY ID FROM DATABASE
                                foreach ($deletedata as $delvalue) 
                                {
                                    //echo $delvalue["id"]."=";
                                    $model4 = $model->find()->where(['user_id'=>$getid["id"],'group_id'=>$data["group_id"],'category_id'=>$delvalue["category_id"]])->one();
                                    $model4->delete();
                                }                                
                            }
                            else
                            {
                                if(strpos($data["value"], "@")!==false)
                                {
                                    $exp=explode("@", $data["value"]);    
                                }
                                else
                                {
                                    $exp[]=$data["value"];
                                }
                                foreach ($exp as $expvlaue) 
                                {
                                    $expvlaue2=explode("-", $expvlaue);
                                    //select from database
                                    $viewdata=$model->find()->where(['user_id'=>$getid["id"],'group_id'=>$data["group_id"],'category_id'=>$expvlaue2[0],'status' => 1])
                                        ->orderBy(['id'=>SORT_DESC])
                                        ->one();
                                    if(empty($viewdata))        //ADD NEW
                                    {
                                        $data2['user_id']=$getid["id"];
                                        $data2['group_id']=$data["group_id"];
                                        $data2['category_id']=$expvlaue2[0];
                                        $data2['amount']=$expvlaue2[1];
                                        $data2['repeat_type']=$expvlaue2[2];
                                        $data2['status']=1;
                                        $data2['created_date']=date('Y-m-d g:i:s');
                                        $data2['modify_date']=date('Y-m-d g:i:s');

                                        $model->attributes = $data2;
                                        $model->id = NULL;
                                        $model->isNewRecord = true;
                                        $model->save();
                                    }
                                    else                        //UDPATE
                                    {
                                        $updatearr=array(
                                            'amount' => $expvlaue2[1],
                                            'repeat_type' => $expvlaue2[2],                   
                                            'modify_date' => date('Y-m-d g:i:s'),
                                            );
                                        $upd=$model->updateAll($updatearr, 'id = '.$viewdata["id"]);
                                    }
                                    $postid[]=$expvlaue2[0];
                                }
                                $year = date("Y");
                                $month = date("m");                            
                                $deletedata=$model->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id'=>$data["group_id"],'status' => 1])
                                        ->orderBy(['id'=>SORT_DESC])
                                        ->all();
                                //SELECT CATEGORY ID FROM DATABASE
                                foreach ($deletedata as $delvalue) 
                                {
                                    $dbid[]=$delvalue["category_id"];
                                }
                                //NOW DELETE ONE BY ONE 
                                foreach ($dbid as $delcat) 
                                {
                                    if(!in_array($delcat, $postid))
                                    {
                                        $model4 = CategoryUser::find()->where(['user_id'=>$getid["id"],'group_id'=>$data["group_id"],'category_id'=>$delcat])->one();
                                        $model4->delete();
                                    }
                                }   
                            }                         
                            //print_r($model->attributes);
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";  
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";  
                        }                      
                    }                    
                    elseif($data["request"]=="viewamount")
                    {
                        $year = date("Y");
                        $month = date("m");
                        $catdata=$model->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id'=>$data["group_id"],'status' => 1])
                                    ->orderBy(['id'=>SORT_ASC])
                                    ->all(); 
                        if(!empty($catdata))
                        {
                            /*$target=$model6->find()->where(['DATE_FORMAT(created_date, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'group_id' => $data["group_id"]])->orderBy(['id'=>SORT_DESC])->one();
                            $totaltarget="0";
                            if(isset($data["category_id"]))
                            {
                                $sumdata=$model4->find()->where(['DATE_FORMAT(selectdate, "%Y-%m")' => $year."-".$month,'user_id'=>$getid["id"],'category_id'=>$data["category_id"],'type' => 2,'account' => $data["group_id"],'status' => 1])->orderBy(['id'=>SORT_DESC])->all();
                                foreach ($sumdata as $sumvalue) 
                                {
                                    $totaltarget+=$sumvalue["amount"];
                                }
                            }*/
                                    
                            foreach ($catdata as $value) 
                            {                    
                                $cat[]=array(
                                    'id' => $value['id'],
                                    'category_id'=>$value['category_id'],
                                    'category_name'=>(!empty($model3->categoryname($value["category_id"])))?$model3->categoryname($value["category_id"]):'',
                                    'category_icon'=>(!empty($model3->categoryname($value["category_id"],'category_icon')))?$model3->categoryname($value["category_id"],'category_icon'):'',
                                    'amount'=>$value['amount'],
                                    'repeat_type'=>$value['repeat_type'],
                                    'repeat'=>($value['repeat_type']==1)?'Weekly':'Monthly',
                                    'status'=>$value['status'],
                                    'created_date'=>$value['created_date'],
                                    'modify_date'=>$value['modify_date'],
                                );
                            }
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                            //$response['target']=round($target["suggest_target"],2);
                            //$response['totalexpense']=$totaltarget;
                            $response['expensedata']=$cat;
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=409;
                            $response['msg']="No Record Found";
                        } 
                    }
                    elseif($data["request"]=="delete")
                    {
                        if(isset($data["id"]))
                        {    
                            if(strpos($data["id"], ",")!==false)
                            {
                                $exp=explode(",", $data["id"]);    
                            }
                            else
                            {
                                $exp[]=$data["id"];
                            }
                            foreach ($exp as $expvlaue) 
                            {
                                $model4 = CategoryUser::find()->where(['id'=>$expvlaue])->one();
                                $model4->delete();
                                /*$model4 = CategoryUser::findOne($expvlaue[0]);
                                $model4->delete();*/
                            }
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";
                        }  
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']="Pass All Parameter";
                        }
                    }                        
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=512;
                        $response['msg']="Invalid Request";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);  
    }

    ##############################################################################################
    #                       MONTHLY / WEEKLY SET BUDGET SECTION                                  #
    ##############################################################################################
    public function actionAnalysis()
    {
        $response=array();   
        $model = new User();
        $model1 = new Amount(); 
        $model2 = new CategoryUser(); 
        $model3 = new UserSearch();
        $model4 = new SetTarget();      
        $model5 = new CategorySearch();
        if(Yii::$app->getRequest()->method==="POST")
        {   
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']) && isset($data["request"]) && !empty($data["request"]))
            {
                $getid=$model3->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $id=$getid["id"];
                    if($data["type"]==1)
                    {
                        $usergroup="user_id=".$id."";
                        $accountquery="account=0";
                    }
                    if($data["type"]==2)
                    {
                        $groupid=$data["groupid"];
                        $usergroup="account=".$groupid."";
                        $accountquery="account!=0";
                    }
                    $year = date("Y",strtotime(date('Y-m-d')));
                    $month = date("m",strtotime(date('Y-m')));
                    $monthno=array('01','02','03','04','05','06','07','08','09','10','11','12'); 
                    $monthname=array('1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
                    $currentyear=date('Y');
                    $i=1;
                    //$j=1;
                    $cashnettotalin=0;
                    $cashnetprevval=0;
                    $cashnetdifftotal=0;
                    $prevamtval=0;
                    $connection = Yii::$app->getDb();
                    //type

                    foreach ($monthno as $cashinmonth) 
                    {                     
                        //CASHFLOW   
                        //Cash In (Income)
                        $commandamtindi = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$cashinmonth."' AND type=1 and $accountquery and status=1 and recordbudget=1 and $usergroup");
                        $analysiscashinarray['cashin'] = $commandamtindi->queryAll();

                        //Cash Out (Expense)
                        $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$cashinmonth."' AND type=2 and $accountquery and status=1 and recordbudget=1 and $usergroup");
                        $analysiscashinarray['cashout'] = $commandamtexp->queryAll();

                        $cashin=round($analysiscashinarray['cashin'][0]['sum(amount)']);
                        $cashout=round($analysiscashinarray['cashout'] [0]['sum(amount)']); 
                        $cashflow=($cashin-$cashout);
                        
                        //NETWORTH    
                        $cashnettotalin+=$cashin;
                        //$cashnetdiff=round(($cashin-$cashnetprevval));
                        
                        if($i==1)
                        {
                            $cashnetprevval=0;     
                            $cashnetdiff=0;     
                        } 
                        else
                        {
                            $cashnetprevval=$prevamtval; 
                            //$cashnetdiff=round(($cashnetin-$cashnetprevval));
                            $cashnetdiff=round(($cashin-$cashnetprevval));
                        }
                        $prevamtval=$analysiscashinarray["cashin"][0]['sum(amount)'];
                        //echo $cashnetdiff;
                        $cashnetdifftotal+=$cashnetdiff;
                        //ARANGE DATA IN ARRAY
                        $analysiscashin['cashflow'][]=array('month'=>$monthname[$i],'cashin'=>$cashin,'cashout'=>$cashout,'cashflow'=>$cashflow);
                        $analysiscashin['networth'][]=array('month'=>$monthname[$i],'networth'=>$cashin,'difference'=>$cashnetdiff);
                        if($i>=1)
                        {
                           $cashnetprevval=$analysiscashinarray["cashin"][0]['sum(amount)'];                            
                        }
                        $i++;
                        //print_r($analysiscashinarray);
                    }
                    //NETWORTH TOTAL
                    $analysiscashin['networthtotal']=array('networthtotal'=>$cashnettotalin,'differencetotal'=>$cashnetdifftotal);
                    
                    //CATEGORY SECTION 
                    if($data["type"]==1)
                    {
                        $ucatdata=$model2->find()->where(['user_id'=>$id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();    
                    }
                    if($data["type"]==2)
                    {
                        $ucatdata=$model2->find()->where(['group_id' => $data["groupid"],'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();    
                    }

                    $analcategory=$ucatdata;
                    $analsmonth=(!empty($data["date"]))?date("m",strtotime(date($data["date"]))):date('m');
                    $ace=1;
                    //find total income
                    $commandamtexp2 = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$analsmonth."' AND type=2 and $accountquery and status=1 and recordbudget=1 and $usergroup");
                    $analysiscatexptotal = $commandamtexp2->queryAll();

                    foreach ($analcategory as $analcatval) 
                    {
                        //Analysis Category wise  (Expense)            
                        $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$currentyear."-".$analsmonth."' AND type=2 and $accountquery and status=1 and recordbudget=1 and $usergroup and category_id=".$analcatval["category_id"]."");
                        $analysiscatexp = $commandamtexp->queryAll();
                        //print_r($analysiscatexp);
                        $amountcat=$analysiscatexp[0]['sum(amount)'];
                        if($amountcat!=0){
                            $percatexp=round((($amountcat*100)/$analysiscatexptotal[0]["sum(amount)"]),2);
                        }
                        else
                        {
                            $percatexp=0;
                        }
                        

                        $analysiscashin['category'][]=array('category'=>$model5->categoryname($analcatval["category_id"]),'amount'=>$amountcat,'percentage'=>$percatexp.'%');
                    }
                    #############################################################################################
                    //SUMMARY
                    $mnt=(!empty($data["date"]))?date("m",strtotime(date($data["date"]))):date('m');
                    $month = date("m",strtotime(date('Y-'.$mnt))); 
                    if($data["type"]==1)
                    {
                         //FIND CURRENT SET TARGET 
                        $currentmonthtarget=$model4->find()->where(['user_id' => $id,'group_id' =>0,'type'=>1,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->orderBy(['id'=>SORT_DESC])->one();  
                    }
                    if($data["type"]==2)
                    {
                         //FIND CURRENT SET TARGET 
                        $currentmonthtarget=$model4->find()->where(['group_id' =>$groupid,'type'=>2,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1])->limit(1)->orderBy(['id'=>SORT_DESC])->one();  
                    }
                   

                    //Cash In (Income)
                    $commandamtindi2 = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=1 and $accountquery and status=1 and recordbudget=1 and $usergroup");
                    $analysiscashin2=$commandamtindi2->queryAll();
                    $analcashin=round($analysiscashin2[0]['sum(amount)']);

                    //Cash Out (Expense)
                    $commandamtexp = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$year."-".$month."' AND type=2 and $accountquery and status=1 and recordbudget=1 and $usergroup");
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

                    $analysiscashin['summary']['general']=array('totalincome'=>$analcashin,'totalexpense'=>$analcashout,'savingtarget'=>round($currentmonthtarget['suggest_target']),'netcashflow'=>$netcashflow,'targetachievement'=>$targetachi);

                    #BUDGET SECTION
                    //Total Budget
                    if($data["type"]==1)
                    {
                        $commandbudgettot = $connection->createCommand("SELECT sum(amount) FROM category_user where DATE_FORMAT(created_date,'%Y-%m')='".$year."-".$month."' and group_id=0 and status=1 and user_id=".$id."");
                        //Top Spent
                        $ucatdata=$model2->find()->where(['user_id'=>$id,'group_id' => 0,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();
                    }
                    if($data["type"]==2)
                    {
                        $commandbudgettot = $connection->createCommand("SELECT sum(amount) FROM category_user where DATE_FORMAT(created_date,'%Y-%m')='".$year."-".$month."' and group_id=".$groupid." and status=1");
                        //Top Spent
                        $ucatdata=$model2->find()->where(['group_id' => $groupid,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month,'status'=>'1'])->all();
                    }

                    $analysisbudgettot=$commandbudgettot->queryAll();
                    $budgettotal=round($analysisbudgettot[0]['sum(amount)']);

                    $prevmax=0;
                    $prevmin=0;
                    $maxval=0;
                    $minval=0;
                    $category="";
                    $categorymin="";
                    foreach ($ucatdata as $budgetvalue) 
                    {
                        if($data["type"]==1)
                        {
                            $expget=$model3->getExpenseMonthWise($type=2,$user=1,$month=date('Y-m'),$budgetvalue["user_id"],$budgetvalue["category_id"]);

                            $expminget=$model3->getExpenseMonthWise($type=2,$user=1,$month=date('Y-m'),$budgetvalue["user_id"],$budgetvalue["category_id"]);

                        }
                        if($data["type"]==2)
                        {
                            $expget=$model3->getExpenseMonthWise($type=2,$user=2,$month=date('Y-m'),$budgetvalue["group_id"],$budgetvalue["category_id"]);

                            $expminget=$model3->getExpenseMonthWise($type=2,$user=2,$month=date('Y-m'),$budgetvalue["group_id"],$budgetvalue["category_id"]);                            
                        }
                        if(!empty($expget))
                        {                    
                            if($expget>$prevmax)
                            {
                                $maxval=$expget;
                                $category=$model5->categoryname($budgetvalue["category_id"]);
                                $prevmax=$expget;
                            }
                            
                        }

                        if(!empty($expminget))
                        {                    
                            if($expminget<$prevmin)
                            {
                                $minval=$expminget;
                                $categorymin=$model5->categoryname($budgetvalue["category_id"]);
                            }
                            $prevmin=$expminget;
                        }

                        
                    }
                    $budgetdiff=($budgettotal-$analcashout);
                    $analysiscashin['summary']['budget']=array('total'=>$budgettotal,'spent'=>$analcashout,'difference'=>$budgetdiff,'maxcategory'=>$category,'topspent'=>$maxval,'mincategory'=>$categorymin,'minispent'=>$minval);

                    if($data["type"]==2)
                    {
                        //NET SPENDING USERWISE FOR GROUP
                        $userlist=$model3->displayGroupUserForSelect($groupid);
                        $n=1;
                        //print_r($userlist);
                        $totalnetspend=0;
                        $commandnetexpusertot = $connection->createCommand("SELECT sum(amount) FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$month."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account='".$groupid."'");
                        $commauserTotal = $commandnetexpusertot->queryAll();
                        $totalnetspend=$commauserTotal[0]['sum(amount)'];
                        if(empty($totalnetspend))
                        {
                            $totalnetspend=1;
                        }
                        foreach ($userlist as $uservalue) 
                        {           
                            $commandnetexpuser = $connection->createCommand("SELECT sum(amount),user_id FROM amount where DATE_FORMAT(selectdate,'%Y-%m')='".$month."' AND type=2 and account!=0 and status=1 and recordbudget=1 and account='".$groupid."' and user_id='".$uservalue['id']."'");
                            $commandnetexpuser123 = $commandnetexpuser->queryAll();
                            $netamount=$commandnetexpuser123[0]['sum(amount)'];
                            $totalpernet=round((($netamount*100)/$totalnetspend),2);
                            $netspent[]=array('user_id'=>$model3->displayname($uservalue["id"]),'amount'=>$commandnetexpuser123[0]["sum(amount)"],'percentage'=>$totalpernet.'%');
                        }
                        
                        $analysiscashin['netspending']=array('netspent'=>$netspent);
                    }
                   
                    //print_r($analysiscashin);                   

                    $response['error']=false;
                    $response['statuscode']=200;
                    $response['msg']="Success";
                    $response['data']=$analysiscashin;

                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Pass All Parameter";
            }
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
    }
    ##############################################################################################
    #                       MONTHLY SPEND DETAIL SECTION                                         #
    ##############################################################################################
    public function actionAdvertisement()
    {
        $response=array();
        $model = new AdsmgmtSearch();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $currentdate = date("Y-m-d");
                    $catdata=$model->find()->where(['status' => 1])
                                            ->andWhere(['<=','ads_startdate', $currentdate])
                                            ->andWhere(['>=','ads_enddate', $currentdate])
                                            ->orderBy(['id'=>SORT_DESC])
                                            ->all(); 

                    if(!empty($catdata))
                    {                          
                        foreach ($catdata as $value) 
                        {   
                            $cat[]=array(
                                'id' => $value['id'],
                                'title' => $value['ads_title'],
                                'startdate' => $value['ads_startdate'],
                                'enddate' => $value['ads_enddate'],
                                'url' => $value['ads_url'],
                                'image' => $value['ads_image'],
                                'impression' => $value['ads_impressionlimit'],                                
                                'status' => $value['status'],
                                'createddate'=>$value['created_date'],    
                                'modifydate'=>$value['modify_date'],                            
                            );
                        }
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['data']=$cat;
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=409;
                        $response['msg']="No Record Found";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    ##############################################################################################
    #                       SELECT GLOBAL API SECTION                                         #
    ##############################################################################################
    public function actionGetdetail()
    {
        $response=array();
        $model = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data['token']) && isset($data['token']))
            {
                $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                $getid=$model->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $currentdate = date("Y-m-d");
                    $userdata=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                    if(!empty($userdata))
                    {                          
                        $cat[]=array(
                            'userid' => $getid['id'],
                            'nickname' => (!empty($userdata['nick_name']))?$userdata['nick_name']:$userdata['nick_name'],
                            'username' => (!empty($userdata['username']))?$userdata['username']:'',
                            'userpic' => (!empty($userdata['image']))?$userdata['image']:$defaultimg,
                            'category'=>false
                        );

                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['userdetail']=$cat;
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=409;
                        $response['msg']="No Record Found";
                    }                                  
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Token Not Matched";
                } 
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=410;
                $response['msg']="Token Not Matched";                
            }                            
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);    
    }
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/

}
