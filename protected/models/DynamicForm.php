<?php

class DynamicForm extends CFormModel
{
    public $elements = [];
    public $attributeLabels  = [];

    public function __construct(Formulario $formulario) {

        foreach($formulario->elementos as $elemento) {
            $element = new Element([
                'id'=>$elemento->id,
                'name' => $elemento->nombreCampo,
                'required' => (int)$elemento->requerido,
                'label' => $elemento->label
            ]);

            //$this->attributeLabels[$elemento->nombreCampo] = $elemento->label;

            $this->elements[] = $element;
        }

    }

    public function rules()
    {
        $required = array();
        foreach ($this->elements as $e)
            if ($e->required)
                $required[] = $e->name;

        return array(
            array(implode(', ', $required), 'required'),
        );
    }

    public function __get($name)
    {
        foreach ($this->elements as $e)
            if ($e->name == $name) return $this->elements[$name]->value;

        return $this->$name;
    }

    public function attributeLabels()
    {
        return $this->attributeLabels;
    }
}