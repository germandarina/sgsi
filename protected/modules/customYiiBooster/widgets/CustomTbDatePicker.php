<?php

Yii::import('booster.widgets.TbDatePicker');

class CustomTbDatePicker extends TbDatePicker {

    /**
     * Sobreescribimos esta funcion ya que se rompe cuando se include el js con la config en espaniol
     */
    public function registerLanguageScript() {

        $booster = Booster::getBooster();

        if (isset($this->options['language']) && $this->options['language'] != 'en') {
            $filename = '/bootstrap-datepicker/js/locales/bootstrap-datepicker.' . $this->options['language'] . '.js';

            if (file_exists(Yii::getPathOfAlias('booster.assets') . $filename)) {
                if ($booster->enableCdn) {
                    Yii::app()->clientScript->registerScriptFile(
                        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/locales/bootstrap-datepicker.' . $this->options['language'] . '.js',
                        CClientScript::POS_READY
                    );
                } else {

                    $locale = Yii::app()->assetManager->publish(Yii::getPathOfAlias('booster.assets') . $filename);

                    // registers locale
                    Yii::app()->clientScript->registerScriptFile($locale, CClientScript::POS_END);
                    //$booster->cs->registerScriptFile($booster->getAssetsUrl() . $filename, CClientScript::POS_READY);
                }
            }
        }
    }
}