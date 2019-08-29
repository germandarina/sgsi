<?php

class NivelDeRiesgosController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new NivelDeRiesgos;


        if (isset($_POST['NivelDeRiesgos'])) {
            $model->attributes = $_POST['NivelDeRiesgos'];
            $usuario = User::model()->findByPk(Yii::app()->user->model->id);
            if(!is_null($usuario->ultimo_proyecto_id)){
                $model->proyecto_id = $usuario->ultimo_proyecto_id;
            }else{
                Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                $this->redirect(array('create'));

            }
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Nivel de riesgo creado con exito');
                $this->redirect(array('create'));
            }
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['NivelDeRiesgos'])) {
            $model->attributes = $_POST['NivelDeRiesgos'];
            $usuario = User::model()->findByPk(Yii::app()->user->model->id);
            if(!is_null($usuario->ultimo_proyecto_id)){
                $model->proyecto_id = $usuario->ultimo_proyecto_id;
            }else{
                Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                $this->redirect(array('create'));

            }
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Nivel de riesgo actualizado con exito');
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
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
                $grupo_activo = AnalisisRiesgoDetalle::model()->findByAttributes(['nivel_riesgo_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este Nivel de Riesgo esta relacionado a una gestion de riesgos.");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el nivel de riesgo";
                echo CJSON::encode($data);
            }catch (Exception $exception){
                $data = $exception->getMessage();
                echo CJSON::encode($data);
                die();
            }
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('NivelDeRiesgos');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new NivelDeRiesgos('search');
        $model->unsetAttributes();  // clear any default values
        $usuario = User::model()->getUsuarioLogueado();
        if(is_null($usuario->ultimo_proyecto_id)){
            Yii::app()->user->setNotification('error','Seleccione un proyecto');
            $this->redirect(array('/'));
        }
        $model->proyecto_id = $usuario->ultimo_proyecto_id;
        if (isset($_GET['NivelDeRiesgos']))
            $model->attributes = $_GET['NivelDeRiesgos'];

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
        $model = NivelDeRiesgos::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $usuario = User::model()->getUsuarioLogueado();
        if(!is_null($usuario)){
            if($model->proyecto_id != $usuario->ultimo_proyecto_id){
                Yii::app()->user->setNotification('error','Acceso denegado');
                $this->redirect(array('admin'));
            }
        }else{
            $this->redirect(array('admin'));
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nivel-de-riesgos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
