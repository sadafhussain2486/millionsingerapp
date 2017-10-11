<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;
use app\models\CategoryUser;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_type', 'status'], 'integer'],
            [['category_name', 'category_icon', 'applied_for', 'status', 'created_date', 'modify_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Category::find()->orderBy(['id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_type' => $this->category_type,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'category_icon', $this->category_icon])
            ->andFilterWhere(['like', 'applied_for', $this->applied_for]);

        return $dataProvider;
    }
    public function categoryname($id,$column="category_name")
    {
        if(!empty($id))
        {
            $data=$this->find('all')
                   ->where(['id'=>$id])
                   ->one();
            return $data[$column];
        }
        else
        {
            return false;
        }
    }
    public function displayCategoryForSelect($type,$applied=1)
    {
        $showuser=array();
        $userd=$this->find()->where(['status'=>1,'type'=>$type,'applied_for'=>$applied])->all();
        if(!empty($userd))
        {
            foreach($userd as $value) 
            {
                $showuser[]=array("id"=>$value["id"],"category_name"=>$value["category_name"]);
            } 
        }
        return $showuser;
    }
    public function displaySelectedCategory($id,$groupid)
    {
        $showuser=array();
        $model=new CategoryUser();

        $currdate = date("Y-m",strtotime(date('Y-m-d')));

        $userd=$model->find()->where(['status'=>1,'user_id'=>$id,'group_id'=>$groupid,'DATE_FORMAT(created_date,"%Y-%m")'=>$currdate])->orderBy(['category_id'=>SORT_ASC])->all();
        if(!empty($userd))
        {
            foreach($userd as $value) 
            {
                $showuser[]=$value["category_id"];
            } 
        }
        return $showuser;
    }
}
