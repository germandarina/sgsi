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
            $model->attributes = $_POST['Area'];
            if(Yii::app()->user->model->isAuditor()){
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)) {
                    if ($model->save()) {
                        $area_proyecto = new AreaProyecto();
                        $area_proyecto->area_id = $model->id;
                        $area_proyecto->proyecto_id = $usuario->ultimo_proyecto_id;
                        if($area_proyecto->save()){
                            Yii::app()->user->setNotification('success', 'El area fue creada con exito');
                            $this->redirect(array('create'));
                        }
                    }
                }else{
                    Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                    $this->redirect(array('create'));
                }
            }else{
                if ($model->save()) {
                    Yii::app()->user->setNotification('success', 'El area fue creada con exito');
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

        if (isset($_POST['Area'])) {
            $model->attributes = $_POST['Area'];
            if ($model->save()) {
                Yii::app()->user->setNotification('success', 'El area fue actualizada con exito');
                $this->redirect(array('admin'));
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
            $grupo_activo = Proceso::model()->findByAttributes(['area_id'=>$id]);
            if(!is_null($grupo_activo)){
                throw new Exception("Error. Esta area ya posee las asociaciones realizadas");
            }
            $this->loadModel($id)->delete();
            $data = "Se elimino correctamente el area";
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'area-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    public function actionGetProcesos(){
        if(isset($_POST['area_id'])){
            $model = $this->loadModel($_POST['area_id']);
            $procesos = $model->procesos; //Proceso::model()->findAllByAttributes(array('area_id'=>$_POST['area_id']));
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
