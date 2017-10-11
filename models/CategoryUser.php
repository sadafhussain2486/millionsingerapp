<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense_category".
 *
 * @property integer $id
 * @property integer $parent_category_id
 * @property string $category_name
 * @property string $category_slug
 * @property string $category_icon
 * @property integer $category_type
 * @property string $applied_for
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class CategoryUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','group_id','category_id', 'amount', 'repeat_type', 'status', 'created_date', 'modify_date'], 'required'],
            [['repeat_type','category_id','group_id', 'user_id', 'status'], 'integer'],
            //[['created_date', 'modify_date'], 'safe'],
            //[['category_name', 'category_slug', 'category_icon', 'applied_for'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'group_id' => 'Group',
            'category_id' => 'Category',
            'amount' => 'Amount',
            'repeat_type' => 'Repeat Type',
            'status' => 'Status',
            //'created_date' => 'Created Date',
            //'modify_date' => 'Modify Date',
        ];
    }
}
