<?php

/**
 * This is the model class for table "vulnerabilidad".
 *
 * The followings are the available columns in table 'vulnerabilidad':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Control[] $controls
 * @property Amenaza $amenaza
 */
class Vulnerabilidad extends CustomCActiveRecord
{
    public $fecha_valor_vulnerabilidad;
    public $valor_vulnerabilidad;
	public $tipo_activo_id;
    public $amenazas;
    public $array_amenazas = [];
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vulnerabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion,array_amenazas', 'required'),

            array('tipo_activo_id', 'required','on'=>'create'),
			//array('amenaza_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>250),
			array('descripcion', 'length', 'max'=>800),
			array('tipo_activo_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tipo_activo_id,id, nombre, descripcion, amenazas, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'controles' => array(self::HAS_MANY, 'Control', 'vulnerabilidad_id'),
			'amenaza_vulnerabilidad' => array(self::HAS_MANY, 'AmenazaVulnerabilidad', 'vulnerabilidad_id'),
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
			'amenazas' => 'Amenazas',
            'array_amenazas' => 'Amenazas',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'tipo_activo_id' => 'Tipo Activo',
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
	public function search($amenaza_id = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select= " t.id, t.nombre, t.descripcion, t.creaUserStamp, group_concat(a.nombre) as amenazas ";
		$criteria->join = " inner join amenaza_vulnerabilidad am on am.vulnerabilidad_id = t.id
		                    inner join amenaza a on a.id = am.amenaza_id ";
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.descripcion',$this->descripcion,true);
        if(!empty($this->amenazas)){
            $criteria->addCondition(" a.nombre like '%".$this->amenazas."%' ");
        }
        if(!is_null($amenaza_id)){
            $criteria->compare("a.id",$amenaza_id);
        }
        $criteria->group = "t.id";
		//$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
		//$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
		//$criteria->compare('modUserStamp',$this->modUserStamp,true);
		//$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vulnerabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getFechaValorVulnerabilidad($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
        $analisis_vulnerabilidad = AnalisisVulnerabilidad::model()->findByAttributes(array( 'vulnerabilidad_id' => $this->id,
                                                                            'analisis_id' => $analisis_id,
                                                                            'grupo_activo_id' => $grupo_activo_id,
                                                                            'analisis_amenaza_id'=>$analisis_amenaza_id),array('order'=>'id desc'));
        if(!is_null($analisis_vulnerabilidad)){
            return Utilities::ViewDateFormat($analisis_vulnerabilidad->fecha);
        }else{
            return "";
        }
    }

    public function getValorVulnerabilidad($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
        $analisis_vulnerabilidad = AnalisisVulnerabilidad::model()->findByAttributes(array( 'vulnerabilidad_id'=>$this->id,
                                                                                            'analisis_id'=>$analisis_id,
                                                                                            'grupo_activo_id'=>$grupo_activo_id,
                                                                                            'analisis_amenaza_id'=>$analisis_amenaza_id ),array('order'=>'id desc'));
        if(!is_null($analisis_vulnerabilidad)){
            return $analisis_vulnerabilidad->valor;
        }else{
            return "";
        }
    }

    public function getMayorValorVulnerabilidad($analisis_id,$grupo_activo_id){
        $queryDistinct ="select distinct(vulnerabilidad_id) as id
                        from analisis_vulnerabilidad
                        where analisis_id = ".$analisis_id."
                        and grupo_activo_id = ".$grupo_activo_id."
                       ";
        $commmand = Yii::app()->db->createCommand($queryDistinct);
        $resutados = $commmand->queryAll($queryDistinct);
        if(!empty($resutados)){
            $arrayValores = [];
            foreach ($resutados as $resutado){
               $av = AnalisisVulnerabilidad::model()->findByAttributes([ 'vulnerabilidad_id'=>$resutado['id'],
                                                                         'analisis_id'=>$analisis_id,
                                                                         'grupo_activo_id'=>$grupo_activo_id,
                                                                         ],['order'=>'id desc']);
                $arrayValores[] = $av->valor;
            }

            $mayor_valor = max($arrayValores);
            return $mayor_valor;
        }else{
            return 0;
        }
    }

//    public function getAmenazas(){
//        $ame_vulne = AmenazaVulnerabilidad::model()->findAllByAttributes(['amenaza_id'=>$this->amenaza_id]);
//        $stringAmenazas = "";
//        if(!empty($ame_vulne)){
//            foreach ($ame_vulne as $relacion){
//                $stringAmenazas .= $relacion->amenaza->nombre.' , ';
//            }
//        }
//        return trim($stringAmenazas, ' , ');
//    }
}
