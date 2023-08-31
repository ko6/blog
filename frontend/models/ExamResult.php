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
    public static function  checkResult3($cookie, $result)
    {

        $c = count($result);
        $j = 0;
        for ($i = 0; $i < $c; $i++) {
            $j += ExamResult::updateAll(['result' => $result[$i]], ['cookie' => $cookie, 'state' => 1, 'result' => 0, 'index' => $i + 1]);
        }
        return $j;
    }

    public static function  checkResult2($cookie, $score)
    {
        //更新考试成绩

        return ExamResult::updateAll(['score' => $score], ['cookie' => $cookie, 'state' => 1, 'score' => 0]);
    }

    /**
     * @description: 将拿到的答案，添加为参考答案。
     * @return {*}
     * @author: koko
     */
    public static function  addReferenceAnswer($course_id, $question_id, $checked_value, $value, $optionResult)
    {
        //参考答案的cookie记录为checked_value
        //先判断是否已存在
        $result_id = ExamResult::find()
            ->select("id")
            ->where(["checked_value" => $checked_value, "cookie" => $checked_value])
            ->asArray()
            ->one();

        //如果已存在就略过。不存在就新增。
        if ($result_id == null) {
            $result = new ExamResult();
            $result->course_id = $course_id;
            $result->question_id = $question_id;
            $result->checked_value = $checked_value;
            $result->value  = $value;
            $result->cookie = $checked_value;
            if ($optionResult == 1 || $optionResult == 2) { //200230831 疑似多选题目的错误答案标识为2，先添加
                $result->result = -1; //错误选项
            } else {
                $result->result = 1; //正确选项
            }
            $result->save();
        }
        return;
    }

    public static function  checkResult_zxy2($answer)
    {
        //保存前端的答卷信息
        //{"saveTime":1692691961481,"answers":[{"key":"a3490b77-4fc0-4c35-825d-db8f6fe179c6","value":[{"id":"96ad966c-e183-4397-8049-981b05364682","value":"0"}]},{"key":"0f1eff4e-8148-4e58-a5e5-9cf7de9aa694","value":[{"id":"a68aedf0-9822-48e8-a84e-6d497570e6f7","value":"1"}]}],"examid":"d19cb6d2-845b-464e-9d2f-c49158ece9d0","examRecordId":"112b362a-4e2d-48f4-9d29-8765fcbe5a19","type":2}


        //先判断是否有


        //先通过examid找到课程id
        $course_id = ExamCourse::find()
            ->select("id")
            ->where(["remark" => $answer["examid"]])
            ->asArray()
            ->one();


        // var_dump($course_id);
        if (count($course_id) == 1) {
            $course_id = $course_id["id"];
        } else {
            return '{"state":0,"err":"未找到' . $answer["examid"] . '对应的课程"}';
        }

        $examRecordId = $answer["examRecordId"];

        //轮询拼装更新答卷记录的sql
        // ( course_id, question_id, checked_value, value,  cookie )
        // VALUES(21, 171, '值1|值2', 'id1|id3',  '6c4a3705-9062-423d-b7fd-39edef3519fa'),
        $sql = null; //拼装后的sql语句
        foreach ($answer["answers"] as $q) {
            //查询出题目id
            // var_dump("qqqq",$q["key"]);
            $qId = ExamQuestion::findIdByQid($q["key"]);
            if ($qId == null) {
                return '{"state":0,"err":"未找到' . $q["key"] . '对应的题目"}';
            }
            // var_dump("qqqq", $q["key"], $qId);

            $checked_id = null; //zxy中的选择项id，对应库表中的checked_value
            $checked_value = null; //zxy中的选择项value，对应库表中的value
            foreach ($q["value"] as $a) {
                //查询出答案id--- 不需要查询答案id
                //多选题，使用|拼接多个答案

                // $oId =ExamOption::findIdByQuestionAttrCopyId($a["id"]);
                if ($checked_id == null) {
                    $checked_id = $a["id"];
                    $checked_value = $a["value"];
                } else {
                    $checked_id = $checked_id . "|" . $a["id"];
                    $checked_value = $checked_value . "|" . $a["value"];
                }
            }

            //拼装sql,一次性更新。
            if ($sql == null) {
                $sql = "( $course_id, $qId,  '$checked_id', '$checked_value',  '$examRecordId' )";
            } else {
                $sql = "$sql,( $course_id, $qId,  '$checked_id', '$checked_value',  '$examRecordId' )";
            }
        }

        // var_dump($sql);

        //         INSERT INTO exam_result
        // ( course_id, question_id, checked_value, value,  cookie )
        // VALUES(21, 171, '值1|值2', 'id1|id3',  '6c4a3705-9062-423d-b7fd-39edef3519fa'),
        // (21, 171, '值1|值2', 'id1|id2',  '6c4a3705-9062-423d-b7fd-39edef3519fc')
        // on DUPLICATE KEY UPDATE value= VALUES(value);

        $sql = " INSERT INTO exam_result ( course_id, question_id, checked_value, value,  cookie )
VALUES $sql on DUPLICATE KEY UPDATE checked_value= VALUES(checked_value),value= VALUES(value);";
        // var_dump($sql);

        $result = Yii::$app->db->createCommand($sql)->queryAll();

        //预期结果是空
        // var_dump($result);

        return;
    }

    public static  function  checkResult1($course_id, $question_id, $checked_value, $value, $cookie, $index)
    {

        //$this::findOne(id)->where($this->name=$name)

        $i = ExamResult::find()->where(["course_id" => $course_id, "question_id" => $question_id, "cookie" => $cookie, "state" => 1])->one();
        //        var_dump($i->value);
        //        exit;
        //        if($i->)
        if (NUll == $i) {
            $model = new ExamResult();
            $model->course_id = $course_id;
            $model->question_id = $question_id;
            $model->checked_value = $checked_value;
            $model->value = $value;
            $model->cookie = $cookie;
            $model->index = $index;
            //            var_dump( $model -> save());
            if ($model->save()) {
                return '{"state":200,"msg":"add success"}';
            } else {
                var_dump($model->errors);
                exit;
                return '{"state":500,"msg":"' . implode("|", $model->errors) . '"}';
            };
        } else {
            if ($i->value == $value) {
                return '{"state":200,"msg":"ok"}';
            } else {
                $model = ExamResult::findOne($i->id);
                $model->state = -1;
                $model->update();

                $model = new ExamResult();
                $model->course_id = $course_id;
                $model->question_id = $question_id;
                $model->checked_value = $checked_value;
                $model->value = $value;
                $model->cookie = $cookie;
                $model->index = $index;
                if ($model->save()) {
                    return '{"state":200,"msg":"ok"}';
                } else {
                    return '{"state":500,"msg":"更新失败"}';
                };
            }
            //                return "nononono";
        }
        //        return $i;
        //ScoreTime::find()->where(['in','status',[self::active_status_1,self::active_status_2]])->asArray()->one();

    }
    public static function getResultByQuestionIid($question_id)
    {
        //        SELECT question_id,checked_value,value,count(*),count(case when result="1" then 1 else null end) s,count(case when result="-1" then 1 else null end) n FROM `exam_result` x
        //where x.course_id = 3
        //        and x.state = 1
        //group by question_id,value
        $r = ExamResult::find()->where('question_id = ' . $question_id . ' and state = 1')->select('checked_value,count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')->groupBy('checked_value')->asArray()->all();
        return $r;
    }
}
