<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\PostSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Tips;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
//                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        $p = Yii::$app->request->post();

        if ($model->load($p)){
            //判断正文格式，然后加载对应编辑器里的内容保存到数据库
            if($model->post_content_type == 1 && isset($p['Post']["post_content_1"])){
                $model->post_content = $p['Post']["post_content_1"];
            } elseif ($model->post_content_type == 2 && isset($p['Post']["post_content_2"])) {
                $model->post_content = $p['Post']["post_content_2"];
            } else {
                echo '<script> alert("编辑器类型或编辑器内容异常，获取文章正文内容失败");</script>';
            }

            //处理正文为空的情况
            $model->post_content == null && $model->post_content = '正文无内容';

            //处理文章标签，主要是标签使用统计

            if(isset($model->post_tips) && $model->post_tips!=null ){
              Tips::set_tips($model->post_tips);

            }

            //处理文章发布日期
            $model->created_at = strtotime($model->created_at);
            $model->updated_at = time();



            if ( $model->save()) {
                return $this->redirect(['view', 'id' => $model->post_id]);
            } else {
                echo '<script> alert("添加失败");history.go(-1);</script>';

            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $p = Yii::$app->request->post();

        if ($model->load($p)){
            //判断正文格式，然后加载对应编辑器里的内容保存到数据库
            if($model->post_content_type == 1 && isset($p['Post']["post_content_1"])){
                $model->post_content =$p['Post']["post_content_1"];
            } elseif ($model->post_content_type == 2 && isset($p['Post']["post_content_2"])) {
                $model->post_content = $p['Post']["post_content_2"];
            } else {
                echo '<script> alert("编辑器类型或编辑器内容异常，获取文章正文内容失败");</script>';
            }

            //处理正文为空的情况
            $model->post_content == null && $model->post_content = '正文无内容';

            //处理文章标签，主要是标签使用统计
            if(isset($model->post_tips) && isset($model->oldAttributes['post_tips']) && ($model->post_tips!=null || $model->oldAttributes['post_tips']!=null)){
              Tips::set_tips($model->post_tips,$model->oldAttributes['post_tips']);
            }

            //处理文章发布日期
            $model->created_at = strtotime($model->created_at);
            $model->updated_at = time();



            if ( $model->save()) {
                return $this->redirect(['view', 'id' => $model->post_id]);
            } else {
//               var_dump($model->errors);
                echo '<script> alert("编辑失败");history.go(-1);</script>';
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
