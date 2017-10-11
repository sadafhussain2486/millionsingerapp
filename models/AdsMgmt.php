<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads_mgmt".
 *
 * @property integer $id
 * @property string $ads_image
 * @property string $ads_url
 * @property string $ads_startdate
 * @property string $ads_enddate
 * @property integer $status
 * @property string $created_date
 * @property string $modify_date
 */
class AdsMgmt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_mgmt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category','ads_title','ads_url', 'ads_startdate', 'ads_enddate', 'ads_impressionlimit', 'status', 'created_date', 'modify_date'], 'required'],
            [['ads_startdate', 'ads_enddate', 'created_date', 'modify_date'], 'safe'],
            [['status'], 'integer'],
            [['ads_title', 'ads_image', 'ads_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ads_title' => 'Ads Title',
            'ads_image' => 'Ads Image',
            'ads_url' => 'Ads Url',
            'ads_startdate' => 'Ads Startdate',
            'ads_enddate' => 'Ads Enddate',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }
}
