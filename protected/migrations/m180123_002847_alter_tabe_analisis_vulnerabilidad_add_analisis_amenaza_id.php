<?php

class m180123_002847_alter_tabe_analisis_vulnerabilidad_add_analisis_amenaza_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_vulnerabilidad`
                        ADD COLUMN `analisis_amenaza_id` INT(11) NULL DEFAULT NULL AFTER `grupo_activo_id`,
                        ADD COLUMN `Columna 6` INT(11) NULL DEFAULT NULL AFTER `valor`,
                        ADD INDEX `analisis_amenaza_id` (`analisis_amenaza_id`),
                        ADD CONSTRAINT `fk_analisis_vulnerabilidad_analisis_amenaza_id` FOREIGN KEY (`analisis_amenaza_id`) REFERENCES `analisis_amenaza` (`id`);
                    ");
	}

	public function down()
	{
		echo "m180123_002847_alter_tabe_analisis_vulnerabilidad_add_analisis_amenaza_id does not support migration down.\n";
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