<?php

class m171227_014346_create_table_proyecto extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `proyecto` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
                        `fecha` DATE NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
                        PRIMARY KEY (`id`)
                    )
                    COLLATE='utf8_spanish2_ci'
                    ENGINE=InnoDB
                    ;");
	}

	public function down()
	{
		echo "m171227_014346_create_table_proyecto does not support migration down.\n";
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