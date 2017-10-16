<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Followers;
//use app\models\GroupSearch;
//use app\models\GroupMember;
//use app\models\ExpenseCategory;
//use app\models\IncomeCategory;
//use app\models\Category;
//use app\models\IncomeAmount;
//use app\models\ExpenseAmount;
//use app\models\SetTarget;
//use app\models\Pages;
//use app\models\News;
//use app\models\Feedback;
//use app\models\Notice;
//use app\models\NoticeComment;
//use app\models\Amount;
//use app\models\CategoryUser;
//use app\models\CategorySearch;
//use app\models\AdsmgmtSearch;
//use app\models\Pushnotification;
//use app\models\PushnotificationSearch;
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
            ]
        ];
    }
    public function alertenglish($index=null){
        $alertenglish=array(
            '200'=>'Success',
            '202'=>'Sorry, not Saved',
            '512'=>'Your Request is Invalid.',
            '400'=>'User id Empty',
            '401'=>'Please Enter the value',
            '402'=>'User id can\'t be empty',
            '403'=>'User not Found.',
            '404'=>'Invalid Otp Code.',
            '405'=>'Phone number can\'t be empty.',
            '406'=>'Invalid Password',
            '407'=>'New Password Not Empty.',
            '408'=>'Current Password Not Empty.',
            '409'=>'No Record Found',
            '410'=>'Token Not Match',
            '411'=>'Email Is Empty',
            '412'=>'Please pass all the parameters',
            '413'=>'Email is not changed',
            '414'=>'OTP not verify',
            '415'=>'Your Account is Disable By Admin',
            '416'=>'Error Found',
            '417'=>'Opening balance not in Decimal.',
            '418'=>'Maximum Limit of Group you create.',
            '419'=>'Maximum user add in this group',
            '421'=>'Family Member Should be 1.',
            '422'=>'Group Admin cannot exit the group.',
            '423'=>'Group Admin cannot delete the group.',
            '424'=>'Enter atleast 3 characters.',
            '425'=>'Parameters passed are invalid',
        );
        if($index!=null){
            return $alertenglish[$index];
        }
        else
        {
            return $alertenglish;
        }
    }    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex(){
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
    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    
    #####################################  USER  LOGIN SECTION     #########################################################
    public function actionUserlogin_reg() {           
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST"){
            $data=Yii::$app->request->post();
//            $language=$data["lang"];
//            if($language==1)
//            {
//                $language=1;                    //Chinese
//                $returnmessage=$this->alertchinese();                    
//            }
//            else
//            {
//                $language=0;                    //English
//                $returnmessage=$this->alertenglish();
//            }
            $returnmessage=$this->alertenglish();
            
            if(isset($data["device_type"]) && !empty($data["device_type"]) && isset($data["device_id"]) && !empty($data["device_id"])){
                if($data["device_type"] == 1 || $data["device_type"] == 2){  //1=> android 2=> ios
                    if(isset($data["registration_type"]) && $data["registration_type"] == 1) {  // USING MOBILE NUMBER 
                        if(isset($data["number"]) && !empty($data["number"])) {
                            $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20); 
                            $userdata=$model->find()->where(['number' => $data['number'], 'role' => 2])
                                            ->limit(1)
                                            ->orderBy(['id'=>SORT_ASC])
                                            ->one(); 
                            if(!empty($userdata)) {  //LOGIN                                      
                                $otp = '00000';
        //                            $hashpassword = md5($data["password"]);
        //                            if($userdata["password"]==$hashpassword)
        //                            {
                                if($userdata["status"]==1) {
                                    //UPDATE INTO DATABASE
                                    $updatearr=array(
                                        'otp_code' => $otp,
                                        'session_key' => $sessionkey,
        //                                        'register_id'=>$data['register_id'],
        ////                                        'device_type'=>$data['device_type'],
                                        'updated_date' => date('Y-m-d g:i:s')
        //                                        'lang' => $language
                                        );
                                    $upd=User::updateAll($updatearr, 'id = '.$userdata['id']); 
                                    $response['error']=false;                        
                                    $response['userid']=$userdata["id"];
                                    $response['session_key']=$sessionkey;
                                    $response['verify_no']=$userdata["verify_no"];
                                    $response['is_new']= 2;       // to check login or registration
                                    $response['statuscode']=200;
                                    $response['msg']="Success";
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=415;
                                    $response['msg']=$returnmessage[$response['statuscode']];
                                }
                            }
                            else{ //Registration
                               $otpcode="000000"; 

                               $data['otp_code']=$otpcode;
                               $data['created_date']=date('Y-m-d g:i:s');
                               $data['updated_date']=date('Y-m-d g:i:s');
   //                            $model->device_id = $data["device_type"];
                               $model->lang=1;
       //                        $model->scenario = User::SCENARIO_CREATE;
                               $model->attributes = $data;
   //                            print_r($data);
   //                            print_r($model->attributes); exit;
                               if ($model->save()) {
                                   $response['error']=false;
                                   $response['userid']=$model->getPrimaryKey();
                                   $response['session_key']=$sessionkey;
                                    $response['is_new']= 1;       // to check 2- login or 1-registration
                                   $response['statuscode']=200;
                                   $response['msg']="Success";
                               } 
                               else {
                                   $response['error']=true;
                                   $response['statuscode']=202;
                                   $response['msg']=$returnmessage[$response["statuscode"]];
                               }                                
                            } 
                        }
                        else {
                            $response['error']=true;
                            $response['statuscode']=412;
                            $response['msg']=$returnmessage[$response['statuscode']];
                        }
                    }
                    //SOCIAL HERE
                }  
                else{  /// Device Type not correct
                    $response['error']=true;
                    $response['statuscode']=425;
                    $response['msg']=$returnmessage[$response['statuscode']];
                }
                
            }   //parameters not defined
            else {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']=$returnmessage[$response['statuscode']];
            }
        }   // Request not Post
        else {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Your Request is Invalid";
        }
        echo json_encode($response);
    }
    
    
    ########################################  REGISTER USER SECTION   ######################################################
