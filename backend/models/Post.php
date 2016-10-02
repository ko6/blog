<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
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
            [['created_at', 'post_title', 'post_category', 'post_url_name', 'post_content'], 'required'],
            [['post_author', 'updated_at', 'post_category', 'post_status', 'post_hits'], 'integer'],
            [['post_title', 'post_excerpt', 'post_url_name', 'post_content', 'post_pic'], 'string'],
        ];
    }

    /*
    * 自动以当前时间戳填充文章更新时间，updated_at为默认字段，不用再次指定。
    */
    public function behaviors()
    {
        return [
                   [
                       'class' => TimestampBehavior::className(),
                       'createdAtAttribute' => false,//不填充发布日期
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
/**
* 保存数据前处理发布日期字段,添加作者信息
*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // 添加作者信息
      if ($this->isNewRecord) {
          $this->post_author = Yii::$app->user->getId();
      }
            // 将发布日期转换为时间戳
            $this->created_at = strtotime($this->created_at);
            return true;
        } else {
            return false;
        }
    }
}
