<?php

/**
 * This is the model class for table "proceso".
 *
 * The followings are the available columns in table 'proceso':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $area_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Area $area
 */
class Proceso extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $area_id_2;
	public $activo_id;
	public $proyecto_id;

	public function tableName()
	{
		return 'proceso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, area_id', 'required'),
			array('area_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('proyecto_id,activo_id,area_id_2,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('proyecto_id,activo_id,area_id_2,id, nombre, descripcion, area_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
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
        $criteria->join = " inner join area a on a.id = t.area_id
                            inner join area_proyecto ap on ap.area_id = a.id ";
        $criteria->compare('ap.proyecto_id',$this->proyecto_id);
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
        if($this->area_id_2 != ""){
            $criteria->together = true;
            $criteria->with = array('area');
            $criteria->compare('area.id',$this->area_id_2,true);
        }
        if($this->area_id != ""){
            $criteria->together = true;
            $criteria->with = array('area');
            $criteria->compare('area.nombre',$this->area_id,true);
        }
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPorActivo(){
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = " t.* ";
        $criteria->join = " inner join area a on a.id = t.area_id
                            inner join activo_area aa on aa.area_id = a.id
                          ";
        $criteria->addCondition(" aa.activo_id = ".$this->activo_id );
        $criteria->group = " t.id ";

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Proceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getActivos(){
	    $activos_areas = ActivoArea::model()->findAllByAttributes(['area_id'=>$this->area_id]);
        $array_activos=[];
	    if(!empty($activos_areas)){
	        foreach ($activos_areas as $relacional){
                if(!array_key_exists($relacional->activo_id,$array_activos)){
                    $array_activos[$relacional->activo_id] = $relacional->activo;
                }
            }
        }
	    return $array_activos;
    }
}
