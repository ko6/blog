<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Link;

/**
 * LinkSearch represents the model behind the search form about `backend\models\Link`.
 */
class LinkSearch extends Link
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_id', 'created_at', 'link_status', 'link_hits'], 'integer'],
            [['link_url', 'link_remark'], 'safe'],
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
        $query = Link::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'link_id' => $this->link_id,
            'created_at' => $this->created_at,
            'link_status' => $this->link_status,
            'link_hits' => $this->link_hits,
        ]);

        $query->andFilterWhere(['like', 'link_url', $this->link_url])
            ->andFilterWhere(['like', 'link_remark', $this->link_remark]);

        return $dataProvider;
    }
}
