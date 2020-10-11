<?php

/**
 * This is the model class for table "analisis".
 *
 * The followings are the available columns in table 'analisis':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property integer $personal_id
 * @property integer $proyecto_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Personal $personal
 * @property Proyecto $proyecto
 * @property GrupoActivo[] $grupoActivos
 */
class Analisis extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $valor_form_valoracion;
	public function tableName()
	{
		return 'analisis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, fecha, personal_id', 'required'),
			array('proyecto_id,personal_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, proyecto_id,descripcion, fecha, personal_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'personal' => array(self::BELONGS_TO, 'Personal', 'personal_id'),
            'proyecto' => array(self::BELONGS_TO, 'Proyecto', 'proyecto_id'),
            'grupoActivos' => array(self::HAS_MANY, 'GrupoActivo', 'analisis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'fecha' => 'Fecha',
			'personal_id' => 'Personal',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'valor_form_valoracion' =>'Valor',
            'proyecto_id'=>'Proyecto'
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('personal_id',$this->personal_id);
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
		$criteria->compare('modUserStamp',$this->modUserStamp,true);
		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Analisis the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPersonal(){
        return $this->personal->apellido.' , '.$this->personal->nombre;

    }
    public function tienePlanDeTratamiento(){
        $plan = Plan::model()->findByAttributes(['analisis_id'=>$this->id]);
        if(!is_null($plan)){
            return true;
        }else{
            return false;
        }
    }

    public function getAreasActivosAfectados($analisis_id){
        $query = " select 
                        a.id as analisis_id,
                        ar.id as area_id,
                        ar.nombre as nombre_area
                from analisis a
                inner join grupo_activo ga on ga.analisis_id = a.id
                inner join activo ac on ac.id = ga.activo_id
                inner join activo_area aa on aa.activo_id = ac.id
                inner join area ar on ar.id = aa.area_id
                where a.id = ".$analisis_id."
                and ga.valor >= ".GrupoActivo::VALOR_MEDIO."
                group by ar.id
                order by ar.id, ga.valor desc";
        $command = Yii::app()->db->createCommand($query);
        $resultados = $command->queryAll($query);
        return $resultados;
    }

    public static function getActivosAfectadosPorArea($analisis_id,$area_id){

	    $query =" select ac.nombre as nombre_activo,
                         ga.valor as valor_activo,
                         pr.nombre as nombre_proceso,
                         concat(per.apellido,', ',per.nombre) as responsable
                from analisis a
                inner join grupo_activo ga on ga.analisis_id = a.id
                inner join activo ac on ac.id = ga.activo_id
                inner join personal per on per.id = ac.personal_id
                inner join activo_area aa on aa.activo_id = ac.id
                inner join area  ar on ar.id = aa.area_id
                inner join proceso pr on pr.area_id = ar.id
                where a.id = ".$analisis_id."
                and ga.valor >= ".GrupoActivo::VALOR_MEDIO."
                and ar.id = ".$area_id."
                order by ar.id, ga.valor desc";
        $command = Yii::app()->db->createCommand($query);
        $resultados = $command->queryAll($query);
        return $resultados;
    }

    public static function getValoresGrafico($analisis_id){
        $queryIntegridad = "select valor_integridad,
                                   valor_disponibilidad,
                                   valor_confidencialidad,
                                   valor_trazabilidad
                                from analisis a
                                inner join analisis_riesgo ar on ar.analisis_id = a.id
                                inner join analisis_riesgo_detalle ard on ard.analisis_riesgo_id = ar.id
                                where a.id = ".$analisis_id." ";
        $command = Yii::app()->db->createCommand($queryIntegridad);
        $valores = $command->queryAll($queryIntegridad);
        $cantidadTotal = count($valores);
        if($cantidadTotal > 0){
            $arrayValores = [];
            $analisis = Analisis::model()->findByPk($analisis_id);
            $nivelesRiesgos = NivelDeRiesgos::model()->findAllByAttributes(['proyecto_id'=>$analisis->proyecto_id]);
            foreach ($nivelesRiesgos as $nr){
                $cantidadIntegridad =0;
                $cantidadDisponibilidad =0;
                $cantidadConfidencialidad =0;
                $cantidadTrazabilidad=0;
                foreach ($valores as $valor){
                    if($nr->valor_minimo<= $valor['valor_integridad'] && $nr->valor_maximo >= $valor['valor_integridad']){
                        $cantidadIntegridad +=1;
                    }
                    if($nr->valor_minimo<= $valor['valor_disponibilidad'] && $nr->valor_maximo >= $valor['valor_disponibilidad']){
                        $cantidadDisponibilidad +=1;
                    }
                    if($nr->valor_minimo<= $valor['valor_confidencialidad'] && $nr->valor_maximo >= $valor['valor_confidencialidad']){
                        $cantidadConfidencialidad +=1;
                    }
                    if($nr->valor_minimo<= $valor['valor_trazabilidad'] && $nr->valor_maximo >= $valor['valor_trazabilidad']){
                        $cantidadTrazabilidad +=1;
                    }
                }
                $arrayValores['integridad'][NivelDeRiesgos::$arrayConceptos[$nr->concepto]] = $cantidadIntegridad;
                $arrayValores['disponibilidad'][NivelDeRiesgos::$arrayConceptos[$nr->concepto]] = $cantidadDisponibilidad;
                $arrayValores['confidencialidad'][NivelDeRiesgos::$arrayConceptos[$nr->concepto]] = $cantidadConfidencialidad;
                $arrayValores['trazabilidad'][NivelDeRiesgos::$arrayConceptos[$nr->concepto]] = $cantidadTrazabilidad;
            }

            $arrayGraficoIntegridad =[];
            $arrayGraficoDispo =[];
            $arrayGraficoConfi =[];
            $arrayGraficoTraza =[];

            // INTEGRIDAD
            $filaGrafico = array();
            $porcentajeNoAceptable = round($arrayValores['integridad']['No Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeNoAceptable;
            $filaGrafico['color'] = "rgba(255,77,77,1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'No Aceptable ('.$porcentajeNoAceptable.' %)' ;
            $arrayGraficoIntegridad[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptableConPrecaucion = round($arrayValores['integridad']['Aceptable con Precaucion']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptableConPrecaucion;
            $filaGrafico['color'] = "rgb(255, 180, 68)";
            $filaGrafico['label'] =  'Aceptable con Precaucion ('.$porcentajeAceptableConPrecaucion.' %)';
            $arrayGraficoIntegridad[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptable = round($arrayValores['integridad']['Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptable;
            $filaGrafico['color'] = "rgb(38, 185, 154, 1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'Aceptable ( '.$porcentajeAceptable.' % )';
            $arrayGraficoIntegridad[] = $filaGrafico;
            /*Inicio - Agregado por Juan 10/05/20*/
            $filaGrafico = array();
            $porcentajeSinValor = 100 - ($porcentajeNoAceptable+$porcentajeAceptableConPrecaucion+$porcentajeAceptable);

            $filaGrafico['value'] =  $porcentajeSinValor;
            $filaGrafico['color'] = "rgb(66, 100, 222)";
            $filaGrafico['label'] =  'Sin valor ( '.$porcentajeSinValor.' % )';
            $arrayGraficoIntegridad[] = $filaGrafico;
            /*Fin - Agregado por Juan*/
            // DISPONIBILIDAD
            $filaGrafico = array();
            $porcentajeNoAceptable = round($arrayValores['disponibilidad']['No Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeNoAceptable;
            $filaGrafico['color'] = "rgba(255,77,77,1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'No Aceptable ('.$porcentajeNoAceptable.' %)' ;
            $arrayGraficoDispo[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptableConPrecaucion = round($arrayValores['disponibilidad']['Aceptable con Precaucion']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptableConPrecaucion;
            $filaGrafico['color'] = "rgb(255, 180, 68)";
            $filaGrafico['label'] =  'Aceptable con Precaucion ('.$porcentajeAceptableConPrecaucion.' %)';
            $arrayGraficoDispo[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptable = round($arrayValores['disponibilidad']['Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptable;
            $filaGrafico['color'] = "rgb(38, 185, 154, 1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'Aceptable ( '.$porcentajeAceptable.' % )';
            $arrayGraficoDispo[] = $filaGrafico;

            /*Inicio - Agregado por Juan 10/05/20*/
            $filaGrafico = array();
            $porcentajeSinValor = 100 - ($porcentajeNoAceptable+$porcentajeAceptableConPrecaucion+$porcentajeAceptable);

            $filaGrafico['value'] =  $porcentajeSinValor;
            $filaGrafico['color'] = "rgb(66, 100, 222)";
            $filaGrafico['label'] =  'Sin valor ( '.$porcentajeSinValor.' % )';
            $arrayGraficoDispo[] = $filaGrafico;
            /*Fin - Agregado por Juan*/

            // CONFIDENCIALIDAD

            $filaGrafico = array();
            $porcentajeNoAceptable = round($arrayValores['confidencialidad']['No Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeNoAceptable;
            $filaGrafico['color'] = "rgba(255,77,77,1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'No Aceptable ('.$porcentajeNoAceptable.' %)' ;
            $arrayGraficoConfi[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptableConPrecaucion = round($arrayValores['confidencialidad']['Aceptable con Precaucion']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptableConPrecaucion;
            $filaGrafico['color'] = "rgb(255, 180, 68)";
            $filaGrafico['label'] =  'Aceptable con Precaucion ('.$porcentajeAceptableConPrecaucion.' %)';
            $arrayGraficoConfi[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptable = round($arrayValores['confidencialidad']['Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptable;
            $filaGrafico['color'] = "rgb(38, 185, 154, 1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'Aceptable ( '.$porcentajeAceptable.' % )';
            $arrayGraficoConfi[] = $filaGrafico;

            /*Inicio - Agregado por Juan 10/05/20*/
            $filaGrafico = array();
            $porcentajeSinValor = 100 - ($porcentajeNoAceptable+$porcentajeAceptableConPrecaucion+$porcentajeAceptable);

            $filaGrafico['value'] =  $porcentajeSinValor;
            $filaGrafico['color'] = "rgb(66, 100, 222)";
            $filaGrafico['label'] =  'Sin valor ( '.$porcentajeSinValor.' % )';
            $arrayGraficoConfi[] = $filaGrafico;
            /*Fin - Agregado por Juan*/

            // TRAZABILIDAD

            $filaGrafico = array();
            $porcentajeNoAceptable = round($arrayValores['trazabilidad']['No Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeNoAceptable;
            $filaGrafico['color'] = "rgba(255,77,77,1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'No Aceptable ('.$porcentajeNoAceptable.' %)' ;
            $arrayGraficoTraza[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptableConPrecaucion = round($arrayValores['trazabilidad']['Aceptable con Precaucion']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptableConPrecaucion;
            $filaGrafico['color'] = "rgb(255, 180, 68)";
            $filaGrafico['label'] =  'Aceptable con Precaucion ('.$porcentajeAceptableConPrecaucion.' %)';
            $arrayGraficoTraza[] = $filaGrafico;

            $filaGrafico = array();
            $porcentajeAceptable = round($arrayValores['trazabilidad']['Aceptable']*100/ $cantidadTotal,2);

            $filaGrafico['value'] =  $porcentajeAceptable;
            $filaGrafico['color'] = "rgb(38, 185, 154, 1)"; /*Cambio de color - Juan 6/9/2020*/
            $filaGrafico['label'] =  'Aceptable ( '.$porcentajeAceptable.' % )';
            $arrayGraficoTraza[] = $filaGrafico;

            /*Inicio - Agregado por Juan 10/05/20*/
            $filaGrafico = array();
            $porcentajeSinValor = 100 - ($porcentajeNoAceptable+$porcentajeAceptableConPrecaucion+$porcentajeAceptable);

            $filaGrafico['value'] =  $porcentajeSinValor;
            $filaGrafico['color'] = "rgb(66, 100, 222)";
            $filaGrafico['label'] =  'Sin valor ( '.$porcentajeSinValor.' % )';
            $arrayGraficoTraza[] = $filaGrafico;
            /*Fin - Agregado por Juan*/

            return compact('arrayGraficoTraza','arrayGraficoConfi','arrayGraficoDispo','arrayGraficoIntegridad');
        }else{
            return [];
        }

    }
    public function getOtrasDependencias($analisis_id,$id_dependencias,$activo_id){
        $queryOtrasDependencias = "select * from dependencia
                                                        where id not in (".$id_dependencias.")
                                                        and activo_id <>".$activo_id."
                                                        and analisis_id = ".$analisis_id."
                                                        ";
        $command = Yii::app()->db->createCommand($queryOtrasDependencias);
        $otrasDependencias = $command->queryAll($queryOtrasDependencias);
        return $otrasDependencias;
    }
}
