<?php

/**
 * This is the model class for table "tipo_activo".
 *
 * The followings are the available columns in table 'tipo_activo':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $confidencialidad
 * @property integer $integridad
 * @property integer $disponibilidad
 * @property integer $trazabilidad
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 */
class TipoActivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_activo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, confidencialidad, integridad, disponibilidad, trazabilidad', 'required'),
			array('confidencialidad, integridad, disponibilidad, trazabilidad', 'numerical', 'integerOnly'=>true),
			array('nombre, descripcion, creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, confidencialidad, integridad, disponibilidad, trazabilidad, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'confidencialidad' => 'Confidencialidad',
			'integridad' => 'Integridad',
			'disponibilidad' => 'Disponibilidad',
			'trazabilidad' => 'Trazabilidad',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('confidencialidad',$this->confidencialidad);
		$criteria->compare('integridad',$this->integridad);
		$criteria->compare('disponibilidad',$this->disponibilidad);
		$criteria->compare('trazabilidad',$this->trazabilidad);
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
	 * @return TipoActivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
