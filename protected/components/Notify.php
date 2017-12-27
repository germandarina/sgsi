<?php

class Notify extends CWidget
{

    public static $sounds = [
        'error' => 'sound2',
        'success' => 'sound1',
        'info' => 'sound3',
        'default' => 'sound5',
    ];

    public function run()
    {

        $notifications = Yii::app()->user->getNotifications();

        if (!empty($notifications)) {
            
           // $script = "$.notify('%s', '%s');";
            $script = "Lobibox.notify('%s', {
                    msg: '%s',
                    sound: '%s',
            });";

            $js = '';
            foreach ($notifications as $key => $value) {
                $sound = isset(self::$sounds[$key]) ? self::$sounds[$key] : self::$sounds['default'];

                $js .= sprintf($script, $key, $value, $sound);
            }

            Yii::app()->clientScript->registerScript(
                'notify', $js, CClientScript::POS_READY
            );
        }

    }
}

?>