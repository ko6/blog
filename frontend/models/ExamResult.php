<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "exam_result".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $question_id
 * @property string $checked_value
 * @property string $value
 * @property integer $result
 * @property string $remark
 * @property string $cookie
 * @property integer $score 得分
 */
class ExamResult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'question_id', 'checked_value', 'cookie'], 'required'],
            [['course_id', 'question_id', 'result'], 'integer'],
            [['checked_value', 'remark'], 'string', 'max' => 3000],
            [['value', 'cookie'], 'string', 'max' => 1000]
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
            'question_id' => 'Question ID',
            'checked_value' => 'Checked Value',
            'value' => 'Value',
            'result' => 'Result',
            'remark' => 'Remark',
            'cookie' => 'Cookie',
            'index' => 'index',
            'state' => 'state',
            'score' => 'score',
        ];
    }
    public static function  checkResult3($cookie,$result){

        $c=count($result);
        $j=0;
        for($i=0;$i<$c;$i++){
           $j+= ExamResult::updateAll(['result'=>$result[$i]],['cookie'=>$cookie,'state'=>1,'result'=>0,'index'=>$i+1]);
        }
        return $j;
    }

    public static function  checkResult2($cookie,$score){

        return ExamResult::updateAll(['score'=>$score],['cookie'=>$cookie,'state'=>1,'score'=>0]);
    }

        public static  function  checkResult1($course_id,$question_id,$checked_value,$value,$cookie,$index){
// todo 记录选择答案时，先将之前选择的内容禁用，再新增新的记录。只取一条记录来比较，会在高并发场景下出现异常。  20220904
// 比如多选题，快速选择多个答案，因为处理速度慢，数据库里可能存在多个有效答案。前端改为定时请求后，能有效减少此问题。
        //$this::findOne(id)->where($this->name=$name)

        $i = ExamResult::find()->where(["course_id"=>$course_id,"question_id"=>$question_id,"cookie"=>$cookie,"state"=>1])->one();
//        var_dump($i->value);
//        exit;
//        if($i->)
        if(NUll==$i){
            $model = new ExamResult();
            $model->course_id = $course_id;
            $model->question_id = $question_id;
            $model->checked_value = $checked_value;
            $model->value = $value;
            $model->cookie = $cookie;
            $model->index = $index;
//            var_dump( $model -> save());
           if( $model -> save()){
               return '{"state":200,"msg":"ok"}';
           }else{
               var_dump($model->errors);
               exit;
               return '{"state":500,"msg":"'.implode("|",$model ->errors).'"}';
           };

            } else {
                if($i->value == $value){
                    return '{"state":200,"msg":"ok"}';
                }else{
                    $model = ExamResult::findOne($i->id);
                    $model->state = -1;
                    $model ->update();

                    $model = new ExamResult();
                    $model->course_id = $course_id;
                    $model->question_id = $question_id;
                    $model->checked_value = $checked_value;
                    $model->value = $value;
                    $model->cookie = $cookie;
                    $model->index = $index;
                    if($model -> save()){
                        return '{"state":200,"msg":"ok"}';
                    }else{
                        return '{"state":500,"msg":"更新失败"}';
                    };
                }
//                return "nononono";
        }
//        return $i;
        //ScoreTime::find()->where(['in','status',[self::active_status_1,self::active_status_2]])->asArray()->one();

    }
    public  function getResult($course_id){
//        SELECT question_id,checked_value,value,count(*),count(case when result="1" then 1 else null end) s,count(case when result="-1" then 1 else null end) n FROM `exam_result` x
//where x.course_id = 3
//        and x.state = 1
//group by question_id,value
       $r= ExamResult::find()->where('course_id = '.$course_id .' and state = 1')->select('question_id,checked_value,value,count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')->groupBy('question_id,value')->asArray()->one();
        return $r;
    }
}
