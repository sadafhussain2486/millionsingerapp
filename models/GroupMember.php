<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_member".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class GroupMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_member';
    }
	
	public function getGroup()
	{
    return $this->hasOne(Group::className(), ['id' => 'group_id']);
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sent_by', 'user_id', 'group_id','invite_status','exit_by', 'status', 'created_date', 'modify_date'], 'required'],
            [['sent_by','user_id', 'group_id','invite_status','exit_by', 'status'], 'integer'],
            [['created_date', 'modify_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sent_id' => 'Sent By',
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
			'groupName' => Yii::t('app', 'Group Name')
        ];
    }
    
}
