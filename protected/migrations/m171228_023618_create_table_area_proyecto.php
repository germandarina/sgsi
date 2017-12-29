<?php

class m171228_023618_create_table_area_proyecto extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `area_proyecto` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `area_id` INT NULL,
                        `proyecto_id` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `area_id` (`area_id`),
                        INDEX `proyecto_id` (`proyecto_id`),
                        CONSTRAINT `fk_area_proyecto_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`),
                        CONSTRAINT `fk_area_proecto_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m171228_023618_create_table_area_proyecto does not support migration down.\n";
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