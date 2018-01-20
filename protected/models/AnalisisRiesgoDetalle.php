<?php

/**
 * This is the model class for table "analisis_riesgo_detalle".
 *
 * The followings are the available columns in table 'analisis_riesgo_detalle':
 * @property integer $id
 * @property integer $analisis_riesgo_id
 * @property integer $grupo_activo_id
 * @property integer $valor_activo
 * @property integer $valor_integridad
 * @property integer $valor_disponibilidad
 * @property integer $valor_confidencialidad
 * @property integer $valor_trazabilidad
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property AnalisisRiesgo $analisisRiesgo
 * @property GrupoActivo $grupoActivo
 */
class AnalisisRiesgoDetalle extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'analisis_riesgo_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('analisis_riesgo_id, grupo_activo_id, valor_activo, valor_integridad, valor_disponibilidad, valor_confidencialidad, valor_trazabilidad', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, analisis_riesgo_id, grupo_activo_id, valor_activo, valor_integridad, valor_disponibilidad, valor_confidencialidad, valor_trazabilidad, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'analisisRiesgo' => array(self::BELONGS_TO, 'AnalisisRiesgo', 'analisis_riesgo_id'),
			'grupoActivo' => array(self::BELONGS_TO, 'GrupoActivo', 'grupo_activo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'analisis_riesgo_id' => 'Analisis Riesgo',
			'grupo_activo_id' => 'Grupo Activo',
			'valor_activo' => 'Valor Activo',
			'valor_integridad' => 'Valor Integridad',
			'valor_disponibilidad' => 'Valor Disponibilidad',
			'valor_confidencialidad' => 'Valor Confidencialidad',
			'valor_trazabilidad' => 'Valor Trazabilidad',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
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
		$criteria->compare('analisis_riesgo_id',$this->analisis_riesgo_id);
		$criteria->compare('grupo_activo_id',$this->grupo_activo_id);
		$criteria->compare('valor_activo',$this->valor_activo);
		$criteria->compare('valor_integridad',$this->valor_integridad);
		$criteria->compare('valor_disponibilidad',$this->valor_disponibilidad);
		$criteria->compare('valor_confidencialidad',$this->valor_confidencialidad);
		$criteria->compare('valor_trazabilidad',$this->valor_trazabilidad);
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
	 * @return AnalisisRiesgoDetalle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
