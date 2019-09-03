<?php

class VulnerabilidadController extends Controller
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
                'actions' => array('create', 'update', 'admin','delete','getAmenazas'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin'),
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
        $model = new Vulnerabilidad;

        if (isset($_POST['Vulnerabilidad'])) {

            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Vulnerabilidad'];
                if (!$model->save()) {
                    throw new Exception("Erro al guardar vulnerablidad");
                }
                if(isset($_POST['Vulnerabilidad']['array_amenazas']) && !empty($_POST['Vulnerabilidad']['array_amenazas'])){
                    foreach ($_POST['Vulnerabilidad']['array_amenazas'] as $amenaza_id){
                        $amenaza_vulne = new AmenazaVulnerabilidad();
                        $amenaza_vulne->vulnerabilidad_id = $model->id;
                        $amenaza_vulne->amenaza_id = $amenaza_id;
                        if(!$amenaza_vulne->save()){
                            throw new Exception("Error al crear relacion amenaza vulnerabilidad");
                        }
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Vulnerabilidad creada con exito');
                $this->redirect(array('create'));
            }catch (Exception $ex){
                $transaction->rollback();
                Yii::app()->user->setNotification('error',$ex->getMessage());
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
        $amenaza_vulne = AmenazaVulnerabilidad::model()->findAllByAttributes(array('vulnerabilidad_id'=>$model->id));
        foreach ($amenaza_vulne as $relacion){
            $model->array_amenazas[] = $relacion->amenaza_id;
        }
        if (isset($_POST['Vulnerabilidad'])) {
            try{
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Vulnerabilidad'];
                if (!$model->save()){
                    throw new Exception("Error al guardar vulnerablidad");
                }

                foreach ($amenaza_vulne as $relacion){
                    if(!$relacion->delete()){
                        throw new Exception("Error al eliminar relacion vieja");
                    }
                }

                if(isset($_POST['Vulnerabilidad']['array_amenazas']) && !empty($_POST['Vulnerabilidad']['array_amenazas'])){
                    foreach ($_POST['Vulnerabilidad']['array_amenazas'] as $amenaza_id){
                        $ame_vulne = new AmenazaVulnerabilidad();
                        $ame_vulne->vulnerabilidad_id = $model->id;
                        $ame_vulne->amenaza_id = $amenaza_id;
                        if(!$ame_vulne->save()){
                            throw new Exception("Error al crear relacion amenaza vulnerabilidad");
                        }
                    }
                }

                $transaction->commit();
                Yii::app()->user->setNotification('success','Vulnerabilidad actualizada con exito');
                $this->redirect(array('admin'));
            }catch (Exception  $ex){
                $transaction->rollback();
                Yii::app()->user->setNotification('error',$ex->getMessage());
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
                $grupo_activo = Control::model()->findByAttributes(['vulnerabilidad_id'=>$id]);
                if(!is_null($grupo_activo)){
                    throw new Exception("Error. Esta Vulnerabilidad esta asociada a un grupo");
                }
                $amenaza_vulne = AmenazaVulnerabilidad::model()->findByAttributes(['vulnerabilidad_id'=>$id]);
                if(!is_null($amenaza_vulne)){
                    throw new Exception("Error. Esta Vulnerabilidad esta asociada a una amenaza");
                }

                $analisis_vulne = AnalisisVulnerabilidad::model()->findByAttributes(['vulnerabilidad_id'=>$id]);
                if(!is_null($analisis_vulne)){
                    throw new Exception("Error. Esta Vulnerabilidad esta asociada a un analisis");
                }

                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente la vulnerabilidad";
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
        $dataProvider = new CActiveDataProvider('Vulnerabilidad');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Vulnerabilidad('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Vulnerabilidad']))
            $model->attributes = $_GET['Vulnerabilidad'];

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
        $model = Vulnerabilidad::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vulnerabilidad-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAmenazas(){
        if(isset($_POST['tipo_activo_id'])){
            $tipo_activo = TipoActivo::model()->findByPk($_POST['tipo_activo_id']);
            $amenazas = $tipo_activo->amenazas;
            $datos = ['amenazas'=>$amenazas];
            echo CJSON::encode($datos);
            die();
        }
    }
}
