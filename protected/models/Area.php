<?php

/**
 * This is the model class for table "area".
 *
 * The followings are the available columns in table 'area':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $organizacion_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Personal[] $personals
 * @property Proceso[] $procesos
 *  @property Organizacion $organizacion
 */
class Area extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $proyecto_id;

	public function tableName()
	{
		return 'area';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, organizacion_id', 'required'),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('proyecto_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('proyecto_id,id,organizacion_id, nombre, descripcion, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'personals' => array(self::HAS_MANY, 'Personal', 'area_id'),
			'procesos' => array(self::HAS_MANY, 'Proceso', 'area_id'),
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
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'organizacion_id'=>'Organizacion',
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

        $criteria->join = " inner join area_proyecto ap on ap.area_id = t.id ";
        $criteria->compare('ap.proyecto_id',$this->proyecto_id);

        $criteria->compare('t.id',$this->id);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.descripcion',$this->descripcion,true);
		$criteria->compare('t.creaUserStamp',$this->creaUserStamp,true);
		$criteria->compare('t.creaTimeStamp',$this->creaTimeStamp,true);
        if($this->organizacion_id != ""){
            $criteria->with = array('organizacion');
            $criteria->compare('organizacion.nombre',$this->organizacion_id,true);
        };
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
	 * @return Area the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAreasDisponibles(){
        if(Yii::app()->user->model->isAdmin()){
            return $this->findAll();
        }else{
            $usuario = User::model()->findByPk(Yii::app()->user->model->id);
            $arrayAreas = [];
            if(!is_null($usuario->ultimo_proyecto_id)){
                $area_proyecto = AreaProyecto::model()->findAllByAttributes(['proyecto_id'=>$usuario->ultimo_proyecto_id]);
                if(!empty($area_proyecto)){
                    foreach ($area_proyecto as $ap){
                        $arrayAreas[] = Area::model()->findByPk($ap->area_id);
                    }
                }
            }
            return $arrayAreas;
        }
    }
}
