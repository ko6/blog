<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "exam_course".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $info
 * @property string $remark
 */
class ExamCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['info'], 'string', 'max' => 200],
            [['remark'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'info' => 'Info',
            'remark' => 'Remark',
        ];
    }

    public static function  checkCourseName($name, $info = "", $remark = "")
    {

        //$this::findOne(id)->where($this->name=$name)
        //        var_dump($name,$info);exit;
        $i = ExamCourse::find()->where(['=', 'name', $name])->select("id")->asArray()->one();
        if (NUll == $i) {
            $model = new ExamCourse();
            $model->name = $name;
            $model->info = $info;
            $model->remark = $remark;

            if (!$model->save()) {
                var_dump($model->errors);
                exit();
            };
            return $model->id;
        } else {
            return $i['id'];
        }

        //ScoreTime::find()->where(['in','status',[self::active_status_1,self::active_status_2]])->asArray()->one();

    }
}
