<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $post_id
 * @property integer $post_author
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $post_title
 * @property integer $post_category
 * @property string $post_excerpt
 * @property integer $post_status
 * @property string $post_url_name
 * @property string $post_content
 * @property integer $post_hits
 * @property string $post_pic
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_author', 'post_title', 'post_category', 'post_url_name', 'post_content'], 'required'],
            [['post_author', 'created_at', 'updated_at', 'post_category', 'post_status', 'post_hits'], 'integer'],
            [['post_title', 'post_excerpt', 'post_url_name', 'post_content', 'post_pic'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'post_author' => 'Post Author',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'post_title' => 'Post Title',
            'post_category' => 'Post Category',
            'post_excerpt' => 'Post Excerpt',
            'post_status' => 'Post Status',
            'post_url_name' => 'Post Url Name',
            'post_content' => 'Post Content',
            'post_hits' => 'Post Hits',
            'post_pic' => 'Post Pic',
        ];
    }
}
