<script>
    function getAcciones() {
        var controller = $("#Menu_controllers").val()
        if (controller == "") {
            return Lobibox.notify('error',{msg:'Seleccione un controller'});
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('menu/getAccionesPorController') ?>",
            data: {'controller': controller},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var acciones = datos.acciones;
                $("#Menu_accionesControllers").find('option').remove();
                $("#Menu_accionesControllers").select2('val', null);
                $.each(acciones, function (i, accion) {
                    $("#Menu_accionesControllers").append('<option value="' + i + '">' + accion + '</option>');
                });
            }
        });

    }
</script>

<div class="box-body">
    <?php
    /** @var TbActiveForm $form */
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'verticalForm',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'type' => 'horizontal',
            // 'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    );
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-12">
            <?php
            echo $form->select2Group(
                $model,
                'controllers',
                array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-4 input-group-sm',
                        'onchange' => '{ getAcciones();}',

                    ),
                    'widgetOptions' => array(
                        'asDropDownList' => true,
                        'data' => $controllerList,
                        'htmlOptions' => array('prompt' => '--Seleccione--')
                    ),
                )
            );
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
            echo $form->select2Group(
                $model,
                'accionesControllers',
                array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-4 input-group-sm',
                    ),
                    'widgetOptions' => array(
                        'asDropDownList' => true,
                        'data' => [],
                        'htmlOptions' => array('prompt' => '--Seleccione--','multiple'=>'multiple'),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--',
                        ],
                    ),
                )
            );
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
            echo $form->select2Group(
                $model,
                'perfiles',
                array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-4 input-group-sm',
                    ),
                    'widgetOptions' => array(
                        'asDropDownList' => true,
                        'data' => $perfiles,
                        'htmlOptions' => [
                            'multiple'=>'multiple'
                        ],
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--',
                        ],
                    ),
                )
            );
            ?>
        </div>
    </div>




    <?php
    $this->widget(
        'booster.widgets.TbButton',
        array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Crear' : 'Actualizar', 'context' => 'primary', 'size' => 'small')
    );

    $this->endWidget();
    ?>
</div>
