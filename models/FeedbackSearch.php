<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Feedback;

/**
 * FeedbackSearch represents the model behind the search form about `app\models\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    /**
     * @inheritdoc
     */
    public $username; 
    public function rules()
    {
        return [
            [['id', 'user_id', 'sortorder', 'status'], 'integer'],
            [['comment','user.username', 'created_date', 'modify_date'], 'safe'],
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
        $query = Feedback::find()->orderBy(['id'=>SORT_ASC]);

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
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
             ->andFilterWhere(['like', 'user.username', $this->user_id]);;
        //print_r($dataProvider);
        return $dataProvider;
    }
}
