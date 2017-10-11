<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "set_target".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $income
 * @property integer $family_member
 * @property integer $children_no
 * @property integer $house_type
 * @property string $monthly_rent
 * @property integer $investment_habit
 * @property string $suggest_target
 * @property integer $working_member
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class SetTarget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'set_target';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','type','group_id', 'income', 'family_member', 'children_no', 'house_type', 'monthly_rent', 'investment_habit', 'suggest_target', 'working_member','confidence_meet_target', 'created_date', 'modify_date'], 'required'],
            [['user_id','type','group_id', 'family_member', 'children_no', 'house_type', 'investment_habit', 'working_member','confidence_meet_target', 'status'], 'integer'],
            [['income', 'monthly_rent', 'suggest_target'], 'number'],
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
            'user_id' => 'User ID',
            'income' => 'Income',
            'family_member' => 'Family Member',
            'children_no' => 'Children No',
            'house_type' => 'House Type',
            'monthly_rent' => 'Monthly Rent',
            'investment_habit' => 'Investment Habit',
            'suggest_target' => 'Suggest Target',
            'working_member' => 'Working Member',
            'confidence_meet_target'=> 'Meet Target',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
