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
         $post = Post::find()->where(['post_category'=>'1'])->orderby("created_at desc")->asArray()->all();

               return $this->render('category',[
               'post' => $post, //传递文章列表信息
             ]);

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

      $post->post_hits += 1;
      $post->save();



            return $this->render('article',[
            'post' => $post->attributes, //传递文章具体信息
          ]);


    }
    public function actionC($id)
    {
      $post = Post::find()->where(['post_category'=>$id])->orderby("created_at desc")->asArray()->all();

            return $this->render('category',[
            'post' => $post, //传递文章列表信息
          ]);


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
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

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
}
