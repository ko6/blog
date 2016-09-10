<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PostCategory;

/**
 * PostCategorySearch represents the model behind the search form about `backend\models\PostCategory`.
 */
class PostCategorySearch extends PostCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_status'], 'integer'],
            [['category_name', 'category_keyword', 'category_descript'], 'safe'],
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
        $query = PostCategory::find();

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
            'category_id' => $this->category_id,
            'category_status' => $this->category_status,
        ]);

        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'category_keyword', $this->category_keyword])
            ->andFilterWhere(['like', 'category_descript', $this->category_descript]);

        return $dataProvider;
    }
}
