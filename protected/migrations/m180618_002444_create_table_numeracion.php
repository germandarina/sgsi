<?php

class m180618_002444_create_table_numeracion extends CDbMigration
{
	public function up()
	{
	    $this->execute("CREATE TABLE `numerador` (
                                `id` INT(11) NOT NULL AUTO_INCREMENT,
                                `numero` INT(11) NULL DEFAULT NULL,
                                `creaUserStamp` VARCHAR(100) NULL DEFAULT NULL,
                                `creaTimeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                `modUserStamp` VARCHAR(100) NULL DEFAULT NULL,
                                `modTimeStamp` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
                                PRIMARY KEY (`id`)
                            
                            )
                            COLLATE='latin1_swedish_ci'
                            ENGINE=InnoDB
                           ;
                            ");
	}

	public function down()
	{
		echo "m180618_002444_create_table_numeracion does not support migration down.\n";
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