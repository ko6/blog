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
 * ExamCourseController implements the CRUD actions for ExamCourse model.
 */
class ExamCourseController extends Controller
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

    /**
     * Lists all ExamCourse models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new ExamCourseSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionCheck()
    {
        //{"name":"软件开发服务试题","info":"满分：100，100分合格，共10题，可考5次次，考试限时：不限时","question":[{"name":"以下哪种不属于软件开发服务产品架构的？","questionid":"63934fce-94ac-48c2-bbfe-b5aa5e1a5519","qid":"071a0b20-04f7-43d7-a23e-9c85605b33c0","option":["流程层","数据层","工具层","决策层"]},{"name":"以下哪个构建类型不是软件开发服务的构建功能中的？","questionid":"af2f9c9f-71e0-4442-b4ff-197089723e63","qid":"dbdf035e-9791-4834-b35b-172df9663091","option":["从源代码构建程序包","从程序包构建镜像","从构件构建镜像","从源代码构建镜像"]},{"name":"以下哪个功能模块不是浪潮云软件开发服务的？","questionid":"b3126cb8-a928-4744-b3d9-8d039f227fbe","qid":"6dfb76bf-e9c5-4903-a199-ab022f3f8357","option":["代码扫描","代码检查","代码托管","流水线"]},{"name":"以下哪种任务类型可以放在流水线功能中的第一阶段？","questionid":"51df4670-a665-48ab-a2e1-93e39a38962a","qid":"d4df6d9c-33bc-41c2-b250-7a69c706b007","option":["添加git标签","代码检查","构建","分支合并"]},{"name":"以下哪种触发方式不是软件开发服务产品的构建功能中的触发方式？","questionid":"8b0b3d4b-5bab-4d51-8011-84358021f6fc","qid":"3628be0a-20e8-4607-ab22-1260c62bbd6f","option":["手动出发","定时检查","Git事件触发","自动触发"]},{"name":"以下哪个选项是属于软件开发服务产品的销售价值？","questionid":"23ffe357-5044-4710-8c8b-cb98ea64f636","qid":"e841277f-3129-4f7c-b383-7a79538f74e5","option":["粘性升级","差异化竞争","资源折扣","资源带动"]},{"name":"以下哪个选项是属于软件开发服务的应用数据可视化的功能模块？","questionid":"55dad37b-c7ff-4066-9fc3-1a2aaa9cdcf7","qid":"3d3426e3-421f-43d2-a0f1-735d7b27ed4f","option":["运维看板","项目看板","质量看板","开发看板"]},{"name":"以下哪种属于软件开发服务的应用自动化发布策略？","questionid":"38581a1a-25b9-4c4e-a48e-380b8bbf3354","qid":"1bc0c91a-e144-4ac0-82dd-098945a869bd","option":["灰度发布","AB测试","滚动发布","蓝绿发布"]},{"name":"以下哪个选项是属于软件开发服务的支持体系？","questionid":"80f42a61-3229-44d8-bfd2-c3091233fccb","qid":"bc802dec-8a05-44da-9467-661e08721113","option":["开放体验、免费试用","架构设计、上云指导","线上资料、线下支持"]},{"name":"浪潮云软件开发服务产品可以集成的源代码库有哪些？","questionid":"b3fa99c9-0343-4de3-89b6-0d9b17ec5192","qid":"7d0326c7-8871-4c2f-a323-5b00599284e0","option":["Gitea","GitHub","码云","GitLab"]}]}
//        return(Yii::$app->request->post("s","1"));
       $json = Yii::$app->request->post();
    //   var_dump($json);
//        var_dump($json['question'][1]['name']);
//        var_dump(Yii::$app->request->get());
//        var_dump(Yii::$app->request->params("q"));
    //   exit();
//        $json = json_decode($q);

//        var_dump(ExamCourse::checkCoureName("1"));
//        var_dump($json->question);
//        var_dump(ob_get_length($json->question));
        $coure_id = ExamCourse::checkCoureName($json['name'],$json['info']);
//        var_dump('$coure_id='.$coure_id);
        $json['coure_id']=$coure_id;
        $c=count($json['question']);
         for($i=0;$i<$c;$i++){
         //   var_dump($json['question'][$i]);
           // return;
           
            $question_id = ExamQuestion::checkQuestionName($json['question'][$i]['name'],$json['question'][$i]['questionid'],$json['question'][$i]['qid'],$coure_id,$json['question'][$i]['type']);
//            var_dump('$question_id='.$question_id);
//continue;

            $json['question'][$i]["question_id"]=$question_id;
            $d=count($json['question'][$i]['option']);
//            $json['question'][$i]['id']=$question_id;
            
            for($j=0;$j<$d;$j++){
//break;
                //保存选项，并查询选项的历史记录。
                $k = ExamOption::checkOptionName($json['question'][$i]['option'][$j][0],$question_id,$coure_id,$json['question'][$i]['type'],$json['question'][$i]['name']);
//                var_dump($k);exit;
                $json['question'][$i]['option'][$j]["c_id"]=$coure_id;
                $json['question'][$i]['option'][$j]["q_id"]=$question_id;
                $json['question'][$i]['option'][$j]["c"]=$k[0]["c"];
                $json['question'][$i]['option'][$j]["r"]=$k[0]["r"];
                $json['question'][$i]['option'][$j]["w"]=$k[0]["w"];
                $json['question'][$i]['option'][$j]["s"]=$k[0]["s"];
//                echo '<br>';
//                var_dump($k);


            }
        }
//        exit;
//        $json['result']= ExamResult::getResult($coure_id);
//        $json['name']="123";

//var_dump($json['question'], json_encode($json['question'],JSON_UNESCAPED_UNICODE));
        return json_encode($json['question'],JSON_UNESCAPED_UNICODE);
//        $searchModel = new ExamCourseSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }


    public function actionShow($id='',$name="")
    {
        if (Yii::$app->user->isGuest) {
            echo '还没登录';
            return;
        } 

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
            $question_name=null;
            $question_type=null;
            for($i=0;$i<count($question_model);$i++){
                if($question_model[$i]["id"]==$option_model[$j]["question_id"]){
                    $question_name=$question_model[$i]["name"];
                    $question_type=$question_model[$i]["type"];
                    break;
                }
            }
            $k = ExamOption::checkOptionName(
                $option_model[$j]['content'],
                $option_model[$j]['question_id'],
                null,
                $question_type,
                $question_name,
                true);
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

    public function actionResult()
    {

        //['co'] 'course_id' => 'Course ID',
       // 'question_id' => 'Question ID',
       //     'checked_value' => 'Checked Value',
       //     'value' => 'Value',
       //     'result' => 'Result',
       //     'remark' => 'Remark',
       //     'cookie' => 'Cookie',
        $json = Yii::$app->request->post();
//        return $json;
//        return json_encode($json);
//        return ExamResult::checkResult1(1,1,"1","1","1",1,1,1);
        if(!isset($json['cookie'])||!isset($json['type'])){
           return '{"state":505,"msg":"未授权访问"}';
        }

        if($json['type']==1){
            //checkResult1($course_id,$question_id,$checked_value,$value,$cookie,$index){
         //   $c = ExamQuestion::find()->where(["questionid"=>$json['question_id']])->select(["course_id","id"])->asArray()->one();
//            var_dump($json['qid'],$c);exit;
//

//            var_dump($c["id"],$c['course_id'],$json['checked_value'],$json['value'],$json['cookie'],$json['index']);
            return    ExamResult::checkResult1($json['c_id'],$json['q_id'],$json['checked_value'],$json['value'],$json['cookie'],$json['index']);
//            exit;

        }else if($json['type']==2){
            return    ExamResult::checkResult2($json['cookie'],$json['score']);
        }else if($json['type']==3){
            return    ExamResult::checkResult3($json['cookie'],$json['result']);
        }

//        return json_encode($json);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single ExamCourse model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new ExamCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new ExamCourse();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Updates an existing ExamCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Deletes an existing ExamCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the ExamCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExamCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExamCourse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
