<?php

/**
 * This is the model class for table "acl_menu".
 *
 * The followings are the available columns in table 'acl_menu':
 * @property integer $id
 * @property integer $padreId
 * @property string $label
 * @property string $titulo
 * @property string $url
 * @property integer $sucursalId
 * @property integer $visible
 * @property integer $orden
 * @property string $icono
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 *
 * The followings are the available model relations:
 * @property AclSucursal $sucursal
 */
class Menu extends CustomCActiveRecord
{
    /**
     * @return string the associated database table name
     */
    const TYPE_NOVISIBLE = 0;
    const TYPE_VISIBLE = 1;

    public $perfiles = [];
    public $controllers = [];
    public $accionesControllers;


    public function tableName()
    {
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('label, sucursalId, visible, orden', 'required'),
            array('padreId, sucursalId, visible, orden', 'numerical', 'integerOnly' => true),
            array('label, titulo, url, icono, creaUserStamp, modUserStamp', 'length', 'max' => 50),
            array('creaTimeStamp, modTimeStamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, padreId, label, titulo, url, sucursalId, visible, orden, icono, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp', 'safe', 'on' => 'search'),
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
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'padreId' => 'Padre',
            'label' => 'Label',
            'titulo' => 'Titulo',
            'url' => 'Url',
            'sucursalId' => 'Sucursal',
            'visible' => 'Visible',
            'orden' => 'Orden',
            'icono' => 'Icono',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('padreId', $this->padreId);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('titulo', $this->titulo, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('sucursalId', $this->sucursalId);
        $criteria->compare('visible', $this->visible);
        $criteria->compare('orden', $this->orden);
        $criteria->compare('icono', $this->icono, true);
        $criteria->compare('creaUserStamp', $this->creaUserStamp, true);
        $criteria->compare('creaTimeStamp', $this->creaTimeStamp, true);
        $criteria->compare('modUserStamp', $this->modUserStamp, true);
        $criteria->compare('modTimeStamp', $this->modTimeStamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getVisible()
    {
        return array(
            self::TYPE_NOVISIBLE => 'No Visible',
            self::TYPE_VISIBLE => 'Visible',
        );
    }


    public function findPadre()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'padreId=0 and visible=1';
        $criteria->order = "orden";
        return $this->findAll($criteria);
    }

    public function findHijos($padreId)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->condition = 't.padreId=:padre and t.visible=1';
        $criteria->params = array(":padre" => $padreId);
        $criteria->order = "orden";
        return $this->findAll($criteria);
    }


    public function getPadre($padreId)
    {
        $query = "select label
              from " . $this->tableName() . " where id=" . $padreId;
        $padre = Yii::app()->db->createCommand($query)->queryScalar();
        return $padre;
    }

    public function menuPadres()
    {
        $padres = $this->findPadre();
        $menu = array();
        $userId = Yii::app()->user->id;

        /**
         * @var $authManager CDbAuthManager;
         */
        $authManager = Yii::app()->authManager;
        foreach ($padres as $padre) {
            if(!$authManager->checkAccess($padre->label,$userId)) {
                continue;
            }
            $hijos = $this->findHijos($padre->id);
            $menuHijo = array();
            foreach ($hijos as $hijo) {
                if (!$authManager->checkAccess($hijo->label, $userId)) {
                    continue;
                }
                if(isset(Yii::app()->session["hijoId"])){
                    if(Yii::app()->session["hijoId"] == $hijo->id){
                        $classHijo = 'active';
                    }else{
                        $classHijo = '';
                    }
                }else{
                    $classHijo = '';
                }

                $menuHijo[] = array('label' => $hijo->label, 'url' => $hijo->url, 'authItemName' => $hijo->label, 'icon-class' => $hijo->icono,
                    'eventoClick'=>'guardarSesionUrl('.$hijo->id.','.$padre->id.')','class'=>$classHijo);
            }

            if(isset(Yii::app()->session["padreId"])){
                if(Yii::app()->session["padreId"] == $padre->id){
                    $class = 'treeview active';
                }else{
                    $class = 'treeview';
                }
            }else{
                $class = 'treeview';
            }

            $menu[] = array(
                'label' => $padre->label,
                'url' => $padre->url,
                'items' => $menuHijo,
                'authItemName' => $padre->label,
                'icon-class' => $padre->icono,
                'class'=>$class
            );
        }
        $menu[] = array('label' => 'Cerrar Sesion (' . Yii::app()->user->name . ')', 'url' => '/site/logout', 'icon-class' => 'fa-user-times', 'visible' => !Yii::app()->user->isGuest);
        return $menu;
    }
}
