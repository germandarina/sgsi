<?php

class OrganizacionController extends Controller
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
                'actions' => array('create', 'update', 'admin', 'delete','getAreas'),
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
        $model = new Organizacion;
        if (isset($_POST['Organizacion'])) {

            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Organizacion'];
                if (!$model->save()) {
                    throw new Exception("Error al guardar organizacion");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Organizacion creada con exito');
                $this->redirect(array('admin'));
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

        if (isset($_POST['Organizacion'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Organizacion'];
                if (!$model->save()) {
                    throw new Exception("Error al guardar organizacion");
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Organizacion actualizada con exito');
                $this->redirect(array('admin'));
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
                $area = Area::model()->findByAttributes(['organizacion_id'=>$id]);
                if(!is_null($area)){
                    throw new Exception("Error. Esta organizacion tiene un area relacionada.");
                }
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente la organizacion";
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
        $dataProvider = new CActiveDataProvider('Organizacion');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Organizacion('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Organizacion']))
            $model->attributes = $_GET['Organizacion'];

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
        $model = Organizacion::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'organizacion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAreas(){
        if(isset($_POST['organizacion_id'])){
            $areas = Area::model()->findAllByAttributes(['organizacion_id'=>$_POST['organizacion_id']]);
            $areasIds = [];
            if(isset($_POST['proyecto_id']) && !empty($_POST['proyecto_id'])){
                $areasProyectos = AreaProyecto::model()->findAllByAttributes(['proyecto_id'=>$_POST['proyecto_id']]);
                if(!empty($areasProyectos)){
                    foreach ($areasProyectos as $relacional){
                        $areasIds [] = $relacional->area_id;
                    }
                }
            }

            $datos = ['areas'=>$areas,'areasIds'=>$areasIds];
            echo CJSON::encode($datos);
            die();
        }
    }
}
