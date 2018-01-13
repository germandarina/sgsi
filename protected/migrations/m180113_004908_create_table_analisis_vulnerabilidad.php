<?php

class m180113_004908_create_table_analisis_vulnerabilidad extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis_vulnerabilidad` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `analisis_id` INT NULL,
                        `vulnerabilidad_id` INT NULL,
                        `valor` INT NULL,
                        `fecha` INT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `analisis_id` (`analisis_id`),
                        INDEX `vulnerabilidad_id` (`vulnerabilidad_id`),
                        CONSTRAINT `fk_analisis_vulnerabilidad_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`),
                        CONSTRAINT `fk_analisis_vulnerabilidad_vulnerabilidad_id` FOREIGN KEY (`vulnerabilidad_id`) REFERENCES `vulnerabilidad` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
      ");
	}

	public function down()
	{
		echo "m180113_004908_create_table_analisis_vulnerabilidad does not support migration down.\n";
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