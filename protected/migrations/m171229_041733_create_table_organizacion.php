<?php

class m171229_041733_create_table_organizacion extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `organizacion` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `nombre` VARCHAR(100) NOT NULL,
                        `direccion` VARCHAR(100) NOT NULL,
                        `creaUserStamp` VARCHAR(50) NULL,
                        `creaTimeStamp` TIMESTAMP NULL,
                        `modUserStamp` VARCHAR(50) NULL,
                        `modTimeStamp` TIMESTAMP NULL,
	                      PRIMARY KEY (`id`)
                            )
                            COLLATE='utf8_spanish2_ci'
                            ENGINE=InnoDB
;
");
	}

	public function down()
	{
		echo "m171229_041733_create_table_organizacion does not support migration down.\n";
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