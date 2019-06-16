<?php

class ProcesoController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete','getActivosModal'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin',),
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
        $model = new Proceso;

        if (isset($_POST['Proceso'])) {
            $model->attributes = $_POST['Proceso'];
            if(Yii::app()->user->model->isAuditor()){
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)) {
                    $area_proyecto = AreaProyecto::model()->findByAttributes(['area_id'=>$model->area_id,'proyecto_id'=>$usuario->ultimo_proyecto_id]);
                    if(is_null($area_proyecto)){
                        Yii::app()->user->setNotification('error','El area seleccionada no corresponde al proyecto en el que se encuentra trabajando');
                        $this->redirect(array('create'));
                    }
                    if ($model->save()) {
                        Yii::app()->user->setNotification('success', 'El proceso fue creado con exito');
                        $this->redirect(array('create'));
                    }
                }else{
                    Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                    $this->redirect(array('create'));
                }
            }else{
                if ($model->save()) {
                    Yii::app()->user->setNotification('success', 'El proceso fue creado con exito');
                    $this->redirect(array('create'));
                }
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
        $activo = new Activo();
        $activo->area_id = $model->area_id;
        if (isset($_POST['Proceso'])) {
            $model->attributes = $_POST['Proceso'];
            if(Yii::app()->user->model->isAuditor()){
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)) {
                    $area_proyecto = AreaProyecto::model()->findByAttributes(['area_id'=>$model->area_id,'proyecto_id'=>$usuario->ultimo_proyecto_id]);
                    if(is_null($area_proyecto)){
                        Yii::app()->user->setNotification('error','El area seleccionada no corresponde al proyecto en el que se encuentra trabajando');
                        $this->redirect(array('update','id'=>$model->id));
                    }
                    if ($model->save()) {
                        Yii::app()->user->setNotification('success', 'El proceso fue creado con exito');
                        $this->redirect(array('admin'));
                    }
                }else{
                    Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                    $this->redirect(array('update','id'=>$model->id));
                }
            }else{
                if ($model->save()) {
                    Yii::app()->user->setNotification('success', 'El proceso fue creado con exito');
                    $this->redirect(array('update','id'=>$model->id));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,'activo'=>$activo
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
                $grupo_activo = Personal::model()->findByAttributes(['proceso_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este proceso ya posee las asociaciones realizadas");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el proceso";
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
        $dataProvider = new CActiveDataProvider('Proceso');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Proceso('search');
        $model->unsetAttributes();  // clear any default values
        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
        if(is_null($usuario->ultimo_proyecto_id)){
            Yii::app()->user->setNotification('error','Tiene que seleccionar un proyecto');
            $this->redirect(array('/'));
        }
        $model->proyecto_id = $usuario->ultimo_proyecto_id;
        if (isset($_GET['Proceso']))
            $model->attributes = $_GET['Proceso'];

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
        $model = Proceso::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'proceso-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetActivosModal(){
        if(isset($_POST['proceso_id'])){
           $proceso = $this->loadModel($_POST['proceso_id']);
           $activos = $proceso->getActivos();
           $html = $this->renderPartial('_activosPorProceso', array('activos'=>$activos), true);
           echo CJSON::encode(['html'=>$html]);
           die();
        }
    }
}
