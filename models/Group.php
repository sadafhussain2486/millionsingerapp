<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $group_name
 * @property string $group_icon
 * @property integer $group_type
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $group_icon;
	
    public static function tableName()
    {
        return 'group';
    }
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
    return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	/* public function getUsername() {
    //return $this->user->username;
	} */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_name', 'group_type', 'opening_balance', 'status', 'created_date', 'modify_date'], 'required'],
            [['group_icon'],'file'],
            [['user_id', 'group_type', 'status'], 'integer'],
            [['created_date', 'modify_date'], 'safe'],
            [['group_name', 'group_icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'group_name' => 'Group Name',
            'group_icon' => 'Group Icon',
            'group_type' => 'Group Type',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
			'userName' => Yii::t('app', 'User Name')
        ];
    }

    /*const SCENARIO_CREATE ='create';
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['user_id', 'group_name', 'group_icon', 'group_type', 'status', 'created_date', 'modify_date'];
        return $scenarios;
    }*/
        
    public function clean($string) 
    {
       $string = str_replace('', '-', $string); // Replaces all spaces with hyphens.
       return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
    }

}
