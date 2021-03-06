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
                'actions' => array('create', 'update', 'getOrden', 'admin', 'delete','guardarMenuActivo',
                                    'asignarPermisos','getAccionesPorController'),
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
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['Menu'];
                if ($model->padreId == '') {
                    $model->padreId = 0;
                }
                $menuExiste = Menu::model()->findByAttributes(['url'=>$model->url]);
                if($menuExiste){
                    throw new  Exception("El menu que intenta crear ya existe");
                }
                if (!$model->save()) {
                   throw new  Exception("Error al crear menu");
                }
                if($_POST['Menu']['perfiles']) {
                    $auth_item =  $authManager->getAuthItem($model->label);
                    $permiso_explode = explode('/',$model->url);
                    $permiso = ucwords($permiso_explode[1]).':'.ucwords($permiso_explode[2]);
                    $authItemExiste = null;
                    if(isset($permiso_explode[1])){
                        $sqlExiste = " select * from AuthItem where name = :permiso;";
                        $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                        $commandExiste->bindValue(":permiso", $permiso);
                        $authItemExiste = $commandExiste->queryRow($sqlExiste);
                    }
                    if(is_null($auth_item) && is_null($authItemExiste)){
                        $authManager->createAuthItem($model->label, '0', $model->titulo);
                    }
                    foreach ($_POST['Menu']['perfiles'] as $perfil) {
                        $auth_item_child = $authManager->hasItemChild($perfil,$model->label);
                        $authItemExiste = null;
                        if(!empty($model->url) && !is_null($model->url)){
                            if(isset($permiso_explode[1])){
                                $sqlExiste = " select * from AuthItemChild where parent = :parent and child =:child;";
                                $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                                $commandExiste->bindValue(":parent", $perfil);
                                $commandExiste->bindValue(":child", $permiso);
                                $authItemExiste = $commandExiste->queryRow($sqlExiste);
                            }
                        }
                        if(!($auth_item_child) && is_null($authItemExiste)){
                            $authManager->addItemChild($perfil, $model->label);
                        }
                    }
                }
                $transaction->commit();
                Yii::app()->user->setNotification('success', 'Item creado con Exito');
                $this->redirect(array('admin'));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $e->getMessage());
                $this->redirect('create');
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
            if(!User::model()->esPerfilRbam(trim($nombrePerfil))) {
                $perfiles[$nombrePerfil] = $nombrePerfil;
            }
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
        $labelAnterior = $model->label;

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

                if (!$model->save()) {
                    throw new Exception("Error al actualizar menu");
                }
                if ($labelAnterior != $model->label) {
                    //Realizo un update en las tablas del RBAM
                    $sql = "UPDATE AuthItem set name=:nombreNuevo , description=:descripcionNueva
                         where name=:nombreAnterior";

                    $connection = Yii::app()->db;
                    $command = $connection->createCommand($sql);

                    $nombreNuevo = $model->label;
                    $descripcionNueva = $model->titulo;
                    $nombreAnterior = $labelAnterior;
                    $command->bindValue(":nombreNuevo", $nombreNuevo, PDO::PARAM_STR);
                    $command->bindValue(":descripcionNueva", $descripcionNueva, PDO::PARAM_STR);
                    $command->bindValue(":nombreAnterior", $nombreAnterior, PDO::PARAM_STR);
                    $command->execute();

                    $sql1 = "UPDATE AuthItemChild set child=:nombreNuevo
                         where child=:nombreAnterior";
                    $connection1 = Yii::app()->db;
                    $command1 = $connection1->createCommand($sql1);

                    $nombreNuevo = $model->label;
                    $nombreAnterior = $labelAnterior;
                    $command1->bindValue(":nombreNuevo", $nombreNuevo, PDO::PARAM_STR);
                    $command1->bindValue(":nombreAnterior", $nombreAnterior, PDO::PARAM_STR);
                    $command1->execute();
                }

                if(!empty($_POST['Menu']['perfiles'])) {

                    foreach ($this->getPerfiles() as $perfil) {
                        if($authManager->hasItemChild($perfil, $model->label)) {
                            $authManager->removeItemChild($perfil, $model->label);
                        }
                    }

                    if(!empty($model->url) && !is_null($model->url)) {
                        $permiso_explode = explode('/', $model->url);
                        if (isset($permiso_explode[1])) {
                            $permiso = ucwords($permiso_explode[1]) . ':' . ucwords($permiso_explode[2]);
                            $sqlExiste = " select * from AuthItem where name = :nombre;";
                            $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                            $commandExiste->bindValue(":nombre", $permiso);
                            $authItemExiste = $commandExiste->queryRow($sqlExiste);
                            if (!$authItemExiste) {
                                $sqlAuthItem = "INSERT INTO AuthItem(name,description,type,data) VALUES(:permiso,:descripcion,:type,:data);";
                                $commandAuthItem = Yii::app()->db->createCommand($sqlAuthItem);
                                $commandAuthItem->bindValue(":permiso", $permiso);
                                $commandAuthItem->bindValue(":descripcion", $permiso);
                                $commandAuthItem->bindValue(":type", 0);
                                $commandAuthItem->bindValue(":data", 'N;');
                                $commandAuthItem->execute();
                            }
                        }
                    }

                    foreach ($_POST['Menu']['perfiles'] as $perfil) {
                        if(!$authManager->getAuthItem($model->label)) {
                            $authManager->createAuthItem($model->label, 0);
                        }
                        $authManager->addItemChild($perfil, $model->label);
                        if(!empty($model->url) && !is_null($model->url) && isset($permiso_explode[1])) {
                            $sqlExiste = " select * from AuthItemChild where parent = :parent and child =:child;";
                            $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                            $commandExiste->bindValue(":parent", $perfil);
                            $commandExiste->bindValue(":child", $permiso);
                            $authItemExiste = $commandExiste->queryRow($sqlExiste);
                            if (!$authItemExiste) {
                                $sqlAuthItemChild = "INSERT INTO AuthItemChild(parent,child)  values(:parent,:child);";
                                $commandAuthItemChild = Yii::app()->db->createCommand($sqlAuthItemChild);
                                $commandAuthItemChild->bindValue(":parent", $perfil);
                                $commandAuthItemChild->bindValue(":child", $permiso);
                                $commandAuthItemChild->execute();
                            }
                        }
                    }
                }

                $transaction->commit();
                Yii::app()->user->setNotification('success', 'Item Actualizado con Exito');
                $this->redirect(array('admin'));

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
                $model = $this->loadModel($id);
                $model->delete();
                $data = "Se elimino correctamente el menu";
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

    public function actionAsignarPermisos(){
        /**
         * @var $authManager CDbAuthManager;
         */
        $model = new Menu;
        $perfiles = $this->getPerfiles();
        $controllerlist = $this->getControllers();
        if (isset($_POST['Menu'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                if(isset($_POST['Menu']['perfiles']) && empty($_POST['Menu']['perfiles'])){
                    throw new Exception("Debe seleccionar un perfil");
                }
                if(isset($_POST['Menu']['controllers']) && empty($_POST['Menu']['controllers'])){
                    throw new Exception("Debe seleccionar un controller");
                }
                if(isset($_POST['Menu']['accionesControllers']) && empty($_POST['Menu']['accionesControllers'])){
                    throw new Exception("Debe seleccionar una accion");
                }

                foreach ($_POST['Menu']['accionesControllers'] as $accion){
                    $controller = $_POST['Menu']['controllers'];
                    $permiso = ucwords($controller).':'.ucwords($accion);
                    $descripcion = $accion;
                    $sqlExiste = " select * from AuthItem where name = :nombre;";
                    $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                    $commandExiste->bindValue(":nombre", $permiso);
                    $authItemExiste =  $commandExiste->queryRow($sqlExiste);
                    if(!$authItemExiste){
                        $sqlAuthItem = "INSERT INTO AuthItem(name,description,type,data) VALUES(:permiso,:descripcion,:type,:data);";
                        $commandAuthItem = Yii::app()->db->createCommand($sqlAuthItem);
                        $commandAuthItem->bindValue(":permiso", $permiso);
                        $commandAuthItem->bindValue(":descripcion", $descripcion);
                        $commandAuthItem->bindValue(":type", 0);
                        $commandAuthItem->bindValue(":data", 'N;');
                        $commandAuthItem->execute();
                    }
                    foreach ($_POST['Menu']['perfiles'] as $perfil){
                        $sqlExiste = " select * from AuthItemChild where parent = :parent and child =:child;";
                        $commandExiste = Yii::app()->db->createCommand($sqlExiste);
                        $commandExiste->bindValue(":parent", $perfil);
                        $commandExiste->bindValue(":child", $permiso);
                        $authItemExiste = $commandExiste->queryRow($sqlExiste);
                        if (!$authItemExiste) {
                            $sqlAuthItemChild = "INSERT INTO AuthItemChild(parent,child)  values(:parent,:child);";
                            $commandAuthItemChild = Yii::app()->db->createCommand($sqlAuthItemChild);
                            $commandAuthItemChild->bindValue(":parent", $perfil);
                            $commandAuthItemChild->bindValue(":child", $permiso);
                            $commandAuthItemChild->execute();
                        }
                    }
                }

                $transaction->commit();
                Yii::app()->user->setNotification('success', 'Permisos Asignados');
                $this->redirect(array('asignarPermisos'));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setNotification('error', $e->getMessage());
            }

        }

        $this->render('asignarPermisos', array(
            'model' => $model, 'perfiles' => $perfiles,'controllerList'=>$controllerlist)
        );
    }

    private function getControllers(){
        $controllerlist = [];
        if ($handle = opendir(__DIR__)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controller =  str_replace('Controller.php','',$file);
                    $controllerlist[$controller] = $controller; //str_replace('Controller.php','',$file);
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        return $controllerlist;
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen(__DIR__.'/'. $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[str_replace('Controller.php','',$controller)][] = ($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        return die(var_dump($fulllist));
    }

    public function actionGetAccionesPorController(){
        if(isset($_POST['controller'])){
            $controller = $_POST['controller'];
            $controller .= 'Controller.php';
            $accionesList = [];
            $handle = fopen(__DIR__.'/'. $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $accionesList[$display[1]] = $display[1];
                        endif;
                    endif;
                }
            }
            fclose($handle);
            echo CJSON::encode(['acciones'=>$accionesList]);
            die();
        }
    }
}
