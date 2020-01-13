<?php

/**
 * This is the model class for table "proyecto".
 *
 * The followings are the available columns in table 'proyecto':
 * @property integer $id
 * @property integer usuario_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 * @property integer $organizacion_id
 */
class Proyecto extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $areas = [];
	public $usuarios = [];

	public function tableName()
	{
		return 'proyecto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios,areas,organizacion_id,nombre, descripcion,fecha', 'required'),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('usuarios,usuario_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('usuarios,organizacion_id,usuario_id,areas,id, nombre, descripcion, fecha, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
            'usuario' => array(self::BELONGS_TO, 'User', 'usuario_id'),
            'organizacion' => array(self::BELONGS_TO, 'Organizacion', 'organizacion_id'),
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
			'fecha' => 'Fecha',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'usuario_id'=>'Usuario',
            'organizacion_id' =>'Organizacion',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		//$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
	//	$criteria->compare('modUserStamp',$this->modUserStamp,true);
    //		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);
    //       $criteria->compare('usuario_id',$this->usuario_id,true);

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Proyecto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAreas(){
        $areas_proyectos = AreaProyecto::model()->findAllByAttributes(['proyecto_id'=>$this->id]);
        if(!empty($areas_proyectos)){
            $stringAreas = "";
            foreach ($areas_proyectos as $ap){
                $area = $ap->area;
                $stringAreas .= $area->nombre.' / ';
            }
            return trim($stringAreas, ' / ');
        }else{
            return "";
        }
    }

    public function getProyectosPorUsuario($usuario_id){
	    $query = " select p.*
	                 from proyecto p 
	                 inner join proyecto_usuario pu on pu.proyecto_id = p.id
	                 where pu.usuario_id = ".$usuario_id."
	                 group by pu.proyecto_id ";
	    $proyectos = Proyecto::model()->findAllBySql($query);
	    return $proyectos;
    }
}
