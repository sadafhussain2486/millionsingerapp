<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pushnotification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class Pushnotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pushnotification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','description', 'status', 'created_date', 'modify_date'], 'required'],
            [['status'], 'integer'],
            [['description'], 'string'],
            [['created_date', 'modify_date'], 'safe'],
            [['user_id','title','image'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
