<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $comment_id
 * @property integer $comment_father_id
 * @property integer $comment_post_id
 * @property integer $comment_status
 * @property string $comment_name
 * @property integer $comment_link_id
 * @property string $comment_email
 * @property string $comment_content
 * @property string $comment_ip
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_father_id', 'comment_post_id', 'comment_status', 'comment_link_id'], 'integer'],
            [['comment_post_id', 'comment_status', 'comment_name', 'comment_email', 'comment_content'], 'required'],
            [['comment_content'], 'string'],
            [['comment_name', 'comment_ip'], 'string', 'max' => 50],
            [['comment_email'], 'string', 'max' => 99],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => '评论id',
            'comment_father_id' => '评论爸爸id',
            'comment_post_id' => '被评论的文章id',
            'comment_status' => '状态(1:显示,0:隐藏)',
            'comment_name' => '评论者姓名',
            'comment_link_id' => '评论者网站链接id',
            'comment_email' => 'email',
            'comment_content' => '评论正文',
            'comment_ip' => '评论者ip',
        ];
    }


}
