<?php

class m180101_235440_create_table_control extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `control` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `numeracion` VARCHAR(50) NOT NULL,
                        `vulnerabilidad_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `vulnerabilidad_id` (`vulnerabilidad_id`),
                        CONSTRAINT `fk_control_vulnerabilidad_id` FOREIGN KEY (`vulnerabilidad_id`) REFERENCES `vulnerabilidad` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180101_235440_create_table_control does not support migration down.\n";
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