<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pushnotification;
/**
 * PushnotificationSearch represents the model behind the search form about `app\models\Pushnotification`.
 */
class PushnotificationSearch extends Pushnotification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['description', 'created_date', 'modify_date'], 'safe'],
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
        $query = Pushnotification::find()->orderBy(['id'=>SORT_ASC]);

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
            'status' => $this->status,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
    public function androidnotify($title,$description,$url="",$registerid)
    {
        $API_ACCESS_KEY='AAAACjORWUM:APA91bHXDNT3cafzqqx2CwzJQEzaxx5fZtusSjXgIiJ5Pzx_WLBeVifRKdYyQGSFYBQz4sBnUeHdvacC5jJHk4C51-6OqymvKutNFpH3SAjAGlV_e_Z9qMlT1uU7phVhieQLHnC2-Bl-';
        ################----FIREBASE API-----###################            
        #Send Reponse To FireBase Server  
        $msg = array(
            'title' => $title,
            'body'  => $description,
            'icon'  => $url,
            'click_action' => 'group',
            'sound' => 'mySound'/*Default sound*/
        );
        $data = array(
             "user_id" => '2',
             "date" => date('d-m-Y'),
             "hal_id" => "131313",
             "M_view" => "Text view313"
        );
        $fields = array(
            'to'        => $registerid,
            'notification'  => $msg,
            'data' => $data
        );                       
    
        $headers = array(
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
            );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        //echo $result;
        ##########----END FIREBASE-----###################
    }
}
