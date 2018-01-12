<?php

/**
 * This is the model class for table "grupo_activo".
 *
 * The followings are the available columns in table 'grupo_activo':
 * @property integer $id
 * @property integer $activo_id
 * @property integer $grupo_id
 * @property integer $analisis_id
 * @property integer $confidencialidad
 * @property integer $integridad
 * @property integer $disponibilidad
 * @property integer $trazabilidad
 * @property integer $valor
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Activo $activo
 * @property Analisis $analisis
 * @property Grupo $grupo
 */
class GrupoActivo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $amenaza_nombre;
    public $grupo_nombre;
    public $tipo_activo_nombre;
    public $amenaza_id;
	public function tableName()
	{
		return 'grupo_activo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valor,activo_id, analisis_id, confidencialidad, integridad, disponibilidad, trazabilidad', 'required'),
			array('activo_id, grupo_id, analisis_id, confidencialidad, integridad, disponibilidad, trazabilidad', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('amenaza_nombre,grupo_nombre,activo_nombre,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('amenaza_id,amenaza_nombre,grupo_nombre,tipo_activo_nombre,id, valor,activo_id, grupo_id, analisis_id, confidencialidad, integridad, disponibilidad, trazabilidad, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'activo' => array(self::BELONGS_TO, 'Activo', 'activo_id'),
			'analisis' => array(self::BELONGS_TO, 'Analisis', 'analisis_id'),
			'grupo' => array(self::BELONGS_TO, 'Grupo', 'grupo_id'),
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
			'grupo_id' => 'Grupo',
			'analisis_id' => 'Analisis',
			'confidencialidad' => 'Confidencialidad',
			'integridad' => 'Integridad',
			'disponibilidad' => 'Disponibilidad',
			'trazabilidad' => 'Trazabilidad',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'valor'=>'Valor',
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
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.activo_id',$this->activo_id);
		$criteria->compare('t.grupo_id',$this->grupo_id);
		$criteria->compare('t.analisis_id',$this->analisis_id);
		$criteria->compare('t.confidencialidad',$this->confidencialidad);
		$criteria->compare('t.integridad',$this->integridad);
		$criteria->compare('t.disponibilidad',$this->disponibilidad);
		$criteria->compare('t.trazabilidad',$this->trazabilidad);
        $criteria->join = " left join grupo g  on g.id = t.grupo_id ";
        $criteria->order = " g.id, g.tipo_activo_id ";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchValoraciones(){

        $criteria=new CDbCriteria;
        $criteria->select = " am.id as amenaza_id, am.nombre as amenaza_nombre , am.tipo_activo_id as tipo_activo_id, ta.nombre as tipo_activo_nombre,
                             g.id as grupo_id, g.nombre as grupo_nombre   ";
        if(!is_null($this->amenaza_nombre)){
            $criteria->addCondition(" am.nombre like '%".$this->amenaza_nombre."%'  ");
        }
        if(!is_null($this->grupo_nombre)){
            $criteria->addCondition(" g.nombre like '%".$this->grupo_nombre."%'  ");
        }
        if(!is_null($this->tipo_activo_nombre)){
            $criteria->addCondition(" ta.nombre like '%".$this->tipo_activo_nombre."%'  ");
        }
        $criteria->join = " left join grupo g  on g.id = t.grupo_id 
                            inner join activo a on t.activo_id
                            inner join tipo_activo ta on ta.id = a.tipo_activo_id
                            inner join amenaza am on am.tipo_activo_id = ta.id ";
        $criteria->order = " ta.id asc ";
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GrupoActivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getActivos(){
//        $activo = $this->activo;
//        $tipoActivo = $activo->tipoActivo;
//        $
    }
}
