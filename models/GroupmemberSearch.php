<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupMember;

/**
 * GroupmemberSearch represents the model behind the search form about `app\models\GroupMember`.
 */
class GroupmemberSearch extends GroupMember
{
    /**
     * @inheritdoc
     */
	public $groupname;  
	public $username;  
	
    public function rules()
    {
        return [
            [['id', 'sent_by', 'user_id', 'group_id','invite_status','exit_by', 'status'], 'integer'],
            [['created_date', 'modify_date'], 'safe'],
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
        $query = GroupMember::find()->orderBy(['id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
        ]);
		//$query->joinWith(['user']);
		/* 
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
        } */

        // grid filtering conditions
		
		$query->joinWith(['group']);
		 $dataProvider->setSort([
        'attributes' => [
            'group_id' =>[
			  'asc' => ['group.group_name'=>SORT_ASC],
			  'desc' => ['group.group_name'=>SORT_DESC],
					]
				] 
			]);
				
		
		
        $query->andFilterWhere([
            'id' => $this->id,
			'user_id' => $this->user_id,
            'sent_by' => $this->sent_by,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'invite_status' => $this->invite_status,
            'exit_by' => $this->exit_by,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);
			 
			  //$query->andFilterWhere(['like', 'user.username', $this->user_id]);
			 $query->andFilterWhere(['like', 'group.group_name', $this->group_id]);
        return $dataProvider;
    }
    public function groupjoin($id)
    {
        if(!empty($id))
        {
            $data=GroupmemberSearch::find()->where(['user_id'=>$id])->count();
            return $data;
        }
        else
        {
            return false;
        }
    }
}
