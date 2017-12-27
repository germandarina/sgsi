<?php

class m171227_015117_create_table_proceso extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `proceso` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `area_id` INT NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `area_id` (`area_id`),
                        CONSTRAINT `fk_proceso_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m171227_015117_create_table_proceso does not support migration down.\n";
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