<?php

class m180113_145845_alter_table_relaciones_analisis extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_amenaza`
                            ADD COLUMN `grupo_id` INT(11) NULL DEFAULT NULL AFTER `amenaza_id`,
                            ADD INDEX `grupo_id` (`grupo_id`),
                            ADD CONSTRAINT `fk_analisis_amenaza_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

                    ");

        $this->execute("ALTER TABLE `analisis_vulnerabilidad`
                            ADD COLUMN `grupo_id` INT(11) NULL DEFAULT NULL AFTER `vulnerabilidad_id`,
                            ADD INDEX `grupo_id` (`grupo_id`),
                            ADD CONSTRAINT `fk_analisis_vulnerabilidad_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

                    ");

        $this->execute("ALTER TABLE `analisis_control`
                            ADD COLUMN `grupo_id` INT(11) NULL DEFAULT NULL AFTER `control_id`,
                            ADD INDEX `grupo_id` (`grupo_id`),
                            ADD CONSTRAINT `fk_analisis_control_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

                    ");
	}

	public function down()
	{
		echo "m180113_145845_alter_table_relaciones_analisis does not support migration down.\n";
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