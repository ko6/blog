<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SiteInfo;

/**
 * SiteInfoSearch represents the model behind the search form about `backend\models\SiteInfo`.
 */
class SiteInfoSearch extends SiteInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_info_id'], 'integer'],
            [['site_name', 'site_url', 'site_keyword', 'site_descript', 'site_subtitle', 'site_bottom', 'site_logo'], 'safe'],
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
        $query = SiteInfo::find();

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
            'site_info_id' => $this->site_info_id,
        ]);

        $query->andFilterWhere(['like', 'site_name', $this->site_name])
            ->andFilterWhere(['like', 'site_url', $this->site_url])
            ->andFilterWhere(['like', 'site_keyword', $this->site_keyword])
            ->andFilterWhere(['like', 'site_descript', $this->site_descript])
            ->andFilterWhere(['like', 'site_subtitle', $this->site_subtitle])
            ->andFilterWhere(['like', 'site_bottom', $this->site_bottom])
            ->andFilterWhere(['like', 'site_logo', $this->site_logo]);

        return $dataProvider;
    }
}
