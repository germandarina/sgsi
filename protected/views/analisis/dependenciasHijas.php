<ul>
    <?php foreach($hijos as $hijo) {?>
        <li>
            <?= $hijo->activo->nombre ?>
            <?php $hijos2 = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>$hijo->activo_id));
                if(count($hijos2)) {?>
                <?php echo $this->renderPartial('dependenciasHijas', array('hijos'=>$hijos2), true)?>
            <?php }?>
        </li>
    <?php }?>
</ul>