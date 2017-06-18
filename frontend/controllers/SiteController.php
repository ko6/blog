<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\SiteInfo;
use backend\models\Post;
use backend\models\Comment;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {


        //  return $this->render('index',[
          //  'site_info' => SiteInfo::get_site_info(), //获取网站基本信息
        //  ]);
//临时跳转至文章列表页
//         $post = Post::find()->where(['post_category'=>'1'])->orderby("created_at desc")->asArray()->all();

//               return $this->render('category',[
//               'post' => $post, //传递文章列表信息
//             ]);

       return $this->actionC(1);
    }

    public function actionA($id)
    {
      // $post = Post::find()->where(['post_id'=>$id])->asArray()->one();
      $post = Post::findOne(['post_id'=>$id,'post_status'=>"1"]);
      // var_dump($post);
      if(!isset($post)){
        echo "meiyou";
          throw new NotFoundHttpException('The requested page does not exist.');
      }

//      var_dump($post->created_at);

      $post->post_hits += 1;
      $post->save();

            return $this->render('article',[
            'post' => $post->attributes, //传递文章具体信息
          ]);


    }

    /**
     * @param $id
     * @return string
     */

    public function actionC($id)
    {
        //$_COOKIE['comment_id']) 一个用于标识评论发布作者的字串
        if(empty($_COOKIE['comment_id'])){
            $comment_id = self::guid();
            setcookie('comment_id',$comment_id,time()+3600*24*365,'/');
        }

      $post = Post::find()->where(['post_category'=>$id,'post_status'=>"1"])
          ->select('post_pic,post_title,post_id,post_url_name,post_tips,post_hits,post_excerpt,created_at')
          ->orderby("created_at desc")
          ->asArray()->all();

        if(sizeof($post)==0){
            return $this->render('error',[
                'name' => 'Not Found (#404)',
                'message'=>'没找到您访问的页面',
            ]);
        } else {

            return $this->render('category',[
                'post' => $post, //传递文章列表信息
//                'title'=>'TIP: '.$id, //传递标题
            ]);
        }


    }

    public function actionT($id)
    {
      $post = Post::find()
          ->where(['and',['like','post_tips',$id],'post_status'=>"1"])
          ->select('post_pic,post_title,post_id,post_url_name,post_tips,post_hits,post_excerpt,created_at')
          ->orderby("created_at desc")
          ->asArray()->all();

        if(sizeof($post)==0){
            return $this->render('error',[
                'name' => 'Not Found (#404)',
                'message'=>'没找到您访问的页面',
            ]);
        } else {

            return $this->render('category',[
                'post' => $post, //传递文章列表信息
                'title'=>'TIP: '.$id, //传递标题
            ]);
        }



    }


    /**
     * 保存评论信息
     * @return string
     */
    public function actionComments()
    {
        $model =new Comment();

        $p = Yii::$app->request->post();
        $t='';
        //保存状态，1：保存成功
        $status='';

        if ($model->load($p)){
            //检测数据合法性
            //comment_post_id 正整数
            if(!(is_numeric($model->comment_post_id)&&is_int($model->comment_post_id*1)&&$model->comment_post_id>0)){
                $t='文章信息错误';
                $status='0';
                return "{\"status\":$status,\"t\":\"$t\"}";
            } elseif (empty($model->comment_name)){
                $t='您的名字不能为空';
                $status='0';
                return "{\"status\":$status,\"t\":\"$t\"}";
            } elseif (empty($model->comment_content)){
                $t='评论内容不能为空';
                $status='0';
                return "{\"status\":$status,\"t\":\"$t\"}";
            } elseif (empty($model->comment_email)){
                $t='邮件地址不能为空';
                $status='0';
                return "{\"status\":$status,\"t\":\"$t\"}";
            }


            //$_COOKIE['comment_id']) 一个用于验证评论作者的字串
            //作者可以看到自己发布的未通过审核的回复内容
            if(empty($_COOKIE['comment_id'])){
                $comment_id = self::guid();
                setcookie('comment_id',$comment_id,time()+3600*24*365,'/');
                $model->comment_ip=$comment_id;
            } else {
                $model->comment_ip=$_COOKIE['comment_id'];
            }



            //todo 将链接转换为id
            $model->comment_link_id=1;


            //置状态为待审核
            $model->comment_status=0;
            if ( $model->save()){
                //保存成功
                $t= "";
                $status='1';
                return "{\"status\":$status,\"t\":\"$t\"}";
            } else {
               //保存失败
                $e= $model->errors;
                $t="";
                foreach ($e as $k => $v){
                    $t=$t."#".$k."=>".implode(" ",$v);
                }
                $status='0';
                return "{\"status\":$status,\"t\":\"$t\"}";
            }

        }else{
            $t= "加载提交信息失败";
            $status='0';
            return "{\"status\":$status,\"t\":\"$t\"}";
        }


    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }
    //
    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     } else {
    //         return $this->render('login', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();
    //
    //     return $this->goHome();
    // }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending email.');
//            }
//
//            return $this->refresh();
//        } else {
//            return $this->render('contact', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    // public function actionSignup()
    // {
    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($user = $model->signup()) {
    //             if (Yii::$app->getUser()->login($user)) {
    //                 return $this->goHome();
    //             }
    //         }
    //     }
    //
    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    static public function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }

}
