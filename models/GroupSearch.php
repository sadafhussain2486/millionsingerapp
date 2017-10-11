<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Group;

/**
 * GroupSearch represents the model behind the search form about `app\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
   public $username; 
	 
    public function rules()
    {
        return [
            [['id', 'user_id',  'group_type', 'category_id','status'], 'integer'],
            [['group_name','user.username', 'group_icon', 'created_date', 'modify_date'], 'safe'],
			[['username'], 'safe'],
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
        $query = Group::find()->orderBy(['id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
        ]);	
		
		$query->joinWith(['user']);
    		 $dataProvider->setSort([
            'attributes' => [
                'user_id' =>[
    			  'asc' => ['user.username'=>SORT_ASC],
    			  'desc' => ['user.username'=>SORT_DESC],
    			]
            ] 
        ]);
		if (!($this->load($params) && $this->validate())) {
            
            return $dataProvider;
        }
		
       /*  $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        } */

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'group_type' => $this->group_type,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'group_icon', $this->group_icon])
			->andFilterWhere(['like', 'user.username', $this->user_id]);
        return $dataProvider;
    }
    public function groupname($id,$coloumn="group_name")
    {
        if(!empty($id))
        {
            $data=GroupSearch::find('all')
                   ->where(['id'=>$id])
                   ->one();
            return $data[$coloumn];
        }
        else
        {
            return false;
        }
    }
    public function groupcount($id)
    {
        if(!empty($id))
        {
            $data=GroupSearch::find()->where(['user_id'=>$id])->count();
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function displayGroupForSelect($id)
    {
        $showuser=array();
        $userd=$this->find()->where(['status'=>1,'type'=>$type])->all();
        if(!empty($userd))
        {
            foreach($userd as $value) 
            {
                $showuser[]=array("id"=>$value["id"],"category_name"=>$value["category_name"]);
            } 
        }
        return $showuser;
    }
}
