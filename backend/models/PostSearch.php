<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Post;

/**
 * PostSearch represents the model behind the search form about `backend\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'post_author', 'created_at', 'updated_at', 'post_category', 'post_status', 'post_hits'], 'integer'],
            [['post_title', 'post_excerpt', 'post_url_name', 'post_content', 'post_pic'], 'safe'],
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
        $query = Post::find();

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
            'post_id' => $this->post_id,
            'post_author' => $this->post_author,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'post_category' => $this->post_category,
            'post_status' => $this->post_status,
            'post_hits' => $this->post_hits,
        ]);

        $query->andFilterWhere(['like', 'post_title', $this->post_title])
            ->andFilterWhere(['like', 'post_excerpt', $this->post_excerpt])
            ->andFilterWhere(['like', 'post_url_name', $this->post_url_name])
            ->andFilterWhere(['like', 'post_content', $this->post_content])
            ->andFilterWhere(['like', 'post_pic', $this->post_pic]);

        return $dataProvider;
    }
}
