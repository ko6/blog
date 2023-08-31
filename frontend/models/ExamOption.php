<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "exam_option".
 *
 * @property integer $id
 * @property string $question_id
 * @property string $course_id
 * @property string $content
 * @property integer $count
 * @property integer $correct
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 * @property string $value
 * @property string $questionAttrCopyId 知学云的题目选项id
 * @property string $questionCopyId 知学云的题目id
 */
class ExamOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'content', 'course_id'], 'required'],
            [['count', 'correct', 'question_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string', 'max' => 500],
            [['remark'], 'string', 'max' => 300],
            [['questionCopyId', 'questionAttrCopyId'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'content' => 'Content',
            'count' => 'Count',
            'correct' => 'Correct',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'remark' => 'Remark',
            'course_id' => 'course_id',
            'value' => 'value',
            'questionCopyId' => 'questionCopyId',
            'questionAttrCopyId' => 'questionAttrCopyId'
        ];
    }

    /**
     * @param $name
     * @param $question_id
     * @param null $course_id
     * @param null $question_type
     * @param null $question_name
     * @param bool|false $read_only 是否只查询（在展示题库时，不存在插入答案的场景，配置为true可以减少数据库读写。）
     * 
     * @param null $type 知学云的选项对错信息 -1：考卷，未指示对错   1：错误选项   0：正确选项 
     * @param null $questionAttrCopyId 知学云的选项id
     * @return array|null|\yii\db\ActiveRecord|\yii\db\ActiveRecord[]
     */
    public static  function  checkOptionName(
        $name,
        $question_id,
        $course_id = null,
        $question_type = null,
        $question_name = null,
        $read_only = false,
        $questionAttrCopyId = null,
        $questionCopyId = null,
        $value = null,
        $type = null
    ) {


        //检查选项是否存在，不存在就保存。存在就返回选择结果统计数据
        //20220728 尝试以题目名称为依据查询答案。不判断题目id.尝试适配同一题目出现在不同题库中的情况。不知道有没有，只是试一下。
        //20230830 当题目标注了答案时，生成一份答题记录到库里

        // $question_type 预期值：SingleChoice   MultiChoice    Judge
        //$this::findOne(id)->where($this->name=$name)
        // var_dump($name,$question_id,$course_id,$question_type);exit;
        if (!$read_only) {
            $i = ExamOption::find()->where(["content" => $name, "question_id" => $question_id])->select(["count"])->asArray()->one();
            if (NUll == $i) {
                $model = new ExamOption();
                $model->content = $name; //content对应知学云的value
                $model->question_id = $question_id;
                //            $model->value = $value;
                $model->count = 0;
                $model->correct = 0;
                $model->course_id = $course_id;
                $model->questionAttrCopyId = $questionAttrCopyId;
                $model->questionCopyId = $questionCopyId;
                $model->value = $value; //value对应知学云的name
                if (!$model->save()) {
                    var_dump($model->errors);
                    exit;
                };
                $i = [["c" => 0, "r" => 0, "w" => 0, "s" => 0]];
            }
        }


        //判断是否有答案标识 预期type为1或0
        if ($type == 1 || $type == 0) {
            ExamResult::addReferenceAnswer($course_id, $question_id, $questionAttrCopyId, $value, $type);
        }









        //20220728 尝试把所有名称相同的题目id全找出来，然后查询答案

        if ($question_name == null) {
            $question_name = ExamQuestion::find()->where("id = " . $question_id)->select('name')->asArray()->one()['name'];
            //            $question_name = $question_name['name'];
        }

        //        $question_id_arr = ExamQuestion::find()->where($question_name)->select('id')->asArray()->column();

        //        var_dump($question_id_arr);exit;
        //        $question_type='SingleChoice';
        //$i = ExamResult::find()->where("question_id = ".$question_id .' and checked_value like \'%'.$name.'%\' and state = 1')->select('count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')->asArray()->all();
        //20201228 不记得之前匹配选项时为啥要用like 而不用=号了，先改回=号，避免那种A选项包含B选项时，会把A的选择结果同时算到B上面。
        //20210108 用like是为了处理多选题，多选的答案是A|B|C 这样的格式
        //20220728 多选用 like \'%'.$name.'%\' 仍存在答案覆盖的问题。比如 中国上海 中包含了 上海
        // 'MultiChoice','SingleChoice','Judge' 对应原云学堂的课程类型    1，2对应知学云的课程类型 预期1是单选，2是多选
        if ($question_type == 'SingleChoice' || $question_type == 'Judge') {
            //单选直接用=查询
            //20220728 判断也用=查询
            $i = ExamResult::find()
                ->andWhere('question_id in (select id from exam_question where name =\'' . str_replace("'", "\\'", $question_name) . '\' )')
                ->andwhere('checked_value = \'' . str_replace("'", "\\'", $name) . '\' and state = 1')
                ->select('count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')
                ->asArray()->all();
        } else if ($question_type == "MultiChoice") {
            // 多选用like查询
            $i = ExamResult::find()
                ->andwhere('checked_value like \'%' . str_replace("'", "\\'", $name) . '%\' and state = 1')
                ->andWhere('question_id in (select id from exam_question where name =\'' . str_replace("'", "\\'", $question_name) . '\' )')
                ->select('count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')
                ->asArray()->all();
        } else if ($question_type == 1) {
            //20230830 知学云单选查询 关闭尝试以题目名称为依据查询答案。不判断题目id.尝试适配同一题目出现在不同题库中的情况。
            $i = ExamResult::find()
                ->andWhere("question_id ='$question_id'")
                ->andwhere("checked_value = '$questionAttrCopyId' and state = 1")
                ->select('count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')
                ->asArray()->all();
        } else {
            //20230830 预期是知学云多选查询 关闭尝试以题目名称为依据查询答案。不判断题目id.尝试适配同一题目出现在不同题库中的情况。
            $i = ExamResult::find()
                ->andWhere("question_id ='$question_id'")
                ->andwhere("checked_value like '%$questionAttrCopyId%' and state = 1")
                ->select('count(*) c,count(case when result="1" then 1 else null end) r,count(case when result="-1" then 1 else null end) w,max(score) s')
                ->asArray()->all();
        }

        if (!isset($i[0])) {
            $i = [["c" => 0, "r" => 0, "w" => 0, "s" => 0]];
        }
        return $i;
        //ScoreTime::find()->where(['in','status',[self::active_status_1,self::active_status_2]])->asArray()->one();

    }

    /**
     * @description: 通过 questionAttrCopyId 查询选项id
     * @param {*} $questionAttrCopyId
     * @return {*} $id
     * @author: koko
     */
    public static function findIdByQuestionAttrCopyId($questionAttrCopyId)
    {

        $i = ExamOption::find()->where(["questionAttrCopyId" => $questionAttrCopyId])->select("id")->asArray()->one();
        if (NUll == $i) {
            return null;
        } else {
            return $i['id'];
        }
    }
}
