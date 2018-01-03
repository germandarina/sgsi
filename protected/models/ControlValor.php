<?php

/**
 * This is the model class for table "control_valor".
 *
 * The followings are the available columns in table 'control_valor':
 * @property integer $id
 * @property string $fecha
 * @property integer $valor
 * @property integer $control_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Control $id0
 */
class ControlValor extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'control_valor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		    array('valor,control_id,fecha','required'),
			array('valor, control_id', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('fecha, creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, valor, control_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'control' => array(self::BELONGS_TO, 'Control', 'control_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'valor' => 'Valor',
			'control_id' => 'Control',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('control_id',$this->control_id);
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
	 * @return ControlValor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
