<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_info".
 *
 * @property integer $site_info_id
 * @property string $site_name
 * @property string $site_url
 * @property string $site_keywords
 * @property string $site_description
 * @property string $site_subtitle
 * @property string $site_bottom
 * @property string $site_logo
 */
class SiteInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_info_id'], 'required'],
            [['site_info_id'], 'integer'],
            [['site_bottom'], 'string'],
            [['site_name', 'site_url', 'site_keywords', 'site_description', 'site_subtitle', 'site_logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_info_id' => 'Site Info ID',
            'site_name' => '网站名称',
            'site_url' => '首页地址',
            'site_keywords' => '网站关键字',
            'site_description' => '网站描述',
            'site_subtitle' => '网站二级标题',
            'site_bottom' => '网站底部显示内容(支持html)',
            'site_logo' => '网站logo地址',
        ];
    }

    /**
    * @返回网站基本信息,默认基本信息存储在id为1的记录中
    */

    public static function get_site_info()
    {
      $info = SiteInfo::find()->where(['site_info_id'=>'1'])->asArray()->one();
// foreach($typeid as $type_id) {
//     $id[] = $type_id['id'];
// }
      if(isset($info)){
      return($info);
    } else {
      return null;
      }


    }
}
