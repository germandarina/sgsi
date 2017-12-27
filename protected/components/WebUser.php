<?php

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

    const NOTIFICATION_KEY_PREFIX = 'notification';
    const NOTIFICATION_COUNTERS = 'Yii.CWebUser.notificationcounters';

    public function getModel()
    {
        return Yii::app()->getSession()->get('model');
    }

    public function login($identity,  $duration=0)
    {
        parent::login($identity, $duration);
        Yii::app()->getSession()->add('model', $identity->getModel());
    }

    public function logout($destroySession= true)
    {
        // I always remove the session variable model.
        Yii::app()->getSession()->remove('model');
    }

    public function getNotifications($delete=true)
    {
        //$flashes=array();
        //$prefix=self::NOTIFICATION_KEY_PREFIX;

        $flashes=array();
        $prefix=$this->getStateKeyPrefix().self::NOTIFICATION_KEY_PREFIX;
        $keys=array_keys($_SESSION);
        $n=strlen($prefix);
        foreach($keys as $key)
        {
            if(!strncmp($key,$prefix,$n))
            {
                $flashes[substr($key,$n)]=$_SESSION[$key];
                if($delete)
                    unset($_SESSION[$key]);
            }
        }
        if($delete)
            $this->setState(self::NOTIFICATION_COUNTERS,array());
        return $flashes;


        // if(isset($_SESSION[self::NOTIFICATION_KEY_PREFIX])) {
        //     $notification = $_SESSION[self::NOTIFICATION_KEY_PREFIX];

        //     if($delete) {
        //         unset($_SESSION[self::NOTIFICATION_KEY_PREFIX]);
        //     }
        //     // $keys=array_keys($_SESSION);
        //     // $n=strlen($prefix);
        //     // foreach($keys as $key)
        //     // {
        //     //     if(!strncmp($key,$prefix,$n))
        //     //     {
        //     //         $flashes[substr($key,$n)]=$_SESSION[$key];
        //     //         if($delete)
        //     //             unset($_SESSION[$key]);
        //     //     }
        //     // }
        //     // if($delete)
        //     //     $this->setState(self::FLASH_COUNTERS,array());
        //     return $notification;
        // }


    }

    public function setNotification($key,$value,$defaultValue=null)
    {
        $this->setState(self::NOTIFICATION_KEY_PREFIX.$key,$value,$defaultValue);
        $counters=$this->getState(self::NOTIFICATION_COUNTERS,array());
        if($value===$defaultValue)
            unset($counters[$key]);
        else
            $counters[$key]=0;
        $this->setState(self::NOTIFICATION_COUNTERS,$counters,array());
    }

    // public function setNotification($value,$defaultValue=null)
    // {

    //     $_SESSION[self::NOTIFICATION_KEY_PREFIX] = $value;
    //     // $this->setState(self::FLASH_KEY_PREFIX.$key,$value,$defaultValue);
    //     // $counters=$this->getState(self::FLASH_COUNTERS,array());
    //     // if($value===$defaultValue)
    //     //     unset($counters[$key]);
    //     // else
    //     //     $counters[$key]=0;
    //     // $this->setState(self::FLASH_COUNTERS,$counters,array());
    // }
}

?>