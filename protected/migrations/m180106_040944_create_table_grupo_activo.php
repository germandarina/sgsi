<?php

class m180106_040944_create_table_grupo_activo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `grupo_activo` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `activo_id` INT NOT NULL,
                `grupo_id` INT NOT NULL,
                `analisis_id` INT NOT NULL,
                `confidencialidad` INT(4) NOT NULL,
                `integridad` INT(4) NOT NULL,
                `disponibilidad` INT(4) NOT NULL,
                `trazabilidad` INT(4) NOT NULL,
                `creaUserStamp` VARCHAR(50) NULL,
                `creaTimeStamp` TIMESTAMP NULL,
                `modUserStamp` VARCHAR(50) NULL,
                `modTimeStamp` TIMESTAMP NULL,
                PRIMARY KEY (`id`),
                INDEX `activo_id` (`activo_id`),
                INDEX `grupo_id` (`grupo_id`),
                INDEX `analisis_id` (`analisis_id`),
                CONSTRAINT `fk_grupo_activo_activo_id` FOREIGN KEY (`activo_id`) REFERENCES `activo` (`id`),
                CONSTRAINT `fk_grupo_activo_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
                CONSTRAINT `fk_grupo_activo_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`)
            )
            COLLATE='utf8_spanish2_ci'
            ENGINE=InnoDB
            ;
            ");
	}

	public function down()
	{
		echo "m180106_040944_create_table_grupo_activo does not support migration down.\n";
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