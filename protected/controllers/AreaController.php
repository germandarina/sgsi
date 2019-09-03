<?php

class AreaController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete','getProcesos','getPersonal','getProcesosModal'),
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
        $model = new Area;
        if (isset($_POST['Area'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $usuario = User::model()->getUsuarioLogueado();
                if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)) {
                    throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
                }

                $model->attributes = $_POST['Area'];
                if (!$model->save()) {
                    throw new Exception("Error al guardar area");
                }
                $area_proyecto = new AreaProyecto();
                $area_proyecto->area_id = $model->id;
                $area_proyecto->proyecto_id = $usuario->ultimo_proyecto_id;
                if(!$area_proyecto->save()){
                    throw new Exception("Error al crear area_proyecto");
                }

                $transaction->commit();
                Yii::app()->user->setNotification('success', 'El area fue creada con exito');
                $this->redirect(array('create'));
            }catch (Exception $exception) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $exception->getMessage());
                $this->redirect(array('admin'));
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
        $proceso = new Proceso();
        $proceso->area_id_2 = $model->id;

        if (isset($_POST['Area'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $usuario = User::model()->getUsuarioLogueado();
                if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)) {
                    throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
                }

                $model->attributes = $_POST['Area'];
                if (!$model->save()) {
                    throw new Exception("Error al actualizar area");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success', 'El area fue actualizada con exito');
                $this->redirect(array('create'));
            }catch (Exception $exception) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $exception->getMessage());
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,'proceso'=>$proceso
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
        try {
            $proceso = Proceso::model()->findByAttributes(['area_id' => $id]);
            if (!is_null($proceso)) {
                throw new Exception("Error. Esta area esta relacionada a un proceso");
            }
            $activo_area = ActivoArea::model()->findByAttributes(['area_id' => $id]);
            if (!is_null($activo_area)) {
                throw new Exception("Error. Esta area esta relacionada a un activo");
            }

            $personal = Personal::model()->findByAttributes(['area_id'=>$id]);
            if(!is_null($personal)){
                throw new Exception("Error. Esta area esta relacionada a un personal");
            }

            $usuario = User::model()->getUsuarioLogueado();
            if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)) {
                throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
            }
            $area_proyecto = AreaProyecto::model()->findAllByAttributes(['area_id'=>$id,'proyecto_id'=>$usuario->ultimo_proyecto_id]);
            if(!empty($area_proyecto)){
                foreach ($area_proyecto as $ap){
                    if(!$ap->delete()){
                        throw new Exception("Error al eliminar area_proyecto");
                    }
                }
            }
            // SOLO ELIMINAMOS LA RELACION ENTRE AREA Y PROYECTO. NO ELIMINAMOS EL AREA
            $data = "Se elimino correctamente el area";
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
        $dataProvider = new CActiveDataProvider('Area');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Area('search');
        $model->unsetAttributes();  // clear any default values
        $usuario = User::model()->getUsuarioLogueado();
        if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
            Yii::app()->user->setNotification('error','Seleccione un proyecto');
            $this->redirect(array('/'));
        }
        $model->proyecto_id = $usuario->ultimo_proyecto_id;
        if (isset($_GET['Area']))
            $model->attributes = $_GET['Area'];

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
        $model = Area::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $areas_por_proyecto =  Area::model()->getAreasDisponibles();
        if(!empty($areas_por_proyecto)){
            $bandera = false;
            foreach ($areas_por_proyecto as $area){
                if($area->id == $id){
                    $bandera = true;
                    break;
                }
            }
            if(!$bandera){
                Yii::app()->user->setNotification('error','Acceso denegado');
                $this->redirect(array('/'));
            }
        }else{
            Yii::app()->user->setNotification('error','Acceso denegado');
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'area-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    public function actionGetProcesos(){
        if(isset($_POST['area_id'])){
            $model = $this->loadModel($_POST['area_id']);
            $procesos = $model->procesos;
            if(!empty($procesos)){
                $datos = ['procesos'=>$procesos];
            }else{
                $datos = ['procesos'=>''];
            }
            echo CJSON::encode($datos);
        }
    }

    public function actionGetPersonal(){
        if(isset($_POST['areas'])){
           $arrayPersonal = [];
           foreach ($_POST['areas'] as $area_id){
              $personal = Personal::model()->findAllByAttributes(array('area_id'=>$area_id));
              if(!empty($personal)){
                foreach ($personal as $persona){
                    $arrayPersonal[] = $persona;
                }
              }
           }
           $datos = ['personal'=>$arrayPersonal];
           echo CJSON::encode($datos);
        }
    }

    public function actionGetProcesosModal(){
        if (isset($_POST['area_id'])){
            $model = $this->loadModel($_POST['area_id']);
            $procesos = $model->procesos;
            $html = $this->renderPartial('_procesosPorArea', array('procesos'=>$procesos), true);
            echo CJSON::encode(['html'=>$html]);
            die();
        }
    }
}
