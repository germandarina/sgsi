<?php

class m180127_214648_alter_table_usuarios_add_ultimoProyectoId extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `usuario`
                        ADD COLUMN `ultimo_proyecto_id` INT NULL AFTER `tipoUsuario`,
                        ADD INDEX `ultimoProyectoId` (`ultimo_proyecto_id`),
                        ADD CONSTRAINT `fk_usuario_ultimo_proyecto_id` FOREIGN KEY (`ultimo_proyecto_id`) REFERENCES `proyecto` (`id`);
                    ");
	}

	public function down()
	{
		echo "m180127_214648_alter_table_usuarios_add_ultimoProyectoId does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}