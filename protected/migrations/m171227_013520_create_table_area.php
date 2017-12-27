<?php

class m171227_013520_create_table_area extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `area` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(50) NOT NULL,
                        `descripcion` VARCHAR(200) NOT NULL,
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
		echo "m171227_013520_create_table_area does not support migration down.\n";
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