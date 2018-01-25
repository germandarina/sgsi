<?php

class m180125_024759_alter_table_tablas_add_proyecto_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `activo`
                            ADD COLUMN `proyecto_id` INT NULL DEFAULT NULL AFTER `ubicacion`,
                            ADD INDEX `proyecto_id` (`proyecto_id`),
                            ADD CONSTRAINT `fk_activo_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`);
                        ");

        $this->execute("ALTER TABLE `analisis`
                            ADD COLUMN `proyecto_id` INT NULL DEFAULT NULL,
                            ADD INDEX `proyecto_id` (`proyecto_id`),
                            ADD CONSTRAINT `fk_analisis_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`);
                        ");

        $this->execute("ALTER TABLE `grupo`
                            ADD COLUMN `proyecto_id` INT NULL DEFAULT NULL,
                            ADD INDEX `proyecto_id` (`proyecto_id`),
                            ADD CONSTRAINT `fk_grupo_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`);
                        ");
	}

	public function down()
	{
		echo "m180125_024759_alter_table_tablas_add_proyecto_id does not support migration down.\n";
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