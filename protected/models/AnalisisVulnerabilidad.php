<?php

/**
 * This is the model class for table "analisis_vulnerabilidad".
 *
 * The followings are the available columns in table 'analisis_vulnerabilidad':
 * @property integer $id
 * @property integer $analisis_id
 * @property integer $vulnerabilidad_id
 * @property integer $analisis_amenaza_id
 * @property integer $valor
 * @property string $fecha
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 * @property integer $grupo_activo_id
 *
 * The followings are the available model relations:
 * @property Analisis $analisis
 * @property Vulnerabilidad $vulnerabilidad
 * @property GrupoActivo $grupoActivo
 * @property AnalisisAmenaza $analisisAmenaza

 */
class AnalisisVulnerabilidad extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'analisis_vulnerabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha', 'required'),
			array('analisis_amenaza_id,grupo_activo_id,analisis_id, vulnerabilidad_id, valor', 'numerical', 'integerOnly'=>true),
			array('fecha', 'length', 'max'=>200),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('analisis_amenaza_id,grupo_activo_id,id, analisis_id, vulnerabilidad_id, valor, fecha, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'analisis' => array(self::BELONGS_TO, 'Analisis', 'analisis_id'),
			'vulnerabilidad' => array(self::BELONGS_TO, 'Vulnerabilidad', 'vulnerabilidad_id'),
            'grupoActivo' => array(self::BELONGS_TO, 'GrupoActivo', 'grupo_activo_id'),
            'analisisAmenaza' => array(self::BELONGS_TO, 'AnalisisAmenaza', 'analisis_amenaza_id'),

        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'analisis_id' => 'Analisis',
			'vulnerabilidad_id' => 'Vulnerabilidad',
			'valor' => 'Valor',
			'fecha' => 'Descripcion',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'grupo_activo_id'=>'GrupoActivo ',
            'analisis_amenaza_id' => 'Analisis Amenaza',
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
		$criteria->compare('analisis_id',$this->analisis_id);
		$criteria->compare('vulnerabilidad_id',$this->vulnerabilidad_id);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('fecha',$this->fecha,true);
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
	 * @return AnalisisVulnerabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
