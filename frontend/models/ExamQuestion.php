<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "exam_question".
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 * @property string $state
 */
class ExamQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'name','question_id'], 'required'],
            [['course_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 500],
            [['remark', 'state'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'remark' => 'Remark',
            'state' => 'State',
            'qid' => 'qid',
            'question_id' => 'question_id',
        ];
    }

    public static  function  checkQuestionName($name,$question_id,$qid="",$course_id,$type=""){

        //$this::findOne(id)->where($this->name=$name)

        $i = ExamQuestion::find()->where(["question_id"=>$question_id,"course_id"=>$course_id])->select("id")->asArray()->one();
        if(NUll==$i){
            $model = new ExamQuestion();
            $model->name = $name;
            $model->course_id = $course_id;
            $model->question_id = $question_id;
            $model->type = $type;
            $model->qid = $qid;

            if(!$model -> save()){
                var_dump($model->errors);
                exit;
            };
            return( $model->id);
        }else{
            return $i['id'];
        }
//        var_dump($i);
//
        //ScoreTime::find()->where(['in','status',[self::active_status_1,self::active_status_2]])->asArray()->one();

    }
}
