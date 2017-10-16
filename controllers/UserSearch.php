<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\GroupMember;
use app\models\Group;
use app\models\AmountSearch;
/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'registration_type', 'device_type', 'lang','verify_no'], 'integer'],
            [['password', 'register_id', 'fb_id', 'image', 'number', 'otp_code', 'device_id',   'gender',  'created_date', 'updated_date'], 'safe'],
        ]; //, 'device_type' 'age''opening_balance','nick_name','occupation',
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	public function getdata() {
              $connection = User::find()->where(['role'=> 2]);
              $dataProvider = new ActiveDataProvider([
            'query' => $connection,
            'pagination'=>false,
        ]);
              return dataProvider;
        } 
	 
    public function search($params)
    {
        //$query = User::find();
        $query = User::find()->where(['role'=> 2])->orderBy(['id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
        ]);

        //$this->load($params);

       // if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
           // return $dataProvider;
        //}

        // grid filtering conditions
       /* $query->andFilterWhere([
            /*'id' => $this->id,
            'age' => $this->age,
            'status' => $this->status,
            'register_by' => $this->register_by,
            'created_date' => $this->created_date,
            'last_update_date' => $this->last_update_date,
        ]);

//        $query->andFilterWhere(['like', 'username', $this->username])
         $query->andFilterWhere(['like', 'password', $this->password])
//            ->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'fb_id', $this->fb_id])
            ->andFilterWhere(['like', 'image', $this->image]);
//            ->andFilterWhere(['like', 'number', $this->number])
////            ->andFilterWhere(['like', 'alternate_no', $this->alternate_no])
//            ->andFilterWhere(['like', 'otp_code', $this->otp_code])
//            ->andFilterWhere(['like', 'device_id', $this->device_id])
//            ->andFilterWhere(['like', 'nick_name', $this->nick_name])
//            ->andFilterWhere(['like', 'occupation', $this->occupation])
//            ->andFilterWhere(['like', 'gender', $this->gender])
//            ->andFilterWhere(['like', 'opening_balance', $this->opening_balance]);
*/
        return $dataProvider;

        // /andFilterWhere(['like', 'registration_id', $this->registration_id])->
    }

    public function validateRegister($data=null)
    {
        $error=array('error'=>false);

        $reg='/^[A-Za-z0-9 _]+$/';
        $latlong='/^[0-9.+-]+$/';
        $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i"; 
        $regphone = "/^[1-9][0-9]*/";
        //print_r($data);

        if ($this->isExistnumber($data['number'])) {
            $error['error']=true;
            $error['statuscode']=301;
            $error['msg']="Mobile number already exists";
        }
//        else if (!preg_match($regex, $data['username']))
//        {
//            $error['error']=true;
//            $error['statuscode']=302;
//            $error['msg']="Please enter valid email.";
//        }
//        else if($this->isExistEmail($data['username']))
//        {
//            $error['error']=true;
//            $error['statuscode']=303;
//            $error['msg']="Email is already registered.";
//        }
//        else if($data['registration_type']==1)
//        {
//            if(!isset($data['password']) || strlen(trim($data['password'])) <= 0)
//            {
//                $error['error']=true;
//                $error['statuscode']=307;
//                $error['msg']="Please enter the password.";
//            }
//            else if (strlen($data['password'])<6 || strlen($data['password'])>16)
//            {
//                $error['error']=true;
//                $error['statuscode']=309;
//                $error['msg']="Password should be within 6-16 characters long.";
//            }
            //else if(preg_match('/[\'^£$%&*()}{@#~><>,|=_+¬-]/',$data['password']))
//            {
//                $error['error']=true;
//                $error['statuscode']=308;
//                $error['msg']="Your password must be between 6 & 16 characters";
//            }
//        }   
//        else if($data['registration_type']==2)
//        {
//            if(!isset($data['mobile_no']) || empty($data['mobile_no']))
//            {
//                $error['error']=true;
//                $error['msg'] = 'Mobile number is required.';
//                $error['statuscode'] = 310;
//            }
//            else if(!empty($data['mobile_no']))
//            { 
//                if(!preg_match($regphone, $data['mobile_no']))
//                {
//                    $error['error']=true; 
//                    $error['statuscode']=311;
//                    $error['msg']="Please enter valid mobile number.";
//                }
//                if(strlen($data['mobile_no'])!=8 && !empty($data['mobile_no']))
//                {  
//                    $error['error']=true;
//                    $error['statuscode']=312;
//                    $error['msg']="Mobile number should be of 8 digit long.";
//                }            
//            }           
//        }         
//        else if (!isset($data['device_id']) || empty($data['device_id'])) 
//        {
//            $error['error']=true;
//            $error['statuscode']=313;
//            $error['msg']="Please enter the device id.";
//        }
//        else if (!isset($data['device_type']) || empty($data['device_type'])) 
//        {
//            $error['error']=true;
//            $error['statuscode']=315;
//            $error['msg']="Please enter device type.";
//        }        
//        else if (!isset($data['register_id']) || empty($data['register_id'])) 
//        {
//            $error['error']=true;
//            $error['statuscode']=316;
//            $error['msg']="Please enter register id.";
//        }
        else
        {
            $error['error']=false;
        }
        return $error;
    }
    
    public function validateUpdate($data=null)
    {
        $error=array('error'=>false);

        $reg='/^[A-Za-z0-9 _]+$/';
        $latlong='/^[0-9.+-]+$/';
        $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i"; 
        $regphone = "/^[1-9][0-9]*/";

        if (!isset($data['nick_name']) || strlen(trim($data['nick_name'])) <= 0)
        {
            $error['error']=true;
            $error['statuscode']=304;
            $error['msg']="Please enter the nick-name.";
        }
        else if (strlen($data['nick_name'])<2 || strlen($data['nick_name'])>20)
        {
            $error['error']=true;
            $error['statuscode']=305;
            $error['msg']="Nick name should be within 2-20 characters.";
        }
        else if (!preg_match($reg,$data['nick_name']))
        {
            $error['error']=true;
            $error['statuscode']=306;
            $error['msg']="Please enter valid nick-name.";
        } 
        else if(!isset($data['horoscope']) || empty($data['horoscope']))
        {  
            $error['error']=true;
            $error['statuscode']=317;
            $error['msg']="Please enter your horoscope.";
        }       
//        else if(!isset($data['mobile_no']) || empty($data['mobile_no']))
//        {
//            $error['error']=true;
//            $error['msg'] = 'Mobile number is required.';
//            $error['statuscode'] = 310;
//        }
//        else if(!preg_match($regphone, $data['mobile_no']) && !empty($data['mobile_no']))
//        { 
//            $error['error']=true; 
//            $error['statuscode']=311;
//            $error['msg']="Please enter valid mobile number.";
//        }
//        else if(strlen($data['mobile_no'])!=8 && !empty($data['mobile_no']))
//        {  
//            $error['error']=true;
//            $error['statuscode']=312;
//            $error['msg']="Mobile number should be of 8 digit long.";
//        }
        else if(!isset($data['gender']) || empty($data['gender']))
        {  
            $error['error']=true;
            $error['statuscode']=314;
            $error['msg']="Please enter the gender.";
        }
        else if(!isset($data['age']) || empty($data['age']))
        {  
            $error['error']=true;
            $error['statuscode']=318;
            $error['msg']="Please enter your age.";
        }
//        else if(!isset($data['age']) || empty($data['age']))
//        {  
//            $error['error']=true;
//            $error['statuscode']=318;
//            $error['msg']="Please enter the age.";
//        }
        else if(!isset($data['location']) || empty($data['location'])){  
            $error['error']=true;
            $error['statuscode']=319;
            $error['msg']="Please enter your location.";
        }
        else if(!isset($data['intro']) || empty($data['intro'])){  
            $error['error']=true;
            $error['statuscode']=320;
            $error['msg']="Please enter your introduction.";
        }
        else if(!isset($data['dob']) || empty($data['dob'])){  
            $error['error']=true;
            $error['statuscode']=322;
            $error['msg']="Please enter your Date of birth.";
        }
        else
        {
            $error['error']=false;
        }

        return $error;
    }
    public function validateLogin($data=null)
    {
        $error=array('error'=>false);

        $reg='/^[A-Za-z0-9 _]+$/';
        $latlong='/^[0-9.+-]+$/';
        $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i"; 
        $regphone = "/^[1-9][0-9]*/";

//        if (!isset($data['username']) || strlen(trim($data['username'])) <= 0) {
//            $error['error']=true;
//            $error['statuscode']=301;
//            $error['msg']="Please enter the username.";
//        }
//        else if (!preg_match($regex, $data['username']))
//        {
//            $error['error']=true;
//            $error['statuscode']=302;
//            $error['msg']="Please enter valid email.";
//        }
        if(isset($data['registration_type']))
        {   
            if($data['registration_type']==1)
            {
                if(!isset($data['password']) || strlen(trim($data['password'])) <= 0)
                {
                    $error['error']=true;
                    $error['statuscode']=307;
                    $error['msg']="Please enter the password.";
                }
                else if(preg_match('/\s/',$data['password']))
                {
                    $error['error']=true;
                    $error['statuscode']=308;
                    $error['msg']="Please enter the valid password.";
                }
            }
            else
            {
                $error['error']=false;
            }
        } 
        else
        {
            $error['error']=false;
        }
        return $error;
    }
    public function isExistEmail($email,$role=null,$password=null)
    {
        if($role)
        {
            $condition = array(
                'staffid'=>$email,
                'role'=>$role
            );
        }
        else if($password)
        {
            $password = md5($password);
            $condition = array(
                'staffid'=>$email,
                'password'=>$password
            );
        }
        else
        {
            $condition = array(
                'email'=>$email
            );
        }
        $data=$this->find('all')
                   ->where($condition)
                   ->all();
        if(count($data)>0)
        {
            return true;
        }
        else
        {  
            return false;
        }

    }
    public function isExistnumber($number,$role=null,$password=null)
    {
//        if($role)
//        {
//            $condition = array(
//                'staffid'=>$email,
//                'role'=>$role
//            );
//        }
//        else if($password)
//        {
//            $password = md5($password);
//            $condition = array(
//                'staffid'=>$email,
//                'password'=>$password
//            );
//        }
//        else
//        echo 'testing';
//        print_r($number);
        if($number)
        {
            $condition = array(
                'number'=>$number
            );
        }
        
        $data=$this->find('all')
                   ->where($condition)
                   ->all();
        if(count($data)>0)
        {
            return true;
        }
        else
        {  
            return false;
        }

    }
    public function isExistBytoken($session_key)   //SESSIONKEY
    {
        if(!empty($session_key))
        {
            $data = $this->find()->where(['session_key' => $session_key])->one();
            //print_r($data);
            if(!empty($data))
            { 
                if(!empty($data->id))
                {                   
                    $arr=array('id'=>$data->id);
                    return $arr; 
                }
            }
            else
            {
                return false;       
            }
        }
        else
        {
            return false;       
        }
        
    }
    public function isExistBytokenandId($token,$user_id)
    {
        if(!empty($token))
        {
            $data = $this->find()
            ->where(['token' => $token,'id'=>$user_id])
            ->count();
            if($data == 1)
            { 
                return true;
            }
            else
            {
                return false;       
            }
        }
        else
        {
            return false;       
        }
    }
    
    public function isExistById($user_id) {
        if(!empty($user_id))
        {
            $data = $this->find()
            ->where(['id'=>$user_id])
            ->count();
            if($data == 1)
            { 
                return true;
            }
            else
            {
                return false;       
            }
        }
        else
        {
            return false;       
        }
    }
    
    public function dataformat($date,$exp="-")
    {
        if(!empty($date))
        {
            $exped=explode($exp, $date);
            return $exped[2].$exp.$exped[1].$exp.$exped[0];
        }
        else
        {
            return false;
        }
    }
    public function displayname($id,$column="nick_name")
    {
        if(!empty($id))
        {
            $data=$this->find('all')
                   ->where(['id'=>$id])
                   ->one();
            return $data[$column];
        }
        else
        {
            return false;
        }
    }
    public function displayUserForSelect()
    {
        $showuser=array();
        $userd=$this->find()->where(['status'=>1,'role'=>2])->all();
        //print_r($userd);
        if(!empty($userd))
        {
            foreach($userd as $value) 
            {
                $showuser[]=array("id"=>$value["id"],"nick_name"=>(!empty($value["nick_name"]))?$value["nick_name"]:$value["name"]);
            } 
        }
        return $showuser;
    }
    public function displayGroupUserForSelect($id)
    {
        $model=new GroupMember();
        $model1=new Group();
        $showuser=array();
        $userd=$model->find()->where(['status'=>1,'group_id'=>$id,'invite_status'=>1])->all();
        $group=$model1->find()->where(['status'=>1,'id'=>$id])->one();
        //FOR GET ADMIN OF GROUP
        if(!empty($group))
        {
            $showuser[]=array("id"=>$group["user_id"],"nick_name"=>$this->displayname($group["user_id"])." (Admin)");
        }
        //FOR USERS OF GROUP
        if(!empty($userd))
        {
            foreach($userd as $value) 
            {
                $showuser[]=array("id"=>$value["user_id"],"nick_name"=>$this->displayname($value["user_id"]));
            } 
        }
        return $showuser;
    }
    public function generateRegId()
    {
        $model=new UserSearch();
        $userd=$model->find('maxId')->where(['role'=>2])->max('id');  
        $prefix="M0000000";
        $id=strlen($userd);
        $newregid= substr($prefix, 0,-$id);     
        return $newregid.$userd;
    }
    public function getDayInMonth()
    {
        $maxDays=date('t');
        $currentDayOfMonth=date('j');
        return ($maxDays-$currentDayOfMonth);
    }
    public function getExpenseMonthWise($type=2,$user=1,$month,$userid,$categoryid)
    {
        $model=new AmountSearch();
        if($user==1) //INDIVIDUAL
        {
            $cond=['type'=>$type,'user_id'=>$userid,'category_id'=>$categoryid,'account'=>0,'DATE_FORMAT(selectdate,"%Y-%m")'=>$month,'status'=>1,'recordbudget'=>1];            
        }
        else
        {
            $cond=['type'=>$type,'account'=>$userid,'category_id'=>$categoryid,'DATE_FORMAT(selectdate,"%Y-%m")'=>$month,'status'=>1,'recordbudget'=>1];
        }
        $userd=$model->find()->where($cond)->all(); 
        $sum=0;
        foreach ($userd as $expvalue) 
        {
            $sum+=$expvalue['amount'];
        }
        return $sum;
        /*$maxDays=date('t');
        $currentDayOfMonth=date('j');
        return ($maxDays-$currentDayOfMonth);*/
    }

}
