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
                'actions' => array('create', 'update', 'admin','crearGrupoActivo','crearDependencia',
                                    'verValoracion','gridControles','guardarValorControl'),
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
        $dependencia = new Dependencia();
        $dependencia->analisis_id = $model->id;
        $dependenciasPadres = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>NULL));
        $model->fecha = Utilities::ViewDateFormat($model->fecha);
        if(isset($_GET['GrupoActivo'])){
            $grupo_activo->amenaza_nombre = $_GET['GrupoActivo']['amenaza_nombre'];
            $grupo_activo->grupo_nombre = $_GET['GrupoActivo']['grupo_nombre'];
            $grupo_activo->tipo_activo_nombre = $_GET['GrupoActivo']['tipo_activo_nombre'];
        }
        if (isset($_POST['Analisis'])) {
            $model->attributes = $_POST['Analisis'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Analisis actualizado con exito');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,'grupo_activo'=>$grupo_activo,'dependencia'=>$dependencia,'dependenciasPadres'=>$dependenciasPadres
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
                if(!empty($_POST['grupo_id'])){
                    $grupo_id = $_POST['grupo_id'];
                }else{
                    $grupo_id =NULL;
                }
                $grupo_activo_existente = GrupoActivo::model()->findByAttributes(array('analisis_id'=>$analisis->id,'activo_id'=>$_POST['activo_id']));
                if(!is_null($grupo_activo_existente)){
                    throw new Exception("El activo seleccionado ya se encuentra asociado.");
                }
//                if(!is_null($grupo_activo_existente)){
//                    $grupo = Grupo::model()->findByPk($grupo_activo_existente->grupo_id);
//                    if($grupo->tipo_activo_id != $grupo_seleccionado->tipo_activo_id){
//                        throw new Exception("El activo seleccionado debe pertenecer al mismo tipo de activo");
//                    }
//                }
                $grupo_activo = new GrupoActivo();
                $grupo_activo->analisis_id = $analisis->id;
                $grupo_activo->grupo_id = $grupo_id;
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
                if(!$grupo_activo_log->save()){
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

    public function actionCrearDependencia(){
        if($_POST['analisis_id']){
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $arrayValoresHijos = [];
                $arrayIdHijos = [];
                $grupo_activo_padre = GrupoActivo::model()->findByAttributes(array('activo_id'=>$_POST['activo_padre_id'],'analisis_id'=>$_POST['analisis_id']));

                $dependenciaPadreExistente = Dependencia::model()->findByAttributes(array('activo_id'=>$_POST['activo_padre_id'],
                                                                                            'analisis_id'=>$_POST['analisis_id']));
                if(is_null($dependenciaPadreExistente)){
                    $dependenciaPadre = new Dependencia();
                    $dependenciaPadre->analisis_id = $_POST['analisis_id'];
                    $dependenciaPadre->activo_id = $_POST['activo_padre_id'];
                    $dependenciaPadre->activo_padre_id = NULL;
                    if(!$dependenciaPadre->save()){
                        throw new Exception("Error al crear dependencia");
                    }
                }

                foreach ($_POST['activo_id'] as $hijo_id){
                    $dependenciaHija = new Dependencia();
                    $dependenciaHija->analisis_id = $_POST['analisis_id'];
                    $dependenciaHija->activo_id = $hijo_id;
                    $dependenciaHija->activo_padre_id = $_POST['activo_padre_id'];
                    if(!$dependenciaHija->save()){
                        throw new Exception("Error al crear dependencia");
                    }
                    $grupo_activo_hijo = GrupoActivo::model()->findByAttributes(array('activo_id'=>$hijo_id,'analisis_id'=>$_POST['analisis_id']));
                    if($grupo_activo_hijo->valor < $grupo_activo_padre->valor){
                        $arrayValoresHijos[] = $grupo_activo_hijo->valor;
                        $arrayIdHijos[] = $grupo_activo_hijo->activo_id;
                    }
                }
                if(!empty($arrayValoresHijos)){
                    $menor_valor = min($arrayValoresHijos);
                    $grupos_activos = GrupoActivo::model()->findAllByAttributes(array('analisis_id'=>$_POST['analisis_id'],'valor'=>$menor_valor));
                    foreach ($grupos_activos as $gp){
                        foreach ($_POST['activo_id'] as $hijo_id){
                            if($gp->activo_id == $hijo_id){
                                $gp->valor = $grupo_activo_padre->valor;
                                if(!$gp->save()){
                                    throw new Exception("Error al actualizar valor de dependencia");
                                }
                                $grupo_activo_log = new GrupoActivoLog();
                                $grupo_activo_log->grupo_activo_id = $gp->id;
                                $grupo_activo_log->valor_anterior = $menor_valor;
                                $grupo_activo_log->valor_nuevo = $gp->valor;
                                if(!$grupo_activo_log->save()){
                                    throw new Exception("Error al guardar log de grupo activo");
                                }
                            }
                        }
                    }

                    $valor_anterior_padre = $grupo_activo_padre->valor;
                    $grupo_activo_padre->valor = $menor_valor;
                    if(!$grupo_activo_padre->save()){
                        throw new Exception("Error al actualizar valor de dependencia");
                    }
                    $grupo_activo_log = new GrupoActivoLog();
                    $grupo_activo_log->grupo_activo_id = $grupo_activo_padre->id;
                    $grupo_activo_log->valor_anterior = $valor_anterior_padre;
                    $grupo_activo_log->valor_nuevo = $grupo_activo_padre->valor;
                    if(!$grupo_activo_log->save()){
                        throw new Exception("Error al guardar log de grupo activo");
                    }
                }
                $transaction->commit();
                $dependenciasPadres = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>NULL));
                $html = $this->renderPartial('dependenciasPadres', array('dependenciasPadres'=>$dependenciasPadres), true);
                $datos = ['error'=>0,'msj'=>'Dependencias creadas con exito','html'=>$html];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $transaction->rollBack();
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
            }
        }
    }

    public function actionVerValoracion($id,$analisis_id,$grupo_id){
        $vulnerabilidad = new Vulnerabilidad();
        $vulnerabilidad->amenaza_id =$id;
        $analisis = Analisis::model()->findByPk($analisis_id);
        $grupo = Grupo::model()->findByPk($grupo_id);
        if (isset($_GET['Vulnerabilidad']))
            $vulnerabilidad->attributes = $_GET['Vulnerabilidad'];

        $this->render('verValoracion', array(
            'vulnerabilidad' => $vulnerabilidad,'analisis'=>$analisis,'grupo'=>$grupo
        ));
    }

    public function actionGridControles($analisis_id,$grupo_id)
    {
        // partially rendering "_relational" view
        $vulnerabilidadId = Yii::app()->getRequest()->getParam('id');
        $control = Control::model()->findByAttributes(array('vulnerabilidad_id' => $vulnerabilidadId));
        $controles = new Control();
        if (!is_null($control)) {
            $controles->vulnerabilidad_id = $control->vulnerabilidad_id;
        } else {
            $controles->vulnerabilidad_id = null;
        }
        $controles->analisis_id = $analisis_id;
        $controles->grupo_id = $grupo_id;
        $this->renderPartial('gridControles', array(
            'id' => Yii::app()->getRequest()->getParam('id'),
            'controles' => $controles,'analisis_id'=>$analisis_id,'grupo_id'=>$grupo_id
        ));
    }

    public function actionGuardarValorControl(){
        if(isset($_POST['control_id'])){
            try{
                $transaction= Yii::app()->db->beginTransaction();
                $control = Control::model()->findByPk($_POST['control_id']);
                $analisis = Analisis::model()->findByPk($_POST['analisis_id']);

                $analisis_control = new AnalisisControl();
                $analisis_control->control_id = $control->id;
                $analisis_control->analisis_id = $analisis->id;
                $analisis_control->valor = $_POST['valor_control'];
                $analisis_control->grupo_id = $_POST['grupo_id'];
                $analisis_control->fecha = Date('Y-m-d');
                if(!$analisis_control->save()){
                    throw new Exception("Error al guardar valoracion del control");
                }
                $vulnerabilidad = $control->vulnerabilidad;

                $analisis_vulnerabilidades = AnalisisVulnerabilidad::model()->findAllByAttributes(array('vulnerabilidad_id'=>$vulnerabilidad->id,
                                                                                                         'analisis_id'=>$analisis->id));
                if(empty($analisis_vulnerabilidades)){
                    $analisis_vulnerabilidad = new AnalisisVulnerabilidad();
                    $analisis_vulnerabilidad->analisis_id = $analisis->id;
                    $analisis_vulnerabilidad->vulnerabilidad_id =$vulnerabilidad->id;
                    $analisis_vulnerabilidad->valor = $analisis_control->valor;
                    $analisis_vulnerabilidad->grupo_id = $_POST['grupo_id'];
                    $analisis_vulnerabilidad->fecha = Date('Y-m-d');
                    if(!$analisis_vulnerabilidad->save()){
                        throw new Exception("Error al valorar vulnerabilidad");
                    }
                }else{
                    $arrayValorVulnerabilidad =[];
                    foreach ($analisis_vulnerabilidades as $av){
                        $arrayValorVulnerabilidad[] = $av->valor;
                    }
                    $mayor_valor_vulnerabilidad = max($arrayValorVulnerabilidad);
                    if($analisis_control->valor > $mayor_valor_vulnerabilidad){

                        $analisis_vulnerabilidad = new AnalisisVulnerabilidad();
                        $analisis_vulnerabilidad->analisis_id = $analisis->id;
                        $analisis_vulnerabilidad->vulnerabilidad_id =$vulnerabilidad->id;
                        $analisis_vulnerabilidad->valor = $analisis_control->valor;
                        $analisis_vulnerabilidad->grupo_id = $_POST['grupo_id'];
                        $analisis_vulnerabilidad->fecha = Date('Y-m-d');
                        if(!$analisis_vulnerabilidad->save()){
                            throw new Exception("Error al valorar vulnerabilidad");
                        }
                    }
                }

                $amenaza = $vulnerabilidad->amenaza;
                $analisis_amenazas = AnalisisAmenaza::model()->findAllByAttributes(array('amenaza_id'=>$amenaza->id,
                                                                                         'analisis_id'=>$analisis->id));

                if(isset($analisis_vulnerabilidad)){
                    if(empty($analisis_amenazas)){

                            $analisis_amenaza = new AnalisisAmenaza();
                            $analisis_amenaza->analisis_id = $analisis->id;
                            $analisis_amenaza->amenaza_id = $amenaza->id;
                            $analisis_amenaza->valor = $analisis_vulnerabilidad->valor;
                            $analisis_amenaza->grupo_id = $_POST['grupo_id'];
                            $analisis_amenaza->fecha = Date('Y-m-d');
                            if(!$analisis_amenaza->save()){
                                throw new Exception("Error al valorar vulnerabilidad");
                            }
                    }else{
                        $arrayValorAmenaza =[];
                        foreach ($analisis_amenazas as $aa){
                            $arrayValorAmenaza[] = $aa->valor;
                        }
                        $mayor_valor_amenaza = max($arrayValorAmenaza);
                        if($analisis_vulnerabilidad->valor > $mayor_valor_amenaza){

                            $analisis_amenaza = new AnalisisAmenaza();
                            $analisis_amenaza->analisis_id = $analisis->id;
                            $analisis_amenaza->amenaza_id = $amenaza->id;
                            $analisis_amenaza->valor = $analisis_control->valor;
                            $analisis_amenaza->grupo_id = $_POST['grupo_id'];
                            $analisis_amenaza->fecha = Date('Y-m-d');
                            if(!$analisis_amenaza->save()){
                                throw new Exception("Error al valorar vulnerabilidad");
                            }
                        }
                    }
                }

                $transaction->commit();
                $datos = ['error'=>0,'msj'=>'Valoracion del control realizada con exito'];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $transaction->rollback();
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
            }


        }
    }
}
