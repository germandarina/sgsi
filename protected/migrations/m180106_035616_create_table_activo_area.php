<?php

class m180106_035616_create_table_activo_area extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `activo_area` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `activo_id` INT NOT NULL,
                        `area_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `activo_id` (`activo_id`),
                        INDEX `area_id` (`area_id`),
                        CONSTRAINT `activo_area_activo_id` FOREIGN KEY (`activo_id`) REFERENCES `activo` (`id`),
                        CONSTRAINT `activo_area_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180106_035616_create_table_activo_area does not support migration down.\n";
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