<?php

class ScriptController extends Controller
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
                    $this->redirect(Yii::app()->user->returnUrl);
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

    public function actionMigrarAmenazaVulnerabilidad(){
        try{
            $transaction = Yii::app()->db->beginTransaction();
              $vulnerabilidades = Vulnerabilidad::model()->findAll();
              if(!empty($vulnerabilidades)){
                  foreach ($vulnerabilidades as $vulne){
                        $amenaza_vulne = new AmenazaVulnerabilidad();
                        $amenaza_vulne->amenaza_id = $vulne->amenaza_id;
                        $amenaza_vulne->vulnerabilidad_id = $vulne->id;
                        if(!$amenaza_vulne->save()){
                            throw new Exception("Error al guardar");
                        }
                  }
              }
            $transaction->commit();
            echo "migracion realizada con exito";
        }catch (Exception $ex){
            $transaction->rollback();
            echo $ex->getMessage();
        }
    }

    public function actionActualizarControles(){
        try{
            $transaction = Yii::app()->db->beginTransaction();
            $controles = Control::model()->findAll();
            if(!empty($controles)){
                foreach ($controles as $control){
                   $amenazas_vulne = AmenazaVulnerabilidad::model()->findAllByAttributes(['vulnerabilidad_id'=>$control->vulnerabilidad_id]);
                   if(!empty($amenazas_vulne)){
                        foreach ($amenazas_vulne as $relacional){
                            $control->amenaza_id = $relacional->amenaza_id;
                            $control->tipo_activo_id = $relacional->amenaza->tipo_activo_id;
                            if(!$control->save()){
                                throw new Exception("Error al actualizar control");
                            }
                        }
                   }
                }
            }
            $transaction->commit();
            echo "controles actualizada con exito";
        }catch (Exception $ex){
            $transaction->rollback();
            echo $ex->getMessage();
        }
    }
}