<?php

class ProyectoController extends Controller
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
                'actions' => array('create', 'update', 'admin','asignarProyecto', 'delete','panel'),
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
        $model = new Proyecto;
        if (isset($_POST['Proyecto'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();

                $model->attributes = $_POST['Proyecto'];
                if(empty($model->fecha)){
                    $model->addError('fecha','Debe seleccionar una fecha');
                    throw new Exception("Debe seleccionar una fecha");
                }
                $model->fecha = Utilities::MysqlDateFormat($model->fecha);
                if(!isset($_POST['Proyecto']['areas']) || empty($_POST['Proyecto']['areas'])){
                    $model->addError('areas','Debe seleccionar al menos 1 area para crear el proyecto');
                }
                if (!$model->save()) {
                    throw new Exception("Error al crear proyecto");
                }
                foreach ($_POST['Proyecto']['areas'] as $areaId){
                     $areaProyecto = new AreaProyecto();
                     $areaProyecto->area_id = $areaId;
                     $areaProyecto->proyecto_id = $model->id;
                     if(!$areaProyecto->save()){
                         throw new Exception("Error al crear relacion area proyecto");
                     }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','El proyecto fue creado con exito');
                $this->redirect(array('admin'));

            }catch (Exception $exception){
                $transaction->rollBack();
                Yii::app()->user->setNotification('error',$exception->getMessage());
                $model->fecha = null;
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
        $areasProyecto = AreaProyecto::model()->findAllByAttributes(array('proyecto_id'=>$model->id));
        if(!empty($areasProyecto)){
            foreach ($areasProyecto as $relacion){
                $model->areas[] = $relacion->area_id;
            }
        }

        if (isset($_POST['Proyecto'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Proyecto'];
                if(empty($model->fecha)){
                    $model->addError('fecha','Debe seleccionar una fecha');
                    throw new Exception("Debe seleccionar una fecha");
                }
                $model->fecha = Utilities::MysqlDateFormat($model->fecha);
                if(!isset($_POST['Proyecto']['areas']) || empty($_POST['Proyecto']['areas'])){
                    $model->addError('areas','Debe seleccionar al menos 1 area para crear el proyecto');
                    throw new Exception('Debe seleccionar al menos 1 area para crear el proyecto');
                }
                if (!$model->save()){
                    throw new Exception("Error al actualizar proyecto");
                }
                foreach ($areasProyecto as $relacion){
                    if(!$relacion->delete()){
                        throw new Exception("Error al eliminar relacion area proyecto");
                    }
                }
                foreach ($_POST['Proyecto']['areas']as $areaId){
                    $areaProyecto = new AreaProyecto();
                    $areaProyecto->area_id = $areaId;
                    $areaProyecto->proyecto_id = $model->id;
                    if(!$areaProyecto->save()){
                        throw new Exception("Error al crear relacion area proyecto");
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Proyecto actualizado con exito');
                $this->redirect(array('admin'));
            }catch (Exception $exception){
                $transaction->rollBack();
                Yii::app()->user->setNotification('error',$exception->getMessage());
                if($model->fecha != ""){
                    $model->fecha = Utilities::ViewDateFormat($model->fecha);
                }
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
                $grupo_activo = Activo::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este proyecto ya posee las asociaciones realizadas");
                }

                $grupo_activo = Grupo::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este proyecto ya posee las asociaciones realizadas");
                }

                $grupo_activo = Analisis::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este proyecto ya posee las asociaciones realizadas");
                }

                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el analisis";
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
        $dataProvider = new CActiveDataProvider('Proyecto');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Proyecto('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Proyecto']))
            $model->attributes = $_GET['Proyecto'];

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
        $model = Proyecto::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'proyecto-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAsignarProyecto(){
        if(isset($_POST['proyecto_id'])){
            $usuario = User::model()->findByPk(Yii::app()->user->model->id);
            $usuario->ultimo_proyecto_id = $_POST['proyecto_id'];
            if(!$usuario->save()){
                $datos =['error'=>1,'msj'=>'error al asignar proyecto.'];
                echo CJSON::encode($datos);
                die();
            }
            $url = Yii::app()->createUrl("/proyecto/panel", array("id" => $usuario->ultimo_proyecto_id));
            $datos =['error'=>0,'msj'=>'Proyecto asignado correctamente.','url'=>$url];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionPanel($id){
        $model = $this->loadModel($id);
        $this->render('panel', array('model' => $model,));
    }
}