//    public function actionRegisteruser() {
//        $response=array();
//        $model = new User();
//        $model2 = new UserSearch();       
//        //print_r($model->attributes);      //THIS IS GIVE THE ALL COLUMN OF TABLE
//        //echo $otpcode=substr(mt_rand(100000,999999),0,6);        
//        if(Yii::$app->getRequest()->method==="POST") {
//            $data=Yii::$app->request->post();
//            $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);  
////            $regid=$model2->generateRegId();
////            $otpcode=substr(mt_rand(100000,999999),0,6);                    
//            $otpcode="000000";            
////            $language=$data["language"];
////            if($language==1)
////            {
////                $language=1;                    //Chinese
////                $returnmessage=$this->alertchinese();                    
////            }
////            else
////            {
////                $language=0;                    //English
////                $returnmessage=$this->alertenglish();
////            }
//            $returnmessage = $this->alertenglish();
//            if(isset($data['device_type']) && !empty($data['device_type']) && isset($data['registration_type']) && !empty($data['registration_type'])){                
//                if($data["registration_type"]==1  && !empty($data["number"])){  //Mobile registration            
//                    $error=$model2->validateRegister($data); //validateRegister($data['number']); //isExistnumber($data['number']);
//                    if($error['error']){   
//                        $response=$error;
////                        $error['error']=true;
////                        $response['statuscode']=412;
////                        $response['msg']=$returnmessage[$response["statuscode"]];
//                    }
//                    else {
//                        if(!empty($data["device_id"])) {   
////                        $data["regid"]= $regid;
////                        $data['password']=md5($data["password"]);
//                            $data['otp_code']=$otpcode;
////                        $data['otpverify']=0;                    
////                        $data['facebook_id']="";
//                            $data['status']=1;
////                        $data['role']=2;
////                        $data['token']=$sessionkey;
//                            $data['created_date']=date('Y-m-d g:i:s');
//                            $data['updated_date']=date('Y-m-d g:i:s');
////                        $model->device_type=$data["device_type"];
////                        $model->register_id=$data["register_id"];
//                            $model->lang=1;
////                        $model->scenario = User::SCENARIO_CREATE;
//                            $model->attributes = $data;
//                        //print_r($data);
//                            if ($model->save()) {
//                                $response['error']=false;
//                                $response['userid']=$model->getPrimaryKey();
//                                $response['session_key']=$sessionkey;
//                                $response['statuscode']=200;
//                                $response['msg']="Success";
//                            } 
//                            else {
//                                $response['error']=true;
//                                $response['statuscode']=202;
//                                $response['msg']=$returnmessage[$response["statuscode"]];
//                            } 
//                        }
//                        else{
//                            $response['error']=true;
//                            $response['statuscode']=412;
//                            $response['msg']=$returnmessage[$response["statuscode"]];
//                        }                        
//                    }                                 
//                }            
//                else {
//                    $response['error']=true;
//                    $response['statuscode']=412;
//                    $response['msg']=$returnmessage[$response["statuscode"]];
//                }            
//            }
//            else {
//                $response['error']=true;
//                $response['statuscode']=412;
//                $response['msg']=$returnmessage[$response["statuscode"]];
//            }
//        }
//        else
//        {
//            $response['error']=true;
//            $response['statuscode']=512;
//            $response['msg']="Your Request is invalid";
//        }
//        echo json_encode($response);
//        die;
//    }
    
    ##################################### USER  LOGIN SECTION        #########################################################
