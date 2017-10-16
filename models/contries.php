<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $registration_id
 * @property string $username
 * @property string $password
 * @property string $device_type
 * @property string $facebook_id
 * @property string $image
 * @property string $number
 * @property string $alternate_no
 * @property string $otp_code
 * @property string $device_id
 * @property string $nick_name
 * @property string $occupation
 * @property string $gender
 * @property integer $age
 * @property integer $status
 * @property integer $registration_type
 * @property string $opening_balance
 * @property string $created_date
 * @property string $last_update_date
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    /*public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;*/

    const SCENARIO_CREATE ='create';
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'password', 'otp_code','verify_no', 'device_id', 'registration_type', 'status', 'role','created_date', 'updated_date'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'registration_id',*/  'number'/*, 'lname', 'name', 'password', 'device_type', 'facebook_id', 'image'*, 'number'/*, 'alternate_no', 'otp_code', 'device_id', 'nick_name', 'occupation', 'gender', 'age',*/ /*'status',*/ /*'registration_type', 'opening_balance'*//*, 'created_date', 'last_update_date'*/], 'required'],
            [[ 'status', 'registration_type', 'device_type', 'lang'], 'integer'],
            //[['created_date', 'last_update_date'], 'safe'],
            [[/*'registration_id',*/ 'number'], 'string', 'max' => 100],
            [[ 'password', 'fb_id', 'image', 'device_id', 'session_key'], 'string', 'max' => 255],
            [['otp_code'], 'string', 'max' => 12],
            [['gender'], 'string', 'max' => 20],
//            [['opening_balance'], 'string', 'max' => 50],
            //[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regid' => 'Registration ID',
            'name' => 'Username',
            'password' => 'Password',
//            'device_type' => 'Device Type',
            'fb_id' => 'Facebook ID',
            'image' => 'Image',
            'number' => 'Mobile No',
//            'alternate_no' => 'Alternate No',
            'otp_code' => 'Otp Code',
            'device_id' => 'Device ID',
        'nick_name' => 'Nick Name',
            //'occupation' => 'Occupation',
            'gender' => 'Gender',
//            'age' => 'Age',
            'status' => 'Status',
            'role' => 'Role',
            'registration_type' => 'Register By',
            //'opening_balance' => 'Opening Balance',
            //'created_date' => 'Created Date',
            //'last_update_date' => 'Last Update Date',
        ];
    }
    public static function findIdentity($id) {
        $user = self::find()
                ->where([
                    "id" => $id
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findIdentityByAccessToken($token, $userType = null) {

        $user = self::find()
                ->where(["accessToken" => $token])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */

    public static function findByUsername($username,$password) {
        $user = self::find()
                ->where([
                    "name" => $username,
                    "password" => $password,
                    "role"=>1
                ])
                ->one();
        if (!count($user)) {
            return 0;
        }
        
        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        echo $this->authKey;
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === $password;
    }
    
}
