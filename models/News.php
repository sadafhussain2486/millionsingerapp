<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property string $created_date
 * @property string $modified_date
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $file; 
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description','title_c', 'description_c'], 'required'],
			[['file','image_c'], 'file'],
            [['description_c'], 'string'],
            [['status','status_c'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['title','title_c', 'image','image_c'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
			'file' => 'Image',
            'image_c' => 'Image',
        ];
    }    
}
