<div class="box">
    <div class="box-header">
        <h3 class="box-title">Admin Usuarios</h3>
        <?php $this->widget(
            'booster.widgets.TbButtonGroup',
            array(
                'size' => 'medium',
                'context' => 'primary',
                'buttons' => array(
                    array(
                        'label' => 'Acciones',
                        'items' => array(
                            array('label' => 'Crear', 'url' => Yii::app()->createUrl('User/create')),
                        )
                    ),
                ),
            )
        ); ?>    </div>

    <?php $this->widget('booster.widgets.TbExtendedGridView', array(
        'id' => 'user-grid',
        'fixedHeader' => false,
        'headerOffset' => 10,
        // 40px is the height of the main navigation at bootstrap
        'type' => 'striped hover condensed bordered',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'selectableRows' => 1,
        'filter' => $model,
        'columns' => array(
            'id',
            'username',
            'perfil',
            [
                'header'=>'Estado',
                'name'=>'estado',
                'value'=>'User::$estados[$data->estado]',
                'filter'=>User::$estados,
            ],
            'creaUserStamp',
            'creaTimeStamp',

            /*
            'modUserStamp',
            'modTimeStamp',
            */
            array(
                'class' => 'booster.widgets.TbButtonColumn',
            ),
        ),
    )); ?>
</div>



