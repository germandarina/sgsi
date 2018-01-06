<?php

class m180106_040918_create_table_grupo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `grupo` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NULL,
                        `criterio` VARCHAR(200) NULL,
                        `tipo_activo_id` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `tipo_activo_id` (`tipo_activo_id`),
                        CONSTRAINT `grupo_tipo_activo_id` FOREIGN KEY (`tipo_activo_id`) REFERENCES `tipo_activo` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180106_040918_create_table_grupo does not support migration down.\n";
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