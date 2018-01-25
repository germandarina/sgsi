<?php

class m180125_010826_alter_table_proyecto_add_usuario_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `proyecto`
                            ADD COLUMN `usuario_id` INT NULL AFTER `fecha`,
                            ADD INDEX `usuario_id` (`usuario_id`),
                            ADD CONSTRAINT `fk_proyecto_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
                        ");
	}

	public function down()
	{
		echo "m180125_010826_alter_table_proyecto_add_usuario_id does not support migration down.\n";
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