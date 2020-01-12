<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function beforeAction($action)
    {
        if(!Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest && Yii::app()->user->model) {
            if(!Yii::app()->user->model->isAdmin()){
                $ruta = $this->getRoute();
                $userId = Yii::app()->user->id;
                $authManager = Yii::app()->authManager;

                $partes = explode('/',$ruta);

                $rutaRBAM = ucfirst($partes[0]).':'.ucfirst($partes[1]);
                if($ruta!='site/index' && $ruta!='site/logout' && $ruta!='user/cambiarPassword' ) {
                    if (!$authManager->checkAccess($rutaRBAM, $userId)) {
                        Yii::app()->user->setNotification('error', 'Este usuario no tiene habilitada esta accion.');
                        $this->redirect(array('/site/index/'));
                    }
                }
            }
        }
        return true;
    }
}