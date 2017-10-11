<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "amount".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $payment_detail
 * @property string $amount
 * @property string $note
 * @property string $bill_image
 * @property integer $repeat
 * @property string $created_date
 * @property string $modify_date
 */
class Amount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'amount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'selectdate', 'category_id', 'payment_detail', 'amount', 'account','status', 'created_date', 'modify_date'], 'required'],
            [['type','user_id', 'category_id', 'repeat','recordbudget'], 'integer'],
            [['amount'], 'number'],
            [['created_date', 'modify_date'], 'safe'],
            [['payment_detail', 'note', 'bill_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'category_id' => 'Expense Category ID',
            'payment_detail' => 'Payment Detail',
            'amount' => 'Amount',
            'note' => 'Note',
            'bill_image' => 'Bill Image',
            'repeat' => 'Repeat',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
