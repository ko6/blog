<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_info".
 *
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
            [['site_name'], 'required'],
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
            'site_name' => 'Site Name',
            'site_url' => 'Site Url',
            'site_keyword' => 'Site Keyword',
            'site_descript' => 'Site Descript',
            'site_subtitle' => 'Site Subtitle',
            'site_bottom' => 'Site Bottom',
            'site_logo' => 'Site Logo',
        ];
    }
}
