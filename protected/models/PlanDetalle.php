<?php

/**
 * This is the model class for table "plan_detalle".
 *
 * The followings are the available columns in table 'plan_detalle':
 * @property integer $id
 * @property integer $plan_id
 * @property integer $analisis_control_id
 * @property string $fecha_posible_inicio
 * @property string $fecha_posible_fin
 * @property string $fecha_real_inicio
 * @property string $fecha_real_fin
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Plan $plan
 * @property AnalisisControl $analisisControl
 */
class PlanDetalle extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plan_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plan_id, analisis_control_id', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
            array('fecha_posible_inicio, fecha_posible_fin','required','on'=>'guardarValores'),
			array('fecha_posible_inicio, fecha_posible_fin, fecha_real_inicio, fecha_real_fin, creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plan_id, analisis_control_id, fecha_posible_inicio, fecha_posible_fin, fecha_real_inicio, fecha_real_fin, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'plan' => array(self::BELONGS_TO, 'Plan', 'plan_id'),
			'analisisControl' => array(self::BELONGS_TO, 'AnalisisControl', 'analisis_control_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'plan_id' => 'Plan',
			'analisis_control_id' => 'Analisis Control',
			'fecha_posible_inicio' => 'Fecha Posible Inicio',
			'fecha_posible_fin' => 'Fecha Posible Fin',
			'fecha_real_inicio' => 'Fecha Real Inicio',
			'fecha_real_fin' => 'Fecha Real Fin',
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

		//$criteria->compare('id',$this->id);
		$criteria->compare('plan_id',$this->plan_id);
//		$criteria->compare('analisis_control_id',$this->analisis_control_id);
//		$criteria->compare('fecha_posible_inicio',$this->fecha_posible_inicio,true);
//		$criteria->compare('fecha_posible_fin',$this->fecha_posible_fin,true);
//		$criteria->compare('fecha_real_inicio',$this->fecha_real_inicio,true);
//		$criteria->compare('fecha_real_fin',$this->fecha_real_fin,true);
//		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
//		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
//		$criteria->compare('modUserStamp',$this->modUserStamp,true);
//		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>false,'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlanDetalle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
