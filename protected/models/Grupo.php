<?php

/**
 * This is the model class for table "grupo".
 *
 * The followings are the available columns in table 'grupo':
 * @property integer $id
 * @property string $nombre
 * @property string $criterio
 * @property integer $tipo_activo_id
 * @property integer $proyecto_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property TipoActivo $tipoActivo
 * @property GrupoActivo[] $grupoActivos
 * @property Proyecto $proyecto
 */
class Grupo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grupo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		    array('tipo_activo_id,nombre,criterio','required'),
			array('proyecto_id,tipo_activo_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('criterio', 'length', 'max'=>800),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('proyecto_id,id, nombre, criterio, tipo_activo_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'tipoActivo' => array(self::BELONGS_TO, 'TipoActivo', 'tipo_activo_id'),
			'grupoActivos' => array(self::HAS_MANY, 'GrupoActivo', 'grupo_id'),
            'proyecto' => array(self::BELONGS_TO, 'Proyecto', 'proyecto_id'),
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
			'criterio' => 'Criterio',
			'tipo_activo_id' => 'Tipo Activo',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'proyecto_id'=>'Proyecto'
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
		$criteria->compare('criterio',$this->criterio,true);
		$criteria->compare('tipo_activo_id',$this->tipo_activo_id);
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Grupo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getGruposDelAnalisis($analisis_id){
        $query = "select g.nombre, g.id
                    from grupo g
                    inner join grupo_activo ga on ga.grupo_id = g.id
                    where analisis_id = ".$analisis_id."  ";
        $command = Yii::app()->db->createCommand($query);
        $resultado = $command->queryAll($query);
        return $resultado;
    }

    public function getActivosPorGrupo(){
	    $grupoActivos = $this->grupoActivos;
        $array_activos = [];
	    if(!empty($grupoActivos)){
	        foreach ($grupoActivos as $relacional){
                if(!array_key_exists($relacional->activo_id,$array_activos)){
                    $array_activos[$relacional->activo_id] = $relacional->activo;
                }
	        }
        }
	    return $array_activos;
    }
}
