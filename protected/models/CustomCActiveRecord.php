<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomCActiveRecord
 *
 * @author jj
 */
abstract class CustomCActiveRecord Extends CActiveRecord
{

    //put your code here

    public $total;
    protected $camposFecha = array();
    protected $camposFechaHora = array();

    public function getClassName()
    {
        return get_class($this);
    }

    public function defaultScope()
    {
        if (!(Yii::app() instanceof CConsoleApplication)) {
            $alias = $this->getTableAlias(false, false);
            if ($this->hasAttribute("proyecto_id")) {
                $usuario = User::model()->findByPk(Yii::app()->user->model->id);
                if(!is_null($usuario)) {
                    return array(
                        'condition' => $alias . ".proyecto_id=:proyecto_id",
                        'params' => array(
                            ':proyecto_id' => $usuario->ultimo_proyecto_id,
                        ),
                    );
                }else{
                    return [];
                }
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    protected function beforeValidate()
    {
        if(PHP_SAPI != 'cli') {
            if ($this->hasAttribute("sucursalId")) {
                $this->sucursalId = Yii::app()->user->model->getUsuarioSucursal()->id;
                //$this->sucursalId = Yii::app()->user->model->sucursalId;
            }

            if ($this->isNewRecord) {
                $this->creaTimeStamp = Date("Y-m-d H:i:s");
                $this->creaUserStamp = Yii::app()->user->model->username;
            }

            if ($this->hasAttribute("modTimeStamp")) {
                $this->modTimeStamp = Date("Y-m-d H:i:s");
                $this->modUserStamp = Yii::app()->user->model->username;
            }
        }else{
            $this->creaTimeStamp = Date("Y-m-d H:i:s");
            $this->creaUserStamp = 'Cron';
            $this->sucursalId  = 1;
        }


        return parent::beforeValidate();
    }

    /*
    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
    */
    public function bloquear($tiempoBloqueo = 60)
    {

        if ($this->estaBloqueado()) {
            return false;
        } else {
            // $this->updateAll(
            //     array("bloqueoTimestamp" => time()), 
            //     "bloqueoUsuarioId = :usuarioId AND bloqueoTimestamp > :time", 
            //     array(":usuarioId" => Yii::app()->user->model->id, ":time" => time())
            // );
            $registrosBloqueados = $this->findAll("bloqueoUsuarioId = :usuarioId AND bloqueoTimestamp > :time",
                array(":usuarioId" => Yii::app()->user->model->id, ":time" => time())
            );
            if (!empty($registrosBloqueados)) {
                foreach ($registrosBloqueados as $registro) {
                    $registro->bloqueoTimestamp = time();
                    $registro->save();
                }
            }
            ##bloqueo de 1 minuto
            $this->bloqueoTimestamp = time() + $tiempoBloqueo;
            $this->bloqueoUsuarioId = Yii::app()->user->model->id;
            $this->save();
            return true;
        }
    }

    public function desBloquear()
    {
        $this->bloqueoTimestamp = time();
        $this->save();
    }

    public function estaBloqueado()
    {
        return isset($this->bloqueoTimestamp) && $this->bloqueoTimestamp > time() && $this->bloqueoUsuarioId != Yii::app()->user->model->id;
    }

    public function expiroBloqueo()
    {
        return ($this->bloqueoTimestamp < time() || $this->bloqueoUsuarioId != Yii::app()->user->model->id);
    }

    public function getTotalPorCampo($campo, $criteria, $sql = '')
    {

        if ($this->hasAttribute($campo) || !empty($sql)) {
            $criteriaTotal = clone $criteria;

            if (empty($sql))
                $criteriaTotal->select = "SUM($campo) as total";
            else
                $criteriaTotal->select = "SUM($sql) as total";

            $modelo = $this->find($criteriaTotal);

            return $modelo->total;
        }
        return 0;

    }

    public function getTypeDescription($type)
    {
        $options = array();
        $options = $this->getTypeOptions($type);
        return $options[$this->$type];
    }

    protected function convertirFechasAMysql()
    {
        try {
            if (!empty($this->camposFechaHora)) {
                foreach ($this->camposFechaHora as $campo) {

                    if (empty($this->$campo)) continue;

                    $date = new DateTime($this->$campo);
                    $this->$campo = $date->format('d-m-Y H:i');

                }
            }

            if (!empty($this->camposFecha)) {
                foreach ($this->camposFecha as $campo) {

                    if (empty($this->$campo)) continue;

                    $date = new DateTime($this->$campo);
                    $this->$campo = $date->format('d-m-Y');

                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    protected function convertirFechasAFormatoVista()
    {
        try {

            if (!empty($this->camposFechaHora)) {
                foreach ($this->camposFechaHora as $campo) {
                    if (empty($this->$campo)) continue;

                    $date = DateTime::createFromFormat('d-m-Y H:i', $this->$campo);
                    $this->$campo = $date->format('Y-m-d H:i:s');

                }
            }

            if (!empty($this->camposFecha)) {
                foreach ($this->camposFecha as $campo) {

                    if (empty($this->$campo)) continue;

                    $date = DateTime::createFromFormat('d-m-Y', $this->$campo);
                    $this->$campo = $date->format('Y-m-d');

                }
            }


        } catch (Exception $e) {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->convertirFechasAMysql();
    }

    public function afterValidate()
    {

        parent::afterValidate();
        $this->convertirFechasAFormatoVista();
    }

}

?>
