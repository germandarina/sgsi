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
                                    'verValoracion','gridControles','guardarValorControl','getGrupoActivo','eliminarGrupoActivo',
                                    'guardarValorAmenaza','guardarRiesgoAceptable','evaluarActivos','getActuacion','crearActualizarActuacion',
                                    'delete','exportarGestionDeRiegosExcel','exportarGestionDeRiegosPDF','buscarPorNombre'),
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
        $model = $this->loadModel($id);
        $grupo_activo = new GrupoActivo();
        $grupo_activo->analisis_id = $model->id;
        $dependencia = new Dependencia();
        $dependencia->analisis_id = $model->id;
        $dependenciasPadres = Dependencia::model()->findAllByAttributes(['activo_padre_id'=>NULL,'analisis_id'=>$model->id]);
        $amenaza = new Amenaza();
        if (isset(Yii::app()->session['filtro'])) {
            $amenaza->attributes = Yii::app()->session['filtro'];
        }
        $amenaza->analisis_id = $model->id;
        if(isset($_GET['Amenaza'])){
            $amenaza->nombre = $_GET['Amenaza']['nombre'];
            $amenaza->grupo_nombre = $_GET['Amenaza']['grupo_nombre'];
            $amenaza->tipo_activo_id = $_GET['Amenaza']['tipo_activo_id'];
            $amenaza->activo_nombre = $_GET['Amenaza']['activo_nombre'];
            Yii::app()->session['filtro'] = $_GET['Amenaza'];
        }


        if (isset($_GET['ajax'])) {
            if (isset($_GET['Amenaza_page'])) {
                Yii::app()->session['paginado'] = ($_GET['Amenaza_page'] - 1);
            } else {
                Yii::app()->session['paginado'] = 0;
            }

        }


        $this->render('view', array(
            'model' => $model,'grupo_activo'=>$grupo_activo,'dependencia'=>$dependencia,'dependenciasPadres'=>$dependenciasPadres,
            'amenaza'=>$amenaza
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

            try{
                $transaction = Yii::app()->db->beginTransaction();

                $usuario = User::model()->getUsuarioLogueado();
                if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
                    throw new Exception('Debe seleccionar un proyecto para empezar a trabajar');
                }
                $model->proyecto_id = $usuario->ultimo_proyecto_id;
                $model->attributes = $_POST['Analisis'];
                $model->fecha = Utilities::MysqlDateFormat($model->fecha);

                if (!$model->save()) {
                    throw new Exception("Error al crear analisis");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Analisis creado con exito');
                $this->redirect(array('update','id'=>$model->id));
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
        $model->fecha = Utilities::ViewDateFormat($model->fecha);
        if (isset($_POST['Analisis'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();

                $usuario = User::model()->getUsuarioLogueado();
                if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
                    throw new Exception('Debe seleccionar un proyecto para empezar a trabajar');
                }
                $model->proyecto_id = $usuario->ultimo_proyecto_id;
                $model->attributes = $_POST['Analisis'];
                $model->fecha = Utilities::MysqlDateFormat($model->fecha);

                if (!$model->save()) {
                    throw new Exception("Error al actualizar analisis");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Analisis actualizado con exito');
                $this->redirect(array('update','id'=>$model->id));
            }catch (Exception $exception){
                $transaction->rollback();
                Yii::app()->user->setNotification('error',$exception->getMessage());
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
                $grupo_activo = GrupoActivo::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este analisis esta asociado a un grupo");
                }

                $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($analisis_amenaza)){
                    throw new Exception("Error. Este analisis esta asociado a una amenaza");
                }

                $analisis_control = AnalisisControl::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($analisis_control)){
                    throw new Exception("Error. Este analisis esta asociado a un control");
                }

                $analisis_riesgo = AnalisisRiesgo::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($analisis_riesgo)){
                    throw new Exception("Error. Este analisis esta asociado a un riesgo");
                }

                $analisis_vulnerabilidad = AnalisisVulnerabilidad::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($analisis_vulnerabilidad)){
                    throw new Exception("Error. Este analisis esta asociado a un riesgo");
                }

                $dependecia = Dependencia::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($dependecia)){
                    throw new Exception("Error. Este analisis esta asociado a una dependencia");
                }

                $plan = Plan::model()->findByAttributes(['analisis_id'=>$id]);
                if(!is_null($plan)){
                    throw new Exception("Error. Este analisis esta asociado a un plan");
                }

                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el analisis";
                $datos = ['error'=>0,'msj'=>$data];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $msj = $exception->getMessage();
                $datos = ['error'=>1,'msj'=>$msj];
                echo CJSON::encode($datos);
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
        $usuario = User::model()->getUsuarioLogueado();
        if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
            Yii::app()->user->setNotification('error','Seleccione un proyecto');
            $this->redirect(array('/'));
        }
        $model->proyecto_id = $usuario->ultimo_proyecto_id;
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
        if ($model === null) {
            Yii::app()->user->setNotification('error','Acceso denegado');
            $this->redirect(array('/'));
           // throw new CHttpException(404, 'The requested page does not exist.');
        }
        $usuario = User::model()->getUsuarioLogueado();
        if(!is_null($usuario)){
           if($model->proyecto_id != $usuario->ultimo_proyecto_id){
               Yii::app()->user->setNotification('error','Acceso denegado');
               $this->redirect(array('/'));
           }
        }else{
            $this->redirect(array('/'));
        }

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
                $analisis = $this->loadModel($_POST['analisis_id']);
                $nuevogrupo = false;
                if(!empty($_POST['grupo_id'])){
                    $grupo_id = $_POST['grupo_id'];
                }else{
                    $grupo_id =NULL;
                }
                if(!empty($_POST['grupo_activo_id'])){
                    $grupo_activo = GrupoActivo::model()->findByPk($_POST['grupo_activo_id']);
                    $dependencia = Dependencia::model()->findByAttributes(['analisis_id'=>$grupo_activo->analisis_id,'activo_id'=>$grupo_activo->activo_id]);
                    if(!empty($dependencia)){
                        throw new Exception("Existe una dependencia relacionada al grupo activo seleccionado");
                    }
                }else{
                    $grupo_activo_existente = GrupoActivo::model()->findByAttributes(array('analisis_id'=>$analisis->id,'activo_id'=>$_POST['activo_id']));
                    if(!is_null($grupo_activo_existente)){
                        throw new Exception("El activo seleccionado ya se encuentra asociado.");
                    }
                    $grupo_activo = new GrupoActivo();
                    $nuevogrupo = true;
                }

                $grupo_activo->analisis_id = $analisis->id;
                $grupo_activo->grupo_id = $grupo_id;
                $grupo_activo->activo_id = $_POST['activo_id'];
                if($_POST['confidencialidad'] != ""){
                    $grupo_activo->confidencialidad = $_POST['confidencialidad'];
                }else{
                    $grupo_activo->confidencialidad = NULL;
                }
                if($_POST['trazabilidad'] != ""){
                    $grupo_activo->trazabilidad = $_POST['trazabilidad'];
                }else{
                    $grupo_activo->trazabilidad = NULL;
                }
                if($_POST['disponibilidad'] != ""){
                    $grupo_activo->disponibilidad = $_POST['disponibilidad'];

                }else{
                    $grupo_activo->disponibilidad = NULL;
                }
                if($_POST['integridad'] != ""){
                    $grupo_activo->integridad = $_POST['integridad'];

                }else{
                    $grupo_activo->integridad = NULL;
                }

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
                if($nuevogrupo){
                    $grupo_activo_log                   = new GrupoActivoLog();
                    $grupo_activo_log->grupo_activo_id  = $grupo_activo->id;
                    $grupo_activo_log->valor_anterior   = $valor_anterior;
                    $grupo_activo_log->valor_nuevo      = $grupo_activo->valor;
                    if(!$grupo_activo_log->save()){
                        throw new Exception("Error al guardar log de grupo activo");
                    }
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
                foreach ($_POST['activo_id'] as $hijo_id){
                    $dependenciaError = Dependencia::model()->findByAttributes(['activo_padre_id'=>$hijo_id,'activo_id'=>$_POST['activo_padre_id']]);
                    if(!is_null($dependenciaError)){
                        throw new Exception("No se puede crear este tipo de dependencia. ");
                    }
                }
                $arrayValoresHijos = [];
                $grupo_activo_padre = GrupoActivo::model()->findByAttributes(array('activo_id'=>$_POST['activo_padre_id'],'analisis_id'=>$_POST['analisis_id']));

                if($_POST['activo_rama_id'] != ""){
                    $dependeciaRama = Dependencia::model()->findByPk($_POST['activo_rama_id']);

                    $dependenciaPadre = Dependencia::model()->findByAttributes(array('activo_id'=>$_POST['activo_padre_id'],
                                                                                    'analisis_id'=>$_POST['analisis_id']
                                                                                    ,'numero'=>$dependeciaRama->numero));
                }else{
                    $dependenciaPadre = Dependencia::model()->findByAttributes(array('activo_id'=>$_POST['activo_padre_id'],
                                                                        'analisis_id'=>$_POST['analisis_id']));
                }

                if(is_null($dependenciaPadre)){
                    $numerador = Numerador::model()->findByPk(1);
                    $dependenciaPadre = new Dependencia();
                    $dependenciaPadre->analisis_id = $_POST['analisis_id'];
                    $dependenciaPadre->activo_id = $_POST['activo_padre_id'];
                    $dependenciaPadre->activo_padre_id = NULL;
                    $dependenciaPadre->numero = $numerador->numero;
                    if(!$dependenciaPadre->save()){
                        throw new Exception("Error al crear dependencia");
                    }
                    $numerador->numero = $numerador->numero +1;
                    if(!$numerador->save()){
                        throw new Exception("Error al actualizar numerador");
                    }
                }

                foreach ($_POST['activo_id'] as $hijo_id){
                    $dependenciaHija = new Dependencia();
                    $dependenciaHija->analisis_id = $_POST['analisis_id'];
                    $dependenciaHija->activo_id = $hijo_id;
                    $dependenciaHija->activo_padre_id = $_POST['activo_padre_id'];
                    $dependenciaHija->numero = $dependenciaPadre->numero;
                    if(!$dependenciaHija->save()){
                        throw new Exception("Error al crear dependencia");
                    }
                    $grupo_activo_hijo = GrupoActivo::model()->findByAttributes(array('activo_id'=>$hijo_id,'analisis_id'=>$_POST['analisis_id']));
                    $arrayValoresHijos[$grupo_activo_hijo->id] = $grupo_activo_hijo->valor;
                    $arrayDependenciasHijas[] = $dependenciaHija->id;
                }
                $valores = "";
                $valoresPadres = GrupoActivo::getValoresPadres($_POST['analisis_id'],$dependenciaPadre->activo_padre_id,$valores);
                if($valoresPadres == "Es Padre"){
                    $mayor_valor = $grupo_activo_padre->valor;
                }else{
                    $valoresPadres = explode('/',$valoresPadres);
                    $mayor_valor = max($valoresPadres);
                }
                if(!empty($arrayValoresHijos)){
                    foreach ($arrayValoresHijos as $i => $fila){
                        $gah = GrupoActivo::model()->findByPk($i);
                        if((int)$mayor_valor > (int)$fila){
                            // busco si ese activo esta como hijo en otra rama distinta. traigo el valor de esa rama
                            // comparo los valores,si el valor de la rama nueva es mayor, el activo toma ese valor.
                            $id_dependencias    = implode(',',$arrayDependenciasHijas);
                            $id_dependencias    .= ', '.$dependenciaPadre->id;
                            $id_dependencias    = trim($id_dependencias,',');
                            $otrasDependencias  = Analisis::model()->getOtrasDependencias($_POST['analisis_id'],$id_dependencias,$gah->activo_id);
                            if(!empty($otrasDependencias)){
                                 $valores = "";
                                 $arrayMayoresValores = [];
                                 foreach ($otrasDependencias as $dep){
                                     $valoresPadres = GrupoActivo::getValoresPadres($_POST['analisis_id'],$dep['activo_padre_id'],$valores);
                                     $grupo_aux     = GrupoActivo::model()->findByAttributes(['activo_id'=>$dep['activo_id'],'analisis_id'=>$_POST['analisis_id']]);
                                     if($valoresPadres == "Es Padre"){
                                         $arrayMayoresValores[] = $grupo_aux->valor;
                                     }else{
                                         $valoresPadres = explode('/',$valoresPadres);
                                         $arrayMayoresValores[] = max($valoresPadres);
                                     }
                                 }
                                 $maximoValor = max($arrayMayoresValores);
                                 if($maximoValor >= $mayor_valor) {
                                     $gah->valor = $maximoValor;
                                 }else {
                                     $gah->valor = $mayor_valor;
                                 }
                                 if(!$gah->save()){
                                     throw new Exception("Error al actualizar valor de activo hijo");
                                 }
                            }else{
                                $gah->valor= $mayor_valor;
                                if(!$gah->save()){
                                    throw new Exception("Error al actualizar valor de activo hijo");
                                }
                            }
                            $grupo_activo_log                   = new GrupoActivoLog();
                            $grupo_activo_log->grupo_activo_id  = $gah->id;
                            $grupo_activo_log->valor_anterior   = $fila;
                            $grupo_activo_log->valor_nuevo      = $mayor_valor;
                            if(!$grupo_activo_log->save()){
                                throw new Exception("Error al guardar log de grupo activo");
                            }
                        }
                    }
                }
                $transaction->commit();
                $dependenciasPadres = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>NULL,'analisis_id'=>$_POST['analisis_id']));
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

    public function actionVerValoracion($id,$analisis_id,$grupo_activo_id,$grupo_id,$activo_id){
        $vulnerabilidad = new Vulnerabilidad();
        $amenaza = Amenaza::model()->findByPk($id);
        $analisis = $this->loadModel($analisis_id);
        $grupo_activo = GrupoActivo::model()->findByPk($grupo_activo_id);
        $grupo = Grupo::model()->findByPk($grupo_id);
        $activo = Activo::model()->findByPk($activo_id);
        $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(['amenaza_id'=>$id,
                                                                        'analisis_id'=>$analisis_id,
                                                                        'grupo_activo_id'=>$grupo_activo_id,
                                                                        'activo_id'=>$activo_id]);
        if (isset($_GET['Vulnerabilidad']))
            $vulnerabilidad->attributes = $_GET['Vulnerabilidad'];

        $this->render('verValoracion', array(
            'vulnerabilidad' => $vulnerabilidad,'analisis'=>$analisis,'grupo_activo'=>$grupo_activo,
            'grupo'=>$grupo,'activo'=>$activo,'analisis_amenaza'=>$analisis_amenaza,'amenaza'=>$amenaza
        ));
    }

    public function actionGridControles()
    {
        // partially rendering "_relational" view
        $vulnerabilidadId = Yii::app()->getRequest()->getParam('id');
        $controles = new Control();
        $controles->vulnerabilidad_id = $vulnerabilidadId;
        $controles->analisis_id = Yii::app()->getRequest()->getParam('analisis_id');
        $controles->grupo_activo_id = Yii::app()->getRequest()->getParam('grupo_activo_id');
        $analisis_id =  Yii::app()->getRequest()->getParam('analisis_id');
        $grupo_activo_id =  Yii::app()->getRequest()->getParam('grupo_activo_id');
        $analisis_amenaza_id = Yii::app()->getRequest()->getParam('analisis_amenaza_id');
        $this->renderPartial('gridControles', array(
            'id' => Yii::app()->getRequest()->getParam('id'),
            'controles' => $controles,'analisis_id'=>$analisis_id,'grupo_activo_id'=>$grupo_activo_id,
            'analisis_amenaza_id'=>$analisis_amenaza_id
        ));
    }

    public function actionGuardarValorControl(){
        if(isset($_POST['control_id'])){
            try{
                $transaction= Yii::app()->db->beginTransaction();
                $control = Control::model()->findByPk($_POST['control_id']);
                $analisis = $this->loadModel($_POST['analisis_id']);

                $analisis_control = AnalisisControl::model()->findByAttributes(['analisis_id'=>$analisis->id,'control_id'=>$control->id,
                                                                                'grupo_activo_id'=>$_POST['grupo_activo_id'],
                                                                                'analisis_amenaza_id'=>$_POST['analisis_amenaza_id']]);
                if(is_null($analisis_control)){
                    $analisis_control = new AnalisisControl();
                }
                $analisis_control->control_id = $control->id;
                $analisis_control->analisis_id = $analisis->id;
                $analisis_control->valor = $_POST['valor_control'];
                $analisis_control->grupo_activo_id = $_POST['grupo_activo_id'];
                $analisis_control->analisis_amenaza_id = $_POST['analisis_amenaza_id'];
                $analisis_control->fecha = Date('Y-m-d');
                if(!$analisis_control->save()){
                    throw new Exception("Error al guardar valoracion del control");
                }

                $vulnerabilidad = $control->vulnerabilidad;

                $analisis_vulnerabilidades = AnalisisVulnerabilidad::model()->findByAttributes(array('vulnerabilidad_id'=>$vulnerabilidad->id,
                                                                                                        'analisis_id'=>$analisis->id,
                                                                                                        'grupo_activo_id'=>$_POST['grupo_activo_id'],
                                                                                                        'analisis_amenaza_id'=>$_POST['analisis_amenaza_id']
                                                                                                    ));
                if(is_null($analisis_vulnerabilidades)){
                    $analisis_vulnerabilidad = new AnalisisVulnerabilidad();
                    $analisis_vulnerabilidad->analisis_id = $analisis->id;
                    $analisis_vulnerabilidad->vulnerabilidad_id =$vulnerabilidad->id;
                    $analisis_vulnerabilidad->valor = $analisis_control->valor;
                    $analisis_vulnerabilidad->grupo_activo_id = $_POST['grupo_activo_id'];
                    $analisis_vulnerabilidad->analisis_amenaza_id = $_POST['analisis_amenaza_id'];
                    $analisis_vulnerabilidad->fecha = Date('Y-m-d');
                    if(!$analisis_vulnerabilidad->save()){
                        throw new Exception("Error al valorar vulnerabilidad");
                    }
                }else{
                    $av = AnalisisVulnerabilidad::model()->findByAttributes(array('vulnerabilidad_id'=>$vulnerabilidad->id,
                                                                                                                'analisis_id'=>$analisis->id,
                                                                                                                'grupo_activo_id'=>$_POST['grupo_activo_id'],
                                                                                                                'analisis_amenaza_id'=>$_POST['analisis_amenaza_id']
                                                                                                            ),array('order'=>'id desc'));

                    if($analisis_control->valor > $av->valor){

                        $analisis_vulnerabilidad = new AnalisisVulnerabilidad();
                        $analisis_vulnerabilidad->analisis_id = $analisis->id;
                        $analisis_vulnerabilidad->vulnerabilidad_id =$vulnerabilidad->id;
                        $analisis_vulnerabilidad->valor = $analisis_control->valor;
                        $analisis_vulnerabilidad->grupo_activo_id = $_POST['grupo_activo_id'];
                        $analisis_vulnerabilidad->fecha = Date('Y-m-d');
                        $analisis_vulnerabilidad->analisis_amenaza_id = $_POST['analisis_amenaza_id'];
                        if(!$analisis_vulnerabilidad->save()){
                            throw new Exception("Error al valorar vulnerabilidad");
                        }
                    }else{
                        $controles = Control::model()->findAllByAttributes(['vulnerabilidad_id'=>$vulnerabilidad->id]);
                        $arrayValorControl = [];
                        foreach ($controles as $ctrl){
                            $an = AnalisisControl::model()->findByAttributes(['analisis_id'=>$analisis->id,'control_id'=>$ctrl->id,
                                                                                            'grupo_activo_id'=>$_POST['grupo_activo_id'],
                                                                                            'analisis_amenaza_id'=>$_POST['analisis_amenaza_id']]);
                            if(!is_null($an)){
                                $arrayValorControl[] = $an->valor;
                            }
                        }
                        $mayor_valor_control = max($arrayValorControl);
                        if($av->valor > $mayor_valor_control){
                            $analisis_vulnerabilidad = new AnalisisVulnerabilidad();
                            $analisis_vulnerabilidad->analisis_id = $analisis->id;
                            $analisis_vulnerabilidad->vulnerabilidad_id =$vulnerabilidad->id;
                            $analisis_vulnerabilidad->valor = $mayor_valor_control;
                            $analisis_vulnerabilidad->grupo_activo_id = $_POST['grupo_activo_id'];
                            $analisis_vulnerabilidad->fecha = Date('Y-m-d');
                            $analisis_vulnerabilidad->analisis_amenaza_id = $_POST['analisis_amenaza_id'];
                            if(!$analisis_vulnerabilidad->save()){
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

    public function actionGetGrupoActivo(){
        if(isset($_POST['grupo_activo_id'])){
            $grupo_activo = GrupoActivo::model()->findByPk($_POST['grupo_activo_id']);
            if(!is_null($grupo_activo->grupo)){
                $tipoActivo = TipoActivo::model()->findByPk($grupo_activo->grupo->tipo_activo_id);
            }else{
                $tipoActivo = TipoActivo::model()->findByPk($grupo_activo->activo->tipo_activo_id);
            }
            $datos = ['grupo_activo'=>$grupo_activo,'tipoActivo'=>$tipoActivo];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionEliminarGrupoActivo(){
        if(isset($_POST['grupo_activo_id'])){
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $grupo_activo = GrupoActivo::model()->findByPk($_POST['grupo_activo_id']);
                $analisis_id = $grupo_activo->analisis_id;
                $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo->id]);
                if(!is_null($analisis_amenaza)){
                    throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a las amenazas");
                }

                $analisis_control = AnalisisControl::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo->id]);
                if(!is_null($analisis_control)){
                    throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a los controles");
                }

                $analisis_vulne = AnalisisVulnerabilidad::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo->id]);
                if(!is_null($analisis_vulne)){
                    throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a las vulnerabilidades");
                }

                $analisis_rd = AnalisisRiesgoDetalle::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo->id]);
                if(!is_null($analisis_rd)){
                    throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a la gestion de riesgos");
                }

                $arrayHijosIds =[];
                $dependencias = Dependencia::model()->findAllByAttributes(['activo_id'=>$grupo_activo->activo_id,'analisis_id'=>$grupo_activo->analisis_id]);
                foreach ($dependencias as $dep){
                    $dep->getHijos($arrayHijosIds);
                    if(!in_array($dep->id,$arrayHijosIds)){
                        $arrayHijosIds[] = $dep->id;
                    }
                }
                if(!empty($arrayHijosIds)){
                    foreach ($arrayHijosIds as $ids){

                        $dependencia = Dependencia::model()->findByPk($ids);
                        $grupo_activo_colateral = GrupoActivo::model()->findByAttributes(['activo_id'=>$dependencia->activo_id,'analisis_id'=>$grupo_activo->analisis_id]);

                        $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo_colateral->id]);
                        if(!is_null($analisis_amenaza)){
                            throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a las amenazas");
                        }

                        $analisis_control = AnalisisControl::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo_colateral->id]);
                        if(!is_null($analisis_control)){
                            throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a los controles");
                        }

                        $analisis_vulne = AnalisisVulnerabilidad::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo_colateral->id]);
                        if(!is_null($analisis_vulne)){
                            throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a las vulnerabilidades");
                        }

                        $analisis_rd = AnalisisRiesgoDetalle::model()->findByAttributes(['grupo_activo_id'=>$grupo_activo_colateral->id]);
                        if(!is_null($analisis_rd)){
                            throw new Exception("Error al eliminar asociacion. Ya posee datos cargados relacionados a la gestion de riesgos");
                        }

                        if(!$grupo_activo_colateral->save()){
                            throw new Exception("Error al actualizar valor grupo activo");
                        }

                        $primerLog = GrupoActivoLog::model()->findByAttributes(['valor_anterior'=>0,'grupo_activo_id'=>$grupo_activo_colateral->id]);
                        $grupo_activo_colateral->valor = $primerLog->valor_nuevo;

                        $logs_colaterales = GrupoActivoLog::model()->findAllByAttributes(['grupo_activo_id'=>$grupo_activo_colateral->id]);
                        foreach ($logs_colaterales as $lc){
                            if($lc->id != $primerLog->id){
                                if(!$lc->delete()){
                                    throw new Exception("Error al eliminar log colateral");
                                }
                            }
                        }
                        if(!$dependencia->delete()){
                            throw new Exception("Error al eliminar dependencias");
                        }
                    }
                }
                $logs = GrupoActivoLog::model()->findAllByAttributes(['grupo_activo_id'=>$grupo_activo->id]);
                if(!empty($logs)){
                    foreach ($logs as $log){
                        if(!$log->delete()){
                            throw new Exception("Error al eliminar log de grupo activo");
                        }
                    }
                }

                if(!$grupo_activo->delete()){
                    throw new Exception("Error al eliminar grupo activo");
                }

                $transaction->commit();
                $dependenciasPadres = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>NULL,'analisis_id'=>$analisis_id));
                $html = $this->renderPartial('dependenciasPadres', array('dependenciasPadres'=>$dependenciasPadres), true);
                $datos = ['error'=>0,'msj'=>'Grupo activo eliminado con exito','html'=>$html];
                echo CJSON::encode($datos);
                die();
            }catch (Exception $exception){
                $transaction->rollBack();
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
                die();
            }
        }
    }

    public function actionGuardarValorAmenaza(){
        if(isset($_POST['amenaza_id'])){
            try{
                $analisis = $this->loadModel($_POST['analisis_id']);
                $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(['analisis_id'=>$analisis->id,
                                                                                'amenaza_id'=>$_POST['amenaza_id'],
                                                                                'grupo_activo_id'=>$_POST['grupo_activo_id'],
                                                                                'activo_id'=>$_POST['activo_id']]);
                if(is_null($analisis_amenaza)){
                    $analisis_amenaza = new AnalisisAmenaza();
                }
                $analisis_amenaza->analisis_id = $analisis->id;
                $analisis_amenaza->amenaza_id = $_POST['amenaza_id'];
                $analisis_amenaza->valor = $_POST['amenaza_valor'];
                $analisis_amenaza->grupo_activo_id = $_POST['grupo_activo_id'];
                $analisis_amenaza->activo_id = $_POST['activo_id'];
                $analisis_amenaza->fecha = Date('Y-m-d');
                if(!$analisis_amenaza->save()){
                    throw new Exception("Error al valorar vulnerabilidad");
                }
                $datos = ['error'=>0,'msj'=>'Valoracion de amenaza realizada con exito'];
                echo CJSON::encode($datos);
                die();
            }catch (Exception $exception){
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
                die();
            }

        }
    }

    public function actionGuardarRiesgoAceptable(){
        if(isset($_POST['analisis_id'])){
            try{
                $analisis_riesgo = AnalisisRiesgo::model()->findByAttributes(array('analisis_id'=>$_POST['analisis_id']));
                if(!is_null($analisis_riesgo)){
                    $analisis_riesgo->riesgo_aceptable = $_POST['riesgo_aceptable'];
                    if(!$analisis_riesgo->save()){
                        throw new Exception("Error al cargar el valor de riesgo aceptable");
                    }
                }else{
                    $analisis_riesgo = new AnalisisRiesgo();
                    $analisis_riesgo->riesgo_aceptable = $_POST['riesgo_aceptable'];
                    $analisis_riesgo->fecha = Date('Y-m-d');
                    $analisis_riesgo->analisis_id = $_POST['analisis_id'];
                    if(!$analisis_riesgo->save()){
                        throw new Exception("Error al crear analisis de riesgo con riesgo aceptable");
                    }
                }
                $datos = ['error'=>0,'msj'=>'Riesgo aceptable guardado con exito'];
                echo CJSON::encode($datos);
                die();
            }catch (Exception $exception){
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
                die();
            }

        }
    }

    public function actionEvaluarActivos(){
        if(isset($_POST['analisis_id'])){
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $analisis =  $this->loadModel($_POST['analisis_id']);
                $analisis_riesgo = AnalisisRiesgo::model()->findByAttributes(array('analisis_id'=>$_POST['analisis_id']));
                if(is_null($analisis_riesgo)) {
                    $analisis_riesgo = new AnalisisRiesgo();
                    $analisis_riesgo->riesgo_aceptable = "";
                    $analisis_riesgo->fecha = Date('Y-m-d');
                    $analisis_riesgo->analisis_id = $_POST['analisis_id'];
                    if(!$analisis_riesgo->save()){
                        throw new Exception("Error al crear analisis de riesgo");
                    }
                }

                $grupos_activos = GrupoActivo::model()->findAllByAttributes(array('analisis_id'=>$analisis_riesgo->analisis_id));
                if(!empty($grupos_activos)){
                    foreach ($grupos_activos as $ga){
                        $valor_activo = $ga->valor;
                        $analisis_amenaza =  AnalisisAmenaza::model()->findByAttributes(array('analisis_id'=>$_POST['analisis_id'],
                                                                                                'grupo_activo_id'=>$ga->id,
                                                                                                'activo_id'=>$ga->activo_id ),
                                                                                                array('order'=>'valor desc'));
                        if(is_null($analisis_amenaza)){
                            throw new Exception("Hay amenazas sin valorar. Valore Todas las amenazas para realizar el analisis");
                        }

                        if(!is_null($analisis_amenaza)){
                            $valor_amenaza              = $analisis_amenaza->valor;
                            $valor_vulnerabilidad       = (int) Vulnerabilidad::model()->getMayorValorVulnerabilidad($_POST['analisis_id'],$ga->id);
                            $valor_riesgo_activo        = $valor_activo * $valor_amenaza * $valor_vulnerabilidad;
                            $analisis_riesgo_detalle    = AnalisisRiesgoDetalle::model()->findByAttributes(array('analisis_riesgo_id'=>$analisis_riesgo->id
                                                                                                                ,'grupo_activo_id'=>$ga->id));
                            if(!is_null($analisis_riesgo_detalle))
                            {
                                if($analisis_riesgo_detalle->nivel_riesgo_id != Activo::model()->getNivelDeRiesgo($valor_riesgo_activo,$analisis->proyecto_id))
                                {
                                    $analisis_riesgo_detalle->valor_activo  = $valor_riesgo_activo;
                                    if(!$analisis_riesgo_detalle->save())
                                    {
                                        throw new Exception("Error al crear analisis de riesgo detalle");
                                    }
                                }
                            }
                            else
                            {
                                $analisis_riesgo_detalle                            = new AnalisisRiesgoDetalle();
                                $analisis_riesgo_detalle->analisis_riesgo_id        = $analisis_riesgo->id;
                                $analisis_riesgo_detalle->grupo_activo_id           = $ga->id;
                                $analisis_riesgo_detalle->valor_activo              = $valor_riesgo_activo;
                            }

                            $analisis_riesgo_detalle->valor_confidencialidad    = $ga->confidencialidad * $valor_amenaza * $valor_vulnerabilidad;
                            $analisis_riesgo_detalle->valor_disponibilidad      = $ga->disponibilidad * $valor_amenaza * $valor_vulnerabilidad;
                            $analisis_riesgo_detalle->valor_integridad          = $ga->integridad * $valor_amenaza * $valor_vulnerabilidad;
                            $analisis_riesgo_detalle->valor_trazabilidad        = $ga->trazabilidad * $valor_amenaza * $valor_vulnerabilidad;
                            $analisis_riesgo_detalle->nivel_riesgo_id           = Activo::model()->getNivelDeRiesgo($valor_riesgo_activo,$analisis->proyecto_id);
                            if(!$analisis_riesgo_detalle->save()){
                                throw new Exception("Error al crear analisis de riesgo detalle");
                            }
                        }
                    }
                }else{
                    throw new Exception("No existen activos cargados para este analisis");
                }
                $transaction->commit();
                $datos = ['error'=>0,'msj'=>'Proceso Realizado con Exito'];
                echo CJSON::encode($datos);
                die();
            }catch (Exception $exception){
                $transaction->rollback();
                $datos = ['error'=>1,'msj'=>$exception->getMessage()];
                echo CJSON::encode($datos);
                die();
            }
        }

    }

    public function actionGetActuacion(){
        if(isset($_POST['analisis_riesgo_detalle_id'])){
            $actuacion = ActuacionRiesgo::model()->findByAttributes(['analisis_riesgo_detalle_id'=>$_POST['analisis_riesgo_detalle_id']]);
            if(!is_null($actuacion)){
                $actuacion->fecha = Utilities::ViewDateFormat($actuacion->fecha);

                $datos = ['actuacion'=>$actuacion];
                echo CJSON::encode($datos);
                die();
            }
            $actuacion = new ActuacionRiesgo();

            $datos = ['actuacion'=>$actuacion];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionCrearActualizarActuacion()
    {
        if(isset($_POST['analisis_riesgo_detalle_id']))
        {
            $actuacion = ActuacionRiesgo::model()->findByAttributes(['analisis_riesgo_detalle_id'=>$_POST['analisis_riesgo_detalle_id']]);
            if(is_null($actuacion))
            {
                $actuacion                              = new ActuacionRiesgo();
                $actuacion->analisis_riesgo_detalle_id  = $_POST['analisis_riesgo_detalle_id'];
            }
            $actuacion->fecha       = Utilities::MysqlDateFormat($_POST['fecha']);
            $actuacion->descripcion = $_POST['descripcion'];
            $actuacion->accion      = $_POST['accion'];
            if($actuacion->accion == ActuacionRiesgo::ACCION_TRANSFERIR){
                $actuacion->accion_transferir = $_POST['accion_transferir'];
            }
            if(!$actuacion->save()){
                $datos = ['error'=>1,'msj'=>'Error al crear/actualizar actuacion'];
                echo CJSON::encode($datos);
                die();
            }
            $datos = ['error'=>0,'msj'=>'Actuacion creada/actualizar con exito'];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionExportarGestionDeRiegosExcel()
    {
        $analisis_riesgo    = AnalisisRiesgo::model()->findByAttributes(array('analisis_id'=>$_GET['analisis_id']));
        $detalles           = AnalisisRiesgoDetalle::model()->findAllByAttributes(['analisis_riesgo_id'=>$analisis_riesgo->id]);

        set_time_limit(0);
        ini_set('memory_limit', '20000M');
        $content = "<br><h3>Gestion de Riesgos</h3>";
        $content .= "<h3>Fecha: " . date("d/m/Y") . "</h3>";
        $content .= $this->renderPartial('_gestionDeRiesgos', array('detalles' => $detalles), true);
        $nombreArchivo = "Gestion de Riesgos.xls";

        Yii::app()->request->sendFile($nombreArchivo, $content);
        Yii::app()->user->setFlash('success', 'El informe fue generado correctamente');
    }

    public function actionExportarGestionDeRiegosPDF(){
        ob_clean();
        $analisis_riesgo = AnalisisRiesgo::model()->findByAttributes(array('analisis_id'=>$_GET['analisis_id']));
        $detalles        = AnalisisRiesgoDetalle::model()->findAllByAttributes(['analisis_riesgo_id'=>$analisis_riesgo->id]);

        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'L', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("DIME");
        $pdf->SetTitle('Gestion de Riesgos');
        $pdf->SetKeywords("GestionDeRiesgos");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "", 9);
//        $pdf->Image(__DIR__ . '/../../images/ladyeva_logo.jpg', 1.5, 1.2, 2.5, 2.5, 'JPG', '', '', false, 300, '', false, false, 0, '', false, false);
//        $pdf->Rect(10.5, 1, 0, 4, 'DF');
        $html = $this->renderPartial('_gestionDeRiesgos', array('detalles' => $detalles), true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("Gestion de Riesgos.pdf", "I");
    }

    public function actionBuscarPorNombre(){
        if (isset($_GET['q'])) {
            $data       = [];
            $criteria   = new CDbCriteria;
            if(Yii::app()->user->model->isAuditor())
            {
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                $criteria->addCondition('t.proyecto_id = '.$usuario->ultimo_proyecto_id);
            }
            $criteria->addCondition('t.nombre LIKE :param ');
            $criteria->params = array(':param' => "%" . $_GET['q'] . "%");
            $analisis = Analisis::model()->findAll($criteria);
            if (empty($analisis))
            {
                $datos["existe"] = 0;
            }
            else
            {
                $data = [];
                foreach ($analisis as $fila)
                {
                    $data[] = [
                        'id'    => $fila->id,
                        'text'  => $fila->nombre,
                    ];
                }
            }
            echo CJSON::encode($data);
        }
    }
}
