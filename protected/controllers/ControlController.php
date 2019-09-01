<?php

class ControlController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete','getControlValor','eliminarControlValor'
                                   ,'guardarControlValor','getControlesEnRiesgo','getVulnerabilidades'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', ),
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
        $model = new Control;
        if (isset($_POST['Control'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Control'];
                if (!$model->save()) {
                    throw new Exception("Error al crear control");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Control creado con exito');
                $this->redirect(array('create'));
            }catch (Exception $exception){
                $transaction->rollback();
                Yii::app()->user->setNotification('error',$exception->getMessage());
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
        if (isset($_POST['Control'])) {
            $model->attributes = $_POST['Control'];
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Control actualizado con exito');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model
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
                $grupo_activo = AnalisisControl::model()->findByAttributes(['control_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este control ya esta asociado a un analisis.");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el control";
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
        $dataProvider = new CActiveDataProvider('Control');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Control('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Control']))
            $model->attributes = $_GET['Control'];

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
        $model = Control::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'control-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetControlValor(){
        if(isset($_POST['control_valor_id'])){
            $controlValor = ControlValor::model()->findByPk($_POST['control_valor_id']);
            if(!is_null($controlValor)){
                $controlValor->fecha = Utilities::ViewDateFormat($controlValor->fecha);
                $datos =['controlValor'=>$controlValor];
                echo CJSON::encode($datos);
            }
        }
    }

    public function actionEliminarControlValor(){
        if(isset($_POST['control_valor_id'])){
            $controlValor = ControlValor::model()->findByPk($_POST['control_valor_id']);
            if(!$controlValor->delete()){
                $datos =['error'=>1];
                echo CJSON::encode($datos);
                die();
            }else{
                $datos =['error'=>0];
                echo CJSON::encode($datos);
                die();
            }
        }
    }

    public function actionGuardarControlValor(){
        if(isset($_POST['control_id'])){
            if(empty($_POST['control_valor_id'])){
                $controlValor = new ControlValor();
            }else{
                $controlValor = ControlValor::model()->findByPk($_POST['control_valor_id']);
            }
            $controlValor->control_id = $_POST['control_id'];
            $controlValor->valor = $_POST['valor'];
            $controlValor->fecha = Utilities::MysqlDateFormat($_POST['fecha']);
            if(!$controlValor->save()){
                $datos =['error'=>1];
                echo CJSON::encode($datos);
                die();
            }else{
                $datos =['error'=>0];
                echo CJSON::encode($datos);
                die();
            }
        }
    }

    public function actionGetControlesEnRiesgo(){
        if(isset($_POST['analisis_riesgo_detalle_id'])){
            $analisis_riesgo_detalle = AnalisisRiesgoDetalle::model()->findByPk($_POST['analisis_riesgo_detalle_id']);
            $analisis_riesgo = $analisis_riesgo_detalle->analisisRiesgo;
            $grupo_activo = $analisis_riesgo_detalle->grupoActivo;
            $analisis_control = AnalisisControl::model()->findAllByAttributes(['analisis_id'=>$analisis_riesgo->analisis_id,'grupo_activo_id'=>$grupo_activo->id]);
            $arrayControles = [];
            if(!empty($analisis_control)){
                foreach ($analisis_control as $ac){
                    if($ac->valor == GrupoActivo::VALOR_ALTO){
                        $arrayControles[] = $ac;
                    }
                }
            }
            $html = $this->renderPartial('_controlesEnRiesgo',array('arrayControles'=>$arrayControles),true);
            $datos =['html'=>$html];
            echo CJSON::encode($datos);
        }
    }

    public function actionGetVulnerabilidades(){
        if(isset($_POST['amenaza_id'])){
            $amenaza_vulne = AmenazaVulnerabilidad::model()->findAllByAttributes(['amenaza_id'=>$_POST['amenaza_id']]);
            $vulnerabilidades = [];
            if(!empty($amenaza_vulne)){
                foreach ($amenaza_vulne as $am){
                    $vulnerabilidades[] = $am->vulnerabilidad;
                }
            }
            $datos = ['vulnerabilidades'=>$vulnerabilidades];
            echo CJSON::encode($datos);
            die();
        }
    }
}
