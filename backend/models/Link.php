<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property integer $link_id
 * @property string $link_url
 * @property integer $created_at
 * @property integer $link_status
 * @property integer $link_hits
 * @property string $link_remark
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_url', 'link_status'], 'required'],
            [['link_url', 'link_remark'], 'string'],
            [['created_at', 'link_status', 'link_hits'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_id' => 'Link ID',
            'link_url' => 'Link Url',
            'created_at' => 'Created At',
            'link_status' => '状态(1:启用,0:禁用)',
            'link_hits' => '链接访问量',
            'link_remark' => 'Link Remark',
        ];
    }

    /**
     * 添加链接地址。返回链接id。如果已存在链接，直接返回id
     * @param $link
     * @return string
     */
    public static function add_link($link){
        return '0';
    }

    /**
     * 通过链接id查询链接信息。返回链接地址及链接状态。如果链接不存在，返回本站地址，状态404
     * @param $id
     * @return array
     */
    public static function get_link($id){
        $link = ["url","status"];
        return $link;
    }
}
