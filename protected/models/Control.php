<?php

/**
 * This is the model class for table "control".
 *
 * The followings are the available columns in table 'control':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $numeracion
 * @property integer $vulnerabilidad_id
 * @property integer $tipo_activo_id
 * @property integer $amenaza_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Vulnerabilidad $vulnerabilidad
 */
class Control extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $analisis_id;
    public $fecha_valor_control;
    public $valor_control;
    public $grupo_activo_id;
    public $analisis_amenaza_id;

	public function tableName()
	{
		return 'control';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, numeracion, amenaza_id, tipo_activo_id,vulnerabilidad_id', 'required'),
			array('vulnerabilidad_id', 'numerical', 'integerOnly'=>true),
			array('nombre, numeracion, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('tipo_activo_id,amenaza_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tipo_activo_id,amenaza_id,id, nombre, descripcion, numeracion, vulnerabilidad_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'vulnerabilidad' => array(self::BELONGS_TO, 'Vulnerabilidad', 'vulnerabilidad_id'),
            'tipoActivo' => array(self::BELONGS_TO, 'TipoActivo', 'tipo_activo_id'),
            'amenaza' => array(self::BELONGS_TO, 'Amenaza', 'amenaza_id'),
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
			'numeracion' => 'Numeracion',
			'vulnerabilidad_id' => 'Vulnerabilidad',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'tipo_activo_id' =>'Tipo Activo',
            'amenaza_id' => 'Amenaza',
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
		$criteria->compare('numeracion',$this->numeracion,true);
        $criteria->together = true;
        $with = [];
		if(!empty($this->vulnerabilidad_id)){
            $with[]= 'vulnerabilidad';
            $criteria->compare('vulnerabilidad.nombre',$this->vulnerabilidad_id,true);
        }

        if(!empty($this->amenaza_id)){
            $with[]= 'amenaza';
            $criteria->compare('amenaza.nombre',$this->amenaza_id,true);
        }
        if(!empty($this->tipo_activo_id)){
            $with[]= 'tipoActivo';
            $criteria->compare('tipoActivo.nombre',$this->tipo_activo_id,true);
        }
        $criteria->with = $with;
//		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
//		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
//		$criteria->compare('modUserStamp',$this->modUserStamp,true);
//		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchValoracion(){
        $criteria=new CDbCriteria;

//        $criteria->compare('id',$this->id);
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('descripcion',$this->descripcion,true);
        $criteria->compare('numeracion',$this->numeracion,true);
        $criteria->compare('vulnerabilidad_id',$this->vulnerabilidad_id);
//        $criteria->compare('grupo_activo_id',$this->grupo_activo_id);
//        $criteria->compare('analisis_id',$this->analisis_id);
//        $criteria->compare('creaUserStamp',$this->creaUserStamp,true);
//        $criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
//        $criteria->compare('modUserStamp',$this->modUserStamp,true);
//        $criteria->compare('modTimeStamp',$this->modTimeStamp,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,'sort'=>false,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Control the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getFechaValorControl($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
        $analisis_control = AnalisisControl::model()->findByAttributes(array('control_id' => $this->id,
                                                                            'analisis_id' => $analisis_id,
                                                                            'grupo_activo_id' => $grupo_activo_id,
                                                                            'analisis_amenaza_id'=>$analisis_amenaza_id ),array('order'=>'id desc'));
        if(!is_null($analisis_control)){
            return Utilities::ViewDateFormat($analisis_control->fecha);
        }else{
            return "";
        }
    }

    public function getValorControl($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
        $analisis_control = AnalisisControl::model()->findByAttributes(array( 'control_id'=>$this->id,
                                                                            'analisis_id'=>$analisis_id,
                                                                            'grupo_activo_id'=>$grupo_activo_id,
                                                                            'analisis_amenaza_id'=>$analisis_amenaza_id ),array('order'=>'id desc'));
        if(!is_null($analisis_control)){
            return $analisis_control->valor;
        }else{
            return "";
        }
    }

    public static function getControlesEnRiesgo($analisis_riesgo_detalle_id){
        $analisis_riesgo_detalle = AnalisisRiesgoDetalle::model()->findByPk($analisis_riesgo_detalle_id);
        $analisis_riesgo = $analisis_riesgo_detalle->analisisRiesgo;
        $grupo_activo = $analisis_riesgo_detalle->grupoActivo;
        $analisis_control = AnalisisControl::model()->findAllByAttributes(['analisis_id'=>$analisis_riesgo->analisis_id,'grupo_activo_id'=>$grupo_activo->id]);
        $arrayControles = [];
        if(!empty($analisis_control)){
            foreach ($analisis_control as $ac){
                if($ac->valor == GrupoActivo::VALOR_ALTO){
                    $arrayControles[] = $ac;
                }
            }
        }

        return $arrayControles;
    }

    public static function getControlesEnRiesgoParaReporte($analisis_riesgo_detalle_id){
        $analisis_riesgo_detalle = AnalisisRiesgoDetalle::model()->findByPk($analisis_riesgo_detalle_id);
        $analisis_riesgo = $analisis_riesgo_detalle->analisisRiesgo;
        $grupo_activo = $analisis_riesgo_detalle->grupoActivo;
        $analisis_control = AnalisisControl::model()->findAllByAttributes(['analisis_id'=>$analisis_riesgo->analisis_id,'grupo_activo_id'=>$grupo_activo->id]);
        $arrayControles = [];
        if(!empty($analisis_control)){
            foreach ($analisis_control as $ac){
                if($ac->valor == GrupoActivo::VALOR_ALTO){
                    $control = $ac->control;
                    if($control){
                        $arrayControles[] = $control->nombre;
                    }
                }
            }
        }

        return $arrayControles;
    }
}