//    public function actionUserlogin() {           
//        $response=array();
//        $model = new User();
//        $model2 = new UserSearch();
//        if(Yii::$app->getRequest()->method==="POST")
//        {
//            $data=Yii::$app->request->post();
////            $language=$data["lang"];
////            if($language==1)
////            {
////                $language=1;                    //Chinese
////                $returnmessage=$this->alertchinese();                    
////            }
////            else
////            {
////                $language=0;                    //English
////                $returnmessage=$this->alertenglish();
////            }
//            $returnmessage=$this->alertenglish();
////            $error=$model2->validateLogin($data);
////            if($error['error'])
////            {
////                $response=$error;
////            }
////            else
////            {   
////            print_r($data);
//            if(isset($data["registration_type"]) && $data["registration_type"] == 1) {
//                if(isset($data["number"]) && !empty($data["number"])) {
//                    $userdata=$model->find()->where(['number' => $data['number'], 'role' => 2, 'status' => 1])
//                                    ->limit(1)
//                                    ->orderBy(['id'=>SORT_ASC])
//                                    ->one(); 
//                    if(!empty($userdata)) {             
//                        $sessionkey = Yii::$app->getSecurity()->generateRandomString($length=20);  
//                        $otp = '00000';
////                            $hashpassword = md5($data["password"]);
////                            if($userdata["password"]==$hashpassword)
////                            {
//                        if($userdata["status"]==1)
//                        {
//                            //UPDATE INTO DATABASE
//                            $updatearr=array(
//                                'otp_code' => $otp,
//                                'session_key' => $sessionkey,
////                                        'register_id'=>$data['register_id'],
//////                                        'device_type'=>$data['device_type'],
//                                'updated_date' => date('Y-m-d g:i:s')
////                                        'lang' => $language
//                                );
//                            $upd=User::updateAll($updatearr, 'id = '.$userdata['id']); 
//                            $response['error']=false;                        
//                            $response['userid']=$userdata["id"];
//                            $response['session_key']=$sessionkey;
//                            $response['verify_no']=$userdata["verify_no"];
//                            $response['statuscode']=200;
//                            $response['msg']="Success";
//                        }
//                        else
//                        {
//                            $response['error']=true;
//                            $response['statuscode']=415;
//                            $response['msg']=$returnmessage[$response['statuscode']];
//                        }
//                    }
////                            }
////                            else
////                            {
////                                $response['error']=true;
////                                $response['statuscode']=406;
////                                $response['msg']=$returnmessage[$response['statuscode']];
////                            }
//                        
//                        /*else if($data["register_by"]==2)
//                        {
//                            if($userdata["status"]==1)
//                            {
//                                //UPDATE INTO DATABASE
//                                $updatearr=array(
//                                    'token' => $sessionkey, 
//                                    'facebook_id' => $data["facebook_id"], 
//                                    'device_type'=>$data['device_type'],                  
//                                    'last_update_date' => date('Y-m-d g:i:s'),
//                                    );
//                                $upd=User::updateAll($updatearr, 'id = '.$userdata['id']); 
//                                $response['error']=false;                        
//                                $response['userid']=$userdata["id"];
//                                $response['token']=$sessionkey;
//                                $response['userverify']=$userdata["otpverify"];
//                                $response['statuscode']=200;
//                                $response['msg']="Success";
//                            }
//                            else
//                            {
//                                $response['error']=true;
//                                $response['statuscode']=415;
//                                $response['msg']="Account is Disable By Administration";
//                            }
//                        }*/
//                        else
//                        {
//                            $response['error']=true;
//                            $response['statuscode']=405;
//                            $response['msg']=$returnmessage[$response['statuscode']];
//                        }                    
//                    }
//                    else
//                    {
//                        $response['error']=true;
//                        $response['statuscode']=405;
//                        $response['msg']=$returnmessage[$response['statuscode']];
//                    }
//                }
//                else{
//                    $response['error']=true;
//                    $response['statuscode']=512;
//                    $response['msg']="Registration type invalid";
//                }
////            }
//        }
//        else
//        {
//            $response['error']=true;
//            $response['statuscode']=512;
//            $response['msg']="Your Request is Invalid";
//        }
//        echo json_encode($response);
//    }
    
    ###################################### OTP VERIFY SECTION  ########################################################
    public function actionVerifyotp() {
        $response=array();
        $model = new User();
        $model2=new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            if(!empty($data["otp_code"]) && isset($data["session_key"]) && !empty($data["session_key"])) {
//                $getid=$model2->isExistBytoken($data["token"]);
                $getid=$model->find()->where(['session_key' =>$data["session_key"], 'role' => 2, 'status' => 1])
                                    ->limit(1)
                                    ->orderBy(['id'=>SORT_ASC])
                                    ->one(); 
                if(!empty($getid)){
//                    $language=$model2->displayname($getid["id"],"lang");
//                    if($language==1)
//                    {
//                        $language=1;                    //Chinese
//                        $returnmessage=$this->alertchinese();                    
//                    }
//                    else
//                    {
//                        $language=0;                    //English
//                        $returnmessage=$this->alertenglish();
//                    }
                     $returnmessage=$this->alertenglish();
                    if(!empty($data["otp_code"])){
                        $otpcode="00000";
                        $user=$model2->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                        //if($user["otp_code"]==trim($data["otpcode"]))
                        if($otpcode==trim($data["otp_code"]))
                        {
                            //UPDATE INTO DATABASE
                            $updatearr=array(
                                'verify_no' => 1, 
                                'otp_code' => '',
                                'updated_date' => date('Y-m-d g:i:s'),
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
                            $response['msg']=$returnmessage[$response["statuscode"]];
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=401;
                        $response['msg']=$returnmessage[$response["statuscode"]];
                    } 
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Session key Not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Please Pass All Parameter";
            }                       
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Your Request is Invalid";
        }
        echo json_encode($response);
    }
    
    #######################################  USER DETAIL UPDATE SECTION  #######################################################
    public function actionProfileupdate() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();        
        if(Yii::$app->getRequest()->method==="POST"){
            $data=Yii::$app->request->post();
            if(!empty($data["session_key"])){
                $getid=$model2->isExistBytoken($data["session_key"]);
                if(!empty($getid)) {
//                    $language=$model2->displayname($getid["id"],"lang");
//                    if($language==1)
//                    {
//                        $language=1;                    //Chinese
//                        $returnmessage=$this->alertchinese();                    
//                    }
//                    else
//                    {
//                        $language=0;                    //English
//                        $returnmessage=$this->alertenglish();
//                    }
                    $returnmessage=$this->alertenglish();
                    $error=$model2->validateUpdate($data);
//                    $error['error'] = '';
                    if($error['error'])
                    {
                        $response=$error;
                    }
                    //if(!empty($data["name"]) && !empty($data["nick_name"]) && !empty($data["location"]) && !empty($data["gender"]) && !empty($data["age"]) && !empty($data["horoscope"]))
                    else {
                        $updatearr=array(
                            'name' => $data["name"],
                            'nick_name' => $data["nick_name"],
                            'intro' => $data["intro"],
                            'location' => $data["location"],
//                            'mobile_no' => $data["mobile_no"],
//                            'nick_name' => $data["nick_name"],
//                            'occupation' => $data["occupation"],   
                            'gender' => $data["gender"],
                            'horoscope' => $data["horoscope"],
                            'age' => $data["age"],  
                            'dob' => $data['dob'],
//                            'opening_balance' => $data["opening_balance"],                 
                            'updated_date' => date('Y-m-d g:i:s'),
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
                            $response['msg']=$returnmessage[$response["statuscode"]];
                        }
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Session id not Matched";
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=402;
                $response['msg']="Session id Not Matched";
            }                      
        }
        else
        {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Your request is invalid.";
        }
        echo json_encode($response);
        die;
    }
    
     ######################################## USER UPDATE PROFILE PIC SECTION  ######################################################
    public function actionUserimage() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();        
        if(Yii::$app->getRequest()->method==="POST") {
            $data=Yii::$app->request->post();
            if(!empty($data["session_key"])) {
                $getid=$model2->isExistBytoken($data["session_key"]);
                if(!empty($getid)) {
//                    $language=$model2->displayname($getid["id"],"lang");
//                    if($language==1)
//                    {
//                        $language=1;                    //Chinese
//                        $returnmessage=$this->alertchinese();                    
//                    }
//                    else
//                    {
//                        $language=0;                    //English
//                        $returnmessage=$this->alertenglish();
//                    }
                    $returnmessage=$this->alertenglish();
                    if(!empty($_FILES)) {
                        $path=Yii::getAlias('@webroot');
                        $model->image = UploadedFile::getInstanceByName('image');                        
                        if($model->image) {
                            $userdata=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 

                            $fullpath=$path.'/upload/user/'.$getid["id"].time().'.'.$model->image->extension;
                            $model->image->saveAs($fullpath);
                            $webpath=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/'.$getid["id"].time().'.'.$model->image->extension;
                            $updatearr=array(
                                'image' => $webpath,
                                );
                            $upd=User::updateAll($updatearr, 'id = '.$getid["id"]); 
                            if ($upd===1) {
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
                                $response['msg']=$returnmessage[$response["statuscode"]];
                            }
                        }
                        else 
                        {
                            $response['error']=true;
                            $response['statuscode']=416;
                            $response['msg']=$returnmessage[$response["statuscode"]];
                        }
                    }  
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=412;
                        $response['msg']=$returnmessage[$response["statuscode"]];
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
    #######################################    USER DETAIL VIEW SECTION    #######################################################
    public function actionUserprofileview(){
        $response=array();
        $model = new User();
        $model2 = new UserSearch();        
        if(Yii::$app->getRequest()->method==="POST") {
            $data=Yii::$app->request->post();
            if(!empty($data["session_key"]) && !empty($data)){
                $getid=$model2->isExistBytoken($data["session_key"]);
                if(!empty($getid)) {
//                    $language=$model2->displayname($getid["id"],"lang");
//                    if($language==1)
//                    {
//                        $language=1;                    //Chinese
//                        $returnmessage=$this->alertchinese();                    
//                    }
//                    else
//                    {
//                        $language=0;                    //English
//                        $returnmessage=$this->alertenglish();
//                    }
                    $returnmessage=$this->alertenglish();
                    $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
                    $user_data=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
                    if(!empty($user_data))  {                            
                        $user[]=array(
                                'user_id' => $user_data['id'],
//                                'registerid'=>$user_data['regid'],
                                'email'=>$user_data['email'],
                                'nick_name'=>(!empty($user_data['nick_name']))?$user_data['nick_name']:$user_data['name'],
                                'intro' => $user_data["intro"],
                                'location' => $user_data["location"],
//                                'fb_id'=>$catdata['fb_id'],
                                'image'=>(!empty($user_data['image']))?$user_data['image']:$defaultimg,
                                'number' => $user_data["number"],
                                'verify_no'=> $user_data['verify_no'],  
                                'dob'=> $user_data['dob'], 
//                                'alternate_no' => (!empty($catdata["alternate_no"]))?$catdata["alternate_no"]:'',
                                'device_id' => $user_data["device_id"],       
//                                'occupation' => $catdata["occupation"],   
                                'gender' => $user_data["gender"],
                                'age' => $user_data["age"],  
                                'registration_type' => $user_data["registration_type"],
                                'status' => $user_data["status"],
                                'lang' => $user_data["lang"],
//                                'opening_balance' => round($catdata["opening_balance"],0),                 
                                'created_date' => $user_data["created_date"],
                                'updated_date' => $user_data["updated_date"],     
                            );
                        $response['error']=false;
                        $response['statuscode']=200;
                        $response['msg']="Success";
                        $response['users']=$user;
                    }
                    else {
                        $response['error']=true;
                        $response['statuscode']=409;
                        $response['msg']=$returnmessage[$response['statuscode']];
                    } 
                }
                else {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Session key is not Matched.";
                } 
            }
            else {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Please pass all parameters";
            }  
        }
        else {
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Invalid Request";
        }
        echo json_encode($response);
    }
    
    #####################################  USER LOGOUT SECTION  #########################################
    public function actionUserlogout() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        $returnmessage=$this->alertenglish();
        if(Yii::$app->getRequest()->method==="POST"){
            $data=Yii::$app->request->post();
            if(!empty($data["session_key"])){
                $getid=$model2->isExistBytoken($data["session_key"]);
                if(!empty($getid)){
                    $updatearray=array(
                            'session_key' => "",           
                            'updated_date' => date('Y-m-d g:i:s'),
                            );
                    $upd=User::updateAll($updatearray, 'id = '.$getid["id"]); 
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
                        $response['msg']="Error in updation";
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Session key Not Matched";
                }
            }
            else{
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Please pass all parameters";
            }                
        }
        else{
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Your Request is invalid.";
        }
        echo json_encode($response);      
    }
    
    #####################################  USER FOLLOW SECTION  #########################################
    public function actionUserfolloww() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        $returnmessage=$this->alertenglish();
        if(Yii::$app->getRequest()->method==="POST"){
            $data=Yii::$app->request->post();
            if(!empty($data["session_key"])){
                $getid=$model2->isExistBytoken($data["session_key"]);
                if(!empty($getid)){
                    if(!empty($data['followed'])){
                        $getfollowed = $model2->isExistById($data["followed"]);
                        if(!empty($getfollowed)){
                            $data['follower'] = $getid['id'];
                            $data['created_date']=date('Y-m-d g:i:s');
    //                        $model->scenario = User::SCENARIO_CREATE;
                            $model->attributes = $data;
//                            print_r($data);
//                            print_r($model->attributes); exit;
                            if ($model->save()) {
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                            } 
                            else {
                                $response['error']=true;
                                $response['statuscode']=202;
                                $response['msg']=$returnmessage[$response["statuscode"]];
                            }  
                            
                            $updatearray=array(
                            'session_key' => "",           
                            'updated_date' => date('Y-m-d g:i:s'),
                            );
                            $upd=User::updateAll($updatearray, 'id = '.$getid["id"]); 
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
                                $response['msg']="Error in updation";
                            }
                        }
                        else {
                            $response['error']=true;
                            $response['msg']="User not available";
                        }
                    }                    
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']="Session key Not Matched";
                }
            }
            else{
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']="Please pass all parameters";
            }                
        }
        else{
            $response['error']=true;
            $response['statuscode']=512;
            $response['msg']="Your Request is invalid.";
        }
        echo json_encode($response);      
    }
    
    
    //BKP
//    public function actionAlluser() {
//        $response=array();
//        $model = new User();
//        $model2 = new UserSearch();
//        $count=20;
//        if(Yii::$app->getRequest()->method==="POST")
//        {
//            $data=Yii::$app->request->post();
//            if(!empty($data["token"]) && !empty($data["data"]))
//            {
//                $getid=$model2->isExistBytoken($data["token"]);
//                if(!empty($getid))
//                {
//                    $language=$model2->displayname($getid["id"],"lang");
//                    if($language==1)
//                    {
//                        $language=1;                    //Chinese
//                        $returnmessage=$this->alertchinese();                    
//                    }
//                    else
//                    {
//                        $language=0;                    //English
//                        $returnmessage=$this->alertenglish();
//                    }
//                    $defaultimg=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg';
//                    if($data["data"]=="single")        //SINGLE PROFILE
//                    {
//                        $catdata=$model->find()->where(['id'=>$getid["id"],'status' => 1])->one(); 
//                        if(!empty($catdata))
//                        {                            
//                            $cat[]=array(
//                                    'user_id' => $catdata['id'],
//                                    'registerid'=>$catdata['regid'],
//                                    'email'=>$catdata['username'],
//                                    'nick_name'=>(!empty($catdata['nick_name']))?$catdata['nick_name']:$catdata['username'],
//                                    'facebook_id'=>$catdata['facebook_id'],
//                                    'image'=>(!empty($catdata['image']))?$catdata['image']:$defaultimg,
//                                    'mobile_no' => $catdata["mobile_no"],
//                                    'alternate_no' => (!empty($catdata["alternate_no"]))?$catdata["alternate_no"]:'',
//                                    'device_id' => $catdata["device_id"],
//                                    'otpverify'=>$catdata['otpverify'],         
//                                    'occupation' => $catdata["occupation"],   
//                                    'gender' => $catdata["gender"],
//                                    'age' => $catdata["age"],  
//                                    'register_by' => $catdata["register_by"],
//                                    'status' => $catdata["status"],
//                                    'lang' => $catdata["lang"],
//                                    'opening_balance' => round($catdata["opening_balance"],0),                 
//                                    'created_date' => $catdata["created_date"],
//                                    'last_update_date' => $catdata["last_update_date"],     
//                                );
//                            $response['error']=false;
//                            $response['statuscode']=200;
//                            $response['msg']="Success";
//                            $response['users']=$cat;
//                        }
//                        else
//                        {
//                            $response['error']=true;
//                            $response['statuscode']=409;
//                            $response['msg']=$returnmessage[$response['statuscode']];
//                        } 
//                    }
//                    elseif($data["data"]=="all")                            //ALL USER PROFILE
//                    {
//                        if(!empty($data["page"]))
//                        {      
//                            $page=$data["page"];                   
//                            if($page==0)
//                            {
//                                $offset=0;
//                            }
//                            else
//                            {
//                                $offset=$count*$page;
//                            }                  
//                            $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
//                                            ->orderBy(['nick_name'=>SORT_ASC])
//                                            ->limit($count)
//                                            ->offset($offset)
//                                            ->all(); 
//                        }
//                        else
//                        {
//                            $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
//                                            ->orderBy(['nick_name'=>SORT_ASC])
//                                            ->all(); 
//                        }                        
//                        if(!empty($catdata))
//                        {
//                            foreach ($catdata as $value) 
//                            {       
//                                $cat[]=array(                                    
//                                    'user_id' => $value['id'],
//                                    'registerid'=>$value['regid'],
//                                    'email'=>$value['username'],
//                                    'nick_name'=>(!empty($value['nick_name']))?$value['nick_name']:$value['username'],
//                                    'facebook_id'=>$value['facebook_id'],
//                                    'image'=>(!empty($value['image']))?$value['image']:$defaultimg,
//                                    'mobile_no' => $value["mobile_no"],
//                                    'alternate_no' => (!empty($value["alternate_no"]))?$value["alternate_no"]:'',
//                                    'device_id' => $value["device_id"],
//                                    'otpverify'=>$value['otpverify'],         
//                                    'occupation' => $value["occupation"],   
//                                    'gender' => $value["gender"],
//                                    'age' => $value["age"],  
//                                    'register_by' => $value["register_by"],
//                                    'status' => $value["status"],
//                                    'lang' => $catdata["lang"],
//                                    'opening_balance' => round($value["opening_balance"],2),
//                                    'created_date' => $value["created_date"],
//                                    'last_update_date' => $value["last_update_date"],                           
//                                );
//                            }
//                            $response['error']=false;
//                            $response['statuscode']=200;
//                            $response['msg']="Success";
//                            $response['users']=$cat;
//                        }
//                        else
//                        {
//                            $response['error']=true;
//                            $response['statuscode']=409;
//                            $response['msg']=$returnmessage[$response['statuscode']];
//                        } 
//                    }
//                    elseif($data["data"]=="search")                            //ALL USER PROFILE
//                    {
//                        if(isset($data["key"]))
//                        {
//                            if(isset($data["page"]))
//                            {      
//                                $page=$data["page"];                   
//                                if($page==0)
//                                {
//                                    $offset=0;
//                                }
//                                else
//                                {
//                                    $offset=$count*$page;
//                                }                 
//                                $catdata=$model->find()->where(['status' => 1,'otpverify'=>1])
//                                                ->andFilterWhere(['like', 'username', $data["key"]])
//                                                ->orFilterWhere(['like', 'nick_name', $data["key"]])
//                                                ->orderBy(['nick_name'=>SORT_ASC])
//                                                ->limit($count)
//                                                ->offset($offset)
//                                                ->all(); 
//                            }
//                            else
//                            {
//                                $catdata=$model->find()->where(['status'=>1,'otpverify'=>1])
//                                                ->andFilterWhere(['like', 'username', $data["key"]])
//                                                ->orFilterWhere(['like', 'nick_name', $data["key"]])
//                                                ->orderBy(['nick_name'=>SORT_ASC])
//                                                ->all(); 
//                            }                        
//                            if(!empty($catdata))
//                            {
//                                foreach ($catdata as $value) 
//                                {       
//                                    $cat[]=array(                                    
//                                        'user_id' => $value['id'],                                        
//                                        'email'=>$value['username'],
//                                        'nick_name'=>(!empty($value['nick_name']))?$value['nick_name']:$value['username'],
//                                        'image'=>(!empty($value['image']))?$value['image']:$defaultimg                           
//                                    );
//                                }
//                                $response['error']=false;
//                                $response['statuscode']=200;
//                                $response['msg']="Success";
//                                $response['users']=$cat;
//                            }
//                            else
//                            {
//                                $response['error']=true;
//                                $response['statuscode']=409;
//                                $response['msg']=$returnmessage[$response['statuscode']];
//                            } 
//                        }
//                        else
//                        {   
//                            $response['error']=true;
//                            $response['statuscode']=412;
//                            $response['msg']=$returnmessage[$response['statuscode']];
//                        }
//                    }
//                    else
//                    {
//                        $response['error']=true;
//                        $response['statuscode']=512;
//                        $response['msg']=$returnmessage[$response['statuscode']];
//                    }                     
//                }
//                else
//                {
//                    $response['error']=true;
//                    $response['statuscode']=410;
//                    $response['msg']="Token Not Matched";
//                } 
//            }
//            else
//            {
//                $response['error']=true;
//                $response['statuscode']=412;
//                $response['msg']="Pass All Parameter";
//            }                     
//        }
//        else
//        {
//            $response['error']=true;
//            $response['statuscode']=512;
//            $response['msg']="Invalid Request";
//        }
//        echo json_encode($response);    
//    }
    
    
    ##############################################################################################
    #                       USER FORGOT PASSWORD SECTION                                         #
    ##############################################################################################
    public function actionForgotpassword() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
//            $language=$data["lang"];
//            if($language==1)
//            {
//                $language=1;                    //Chinese
//                $returnmessage=$this->alertchinese();                    
//            }
//            else
//            {
//                $language=0;                    //English
//                $returnmessage=$this->alertenglish();
//            }
            $returnmessage=$this->alertenglish();
            if(!empty($data["number"]))
            {
                if($model2->isExistnumber($data["number"])==true)
                {
                    $email=$model->find()->where(['number'=>$data["number"],'status' => 1])->one(); 
                    //print_r($email);
                    if (!empty($email))
                    {
                        $otpcode="00000";
                        //$otpcode=substr(mt_rand(100000,999999),0,6);
                        //SEND MAIL
//                        $to=$data["email"];
//                        $subject="This is Forgot Password Mail";
//                        $from=Yii::$app->params['adminEmail'];
//                        $fromname=Yii::$app->params['adminName'];
//                        $username=(!empty($email["nick_name"]))?$email["nick_name"]:$email["username"];
//                        require_once('email/forgotpassword.php');        //Message Variable Come From This File
//                        $returnmail=Yii::$app->mycomponen`    qt->Simplmail($to,$subject,$message,$from,$fromname);
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
                        $response['msg']=$returnmessage[$response['statuscode']];
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=302;
                    $response['msg']=$returnmessage[$response['statuscode']];
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=411;
                $response['msg']=$returnmessage[$response['statuscode']];
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
    #                       USER CHANGE EMAIL SECTION                                            #
    ##############################################################################################
    public function actionChangeemail() {
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
                    $language=$model2->displayname($getid["id"],"lang");
                    if($language==1)
                    {
                        $language=1;                    //Chinese
                        $returnmessage=$this->alertchinese();                    
                    }
                    else
                    {
                        $language=0;                    //English
                        $returnmessage=$this->alertenglish();
                    }
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
                            $response['msg']=$returnmessage[$response["statuscode"]];
                        }
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=303;
                        $response['msg']=$returnmessage[$response["statuscode"]];
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
    #                       USER LANGUAGE CHANGE SECTION                                         #
    ##############################################################################################
    public function actionLanguage() {
        $response=array();
        $model = new User();
        $model2 = new UserSearch();
        if(Yii::$app->getRequest()->method==="POST")
        {
            $data=Yii::$app->request->post();
            $language=$data["lang"];
            if($language==1)
            {
                $language=1;                    //Chinese
                $returnmessage=$this->alertchinese();                    
            }
            else
            {
                $language=0;                    //English
                $returnmessage=$this->alertenglish();
            }
            if(!empty($data["token"]) && isset($data["lang"]))
            {
                $getid=$model2->isExistBytoken($data["token"]);
                if(!empty($getid))
                {
                    $updatearr=array(
                            'lang' => ($data["lang"]==1)?'1':'0',           
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
                        $response['msg']=$returnmessage[$response['statuscode']];
                    }
                }
                else
                {
                    $response['error']=true;
                    $response['statuscode']=410;
                    $response['msg']=$returnmessage[$response['statuscode']];
                }
            }
            else
            {
                $response['error']=true;
                $response['statuscode']=412;
                $response['msg']=$returnmessage[$response['statuscode']];
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
    public function actionChangepassword() {   
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
                    $language=$model2->displayname($getid["id"],"lang");
                    if($language==1)
                    {
                        $language=1;                    //Chinese
                        $returnmessage=$this->alertchinese();                    
                    }
                    else
                    {
                        $language=0;                    //English
                        $returnmessage=$this->alertenglish();
                    }
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
                                        $response['msg']=$returnmessage[$response['statuscode']];
                                    }  
                                }
                                else
                                {
                                    $response['error']=true;
                                    $response['statuscode']=406;
                                    $response['msg']=$returnmessage[$response['statuscode']];
                                }
                            }
                            else
                            {
                                $response['error']=true;
                                $response['statuscode']=403;
                                $response['msg']=$returnmessage[$response['statuscode']];
                            }
                        }
                        else
                        {
                            $response['error']=true;
                            $response['statuscode']=407;
                            $response['msg']=$returnmessage[$response['statuscode']];
                        }       
                    }
                    else
                    {
                        $response['error']=true;
                        $response['statuscode']=408;
                        $response['msg']=$returnmessage[$response['statuscode']];
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
   
}
