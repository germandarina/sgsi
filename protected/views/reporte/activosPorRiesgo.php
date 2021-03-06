<div class="page-title">
     <div class="title_left">
        <h3> Graficos <small>Activos en riesgos</small></h3>
     </div>
     <div class="title_right">
            <div class="box-body">
        <?php $form=$this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm',array(
            'id'=>'plan-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'type' => 'horizontal'
        )); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?php

                    echo $form->select2Group(
                        $analisis,
                        'id',
                        array(
                            'label'=>'Analisis',
                            'wrapperHtmlOptions' => array(
                                'class' => 'col-sm-9 input-group-sm',
                            ),
                            'widgetOptions' => array(
                                'asDropDownList' => false,
                                'htmlOptions' => [
                                    'data-analisis-id' => $analisis->id,
                                    'data-analisis-text' => $analisis->id > 0 ? $analisis->nombre : "",
                                    //'onchange' => 'js:datosCliente()',
                                ],
                                'options' => [
                                    'minimumResultsForSearch' => 10,
                                    'placeholder' => '--Seleccione--',
                                    'minimumInputLength' => '2',
                                    'ajax' => array(
                                        'url' => Yii::app()->controller->createUrl('/analisis/buscarPorNombre'),
                                        'dataType' => 'json',
                                        'data' => 'js: function(term,page) {
                                                            return {
                                                                q: term,
                                                                page_limit: 10,
                                                            };
                                                      }',
                                        'results' => 'js: function(data,page){
                                                          return {results: data};
                                                      }'
                                    ),
                                    'initSelection' => 'js:function(element, callback) {
                                            callback({id:element.attr("data-analisis-id"),text:element.attr("data-analisis-text")});
                                     }',
                                ],
                            ),
                        )
                    );
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php $this->widget('booster.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'context'=>'primary',
                        'label'=>'Filtrar',
                        'htmlOptions'=>['name'=>'filtrar'],
                        'size'=>'small'
                    )); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
          </div>
    </div>
<br>
<?php if(!empty($datos)){ ?>
    <?php $this->renderPartial('_graficoActivosPorRiesgo',['datos'=>$datos]);?>
<?php }?>