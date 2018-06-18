<?php

class ActivoController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete','getActivosPorTipo','getPadresEHijos','getPadresMultiples'),
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
        $model = new Activo;
        if (isset($_POST['Activo'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)){
                   $model->proyecto_id = $usuario->ultimo_proyecto_id;
                }else{
                    throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
                }
                $model->attributes = $_POST['Activo'];
                if (!$model->save()) {
                    throw new Exception("Error al crear activo");
                }
                if(isset($_POST['Activo']['areas']) && !empty($_POST['Activo']['areas'])){
                    foreach ($_POST['Activo']['areas'] as $area_id){
                          $activo_area = new ActivoArea();
                          $activo_area->activo_id = $model->id;
                          $activo_area->area_id = $area_id;
                          if(!$activo_area->save()){
                            throw new Exception("Error al crear relacion activo area");
                          }
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Activo creado con exito');
                $this->redirect(array('create'));
            }catch (Exception $exception){
                $transaction->rollBack();
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
        $activos_areas = ActivoArea::model()->findAllByAttributes(array('activo_id'=>$model->id));
        foreach ($activos_areas as $relacion){
            $model->areas[] = $relacion->area_id;
        }
        if (isset($_POST['Activo'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();

                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)){
                    $model->proyecto_id = $usuario->ultimo_proyecto_id;
                }else{
                    throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
                }

                $model->attributes = $_POST['Activo'];
                if (!$model->save()) {
                    throw new Exception("Error al actualizar activo");
                }
                foreach ($activos_areas as $relacion){
                    if(!$relacion->delete()){
                        throw new Exception("Error al eliminar relacion vieja");
                    }
                }

                if(isset($_POST['Activo']['areas']) && !empty($_POST['Activo']['areas'])){
                    foreach ($_POST['Activo']['areas'] as $area_id){
                        $activo_area = new ActivoArea();
                        $activo_area->activo_id = $model->id;
                        $activo_area->area_id = $area_id;
                        if(!$activo_area->save()){
                            throw new Exception("Error al crear relacion activo area");
                        }
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Activo actualizado con exito');
                $this->redirect(array('admin'));
            }catch (Exception $exception){
                $transaction->rollBack();
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
                $grupo_activo = GrupoActivo::model()->findByAttributes(['activo_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Este activo ya posee las asociaciones realizadas");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el activo";
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
        $dataProvider = new CActiveDataProvider('Activo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Activo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Activo']))
            $model->attributes = $_GET['Activo'];

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
        $model = Activo::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'activo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetActivosPorTipo(){
        if(isset($_POST['grupo_id'])){
            if(!empty($_POST['grupo_id'])){
                $grupo = Grupo::model()->findByPk($_POST['grupo_id']);
                $activos = Activo::model()->findAllByAttributes(array('tipo_activo_id'=>$grupo->tipo_activo_id,'proyecto_id'=>$grupo->proyecto_id));
                $tipoActivo = TipoActivo::model()->findByPk($grupo->tipo_activo_id);
            }else{
                $activo = Activo::model()->findByPk($_POST['activo_id']);
                $activos = Activo::model()->findAllByAttributes(array('tipo_activo_id'=>$activo->tipo_activo_id,'proyecto_id'=>$activo->proyecto_id));
                $tipoActivo = TipoActivo::model()->findByPk($activo->tipo_activo_id);
            }

            $datos = array('activos'=>$activos,'tipoActivo'=>$tipoActivo);
            echo CJSON::encode($datos);
            die();
        }
    }
    public function actionGetPadresEHijos(){
        if(isset($_POST['analisis_id'])){
            $analisis = Analisis::model()->findByPk($_POST['analisis_id']);
            $padres = Activo::model()->getPadresDisponibles($analisis->id,$analisis->proyecto_id);
            $hijos = Activo::model()->getHijosDisponibles($analisis->id,$analisis->proyecto_id);
            $datos = ['hijos'=>$hijos,'padres'=>$padres];
            echo CJSON::encode($datos);
            die();
        }
    }
    public function actionGetPadresMultiples(){
        if(isset($_POST['activo_padre_id'])){
            $queryPadres = "select a.*, d.id as dependencia_id from 
                             dependencia d 
                             inner join activo a on d.activo_padre_id = a.id
                             where d.activo_id =".$_POST['activo_padre_id']." 
                             and d.analisis_id =".$_POST['analisis_id']."
                             group by d.numero
                             ";
            $command = Yii::app()->db->createCommand($queryPadres);
            $padres = $command->queryAll($queryPadres);
            $datos = ['cantidad'=>count($padres),'padres'=>$padres];
            echo CJSON::encode($datos);
            die();
        }
    }
}
