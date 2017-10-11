<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notice_comment".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $notice_id
 * @property string $comment
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class NoticeComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notice_id', 'comment', 'status', 'created_date', 'modify_date'], 'required'],
            [['user_id', 'notice_id', 'status'], 'integer'],
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
            'notice_id' => 'Notice ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
