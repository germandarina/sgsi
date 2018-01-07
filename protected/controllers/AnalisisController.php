<?php

class AnalisisController extends Controller
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
                'actions' => array('create', 'update', 'admin','crearGrupoActivo'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Analisis;

        if (isset($_POST['Analisis'])) {
            $model->attributes = $_POST['Analisis'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Analisis creado con exito');
                $this->redirect(array('update','id'=>$model->id));
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
        $grupo_activo = new GrupoActivo();
        $grupo_activo->analisis_id = $model->id;

        $model->fecha = Utilities::ViewDateFormat($model->fecha);
        if (isset($_POST['Analisis'])) {
            $model->attributes = $_POST['Analisis'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Analisis actualizado con exito');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,'grupo_activo'=>$grupo_activo
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
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
        $dataProvider = new CActiveDataProvider('Analisis');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Analisis('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Analisis']))
            $model->attributes = $_GET['Analisis'];

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
        $model = Analisis::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'analisis-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCrearGrupoActivo(){
        if(isset($_POST['analisis_id'])){
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $analisis = Analisis::model()->findByPk($_POST['analisis_id']);
                $grupo_seleccionado = Grupo::model()->findByPk($_POST['grupo_id']);
                $grupo_activo_existente = GrupoActivo::model()->findByAttributes(array('analisis_id'=>$analisis->id));
                if(!is_null($grupo_activo_existente)){
                    $grupo = Grupo::model()->findByPk($grupo_activo_existente->grupo_id);
                    if($grupo->tipo_activo_id != $grupo_seleccionado->tipo_activo_id){
                        throw new Exception("El activo seleccionado debe pertenecer al mismo tipo de activo");
                    }
                }
                $grupo_activo = new GrupoActivo();
                $grupo_activo->analisis_id = $analisis->id;
                $grupo_activo->grupo_id = $grupo_seleccionado->id;
                $grupo_activo->activo_id = $_POST['activo_id'];
                $grupo_activo->confidencialidad = $_POST['confidencialidad'];
                $grupo_activo->trazabilidad = $_POST['trazabilidad'];
                $grupo_activo->disponibilidad = $_POST['disponibilidad'];
                $grupo_activo->integridad = $_POST['integridad'];
                $arrayValores = array($_POST['confidencialidad'],$_POST['trazabilidad'],$_POST['disponibilidad'],$_POST['integridad']);
                $grupo_activo->valor = max($arrayValores);
                if(!$grupo_activo->save()){
                    throw new Exception("Error al crear grupo activo");
                }
                $grupo_activo_log_existente = GrupoActivoLog::model()->findByAttributes(array('grupo_activo_id'=>$grupo_activo->id));
                if(!is_null($grupo_activo_log_existente)){
                    $valor_anterior = $grupo_activo_log_existente->valor_nuevo;
                }else{
                    $valor_anterior = 0;
                }
                $grupo_activo_log = new GrupoActivoLog();
                $grupo_activo_log->grupo_activo_id = $grupo_activo->id;
                $grupo_activo_log->valor_anterior = $valor_anterior;
                $grupo_activo_log->valor_nuevo = $grupo_activo->valor;
                if(!$grupo_activo->save()){
                    throw new Exception("Error al guardar log de grupo activo");
                }

                $transaction->commit();
                $datos = array('error'=>0,'msj'=>"Grupo Activo creado con exito");
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $transaction->rollBack();
                $datos = array('error'=>1,'msj'=>$exception->getMessage());
                echo CJSON::encode($datos);
            }



        }
    }
}
