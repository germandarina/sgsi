<?php

/**
 * This is the model class for table "plan".
 *
 * The followings are the available columns in table 'plan':
 * @property integer $id
 * @property integer $analisis_id
 * @property string $fecha
 * @property string $nombre
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Analisis $analisis
 * @property PlanDetalle[] $planDetalles
 */
class Plan extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('analisis_id, fecha, nombre', 'required'),
			array('analisis_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, analisis_id, fecha, nombre, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'analisis' => array(self::BELONGS_TO, 'Analisis', 'analisis_id'),
			'planDetalles' => array(self::HAS_MANY, 'PlanDetalle', 'plan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'analisis_id' => 'Analisis',
			'fecha' => 'Fecha',
			'nombre' => 'Nombre',
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
		$criteria->compare('analisis_id',$this->analisis_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('nombre',$this->nombre,true);
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
	 * @return Plan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getActivosAfectados($plan_detalle_id){
        $query = "select al.nombre as nombre_analisis, a.nombre as nombre_activo, ta.nombre as nombre_tipo_activo
                            from plan_detalle pl
                            inner join plan p on p.id =pl.plan_id
                            inner join analisis al on al.id = p.analisis_id
                            inner join analisis_control ac on ac.id = pl.analisis_control_id
                            inner join grupo_activo ga on ga.id = ac.grupo_activo_id
                            inner join activo a on a.id = ga.activo_id
                            inner join tipo_activo ta on ta.id = a.tipo_activo_id
                            where pl.id = ".$plan_detalle_id."  ";
        $command = Yii::app()->db->createCommand($query);
        $resultados = $command->queryAll($query);
        return $resultados;
    }
}
