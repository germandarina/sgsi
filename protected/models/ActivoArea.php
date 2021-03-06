<?php

/**
 * This is the model class for table "activo_area".
 *
 * The followings are the available columns in table 'activo_area':
 * @property integer $id
 * @property integer $activo_id
 * @property integer $area_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Activo $activo
 * @property Area $area
 */
class ActivoArea extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $procesos = [];
	public function tableName()
	{
		return 'activo_area';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activo_id, area_id,procesos', 'required'),
			array('activo_id, area_id', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, procesos,activo_id, area_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'activo'    => array(self::BELONGS_TO, 'Activo', 'activo_id'),
			'area'      => array(self::BELONGS_TO, 'Area', 'area_id'),
            'area_procesos'  => [self::HAS_MANY,'ActivoAreaProceso','activo_area_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'activo_id' => 'Activo',
			'area_id' => 'Area',
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
		$criteria->compare('activo_id',$this->activo_id);
		$criteria->compare('area_id',$this->area_id);
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
	 * @return ActivoArea the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getProcesos(){
	    $area_procesos = $this->area_procesos;
	    $procesos = "";
	    if(!empty($area_procesos)){
	        foreach ($area_procesos as $detalle){
                $procesos .= $detalle->proceso->nombre.' / ';
            }
	        $procesos = trim($procesos,' / ');
        }
	    return $procesos;
    }
}
