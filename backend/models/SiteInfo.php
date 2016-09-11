<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_info".
 *
 * @property integer $site_info_id
 * @property string $site_name
 * @property string $site_url
 * @property string $site_keyword
 * @property string $site_descript
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
            [['site_name', 'site_url', 'site_keyword', 'site_descript', 'site_subtitle', 'site_logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_info_id' => 'Site Info ID',
            'site_name' => 'Site Name',
            'site_url' => 'Site Url',
            'site_keyword' => 'Site Keyword',
            'site_descript' => 'Site Descript',
            'site_subtitle' => 'Site Subtitle',
            'site_bottom' => 'Site Bottom',
            'site_logo' => 'Site Logo',
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
