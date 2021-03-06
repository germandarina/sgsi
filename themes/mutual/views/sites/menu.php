<ul class="sidebar-menu">
    <?php
            $usuario = User::model()->getUsuarioLogueado();
            $proyecto_usuario = ProyectoUsuario::model()->findByAttributes(['usuario_id'=>$usuario->id]);
            if(!is_null($usuario->ultimo_proyecto_id) && !is_null($proyecto_usuario)){ ?>
                <li ><a class="header" style="text-align: center; color: white;" href="#" onclick="toPanel(event)"><b>HOME</b></a></li>
                <?php foreach ($items as $item) { ?>
                    <?php $url = !empty($item['url']) ? Yii::app()->createUrl($item['url']) : '';  ?>
                    <li class="<?php if(!empty($item['items'])) echo $item['class']; ?> ">
                        <a href="<?php echo !empty($url) ? $url : '#'  ?>">
                            <i class="fa <?php echo $item['icon-class'] ?>"></i> <span><?php echo $item['label'] ?></span>
                            <?php if(!empty($item['items'])) { ?>
                                <i class="fa fa-angle-left pull-right"></i>
                            <?php } ?>
                        </a>
                        <?php if(!empty($item['items'])) { ?>
                            <ul class="treeview-menu">
                                <?php foreach ($item['items'] as $subitem) { ?>
                                    <li class="<?php echo $subitem['class']?>">
                                        <a href="<?php echo Yii::app()->createUrl($subitem['url']) ?>" onclick="<?php echo $subitem['eventoClick']?>">
                                            <i class="fa <?php echo $subitem['icon-class'] ?>"></i> <?php echo $subitem['label'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php }
            }?>
</ul>