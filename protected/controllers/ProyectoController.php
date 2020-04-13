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
                if(!isset($_POST['Proyecto']['usuarios']) || empty($_POST['Proyecto']['usuarios'])){
                    $model->addError('usuarios','Debe seleccionar al menos 1 usuario para crear el proyecto');
                }
                if (!$model->save()) {
                    throw new Exception("Error al crear proyecto");
                }
                if(isset($_POST['Proyecto']['areas']) && !empty($_POST['Proyecto']['areas'])){
                    foreach ($_POST['Proyecto']['areas'] as $areaId){
                        $areaProyecto = new AreaProyecto();
                        $areaProyecto->area_id = $areaId;
                        $areaProyecto->proyecto_id = $model->id;
                        if(!$areaProyecto->save()){
                            throw new Exception("Error al crear relacion area proyecto");
                        }
                    }
                }

                if(isset($_POST['Proyecto']['usuarios']) && !empty($_POST['Proyecto']['usuarios'])){
                    foreach ($_POST['Proyecto']['usuarios'] as $usuarioId){
                        $proyectoUsuario = new ProyectoUsuario();
                        $proyectoUsuario->usuario_id = $usuarioId;
                        $proyectoUsuario->proyecto_id = $model->id;
                        if(!$proyectoUsuario->save()){
                            throw new Exception("Error al crear relacion proyecto usuario");
                        }
                        $usuario = User::model()->findByPk($usuarioId);
                        if(is_null($usuario->ultimo_proyecto_id)){
                            $usuario->ultimo_proyecto_id = $model->id;
                            if(!$usuario->save()) {
                                throw new Exception("Error al actualizar usuario, asignacion de proyecto");
                            }
                        }

                        $proyectoUsuarioExiste = ProyectoUsuario::model()->findByAttributes(['proyecto_id'=>$model->id,'usuario_id'=>Yii::app()->user->model->id]);
                        if(is_null($proyectoUsuarioExiste)){
                            $proyectoUsuario = new ProyectoUsuario();
                            $proyectoUsuario->usuario_id = Yii::app()->user->model->id;
                            $proyectoUsuario->proyecto_id = $model->id;
                            if(!$proyectoUsuario->save()){
                                throw new Exception("Error al crear relacion proyecto usuario");
                            }
                        }
                    }
                }
                $usuariosAdministradores = User::model()->getUsuariosAdministradores();
                if(!empty($usuariosAdministradores)){
                    foreach ($usuariosAdministradores as $admin){
                        if($admin['id'] != Yii::app()->user->model->id){
                            $proyectoUsuarioAdmin = ProyectoUsuario::model()->findByAttributes(['proyecto_id'=>$model->id,'usuario_id'=>$admin['id']]);
                            if(is_null($proyectoUsuarioAdmin)){
                                $proyectoUsuario = new ProyectoUsuario();
                                $proyectoUsuario->usuario_id = $admin['id'];
                                $proyectoUsuario->proyecto_id = $model->id;
                                if(!$proyectoUsuario->save()){
                                    throw new Exception("Error al crear relacion proyecto usuario");
                                }
                            }
                        }
                    }
                }
                $usuarioLogueado = Yii::app()->user->model;
                $usuarioLogueado->ultimo_proyecto_id = $model->id;
                if(!$usuarioLogueado->save()){
                    throw new Exception("Error al actualizar usuario con proyecto creado");
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

        $proyectoUsuario = ProyectoUsuario::model()->findAllByAttributes(array('proyecto_id'=>$model->id));
        if(!empty($proyectoUsuario)){
            foreach ($proyectoUsuario as $relacion){
                $model->usuarios[] = $relacion->usuario_id;
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
                if(!isset($_POST['Proyecto']['areas']) || empty($_POST['Proyecto']['areas'])){
                    $model->addError('areas','Debe seleccionar al menos 1 area');
                }

                if(!isset($_POST['Proyecto']['usuarios']) || empty($_POST['Proyecto']['usuarios'])){
                    $model->addError('usuarios','Debe seleccionar al menos 1 usuario');
                }

                $model->fecha = Utilities::MysqlDateFormat($model->fecha);
                if (!$model->save()){
                    throw new Exception("Error al actualizar proyecto");
                }
                if(!empty($areasProyecto)){
                    foreach ($areasProyecto as $relacion){
                        if(!$relacion->delete()){
                            throw new Exception("Error al eliminar relacion area proyecto");
                        }
                    }
                }
                if(isset($_POST['Proyecto']['areas']) && !empty($_POST['Proyecto']['areas'])){
                    foreach ($_POST['Proyecto']['areas'] as $areaId){
                        $areaProyecto = new AreaProyecto();
                        $areaProyecto->area_id = $areaId;
                        $areaProyecto->proyecto_id = $model->id;
                        if(!$areaProyecto->save()){
                            throw new Exception("Error al crear relacion area proyecto");
                        }
                    }
                }

                if(!empty($proyectoUsuario)){
                    foreach ($proyectoUsuario as $relacion){
                        if(!$relacion->delete()){
                            throw new Exception("Error al eliminar relacion proyecto usuario");
                        }
                    }
                }

                if(isset($_POST['Proyecto']['usuarios']) && !empty($_POST['Proyecto']['usuarios'])){
                    foreach ($_POST['Proyecto']['usuarios'] as $usuarioId){
                        $proyectoUsuario = new ProyectoUsuario();
                        $proyectoUsuario->usuario_id = $usuarioId;
                        $proyectoUsuario->proyecto_id = $model->id;
                        if(!$proyectoUsuario->save()){
                            throw new Exception("Error al crear relacion proyecto usuario");
                        }
                        $usuario = User::model()->findByPk($usuarioId);
                        if(is_null($usuario->ultimo_proyecto_id)){
                            $usuario->ultimo_proyecto_id = $model->id;
                            if(!$usuario->save()) {
                                throw new Exception("Error al actualizar usuario, asignacion de proyecto");
                            }
                        }
                    }
                }

                $proyectoUsuarioExiste = ProyectoUsuario::model()->findByAttributes(['proyecto_id'=>$model->id,'usuario_id'=>Yii::app()->user->model->id]);
                if(is_null($proyectoUsuarioExiste)){
                    $proyectoUsuario = new ProyectoUsuario();
                    $proyectoUsuario->usuario_id = Yii::app()->user->model->id;
                    $proyectoUsuario->proyecto_id = $model->id;
                    if(!$proyectoUsuario->save()){
                        throw new Exception("Error al crear relacion proyecto usuario");
                    }
                }

                $usuariosAdministradores = User::model()->getUsuariosAdministradores();
                if(!empty($usuariosAdministradores)){
                    foreach ($usuariosAdministradores as $admin){
                        $proyectoUsuarioAdmin = ProyectoUsuario::model()->findByAttributes(['proyecto_id'=>$model->id,'usuario_id'=>$admin['id']]);
                        if(is_null($proyectoUsuarioAdmin)){
                            $proyectoUsuario = new ProyectoUsuario();
                            $proyectoUsuario->usuario_id = $admin['id'];
                            $proyectoUsuario->proyecto_id = $model->id;
                            if(!$proyectoUsuario->save()){
                                throw new Exception("Error al crear relacion proyecto usuario");
                            }
                        }
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
                $transaction = Yii::app()->db->beginTransaction();
                $activo = Activo::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($activo)){
                    throw new Exception("Error. Este proyecto esta relacionado con un activo");
                }

                $grupo = Grupo::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($grupo)){
                    throw new Exception("Error. Este proyecto esta relacionado con un grupo");
                }

                $analisis = Analisis::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($analisis)){
                    throw new Exception("Error. Este proyecto esta relacionado con un analisis");
                }
                $nivel_de_riesgos = NivelDeRiesgos::model()->findByAttributes(['proyecto_id'=>$id]);
                if(!is_null($nivel_de_riesgos)){
                    throw new Exception("Error. Este proyecto esta relacionado con un nivel de riesgo");
                }

                $area_proyecto = AreaProyecto::model()->findAllByAttributes(['proyecto_id'=>$id]);
                if(!empty($area_proyecto)){
                    foreach ($area_proyecto as $ap){
                        if(!$ap->delete()){
                            throw new Exception("Error al eliminar relacion area proyecto");
                        }
                    }
                }

                $proyecto_usuario = ProyectoUsuario::model()->findAllByAttributes(['proyecto_id'=>$id]);
                if(!empty($proyecto_usuario)){
                    foreach ($proyecto_usuario as $pu){
                        $usuario = User::model()->findByPk($pu->usuario_id);
                        $usuario->ultimo_proyecto_id = NULL;
                        if(!$usuario->save()){
                            throw new Exception("Error al actualizar usuarios");
                        }
                    }

                    foreach ($proyecto_usuario as $pu){
                        if(!$pu->delete()){
                            throw new Exception("Error al eliminar relacion usuario proyecto");
                        }
                    }
                }

                $proyecto = Proyecto::model()->findByPk($id);
                if(!$proyecto->delete()){
                    throw new Exception("Error al eliminar proyecto");
                }
                $transaction->commit();
                $data = "Se elimino correctamente el analisis";
                $datos = ['error'=>0,'msj'=>$data];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $transaction->rollback();
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
        $usuario = User::model()->getUsuarioLogueado();
        if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
            Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
            $this->redirect(array('/'));
        }
        $model->id = $usuario->ultimo_proyecto_id;
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
        if ($model === null) {
            Yii::app()->user->setNotification('error','Acceso denegado');
            $this->redirect(array('/'));
            //throw new CHttpException(404, 'The requested page does not exist.');
        }

        $usuario = User::model()->getUsuarioLogueado();
        if(!is_null($usuario)){
            if($model->id != $usuario->ultimo_proyecto_id){
                Yii::app()->user->setNotification('error','Acceso denegado');
                $this->redirect(array('site/index'));
            }
        }else{
            $this->redirect(array('site/index'));
        }

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
            $usuario = User::model()->getUsuarioLogueado();
            if(is_null($usuario)){
                $datos =['error'=>1,'msj'=>'error al asignar proyecto.'];
                echo CJSON::encode($datos);
                die();
            }
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
