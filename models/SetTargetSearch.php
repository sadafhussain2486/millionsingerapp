<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SetTarget;

/**
 * SetTargetSearch represents the model behind the search form about `app\models\SetTarget`.
 */
class SetTargetSearch extends SetTarget
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id','type','group_id', 'family_member', 'children_no', 'house_type', 'investment_habit', 'working_member', 'status'], 'integer'],
            [['income', 'monthly_rent', 'suggest_target'], 'number'],
            [['created_date', 'modify_date'], 'safe'],
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
        $query = SetTarget::find();

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
            'user_id' => $this->user_id,
            //'type' => $this->type,
            //'group_id' => $this->group_id,
            'income' => $this->income,
            'family_member' => $this->family_member,
            'children_no' => $this->children_no,
            'house_type' => $this->house_type,
            'monthly_rent' => $this->monthly_rent,
            'investment_habit' => $this->investment_habit,
            'suggest_target' => $this->suggest_target,
            'working_member' => $this->working_member,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        return $dataProvider;
    }
}
