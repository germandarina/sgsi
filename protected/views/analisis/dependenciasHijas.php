<ul>
    <?php foreach($hijos as $hijo) {?>
        <li>
            <span><h4><a href="#"><icon class="fa fa-cogs"></a>&nbsp;&nbsp;&nbsp;<?= $hijo->activo->nombre ?></h4>
            <?php $hijos2 = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>$hijo->activo_id));
                if(count($hijos2)) {?>
                <?php echo $this->renderPartial('dependenciasHijas', array('hijos'=>$hijos2), true)?>
            <?php }?>
        </li>
    <?php }?>
</ul>