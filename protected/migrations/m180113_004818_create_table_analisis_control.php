<?php

class m180113_004818_create_table_analisis_control extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis_control` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `analisis_id` INT NULL,
                        `control_id` INT NULL,
                        `valor` INT NULL,
                        `fecha` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `analisis_id` (`analisis_id`),
                        INDEX `control_id` (`control_id`),
                        CONSTRAINT `fk_analisis_control_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`),
                        CONSTRAINT `fk_analisis_control_control_id` FOREIGN KEY (`control_id`) REFERENCES `control` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
      ");
	}

	public function down()
	{
		echo "m180113_004818_create_table_analisis_control does not support migration down.\n";
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