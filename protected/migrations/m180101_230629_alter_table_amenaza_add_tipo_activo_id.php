<?php

class m180101_230629_alter_table_amenaza_add_tipo_activo_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `amenaza`
                        ADD COLUMN `tipo_activo_id` INT(11) NULL AFTER `trazabilidad`,
                        ADD INDEX `tipo_activo_id` (`tipo_activo_id`),
                        ADD CONSTRAINT `fk_amenaza_tipo_activo_id` FOREIGN KEY (`tipo_activo_id`) REFERENCES `tipo_activo` (`id`);");
	}

	public function down()
	{
		echo "m180101_230629_alter_table_amenaza_add_tipo_activo_id does not support migration down.\n";
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