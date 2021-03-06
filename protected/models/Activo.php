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
 * @property integer $cantidad
 * @property integer $proyecto_id
 * @property string $ubicacion
 * The followings are the available model relations:
 * @property Personal $personal
 * @property TipoActivo $tipoActivo
 * @property Proyecto $proyecto
 * @property ActivoArea[] $activoAreas
 * @property GrupoActivo[] $grupoActivos
 */
class Activo extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $areas = [];
	public $area_id;
	public $grupo_id;
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
			array('cantidad,nombre, descripcion, tipo_activo_id', 'required'),
			array('proyecto_id,tipo_activo_id, personal_id', 'numerical', 'integerOnly'=>true),
			array('ubicacion,nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('grupo_id,area_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('grupo_id,area_id,proyecto_id,id, nombre, descripcion, tipo_activo_id, personal_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
            'proyecto' => array(self::BELONGS_TO, 'Proyecto', 'proyecto_id'),
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
            'proyecto_id'=>'Proyecto',
            'area_id'=>'Area',
            'grupo_id'=>'Grupo'
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
//        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
//        if(!is_null($usuario->ultimo_proyecto_id)){
//            $criteria->compare('proyecto_id',$usuario->ultimo_proyecto_id);
//        }

		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
        $criteria->compare('cantidad',$this->cantidad,true);
        $criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('tipo_activo_id',$this->tipo_activo_id);
        if(!empty($this->personal_id)){
            $criteria->together = true;
            $criteria->with = ['personal'];
            $criteria->addCondition("personal.nombre LIKE '%".$this->personal_id."%' or personal.apellido LIKE '%".$this->personal_id."%' ");

        }
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPorArea(){
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = " t.* ";
        $criteria->join = " inner join activo_area aa on aa.activo_id = t.id ";
        $criteria->addCondition(" aa.area_id = ".$this->area_id);
        $criteria->group = " t.id ";
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function searchPorGrupo(){
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = " t.* ";
        $criteria->join = " inner join grupo_activo ga on ga.activo_id = t.id ";
        $criteria->addCondition(" ga.grupo_id = ".$this->grupo_id);
        $criteria->group = " t.id ";
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

    public function getPadresDisponibles($analisis_id,$proyecto_id){
       $queryPadres = " select a.id, concat(a.nombre, ' - ',ta.nombre) as nombre
                            from activo a
                            inner join tipo_activo ta on ta.id = a.tipo_activo_id
                            inner join grupo_activo ga on  ga.activo_id = a.id
                            left join (
                            select d.activo_padre_id
                            from dependencia d
                            inner join analisis an on an.id=d.analisis_id
                            where an.id = ".$analisis_id." and an.proyecto_id = ".$proyecto_id." and d.activo_padre_id is not null
                            )consulta on consulta.activo_padre_id = a.id
                            where consulta.activo_padre_id is null
                            and ga.analisis_id = ".$analisis_id."
                            and a.proyecto_id= ".$proyecto_id."
                            group by a.id
                            order by nombre;";
       $command = Yii::app()->db->createCommand($queryPadres);
       $padres = $command->queryAll($queryPadres);
       return $padres;
    }

    public function getHijosDisponibles($analisis_id,$proyecto_id){
        $queryHijos = " select a.id, concat(a.nombre, ' - ',ta.nombre) as nombre
                            from activo a
                            inner join tipo_activo ta on ta.id = a.tipo_activo_id
                            inner join grupo_activo ga on  ga.activo_id = a.id
                            inner join analisis an on an.id = ga.analisis_id
                            left join dependencia d on d.activo_id = ga.activo_id
                            where (d.id is null or (d.id is not null and d.activo_padre_id is not null))
                            and a.proyecto_id = ".$proyecto_id."
                            and ga.analisis_id = ".$analisis_id."
                            group by a.id
                            order by nombre ";
        $command = Yii::app()->db->createCommand($queryHijos);
        $hijos = $command->queryAll($queryHijos);
        return $hijos;
    }

    public function getNivelDeRiesgo($valor_riesgo_activo,$proyecto_id){
        $nivelesRiesgo = NivelDeRiesgos::model()->findAllByAttributes(['proyecto_id'=>$proyecto_id]);
        foreach ($nivelesRiesgo as $nivel){
            if($valor_riesgo_activo >= $nivel->valor_minimo && $valor_riesgo_activo <= $nivel->valor_maximo){
                return $nivel->concepto;
            }
        }
    }

    public function getProcesos(){
        $activos_areas = ActivoArea::model()->findAllByAttributes(['activo_id'=>$this->id]);
        $array_procesos=[];
        if(!empty($activos_areas)){
            foreach ($activos_areas as $relacional){
                $procesos = Proceso::model()->findAllByAttributes(['area_id'=>$relacional->area_id]);
                if(!empty($procesos)){
                    foreach ($procesos as $proceso){
                        if(!array_key_exists($proceso->id,$array_procesos)){
                            $array_procesos[$proceso->id] = $proceso;
                        }
                    }
                }
            }
        }
        return $array_procesos;
    }

    public function getPadresMultiples($activo_padre_id,$analisis_id){
        $queryPadres = "select a.*, d.id as getActivosPorTipo from 
                             dependencia d 
                             inner join activo a on d.activo_padre_id = a.id
                             where d.activo_id =".$activo_padre_id." 
                             and d.analisis_id =".$analisis_id."
                             group by d.numero
                             ";
        $command = Yii::app()->db->createCommand($queryPadres);
        $padres = $command->queryAll($queryPadres);
        return $padres;
    }
}
