<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_keyword
 * @property string $category_descript
 * @property integer $category_status
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['category_status'], 'integer'],
            [['category_name', 'category_keyword'], 'string', 'max' => 255],
            [['category_descript'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => '分类id',
            'category_name' => '分类名称',
            'category_keyword' => '分类seo关键字',
            'category_descript' => '分类seo描述',
            'category_status' => '分类状态，1：启用，0：禁用',
        ];
    }
    /**
     * 返回所有启用的文章分类，格式 id=》name
     */
    public static function get_post_category()
    {
      $category_temp = PostCategory::find('category_id','category_name')->where(['category_status'=>'1'])->asArray()->all();
      foreach ($category_temp as $key) {
        $category[$key['category_id']]=$key['category_name'];
      }
      return $category;
    }
}
