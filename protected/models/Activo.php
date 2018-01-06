<?php

/**
 * This is the model class for table "activo".
 *
 * The followings are the available columns in table 'activo':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $tipo_activo_id
 * @property integer $personal_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Personal $personal
 * @property TipoActivo $tipoActivo
 * @property ActivoArea[] $activoAreas
 * @property GrupoActivo[] $grupoActivos
 */
class Activo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $areas;
	public function tableName()
	{
		return 'activo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('areas,nombre, descripcion, tipo_activo_id, personal_id', 'required'),
			array('tipo_activo_id, personal_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('descripcion', 'length', 'max'=>200),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, tipo_activo_id, personal_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'personal' => array(self::BELONGS_TO, 'Personal', 'personal_id'),
			'tipoActivo' => array(self::BELONGS_TO, 'TipoActivo', 'tipo_activo_id'),
			'activoAreas' => array(self::HAS_MANY, 'ActivoArea', 'activo_id'),
			'grupoActivos' => array(self::HAS_MANY, 'GrupoActivo', 'activo_id'),
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
			'tipo_activo_id' => 'Tipo Activo',
			'personal_id' => 'Personal',
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
		$criteria->compare('tipo_activo_id',$this->tipo_activo_id);
        if(!empty($this->personal_id)){
            $criteria->together = true;
            $criteria->with = ['personal'];
            $criteria->addCondition("personal.nombre LIKE '%".$this->personal_id."%' or personal.apellido LIKE '%".$this->personal_id."%' ");
//            $criteria->compare('personal.nombre',$this->personal_id,true);
//            $criteria->compare('personal.apellido',$this->personal_id,true);
        }
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
//		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
//		$criteria->compare('modUserStamp',$this->modUserStamp,true);
//		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Activo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPersonal(){
        return $this->personal->apellido.' , '.$this->personal->nombre;
    }
}
