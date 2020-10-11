<?php

/**
 * This is the model class for table "personal".
 *
 * The followings are the available columns in table 'personal':
 * @property integer $id
 * @property string $apellido
 * @property string $nombre
 * @property string $dni
 * @property string $telefono
 * @property integer $area_id
 * @property integer $proceso_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 * @property integer $puesto_trabajo_id
 *
 * The followings are the available model relations:
 * @property Area $area
 * @property Proceso $proceso
 * @property PuestosDeTrabajo $puestoDeTrabajo
 */
class Personal extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $proyecto_id;

	public function tableName()
	{
		return 'personal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('puesto_trabajo_id,apellido, nombre, dni, telefono, area_id, proceso_id', 'required'),
			array('area_id,proceso_id', 'numerical', 'integerOnly'=>true),
			array('apellido, nombre, dni, telefono, creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('puesto_trabajo_id,proyecto_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('puesto_trabajo_id,proyecto_id,id, apellido, proceso_id,nombre, dni, telefono, area_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'area' => array(self::BELONGS_TO, 'Area', 'area_id'),
            'proceso' => array(self::BELONGS_TO, 'Proceso', 'proceso_id'),

        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'apellido' => 'Apellido',
			'nombre' => 'Nombre',
			'dni' => 'Dni',
			'telefono' => 'Telefono',
			'area_id' => 'Area',
            'proceso_id' => 'Proceso',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'puesto_trabajo_id' =>'Puesto de Trabajo',
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

        $criteria->join = " inner join area a on a.id = t.area_id
                            inner join area_proyecto ap on ap.area_id = a.id ";

        $criteria->compare('ap.proyecto_id',$this->proyecto_id);

        $criteria->compare('id',$this->id);
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('dni',$this->dni,true);
		$criteria->compare('telefono',$this->telefono,true);
        $criteria->together = true;

        if($this->area_id != ""){
            $criteria->with = array('area');
            $criteria->compare('area.nombre',$this->area_id,true);
        };
        if($this->proceso_id != ""){
            $criteria->with = array('proceso');
            $criteria->compare('proceso.nombre',$this->proceso_id,true);
        };
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Personal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPersonalDisponiblePorProyecto(){
        $arrayPersonal = [];
        if(Yii::app()->user){
            $usuario = User::model()->findByPk(Yii::app()->user->model->id);
            if(!is_null($usuario->ultimo_proyecto_id)){
                $query = " select t.id, concat(t.nombre,', ',t.apellido) as nombre
                        from personal t 
                        inner join area a on t.area_id = a.id
                        inner join area_proyecto ap on a.id = ap.area_id 
                        where ap.proyecto_id = ".$usuario->ultimo_proyecto_id."
                        group by t.id; ";
                $arrayPersonal = Personal::model()->findAllBySql($query);
            }
        }
        return $arrayPersonal;
    }
}
