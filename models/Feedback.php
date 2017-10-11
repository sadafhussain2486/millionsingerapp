<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $subject
 * @property string $comment
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'comment', 'status', 'created_date', 'modify_date'], 'required'],
            [['user_id', 'sortorder', 'status'], 'integer'],
            [['comment'], 'string'],
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
            'comment' => 'Comment',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
