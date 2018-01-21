<?php

/**
 * This is the model class for table "nivel_de_riesgos".
 *
 * The followings are the available columns in table 'nivel_de_riesgos':
 * @property integer $id
 * @property integer $valor_minimo
 * @property integer $valor_maximo
 * @property integer $concepto
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 */
class NivelDeRiesgos extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	const CONCEPTO_ACEPTABLE = 1;
    const CONCEPTO_ACEPTABLE_CON_PRECAUCION = 2;
    const CONCEPTO_NO_ACEPTABLE = 3;

    public static $arrayConceptos = [
        self::CONCEPTO_ACEPTABLE => 'Aceptable',
        self::CONCEPTO_ACEPTABLE_CON_PRECAUCION => 'Aceptable con Precaucion',
        self::CONCEPTO_NO_ACEPTABLE => 'No Aceptable',
    ];

	public function tableName()
	{
		return 'nivel_de_riesgos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valor_minimo, valor_maximo, concepto', 'required'),
			array('valor_minimo, valor_maximo, concepto', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, valor_minimo, valor_maximo, concepto, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'valor_minimo' => 'Valor Minimo',
			'valor_maximo' => 'Valor Maximo',
			'concepto' => 'Concepto',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('valor_minimo',$this->valor_minimo);
		$criteria->compare('valor_maximo',$this->valor_maximo);
		$criteria->compare('concepto',$this->concepto);
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
	 * @return NivelDeRiesgos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
