<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
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
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'parent_category_id',*/ 'category_name', 'category_name_c', /*'category_type', 'applied_for', 'status'*//*, 'created_date', 'modify_date'*/], 'required'],
            [[/*'parent_category_id',*/ 'category_type','category_sort', 'status'], 'integer'],
            //[['created_date', 'modify_date'], 'safe'],
            [['category_name', 'category_name_c','category_color', 'category_icon', 'applied_for'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'parent_category_id' => 'Parent Category ID',
            'category_name' => 'Category Name',
            'category_icon' => 'Category Icon',
            //'category_type' => 'Category Type',
            'applied_for' => 'Applied For',
            'status' => 'Status',
            //'created_date' => 'Created Date',
            //'modify_date' => 'Modify Date',
        ];
    }
}
