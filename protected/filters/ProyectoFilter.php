<?php
class PerformanceFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        //die(var_dump($filterChain));
//        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
//        if(is_null($usuario->ultimo_proyecto_id)){
//            Yii::app()->user->setNotification('error','Tiene que seleccionar un proyecto');
//            return $this->redirect(array('/'));
//            //return false;
//        }
        // lógica que será executada antes da ação
        return true; // deve retornar false caso a ação não deva ser executada
    }

    protected function postFilter($filterChain)
    {
        die(var_dump($filterChain));
        // lógica que será executada depois da ação
    }
}
