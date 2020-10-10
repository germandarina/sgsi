<?php

/**
 * This is the model class for table "actuacion_riesgo".
 *
 * The followings are the available columns in table 'actuacion_riesgo':
 * @property integer $id
 * @property integer $analisis_riesgo_detalle_id
 * @property string $fecha
 * @property string $descripcion
 * @property integer $accion
 * @property integer $accion_transferir
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property AnalisisRiesgoDetalle $analisisRiesgoDetalle
 */
class ActuacionRiesgo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	const ACCION_RETENCION = 0;
    const ACCION_REDUCION = 1;
    const ACCION_TRANSFERIR = 2;
    const ACCION_EVITAR = 3;

    const ACCION_TRANSFERIR_PROVEEDORES = 0;
    const ACCION_TRANSFERIR_TERCEROS = 1;
    const ACCION_TRANSFERIR_SEGUROS = 2;

    public static $acciones = [
        self::ACCION_RETENCION => 'Retencion',
        self::ACCION_REDUCION => 'Reduccion',
        self::ACCION_TRANSFERIR => 'Transferir',
        self::ACCION_EVITAR => 'Evitar',
    ];

    public static $accionesTransferir = [
        self::ACCION_TRANSFERIR_PROVEEDORES => 'Proveedores',
        self::ACCION_TRANSFERIR_TERCEROS => 'Terceros',
        self::ACCION_TRANSFERIR_SEGUROS => 'Seguros',
    ];
	public function tableName()
	{
		return 'actuacion_riesgo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accion,analisis_riesgo_detalle_id, fecha, descripcion', 'required'),
			array('accion_transferir,analisis_riesgo_detalle_id', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>200),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('accion_transferir,accion,id, analisis_riesgo_detalle_id, fecha, descripcion, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'analisisRiesgoDetalle' => array(self::BELONGS_TO, 'AnalisisRiesgoDetalle', 'analisis_riesgo_detalle_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'analisis_riesgo_detalle_id' => 'Analisis Riesgo Detalle',
			'fecha' => 'Fecha',
			'descripcion' => 'Descripcion',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'accion_transferir' => 'Transferir a',
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
		$criteria->compare('analisis_riesgo_detalle_id',$this->analisis_riesgo_detalle_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('descripcion',$this->descripcion,true);
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
	 * @return ActuacionRiesgo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
