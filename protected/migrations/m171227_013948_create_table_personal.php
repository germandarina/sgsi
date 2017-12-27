<?php

class m171227_013948_create_table_personal extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `personal` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `apellido` VARCHAR(50) NOT NULL,
                        `nombre` VARCHAR(50) NOT NULL,
                        `dni` VARCHAR(50) NOT NULL,
                        `telefono` VARCHAR(50) NOT NULL,
                        `area_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `area_id` (`area_id`),
                        CONSTRAINT `fk_personal_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m171227_013948_create_table_personal does not support migration down.\n";
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