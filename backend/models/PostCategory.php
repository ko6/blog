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
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'category_keyword' => 'Category Keyword',
            'category_descript' => 'Category Descript',
            'category_status' => 'Category Status',
        ];
    }
}
