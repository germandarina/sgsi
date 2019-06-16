<?php

class PersonalController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
//    public function filters()
//    {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            array(
//                'application.filters.ProyectoFilter + admin',
//                'unit'=>'second',
//            ),
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function filters()
    {
        return array(
            'postOnly + edit, create',
            array(
                'application.filters.PerformanceFilter - edit, create',
                'unit'=>'second',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete'),
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
        $model = new Personal;


        if (isset($_POST['Personal'])) {
            $model->attributes = $_POST['Personal'];
            if(Yii::app()->user->model->isAuditor()){
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario->ultimo_proyecto_id)) {
                    $area_proyecto = AreaProyecto::model()->findByAttributes(['area_id'=>$model->area_id,'proyecto_id'=>$usuario->ultimo_proyecto_id]);
                    if(is_null($area_proyecto)){
                        Yii::app()->user->setNotification('error','El area seleccionada no corresponde al proyecto en el que se encuentra trabajando');
                        $this->redirect(array('create'));
                    }
                    if ($model->save()) {
                        Yii::app()->user->setNotification('success', 'El personal fue creado con exito');
                        $this->redirect(array('admin'));
                    }
                }else{
                    Yii::app()->user->setNotification('error','Debe seleccionar un proyecto para empezar a trabajar');
                    $this->redirect(array('create'));
                }
            }else{
                if ($model->save()) {
                    Yii::app()->user->setNotification('success', 'El personal fue creado con exito');
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

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Personal'])) {
            $model->attributes = $_POST['Personal'];
            if ($model->save()) {
                Yii::app()->user->setNotification('success', 'El personal fue actualizado con exito');
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
                $analisis = Analisis::model()->findByAttributes(['personal_id'=>$id]);
                if(!is_null($analisis)){
                    throw new Exception("Error. Este personal esta asociado a un analisis.");
                }

                $activo = Activo::model()->findByAttributes(['personal_id'=>$id]);
                if(!is_null($activo)){
                    throw new Exception("Error. Este personal esta asociado a un activo.");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el personal";
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
        $dataProvider = new CActiveDataProvider('Personal');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Personal('search');
        $model->unsetAttributes();  // clear any default values
//        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
//        if(is_null($usuario->ultimo_proyecto_id)){
//            Yii::app()->user->setNotification('error','Tiene que seleccionar un proyecto');
//            $this->redirect(array('/'));
//        }
//        $model->proyecto_id = $usuario->ultimo_proyecto_id;
        if (isset($_GET['Personal']))
            $model->attributes = $_GET['Personal'];

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
        $model = Personal::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'personal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
