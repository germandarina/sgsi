<?php

class m180119_235357_alter_table_relacionales_add_grupo_activo_id_fk extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_amenaza`
                        ADD COLUMN `grupo_activo_id` INT(11) NULL DEFAULT NULL AFTER `amenaza_id`,
                        ADD INDEX `grupo_activo_id` (`grupo_activo_id`),
                        ADD CONSTRAINT `fk_analisis_amenaza_grupo_activo_id` FOREIGN KEY (`grupo_activo_id`) REFERENCES `grupo_activo` (`id`);
                    ");

        $this->execute("ALTER TABLE `analisis_control`
                        ADD COLUMN `grupo_activo_id` INT(11) NULL DEFAULT NULL AFTER `control_id`,
                        ADD INDEX `grupo_activo_id` (`grupo_activo_id`),
                        ADD CONSTRAINT `fk_analisis_control_grupo_activo_id` FOREIGN KEY (`grupo_activo_id`) REFERENCES `grupo_activo` (`id`);
                    ");

        $this->execute("ALTER TABLE `analisis_vulnerabilidad`
                        ADD COLUMN `grupo_activo_id` INT(11) NULL DEFAULT NULL AFTER `vulnerabilidad_id`,
                        ADD INDEX `grupo_activo_id` (`grupo_activo_id`),
                        ADD CONSTRAINT `fk_analisis_vulnerabilidad_grupo_activo_id` FOREIGN KEY (`grupo_activo_id`) REFERENCES `grupo_activo` (`id`);
                    ");
	}

	public function down()
	{
		echo "m180119_235357_alter_table_relacionales_add_grupo_activo_id_fk does not support migration down.\n";
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