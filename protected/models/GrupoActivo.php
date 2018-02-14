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
    public $fecha_valor_amenaza;
    public $valor_amenaza;
    public $valor_activo;
    public $valor_integridad;
    public $valor_confidencialidad;
    public $valor_disponibilidad;
    public $valor_trazabilidad;
    public $nivel_riesgo_id;
    public $analisis_riesgo_id;
    public $analisis_riesgo_detalle_id;
    public $proyecto_id;

    const VALOR_ALTO = 3;
    const VALOR_MEDIO = 2;
    const VALOR_BAJO= 1;

    public static $arrayValores =array(
        self::VALOR_ALTO => 'Alto',
        self::VALOR_MEDIO => 'Medio',
        self::VALOR_BAJO => 'Bajo',
    );

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
			array('valor,activo_id, analisis_id', 'required'),
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

    public function searchGestionRiesgos()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('t.analisis_id',$this->analisis_id);

        $criteria->select = 't.activo_id, ard.*, ard.id as analisis_riesgo_detalle_id, a.proyecto_id as proyecto_id ';
        $criteria->join = " inner join analisis_riesgo_detalle ard  on ard.grupo_activo_id = t.id
                            inner join analisis_riesgo ar on ar.id = ard.analisis_riesgo_id 
                            inner join analisis a on a.id = ar.analisis_id ";

        $criteria->compare('t.activo_id',$this->activo_id);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,'sort'=>false,'pagination'=>['pageSize'=>20]
        ));
    }



	public function searchValoraciones(){

        $criteria=new CDbCriteria;
        $criteria->select = " am.id as amenaza_id, am.nombre as amenaza_nombre , am.tipo_activo_id as tipo_activo_id, ta.nombre as tipo_activo_nombre,
                             g.id as grupo_id, g.nombre as grupo_nombre, t.analisis_id as analisis_id   ";
        if(!is_null($this->amenaza_nombre)){
            $criteria->addCondition(" am.nombre like '%".$this->amenaza_nombre."%'  ");
        }
        if(!is_null($this->grupo_nombre)){
            $criteria->addCondition(" g.nombre like '%".$this->grupo_nombre."%'  ");
        }
        if(!is_null($this->tipo_activo_nombre)){
            $criteria->addCondition(" ta.nombre like '%".$this->tipo_activo_nombre."%'  ");
        }
        $criteria->join = " 
                            inner join activo a on t.activo_id
                            inner join tipo_activo ta on ta.id = a.tipo_activo_id
                            inner join amenaza am on am.tipo_activo_id = ta.id 
                            left join grupo g on g.id = t.grupo_id ";
        $criteria->group = " am.id ";
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

	public function getFechaValorAmenaza(){
        $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(array( 'amenaza_id' => $this->amenaza_id,
                                                                              'analisis_id' => $this->analisis_id,
                                                                              'grupo_id' => $this->grupo_id ),array('order'=>'id desc'));
        if(!is_null($analisis_amenaza)){
            return Utilities::ViewDateFormat($analisis_amenaza->fecha);
        }else{
            return "";
        }
    }

    public function getValorAmenaza(){
        $analisis_amenaza = AnalisisAmenaza::model()->findByAttributes(array( 'amenaza_id'=>$this->amenaza_id,
                                                                                'analisis_id'=>$this->analisis_id,
                                                                                'grupo_id'=>$this->grupo_id ),array('order'=>'id desc'));
        if(!is_null($analisis_amenaza)){
            return $analisis_amenaza->valor;
        }else{
            return "";
        }
    }

    public function getGrupo(){
        if(!is_null($this->grupo_id)){
            $grupo = $this->grupo;
            return $grupo->nombre;
        }else{
            return "";
        }
    }

    public function getClaseFlechaRiesgoAceptable(){

        $analisis_riesgo = AnalisisRiesgo::model()->findByPk($this->analisis_riesgo_id);
        if($analisis_riesgo->riesgo_aceptable < $this->valor_activo){
            return 'fa fa-long-arrow-up ';
        }
        if($analisis_riesgo->riesgo_aceptable > $this->valor_activo){
            return 'fa fa-long-arrow-down ';
        }
        if($analisis_riesgo->riesgo_aceptable == $this->valor_activo){
            return 'fa fa-exchange ';
        }
    }

    public function getClaseNivelDeRiesgo(){
        switch ($this->nivel_riesgo_id){
            case NivelDeRiesgos::CONCEPTO_ACEPTABLE:
                return  'label label-success';
                break;
            case NivelDeRiesgos::CONCEPTO_ACEPTABLE_CON_PRECAUCION:
                return 'label label-warning';
                break;
            case NivelDeRiesgos::CONCEPTO_NO_ACEPTABLE:
                return 'label label-danger';
                break;
        }
    }

    public function getClaseNivelDeValores($valor,$proyecto_id){
       $nivel_riesgo_id = Activo::model()->getNivelDeRiesgo($valor,$proyecto_id);
       $this->nivel_riesgo_id = $nivel_riesgo_id;
       return $this->getClaseNivelDeRiesgo();
    }

    public function getActuacion(){
        $actuacion = ActuacionRiesgo::model()->findByAttributes(['analisis_riesgo_detalle_id'=>$this->analisis_riesgo_detalle_id]);
        if(is_null($actuacion)){
            return "Sin Actuacion";
        }else{
            return ActuacionRiesgo::$acciones[$actuacion->accion];
        }
    }
}
