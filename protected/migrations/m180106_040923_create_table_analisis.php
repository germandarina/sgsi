<?php

class m180106_040923_create_table_analisis extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `analisis` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `fecha` DATE NOT NULL,
                        `personal_id` INT NOT NULL,
                         `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`),
                        INDEX `personal_id` (`personal_id`),
                        CONSTRAINT `fk_analisis_personal_id` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;
                    ");
	}

	public function down()
	{
		echo "m180106_040923_create_table_analisis does not support migration down.\n";
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