<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `backend\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'comment_father_id', 'comment_post_id', 'comment_status', 'comment_link_id'], 'integer'],
            [['comment_name', 'comment_email', 'comment_content', 'comment_ip'], 'safe'],
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
        $query = Comment::find();

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
            'comment_id' => $this->comment_id,
            'comment_father_id' => $this->comment_father_id,
            'comment_post_id' => $this->comment_post_id,
            'comment_status' => $this->comment_status,
            'comment_link_id' => $this->comment_link_id,
        ]);

        $query->andFilterWhere(['like', 'comment_name', $this->comment_name])
            ->andFilterWhere(['like', 'comment_email', $this->comment_email])
            ->andFilterWhere(['like', 'comment_content', $this->comment_content])
            ->andFilterWhere(['like', 'comment_ip', $this->comment_ip]);

        return $dataProvider;
    }
}
