<?php

class m180120_220551_create_table_analisis_riesgo extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis_riesgo` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `analisis_id` INT NULL,
                        `riesgo_aceptable` INT NULL,
                        `fecha` DATE NULL,
                         `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `analisis_id` (`analisis_id`),
                        CONSTRAINT `fk_analisis_riesgo_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;");
	}

	public function down()
	{
		echo "m180120_220551_create_table_analisis_riesgo does not support migration down.\n";
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