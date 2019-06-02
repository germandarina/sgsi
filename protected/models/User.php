<?php

/**
 * This is the model class for table "acl_user".
 *
 * The followings are the available columns in table 'acl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $sucursalId
 * @property string $creaUserStamp
 * @property string $creaTimeStamp
 * @property string $modUserStamp
 * @property string $modTimeStamp
 * @property string $horaDesde
 * @property string $horaHasta
 * @property integer $diaDesde
 * @property integer $diaHasta
 * @property integer $estado
 * @property integer $ultimo_proyecto_id
 * @property integer $ultimoLoginSucursalId
 * The followings are the available model relations:
 * @property AclSucursal $sucursal
 */
class User extends CActiveRecord
{
    const DOMINGO = 0;
    const LUNES = 1;
    const MARTES = 2;
    const MIERCOLES = 3;
    const JUEVES = 4;
    const VIERNES = 5;
    const SABADO = 6;

    const ACTIVO = 1;
    const INACTIVO = 0;

    public $old_password;
    public $new_password;
    public $repeat_password;
    public $perfil;

    public static $estados = [
        self::ACTIVO => 'Activo',
        self::INACTIVO =>'Inactivo',
    ];
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'usuario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ultimo_proyecto_id,diaDesde, diaHasta, ultimoLoginSucursalId', 'numerical', 'integerOnly' => true),
            array('username,password,sucursalId,estado', 'required'),
            array('username', 'unique'),
            array('username, creaUserStamp, modUserStamp', 'length', 'max' => 50),
            array('password', 'length', 'max' => 255),
            array('creaTimeStamp, modTimeStamp', 'safe'),
            array('horaDesde, horaHasta', 'length', 'max' => 5),
            array('diaDesde', 'length', 'max' => 2),
            array('diaHasta', 'length', 'max' => 2),
            array('estado', 'length', 'max' => 2),
            array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
            array('old_password', 'findPasswords', 'on' => 'changePwd'),
            array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),
            array('new_password', 'compare', 'compareAttribute' => 'old_password', 'on' => 'changePwd', 'operator' => '!=', 'message' => 'La nueva contraseña no puede ser igual a la contraseña actual.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('diaDesde', 'compare', 'compareAttribute' => 'diaHasta', 'operator' => '<', 'message' => 'Dia desde debe ser menor que el dia Hasta.', 'on' => 'jornadaLaboral'),
            array('ultimo_proyecto_id,id, username, password, sucursalId, creaUserStamp, creaTimeStamp, modUserStamp, modTimeStamp
				,horaDesde,horaHasta,diaDesde, diaHasta, estado', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    public function findPasswords($attribute, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->password != md5($this->old_password))
            $this->addError($attribute, 'La contraseña actual es incorrecta.');
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'creaUserStamp' => 'Crea User Stamp',
            'creaTimeStamp' => 'Crea Time Stamp',
            'modUserStamp' => 'Mod User Stamp',
            'modTimeStamp' => 'Mod Time Stamp',
            'horaDesde' => 'Hora Desde',
            'horaHasta' => 'Hora Hasta',
            'diaDesde' => 'Dia Desde',
            'diaHasta' => 'Dia Hasta',
            'estado' => 'Estado',
            'old_password' => 'Actual',
            'new_password' => 'Nueva',
            'repeat_password' => 'Repetir Nueva',
            'ultimoLoginSucursalId' => 'Sucursal'
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('sucursalId',$this->sucursalId);
        $criteria->compare('creaUserStamp', $this->creaUserStamp, true);
        $criteria->compare('creaTimeStamp', $this->creaTimeStamp, true);
        $criteria->compare('estado', $this->estado);

//        $criteria->compare('modUserStamp', $this->modUserStamp, true);
//        $criteria->compare('modTimeStamp', $this->modTimeStamp, true);
//        $criteria->compare('horaDesde', $this->horaDesde, true);
//        $criteria->compare('horaHasta', $this->horaHasta, true);
//        $criteria->compare('diaDesde', $this->diaDesde, true);
//        $criteria->compare('diaHasta', $this->diaHasta, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTypeOptions()
    {
        return array(
            self::LUNES => 'LUNES',
            self::MARTES => 'MARTES',
            self::MIERCOLES => 'MIERCOLES',
            self::JUEVES => 'JUEVES',
            self::VIERNES => 'VIERNES',
            self::SABADO => 'SABADO',
            self::DOMINGO => 'DOMINGO'
        );
    }

    public function getTypeDescription($value)
    {
        $options = array();
        $options = $this->getTypeOptions();

        return $options[$value];
    }

    public function getTypeOptionsHabilitar()
    {
        return array(
            self::ACTIVO => 'ACTIVO',
            self::INACTIVO => 'INACTIVO'
        );
    }

    public function getTypeDescriptionHabilitar($value)
    {
        $options = array();
        $options = $this->getTypeOptionsHabilitar();

        return $options[$value];
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $user = User::model()->findByPk($this->id);
            if (empty($user)) {
                $this->password = md5($this->password);
            } else {
                if ($this->password != $user->password) {
                    $this->password = md5($this->password);
                }
            }

            return true;
        } else
            return false;
    }

    protected function beforeValidate()
    {
        if (empty($this->id)) {
            $this->creaUserStamp = Yii::app()->user->model->username;
            $this->creaTimeStamp = Date("Y-m-d h:m:s");
        } else {
            $this->modUserStamp = Yii::app()->user->model->username;
            $this->modTimeStamp = Date("Y-m-d h:m:s");
        }

        $this->sucursalId = Yii::app()->user->model->sucursalId;

        return parent::beforeValidate();
    }


    public function isAdmin()
    {
        $isAdmin = false;
        $rolesUsuario = array_keys(Yii::app()->authManager->getAuthAssignments($this->id));

        if (in_array('Administrador', $rolesUsuario))
            $isAdmin = true;

        return $isAdmin;
    }

    public function isGerencial(){
        $isAdmin = false;
        $rolesUsuario = array_keys(Yii::app()->authManager->getAuthAssignments($this->id));

        if (in_array('gerencial', $rolesUsuario))
            $isAdmin = true;

        return $isAdmin;
    }

    public function isDataEntry(){
        $isAdmin = false;
        $rolesUsuario = array_keys(Yii::app()->authManager->getAuthAssignments($this->id));

        if (in_array('dataentry', $rolesUsuario))
            $isAdmin = true;

        return $isAdmin;
    }

    public function isAuditor(){
        $isAdmin = false;
        $rolesUsuario = array_keys(Yii::app()->authManager->getAuthAssignments($this->id));

        if (in_array('auditor', $rolesUsuario))
            $isAdmin = true;

        return $isAdmin;
    }

    public function jornadaLaboralValida()
    {
        if (is_null($this->diaDesde) || is_null($this->diaHasta) || is_null($this->horaDesde) || is_null($this->horaHasta))
            return false;

        $fechaActual = new DateTime();
        $diaServidor = $fechaActual->format('w');

        ## si el dia actual esta en el rango (desde, hasta) vemos la hora
        if ($diaServidor >= $this->diaDesde && $diaServidor <= $this->diaHasta) {
            $fechaDesde = new DateTime();
            //echo var_dump($this->horaDesde);die();
            list($hora, $minutos) = explode(':', $this->horaDesde);
            $fechaDesde->setTime($hora, $minutos);
            //echo var_dump($fechaDesde);die();

            $fechaHasta = new DateTime();
            list($hora, $minutos) = explode(':', $this->horaHasta);
            $fechaHasta->setTime($hora, $minutos);
            //echo var_dump($fechaActual,$fechaDesde,$fechaHasta);die();
            if ($fechaActual >= $fechaDesde && $fechaActual <= $fechaHasta)
                return true;


        }
        return false;
    }

    public function getUsuarioSucursal()
    {
        $sucursal = Sucursal::model()->findByPk(1);
        return $sucursal;
    }

    public function afterFind() {
        $perfiles = array_keys(Yii::app()->authManager->getAuthAssignments($this->id));
        foreach ($perfiles as $perfil) {
            $this->perfil = $perfil . ',';
        }
        if(!empty($this->perfil)) {
            $this->perfil = substr($this->perfil, 0, count($this->perfil) - 2);
        }
    }

    public function getJornadaLaboralTimeout() {

        $now = new DateTime();
        $horam = $this->horaHasta;
        list($hora, $min) = explode(':',$horam);

        $hasta = new DateTime();
        $hasta->setTime($hora,$min);

        $interval = $hasta->diff($now);
        $seconds = $interval->h*3600 + $interval->s;

        return $seconds;
    }

    public static function getUsuariosAuditores(){
          $query = " select u.*
                        from usuario u
                        inner join AuthAssignment aa on aa.userid = u.id
                        where aa.itemname = 'auditor'";
          $command = Yii::app()->db->createCommand($query);
          $usuarios = $command->queryAll($query);
          return $usuarios;
    }
}
