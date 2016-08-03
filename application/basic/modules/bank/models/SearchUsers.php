<?php

namespace app\modules\bank\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\bank\models\Users;

/**
 * SearchUsers represents the model behind the search form about `app\modules\bank\models\Users`.
 */
class SearchUsers extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
            [['balance'], 'number'],
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
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchWithLastComments($params)
    {
        $dataProvider = $this->search($params);
        
        $t1 = Users::tableName();
        $t2 = Comments::tableName();

        $dataProvider->query
            ->select("$t1.name, $t2.text")->joinWith('lastComment')->groupBy("$t2.user_id");

        return $dataProvider;
    }
}
