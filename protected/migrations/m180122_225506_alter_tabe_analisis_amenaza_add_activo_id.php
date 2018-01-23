<?php

class m180122_225506_alter_tabe_analisis_amenaza_add_activo_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_amenaza`
                            ADD COLUMN `activo_id` INT(11) NULL DEFAULT NULL AFTER `grupo_activo_id`,
                            ADD INDEX `activo_id` (`activo_id`),
                            ADD CONSTRAINT `fk_analisis_amenaza_activo_id` FOREIGN KEY (`activo_id`) REFERENCES `activo` (`id`);
                        ");
	}

	public function down()
	{
		echo "m180122_225506_alter_tabe_analisis_amenaza_add_activo_id does not support migration down.\n";
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