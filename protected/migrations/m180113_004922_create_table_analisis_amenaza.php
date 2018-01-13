<?php

class m180113_004922_create_table_analisis_amenaza extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis_amenaza` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `analisis_id` INT NULL,
                        `amenaza_id` INT NULL,
                        `valor` INT NULL,
                        `fecha` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `analisis_id` (`analisis_id`),
                        INDEX `amenaza_id` (`amenaza_id`),
                        CONSTRAINT `fk_analisis_amenaza_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`),
                        CONSTRAINT `fk_analisis_amenaza_amenaza_id` FOREIGN KEY (`amenaza_id`) REFERENCES `amenaza` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
      ");
	}

	public function down()
	{
		echo "m180113_004922_create_table_analisis_amenaza does not support migration down.\n";
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