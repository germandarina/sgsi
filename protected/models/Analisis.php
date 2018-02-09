<?php

/**
 * This is the model class for table "analisis".
 *
 * The followings are the available columns in table 'analisis':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property integer $personal_id
 * @property integer $proyecto_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property Personal $personal
 * @property Proyecto $proyecto
 * @property GrupoActivo[] $grupoActivos
 */
class Analisis extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $valor_form_valoracion;
	public function tableName()
	{
		return 'analisis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, fecha, personal_id', 'required'),
			array('proyecto_id,personal_id', 'numerical', 'integerOnly'=>true),
			array('nombre, creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('descripcion', 'length', 'max'=>200),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, proyecto_id,descripcion, fecha, personal_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
            'grupoActivos' => array(self::HAS_MANY, 'GrupoActivo', 'analisis_id'),
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
			'personal_id' => 'Personal',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'valor_form_valoracion' =>'Valor',
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
        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
        if(!is_null($usuario->ultimo_proyecto_id)){
            $criteria->compare('proyecto_id',$usuario->ultimo_proyecto_id);
        }
        if($this->proyecto_id != NULL){
            $criteria->compare('proyecto_id',$this->proyecto_id);
        }
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('personal_id',$this->personal_id);
		$criteria->compare('creaUserStamp',$this->creaUserStamp,true);
		$criteria->compare('creaTimeStamp',$this->creaTimeStamp,true);
		$criteria->compare('modUserStamp',$this->modUserStamp,true);
		$criteria->compare('modTimeStamp',$this->modTimeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Analisis the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPersonal(){
        return $this->personal->apellido.' , '.$this->personal->nombre;

    }
}
