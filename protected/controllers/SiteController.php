<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (isset(Yii::app()->user->model)) {

            // display the login form
            $this->render("index");

        } else {
            $this->layout = 'login';
            $model = new LoginForm;

            // if it is ajax validation request
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            // collect user input data
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login())
                    $this->redirect(Yii::app()->user->returnUrl);
            }
            // display the login form
            $this->render('login', array('model' => $model));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else{
                if (!isset(Yii::app()->user->model)) {
                   $error = 'Debe logearse para acceder al sistema.' ; 
                   $this->redirect(array('login', 'error'=>$error));
                   //$this->redirect(Yii::app()->user->returnUrl,array('error'=>$error));
                 }else{   
                    if($error['code'] == 500) $this->render('error500', $error);
                    else  $this->render('error400', $error);
                }    
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {

        if (isset(Yii::app()->user->model)) {

            // display the login form
            $this->redirect("index");

        } else {
            $this->layout = 'login';

            $model = new LoginForm;

            // if it is ajax validation request
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            // collect user input data
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid

                if ($model->validate() && $model->login()) {
                    Yii::app()->user->setNotification('success', 'Bienvenido ' . Yii::app()->user->model->username . '!');
                    $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                    if(is_null($usuario->ultimo_proyecto_id)){
                        return $this->redirect(Yii::app()->user->returnUrl);
                    }
                    return $this->redirect(array('/proyecto/panel','id'=>$usuario->ultimo_proyecto_id));
                }
            }
            // display the login form
            $this->render('login', array('model' => $model));
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        if(isset(Yii::app()->session["hijoId"])){
            unset(Yii::app()->session['hijoId']);
        }

        if(isset(Yii::app()->session["padreId"])){
            unset(Yii::app()->session['padreId']);
        }
        Yii::app()->user->logout();
        Yii::app()->user->setReturnUrl(Yii::app()->createUrl('/'));
        $this->redirect("login");
    }
}