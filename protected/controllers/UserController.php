<?php

class UserController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'cambiarPassword','cambiarSucursal','delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCambiarPassword()
    {
        $id = Yii::app()->user->model->id;
        $model = $this->loadModel($id);
        $model->setScenario('changePwd');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $valid = $model->validate();

            if ($valid) {
                $model->password = $model->new_password;
                // $model->password_update_time = date('Y-m-d H:i:s');
                $model->save();

                $this->redirect(array('site/logout', 'mensaje' => 'El cambio de password fue realizado correctamente. Por favor loguearse de nuevo.'));
            } else {

                Yii::app()->user->setFlash('error', 'Hubo un error al cambiar el password.');
            }
        }
        $this->render('cambiarPassword', array('model' => $model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;
        $perfiles = array();
        $perfilAuditor = "";
        foreach (Yii::app()->authManager->roles as $nombrePerfil => $perfil) {
            $perfiles[$nombrePerfil] = $nombrePerfil;
            if($perfil->name == 'auditor'){
                $perfilAuditor = $perfil->name;
            }
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {

                foreach ($_POST['User']['perfil'] as $key => $perfil) {
                    Yii::app()->authManager->assign($perfil, $model->id);
                }
                Yii::app()->user->setNotification('success', 'Usuario creado con Exito.');
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model, "perfiles" => $perfiles,'perfilAuditor'=>$perfilAuditor
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $perfiles = array();
        foreach (Yii::app()->authManager->roles as $nombrePerfil => $perfil) {
            $perfiles[$nombrePerfil] = $nombrePerfil;
        }
       // $model->setScenario('jornadaLaboral');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $perfilesAnteriores = array_keys(Yii::app()->authManager->getAuthAssignments($model->id));
                foreach ($perfilesAnteriores as $perfil) {
                    Yii::app()->authManager->revoke($perfil, $model->id);
                }

                foreach ($_POST['User']['perfil'] as $perfil) {
                    Yii::app()->authManager->assign($perfil, $model->id);
                }

                Yii::app()->user->setNotification('success', 'Usuario actualizado con Exito.');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model, "perfiles" => $perfiles
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            try{
                $proyecto = Proyecto::model()->findByAttributes(['usuario_id'=>$id]);
                if(!is_null($proyecto)){
                    throw new Exception("Error. Este usuario esta asociado a un proyecto");
                }

                $this->loadModel($id)->delete();
                $datos = ['error'=>0,'msj'=>"Usuario eliminado correctamente"];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $msj = $exception->getMessage();
                $datos = ['error'=>1,'msj'=>$msj];
                echo CJSON::encode($datos);
                die();
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCambiarSucursal($id)
    {
        Yii::app()->user->model->ultimoLoginSucursalId = $id;
        Yii::app()->user->model->save();

        //  $this->redirect(array('site/index')

        return $this->redirect(array('site/index'));
    }

}
