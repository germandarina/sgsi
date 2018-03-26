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
                'actions' => array('', ''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('activosAfectados','activosPorRiesgo'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('',),
                'users' => array(''),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionActivosAfectados(){
        $analisis = new Analisis();
        $areas = [];
        if(isset($_POST['Analisis'])){
            $aux = Analisis::model()->findByPk($_POST['Analisis']['id']);
            $analisis->id = $aux->id;
            $analisis->nombre =$aux->nombre;
            $areas= Analisis::model()->getAreasActivosAfectados($analisis->id);
            if(isset($_POST['exportar'])){
                set_time_limit(0);
                ini_set('memory_limit', '20000M');
                $content = "<br><h3>Activos Afectados</h3>";
                $content .= "<h3>Fecha: " . date("d/m/Y") . "</h3>";
                $content .= $this->renderPartial('_tablaActivosAfectados', array('areas' => $areas), true);
                $nombreArchivo = "Activos Afectados.xls";
                Yii::app()->request->sendFile($nombreArchivo, $content);
                Yii::app()->user->setFlash('success', 'El informe fue generado correctamente');
            }
        }
        $this->render('activosAfectados', array(
            'analisis' => $analisis,'areas'=>$areas,
        ));
    }


    public function actionActivosPorRiesgo(){
        $analisis = new Analisis();
        $datos = [];
        if(isset($_POST['Analisis'])){
            $aux = Analisis::model()->findByPk($_POST['Analisis']['id']);
            $analisis->id = $aux->id;
            $analisis->nombre =$aux->nombre;
            $datos = Analisis::model()->getValoresGrafico($analisis->id);

        }
        $this->render('activosPorRiesgo', array(
            'analisis' => $analisis,'datos'=>$datos,
        ));
    }

}
