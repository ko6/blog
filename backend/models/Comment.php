<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property string $created_at
 * @property string $comment_time
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
            [['comment_email','comment_link'], 'string', 'max' => 99],
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
            'comment_status' => '状态(1:显示,0:待审,2:隐藏)',
            'comment_name' => '您的名字',
            'comment_link_id' => '评论者网站链接id',
            'comment_link' => '您的站点链接',
            'comment_email' => 'email',
            'comment_content' => '评论内容',
            'comment_ip' => '评论者cookies',
            'created_at' => 'Created At',
        ];
    }


    public function getComment_link()
    {
        //todo 返回链接id所对应的地址，如果有
        return  $this->comment_link_id;
    }

    /**
    * 自动以当前时间戳填充添加时间，created_at，不用再次指定。
    */
     public function behaviors()
     {
         return [
                    [
                        'class' => TimestampBehavior::className(),
                        'updatedAtAttribute' => false,//不填充更新日期
                    ],
          ];
     }

    /**
     * 返回格式化后的评论发布时间
     * @return bool|string
     */
    public function getComment_time()
    {
//        return  $this->created_at;
        return  $this->date('Y/m/d H:m',$this->created_at);
    }

//    public function setComment_time($value)
//    {
//        $this->comment_time = $value;
//    }

    /**
     * 格式化时间
     * @param $format
     * @param $time
     * @return bool|string
     */
    public static function date($format, $time)
    {
        $limit = time() - $time;

        if($limit < 10)
            return '刚刚';

        if($limit < 60)
            return $limit . '秒前';

        if($limit >= 60 && $limit < 3600)
            return floor($limit/60) . '分钟前';

        if($limit >= 3600 && $limit < 86400)
            return floor($limit/3600) . '小时前';

        if($limit >= 86400 and $limit<259200)
            return floor($limit/86400) . '天前';

        if($limit >= 259200)
            return date($format,$time);
    }

}
