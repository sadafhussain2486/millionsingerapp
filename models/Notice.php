<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'description', 'status', 'created_date', 'modify_date'], 'required'],
            [['user_id', 'group_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_date', 'modify_date'], 'safe'],
            //[['title'], 'string', 'max' => 255],
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
            'group_id' => 'Group ID',
            'description' => 'Description',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
