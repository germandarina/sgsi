<?php

class ReporteController extends Controller
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
                'actions' => array('create', 'update', 'admin', 'delete','verPlanes','gridDetalles','getPlanDetalle',
                                    'actualizarControles','guardarValoresDetalle'),
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
        $model = new Plan;
        $model->analisis_id = $_GET['analisis_id'];

        if (isset($_POST['Plan'])) {

            try{
                $transaction = Yii::app()->db->beginTransaction();

                $model->attributes = $_POST['Plan'];
                $model->fecha = Utilities::MysqlDateFormat($model->fecha);
                if (!$model->save()) {
                    throw new Exception("Error al crear plan de tratamiento");
                }

                $analisis_control = AnalisisControl::model()->findAllByAttributes(['analisis_id'=>$model->analisis_id,'valor'=>GrupoActivo::VALOR_ALTO]);
                if(!empty($analisis_control)){
                    foreach ($analisis_control as $ac){
                        $plan_detalle = new PlanDetalle();
                        $plan_detalle->analisis_control_id = $ac->id;
                        $plan_detalle->plan_id = $model->id;
                        if(!$plan_detalle->save()){
                            throw new Exception("Error al crear detalle de plan de tratamiento");
                        }
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success','Plan de Tratamiento Creado con Exito');
                $this->redirect(array('update', 'id' => $model->id));
            }catch (Exception $exception){
                $transaction->rollBack();
                Yii::app()->user->setNotification('error',$exception->getMessage());
            }

        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionVerPlanes(){
        if($_GET['analisis_id']){
            $model = new Plan;
            $model->analisis_id = $_GET['analisis_id'];
            if (isset($_GET['Plan']))
                $model->attributes = $_GET['Plan'];

            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }


    public function actionGridDetalles()
    {
        // partially rendering "_relational" view
        $planId = Yii::app()->getRequest()->getParam('id');
        $plan_detalle = new PlanDetalle();
        $plan_detalle->plan_id = $planId;
        $this->renderPartial('/planDetalle/admin', array(
            'id' => Yii::app()->getRequest()->getParam('id'),'model'=>$plan_detalle
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
        if (isset($_POST['Plan'])) {
            $model->attributes = $_POST['Plan'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            if ($model->save()) {
                Yii::app()->user->setNotification('success','Plan de Tratamiento Actualizado Con Exito');
                $this->redirect(array('/analisis/admin'));
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
        $dataProvider = new CActiveDataProvider('Plan');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Plan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Plan']))
            $model->attributes = $_GET['Plan'];

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
        $model = Plan::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'plan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetPlanDetalle(){
        if(isset($_POST['plan_detalle_id'])){
            $plan_detalle = PlanDetalle::model()->findByPk($_POST['plan_detalle_id']);
            $datos =['plan_detalle'=>$plan_detalle];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionGuardarValoresDetalle(){
        if(isset($_POST['plan_detalle_id'])){
            $detalle = PlanDetalle::model()->findByPk($_POST['plan_detalle_id']);
            $detalle->setScenario('guardarValores');
            if(!empty($_POST['fecha_posible_inicio'])){
                $detalle->fecha_posible_inicio = $_POST['fecha_posible_inicio'];
            }
            if(!empty($_POST['fecha_posible_fin'])){
                $detalle->fecha_posible_fin = $_POST['fecha_posible_fin'];
            }
            if(!empty($_POST['fecha_real_inicio'])){
                $detalle->fecha_real_inicio = $_POST['fecha_real_inicio'];
            }
            if(!empty($_POST['fecha_real_fin'])){
                $detalle->fecha_real_fin = $_POST['fecha_real_fin'];
            }
            if(!$detalle->save()){
                $datos =['error'=>1,'msj'=>'Error al guardar valores'];
                echo CJSON::encode($datos);
                die();
            }

            $datos =['error'=>0,'msj'=>'Valores guardados con exito'];
            echo CJSON::encode($datos);
            die();
        }
    }

    public function actionActualizarControles(){
        if(isset($_POST['plan_id'])){
            $plan = Plan::model()->findByPk($_POST['plan_id']);
            $analisis_control = AnalisisControl::model()->findAllByAttributes(['analisis_id'=>$plan->analisis_id,'valor'=>GrupoActivo::VALOR_ALTO]);
            if(!empty($analisis_control)){
                foreach ($analisis_control as $ac){
                    $plan_detalle = PlanDetalle::model()->findByAttributes(['plan_id'=>$plan->id,'analisis_control_id'=>$ac->id]);
                    if(is_null($plan_detalle)){
                        try{
                            $transaction = Yii::app()->db->beginTransaction();
                            $nuevoDetalle = new  PlanDetalle();
                            $nuevoDetalle->plan_id = $plan->id;
                            $nuevoDetalle->analisis_control_id = $ac->id;
                            if(!$nuevoDetalle->save()){
                                throw new Exception("Error al crear nuevo detalle");
                            }
                            $transaction->commit();
                            $datos =['error'=>0,'msj'=>'Controles actualizados con exito'];
                            echo CJSON::encode($datos);
                            die();
                        }catch (Exception $exception){
                            $transaction->rollBack();
                            $datos =['error'=>1,'msj'=>$exception->getMessage()];
                            echo CJSON::encode($datos);
                            die();
                        }
                    }
                }
            }
            $datos =['error'=>0,'msj'=>'Controles actualizados con exito'];
            echo CJSON::encode($datos);
            die();
        }
    }
}
