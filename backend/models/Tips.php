<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tips".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 * @property integer $status
 * @property string $remark
 */
class Tips extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'count'], 'required'],
            [['count', 'status'], 'integer'],
            [['remark'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '标签名称',
            'count' => '标签使用计数',
            'status' => '状态(1:启用,0:禁用)',
            'remark' => 'Remark',
        ];
    }


    /**
     * 设置标签。新标签，添加且计数+1，旧标签，计数-1
     * @param  $new_tips 新的标签字串，以|分隔标签。例：标签1|标签2|标签4
     * @param null $old_tips 旧的标签字串，以|分隔标签。例：标签1|标签2|标签4
     */
    public function set_tips($new_tips,$old_tips = null)
    {
        $new=null;
        $old=null;
        isset($new_tips) && $new = array_unique(explode("|",$new_tips));
        isset($old_tips) && $old = array_unique(explode("|",$old_tips));
//        var_dump($new);
//        var_dump($old);
//        exit;
        if(count($new)>0){
            foreach($new as $tip){
                    $id = Tips::find_tip($tip);
                if($id>0){
                    $T=Tips::findOne(['id'=>$id]);
                    $T->count ++;
                    $T->save();
                }
            }
        }
        if(count($old)>0){
            foreach($old as $tip){
                $id = Tips::find_tip($tip,false);//标签不存在时不添加
                if($id>0){//判断是否存在标签
                    $T=Tips::findOne(['id'=>$id]);
                    if($T->count>0){//计数大余0时才做减一操作
                        $T->count --;
                        $T->save();
                    }
                }
            }
        }
    }

    /**
     * @返回标签id，如果不存在根据参数$add判断：true添加并返回新id，false返回null。
     */
    public function find_tip($tip,$add = true)
    {
        //查询
        $id = Tips::find()->where(['name'=>$tip])->select('id')->asArray()->one();
        if ($id==null){ //没有找到
            if(!$add){ //没有，而且不添加，返回null
                return null;
            } else {//没有但是要添加,返回添加后的id
                $T = new Tips();
                $T->name = $tip;
                $T->count = 0;
                $T->status = 1;
                $T->save();
                return $T->id;
            }

        } else { //有找到，返回id
            return $id;
        }

    }
}
