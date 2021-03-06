<?php

class m171230_212023_create_table_tipo_activo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `tipo_activo` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(50) NOT NULL,
                        `confidencialidad` INT(4) NOT NULL,
                        `integridad` INT(4) NOT NULL,
                        `disponibilidad` INT(4) NOT NULL,
                        `trazabilidad` INT(4) NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m171230_212023_create_table_tipo_activo does not support migration down.\n";
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