<?php

Yii::import('booster.widgets.TbActiveForm');

class CustomTbActiveForm extends TbActiveForm
{
    public function datePickerGroup($model, $attribute, $options = array()) {

        return $this->widgetGroupInternal('customYiiBooster.widgets.CustomTbDatePicker', $model, $attribute, $options);
    }
}