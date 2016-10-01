<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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

    /*
    * 自动填充编辑时间
    */
    public function behaviors()
    {
         return [
             [
                 'class' => TimestampBehavior::className(),
                //  'createdAtAttribute' => 'created_at',
                 'updatedAtAttribute' => 'updated_at',
                 'value' => new Expression('NOW()'),
             ],
         ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => '文章id',
            'post_author' => '作者id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'post_title' => '标题',
            'post_category' => '分类',
            'post_excerpt' => '简介',
            'post_status' => 'Post Status',
            'post_url_name' => 'url名称，用作个性化文章网址',
            'post_content' => '正文',
            'post_hits' => '点击数',
            'post_pic' => '栏目页展示图片',
        ];
    }
}
