<?php

class MenuController extends Controller
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
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('create', 'update', 'getOrden', 'admin', 'delete','guardarMenuActivo'),
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

    public function actionCreate()
    {
        /**
         * @var $authManager CDbAuthManager;
         */
        $model = new Menu;
        $model->visible = 1;
        $authManager = Yii::app()->authManager;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $model->orden = $this->actionGetOrden();

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->padreId == '') {
                $model->padreId = 0;
            }

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    //Insertamos como un nuevo item

                    if($_POST['Menu']['perfiles']) {
                        $authManager->createAuthItem($model->label, '0', $model->titulo);
                        foreach ($_POST['Menu']['perfiles'] as $perfil) {
                            $authManager->addItemChild($perfil, $model->label);
                        }
                    }
                    $transaction->commit();
                    Yii::app()->user->setNotification('success', 'Item creado con Exito');
                    $this->redirect(array('admin'));
                } else {
                    throw new Exception('Error al crear el item');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $e->getMessage());
            }

        }

        $this->render('create', array(
            'model' => $model, 'perfiles' => $this->getPerfiles()
        ));
    }

    protected function getPerfiles()
    {
        $perfiles = array();
        foreach (Yii::app()->authManager->roles as $nombrePerfil => $perfil) {
            $perfiles[$nombrePerfil] = $nombrePerfil;
        }

        return $perfiles;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /**
         * @var $authManager CDbAuthManager;
         */
        $model = $this->loadModel($id);
        $nAnterior = $model->label;

        $authManager = Yii::app()->authManager;

        $perfilesActuales = [];

        foreach ($this->getPerfiles() as $perfil) {
            if($authManager->hasItemChild($perfil, $model->label)) {
                $perfilesActuales[$perfil] = $perfil;
            }
        }

        $model->perfiles = $perfilesActuales;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->padreId == '') {
                $model->padreId = 0;
            }
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {

                if ($model->save()) {
                    if ($nAnterior <> $model->label) {
                        //Realizo un update en las tablas del RBAM
                        $sql = "UPDATE AuthItem set name=:nombreNuevo , description=:descripcionNueva
					         where name=:nombreAnterior";

                        $connection = Yii::app()->db;
                        $command = $connection->createCommand($sql);

                        $nombreNuevo = $model->label;
                        $descripcionNueva = $model->titulo;
                        $nombreAnterior = $nAnterior;
                        $command->bindValue(":nombreNuevo", $nombreNuevo, PDO::PARAM_STR);
                        $command->bindValue(":descripcionNueva", $descripcionNueva, PDO::PARAM_STR);
                        $command->bindValue(":nombreAnterior", $nombreAnterior, PDO::PARAM_STR);
                        $command->execute();

                        $sql1 = "UPDATE AuthItemChild set child=:nombreNuevo
					         where child=:nombreAnterior";
                        $connection1 = Yii::app()->db;
                        $command1 = $connection1->createCommand($sql1);

                        $nombreNuevo = $model->label;
                        $nombreAnterior = $nAnterior;
                        $command1->bindValue(":nombreNuevo", $nombreNuevo, PDO::PARAM_STR);
                        $command1->bindValue(":nombreAnterior", $nombreAnterior, PDO::PARAM_STR);
                        $command1->execute();
                    }
                    if (!empty($_POST['Menu']['perfiles'])) {

                        foreach ($this->getPerfiles() as $perfil) {
                            if($authManager->hasItemChild($perfil, $model->label)) {
                                $authManager->removeItemChild($perfil, $model->label);
                            }
                        }

                        foreach ($_POST['Menu']['perfiles'] as $perfil) {
                            if(!$authManager->getAuthItem($model->label)) {
                                $authManager->createAuthItem($model->label, 0);
                            }
                            $authManager->addItemChild($perfil, $model->label);
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setNotification('success', 'Item Actualizado con Exito');
                    $this->redirect(array('admin'));
                } else {
                    throw new Exception('Error al actualizar item');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $e->getMessage());
            }

        }

        $this->render('update', array(
            'model' => $model, 'perfiles' => $this->getPerfiles(),
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
                $this->loadModel($id)->delete();
                $data = "Se elimino correctamente el menus";
                $datos = ['error'=>0,'msj'=>$data];
                echo CJSON::encode($datos);
            }catch (Exception $exception){
                $msj = $exception->getMessage();
                $datos = ['error'=>1,'msj'=>$msj];
                echo CJSON::encode($datos);
                die();
            }
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
        $dataProvider = new CActiveDataProvider('Menu');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Menu('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Menu']))
            $model->attributes = $_GET['Menu'];

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
        $model = Menu::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetOrden()
    {
        $menu = new Menu;
        $padreId = 0;
        if (isset($_GET['padreId'])) {
            $padreId = $_GET['padreId'];
        }

        $query = "select case when max(orden) is null then 1
                     else max(orden)+1 end 
              from " . $menu->tableName() . " where padreId=" . $padreId;
        $orden = Yii::app()->db->createCommand($query)->queryScalar();

        return $orden;
    }

    public function actionGuardarMenuActivo(){
        Yii::app()->session["hijoId"] = $_POST['hijoId'];
        Yii::app()->session["padreId"] = $_POST['padreId'];
    }
}
