<?php

/**
 * This is the model class for table "afi_valorElemento".
 *
 * The followings are the available columns in table 'afi_valorElemento':
 * @property integer $id
 * @property integer $elementoId
 * @property string $valor
 * @property integer $archivoId
 * @property integer $modelId
 * @property string $model
 */
class ValorElemento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'valorElemento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('elementoId, modelId, model', 'required'),
			array('elementoId, archivoId, modelId', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>254),
			array('model', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, elementoId, valor, archivoId, modelId, model', 'safe', 'on'=>'search'),
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
			'elementoId' => 'Elemento',
			'valor' => 'Valor',
			'archivoId' => 'Archivo',
			'modelId' => 'Model',
			'model' => 'Model',
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
		$criteria->compare('elementoId',$this->elementoId);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('archivoId',$this->archivoId);
		$criteria->compare('modelId',$this->modelId);
		$criteria->compare('model',$this->model,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValorElemento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCountValorElemento($modelId,$model,$elementoId){
    	$valorElemento = ValorElemento::model()->findAll('model=:model and modelId=:modelId and elementoId=:elementoId',
    		array(":model"=>$model,":modelId"=>$modelId,":elementoId"=>$elementoId));
    	return count($valorElemento);
    }
}
