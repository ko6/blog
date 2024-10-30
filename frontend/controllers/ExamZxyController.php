<?php

namespace frontend\controllers;

use frontend\models\ExamOption;
use frontend\models\ExamQuestion;
use frontend\models\ExamResult;
use Yii;
use frontend\models\ExamCourse;
use frontend\models\ExamCourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 知学云平台课程记录相关方法 
 * 2023/8/20
 */
class ExamZxyController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin:*');
        // header('Access-Control-Allow-Credentials:true');
        // header('Access-Control-Allow-Private-Network:true');
        header('Access-Control-Allow-Headers:*');
        $this->enableCsrfValidation = false;
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            exit;
        }
        return parent::beforeAction($action);
    }

    /**
     * @description: 保存题目（和答案），返回选项的答题记录
     * @return {*}
     * @author: koko
     */
    public function actionCheck()
    {

        $json = Yii::$app->request->post("data");
        //    return $json;
        //    return json_encode($json);
        // var_dump(urldecode($json));
        // exit;   
        $json = json_decode(urldecode($json), true);

        // var_dump($json); 
        // exit;
        $result = []; //记录各题目各选项选择的统计结果

        $coure_id = ExamCourse::checkCourseName($json['examName'], $json['examInfo'], $json['examid']);
        //    var_dump('$coure_id='.$coure_id);
        // $json['coure_id']=$coure_id;
        // exit;
        $c = count($json['questions']);

        for ($i = 0; $i < $c; $i++) {
            //    var_dump($json['questions'][$i]);
            //    return;

            $questionId = null; //20230831 这个参数只出现在考卷中，在考试结果的卷面中没有。还没有理解它的真实用途。考虑可以移除。
            if (isset($json['questions'][$i]['questionId'])) {
                $questionId =   isset($json['questions'][$i]['questionId']);
            }
            $question_id = ExamQuestion::checkQuestionName(
                $json['questions'][$i]['content'],
                $questionId,
                $json['questions'][$i]['id'],
                $coure_id,
                $json['questions'][$i]['type']
            );

            $result[$json['questions'][$i]['id']] = []; //将当前题目，插入返回结果中
            $d = count($json['questions'][$i]['questionAttrCopys']);
            //            $json['questions'][$i]['id']=$question_id;

            for ($j = 0; $j < $d; $j++) {
                //break;
                //保存选项，并查询选项的历史记录。
                //20230830 此环节同步保存答案(如果有) 有答案的数据中没有questionCopyId参数，需要单独判断下
                $questionCopyId = null;
                if (isset($json['questions'][$i]['questionAttrCopys'][$j]['questionCopyId'])) {
                    $questionCopyId = $json['questions'][$i]['questionAttrCopys'][$j]['questionCopyId'];
                }
                //针对判断题,前端传入一个result字段,用于标明该选项是否正确. 1正确  -1错误 20241030
                if(!isset($json['questions'][$i]['questionAttrCopys'][$j]['result'])){
                    // 如果未设置,置为空
                    $questionAttrCopys_result = 0;
                }else{
                    $questionAttrCopys_result = $json['questions'][$i]['questionAttrCopys'][$j]['result'];

                }
                $k = ExamOption::checkOptionName(
                    $json['questions'][$i]['questionAttrCopys'][$j]['value'],
                    $question_id,
                    $coure_id,
                    $json['questions'][$i]['type'],
                    $json['questions'][$i]['content'],
                    false,
                    $json['questions'][$i]['questionAttrCopys'][$j]['id'],
                    $questionCopyId,
                    $json['questions'][$i]['questionAttrCopys'][$j]['name'],
                    $json['questions'][$i]['questionAttrCopys'][$j]['type'],
                    $questionAttrCopys_result
                );
                //                var_dump($k);exit;
                $result[$json['questions'][$i]['id']][$json['questions'][$i]['questionAttrCopys'][$j]['id']] = []; //记录当前选项

                $result[$json['questions'][$i]['id']][$json['questions'][$i]['questionAttrCopys'][$j]['id']]["c"] = $k[0]["c"];
                $result[$json['questions'][$i]['id']][$json['questions'][$i]['questionAttrCopys'][$j]['id']]["r"] = $k[0]["r"];
                $result[$json['questions'][$i]['id']][$json['questions'][$i]['questionAttrCopys'][$j]['id']]["w"] = $k[0]["w"];
                $result[$json['questions'][$i]['id']][$json['questions'][$i]['questionAttrCopys'][$j]['id']]["s"] = $k[0]["s"];
            }
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }


    public function actionShow($id = '', $name = "")
    {
        if ($id == "" && $name == "") {
            return '{"state":500,err:"未找到相关课程"}';
        }
        if ($id != "") {

            $course_model = $this->findModel($id);
        } else {
            $course_model = ExamCourse::find()->where(["name" => $name])->one();
        }

        if ($course_model == null) {
            return '{"state":501,err:"未找到相关课程"}';
        }
        //        $question_id=ExamQuestion::find()->where(["course_id"=>$course_model->id])->select('id')->asArray()->all();
        $question_model = ExamQuestion::find()->where(["course_id" => $course_model->id])->asArray()->all();
        //        $id=[];
        //        foreach( $question_model  as $i){
        //            array_push($id,$i['id']) ;
        //
        //        };
        //        var_dump($question_model);
        //        exit;
        $option_model = ExamOption::find()->where(['=', "course_id", $course_model->id])->asArray()->all();

        $d = count($option_model);
        //            $json['question'][$i]['id']=$question_id;
        for ($j = 0; $j < $d; $j++) {
            //找出题目名称,类型
            $question_name = null;
            $question_type = null;
            for ($i = 0; $i < count($question_model); $i++) {
                if ($question_model[$i]["id"] == $option_model[$j]["question_id"]) {
                    $question_name = $question_model[$i]["name"];
                    $question_type = $question_model[$i]["type"];
                    break;
                }
            }
            $k = ExamOption::checkOptionName(
                $option_model[$j]['content'],
                $option_model[$j]['question_id'],
                null,
                $question_type,
                $question_name,
                true
            );
            //                var_dump($k);exit;

            $option_model[$j]["c"] = $k[0]["c"];
            $option_model[$j]["r"] = $k[0]["r"];
            $option_model[$j]["w"] = $k[0]["w"];
            $option_model[$j]["s"] = $k[0]["s"];
        }
        //      var_dump($k);
        //if($option_model[$j]['id']==257){
        //    print_r("#########");
        //            var_dump($option_model );
        //            print_r("#########");
        //            var_dump($option_model[1] );
        //                        exit;

        return $this->render('show', [
            'model' => $course_model,
            'question' => $question_model,
            'option' => $option_model
        ]);
    }

    /**
     * @description: 记录考试结果和考试题目
     * type:1 查询答案      2保存题目
     * 
     * @return {*}
     * @author: koko
     */
    public function actionResult()
    {

        $json = Yii::$app->request->post("data");
        //    return $json;
        //    return json_encode($json);
        // var_dump(urldecode($json));
        // exit;   
        $json = json_decode(urldecode($json), true);
        //     var_dump(isset($json['type'])); 
        //     var_dump(isset($json->type)); 
        // var_dump($json); 
        //        return ExamResult::checkResult1(1,1,"1","1","1",1,1,1);
        if (!isset($json['cookie']) && !isset($json['type'])) {
            return '{"state":505,"msg":"未授权访问"}';
        }

        if ($json['type'] == 1) {
            //传入题目id,查询题目参考答案.


            //先查询并保存考试科目
            // var_dump($json['questionCopyIds']);

            $result = []; //保存查询结果。 结果格式如下：
            // key(问题id)=>state   0 未同步   1 已同步
            // key(问题id)[答案id]=>c 选择次数
            // key(问题id)[答案id]=>r 正确次数
            // key(问题id)[答案id]=>w 错误次数
            // key(问题id)[答案id]=>s 最高得分

            for ($i = 0; $i < count($json['questionCopyIds']); $i++) {
                //先查询问题id
                $qId = $json['questionCopyIds'][$i];
                $result[$qId] = []; //记录当前题目状态

                $question_id = ExamQuestion::findIdByQid($qId);

                if ($question_id == null) {
                    $result[$qId]['state'] = 0; //没找到问题
                } else {
                    $result[$qId]['state'] = 1; //找到了问题
                    $result[$qId]['result'] = ExamResult::getResultByQuestionIid($question_id); //查找问题的答题记录


                }
            }


            return json_encode($result);




            exit;


            $coure_id =  ExamCourse::checkCourseName($json['examName'], $json['examInfo'], $json['examid']);

            var_dump($coure_id);

            //checkResult1($course_id,$question_id,$checked_value,$value,$cookie,$index){
            //   $c = ExamQuestion::find()->where(["questionid"=>$json['question_id']])->select(["course_id","id"])->asArray()->one();
            //            var_dump($json['qid'],$c);exit;
            //

            return ExamResult::getResult($coure_id);

            //            var_dump($c["id"],$c['course_id'],$json['checked_value'],$json['value'],$json['cookie'],$json['index']);
            // return    ExamResult::checkResult1($json['c_id'],$json['q_id'],$json['checked_value'],$json['value'],$json['cookie'],$json['index']);
            //            exit;

        } else if ($json['type'] == 2) {
            //传入答题详情，记录答题情况

            return    ExamResult::checkResult_zxy2($json);
        } else if ($json['type'] == 3) {
            //20230831 更新考试成绩
            return    ExamResult::checkResult2($json['cookie'], $json['score']);
        }

        //        return json_encode($json);

        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
    }





}
