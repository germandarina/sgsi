<?php

/**
 * This is the model class for table "afi_elementoFormulario".
 *
 * The followings are the available columns in table 'afi_elementoFormulario':
 * @property integer $id
 * @property integer $formularioId
 * @property string $nombreCampo
 * @property integer $tipoCampoId
 * @property integer $requerido
 * @property integer $label
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property ElementoFormulario $formulario
 * @property ElementoFormulario[] $elementoFormularios
 */
class ElementoFormulario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'elementoFormulario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formularioId, nombreCampo, tipoCampoId, creaUserStamp, creaTimeStamp', 'required'),
			array('formularioId, tipoCampoId, requerido', 'numerical', 'integerOnly'=>true),
			array('nombreCampo, label, creaUserStamp, modUserStamp', 'length', 'max'=>100),
			array('modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, formularioId, nombreCampo, tipoCampoId, label, requerido, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'tipoCampo' => array(self::BELONGS_TO, 'TipoCampo', 'tipoCampoId'),
			'formulario' => array(self::BELONGS_TO, 'Formulario', 'formularioId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'formularioId' => 'Formulario',
			'nombreCampo' => 'Nombre Campo',
			'tipoCampoId' => 'Tipo Campo',
			'requerido' => 'Requerido',
			'label' => 'Label',
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
		$criteria->compare('formularioId',$this->formularioId);
		$criteria->compare('nombreCampo',$this->nombreCampo,true);
		$criteria->compare('tipoCampoId',$this->tipoCampoId);
		$criteria->compare('requerido',$this->requerido);
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
	 * @return ElementoFormulario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public  function esRequerido($formularioId,$nombreCampo){
		$elemento = ElementoFormulario::model()->find('formularioId=:formularioId and nombreCampo=:nombreCampo',
		                                        array(":formularioId"=>$formularioId,":nombreCampo"=>$nombreCampo));
		return $elemento->requerido;                                       		
	}
}
