<?php

/**
 * This is the model class for table "dependencia".
 *
 * The followings are the available columns in table 'dependencia':
 * @property integer $id
 * @property integer $activo_id
 * @property integer $activo_padre_id
 * @property integer $analisis_id
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 * @property integer $numero
 *
 * The followings are the available model relations:
 * @property Activo $activo
 * @property Activo $activoPadre
 * @property Analisis $analisis
 */
class Dependencia extends CustomCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $activo_rama_id;
	public function tableName()
	{
		return 'dependencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activo_id, analisis_id', 'required'),
			array('numero,activo_id, activo_padre_id, analisis_id', 'numerical', 'integerOnly'=>true),
			array('creaUserStamp, modUserStamp', 'length', 'max'=>50),
			array('activo_rama_id,creaTimeStamp, modTimeStamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('activo_rama_id,numero,id, activo_id, activo_padre_id, analisis_id, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on'=>'search'),
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
			'activoPadre' => array(self::BELONGS_TO, 'Activo', 'activo_padre_id'),
			'analisis' => array(self::BELONGS_TO, 'Analisis', 'analisis_id'),
            'hijos' => array(self::HAS_MANY, 'Activo', 'activo_padre_id'),
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
			'activo_padre_id' => 'Activo Padre',
			'analisis_id' => 'Analisis',
			'creaUserStamp' => 'Crea User Stamp',
			'creaTimeStamp' => 'Crea Time Stamp',
			'modUserStamp' => 'Mod User Stamp',
			'modTimeStamp' => 'Mod Time Stamp',
            'activo_rama_id' => 'Ramal',
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
		$criteria->compare('activo_id',$this->activo_id);
		$criteria->compare('activo_padre_id',$this->activo_padre_id);
		$criteria->compare('analisis_id',$this->analisis_id);
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
	 * @return Dependencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function getHijos(&$arrayHijosIds = []){
        $hijos = Dependencia::model()->findAllByAttributes(['analisis_id'=>$this->analisis_id,'activo_padre_id'=>$this->activo_id,'numero'=>$this->numero]);
        if(!empty($hijos)){
            foreach ($hijos as $hijo){
                $arrayHijosIds[] = $hijo->id;
                $hijo->getHijos($arrayHijosIds);
            }
            return $arrayHijosIds;
        }else{
            return $arrayHijosIds;
        }
    }
}
