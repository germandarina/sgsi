<?php

/**
 * This is the model class for table "puestos_de_trabajo".
 *
 * The followings are the available columns in table 'puestos_de_trabajo':
 * @property integer $id
 * @property integer $area_id
 * @property string $nombre
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Area $area
 */
class PuestosDeTrabajo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'puestos_de_trabajo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('area_id, nombre', 'required'),
			array('area_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>255),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, area_id, nombre, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'area_id' => 'Area',
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
        $criteria->select = " t.id,t.area_id,t.nombre ";
        $criteria->join = " inner join area a on a.id = t.area_id
                            inner join area_proyecto ap on ap.area_id = a.id ";
        $usuario = User::model()->getUsuarioLogueado();
        if(is_null($usuario) || is_null($usuario->ultimo_proyecto_id)){
            throw new Exception("Debe seleccionar un proyecto para empezar a trabajar");
        }
		$criteria->compare('ap.proyecto_id',$usuario->ultimo_proyecto_id);
		$criteria->compare('t.nombre',$this->nombre,true);
        if($this->area_id != ""){
            $criteria->together = true;
            $criteria->with = array('area');
            $criteria->compare('area.nombre',$this->area_id,true);
        }
		$criteria->group = ' t.id ';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PuestosDeTrabajo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
